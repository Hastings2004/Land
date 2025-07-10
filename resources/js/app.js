import './bootstrap';

// Sidebar and dashboard interactivity logic

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar logic
    const sidebar = document.getElementById('sidebar');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const hoverTrigger = document.getElementById('hover-trigger');
    const logoutModal = document.getElementById('logout-modal');
    const logoutForm = document.getElementById('logout-form');
    const confirmLogoutBtn = document.getElementById('confirm-logout-btn');
    let sidebarOpen = false;
    let hoverTimeout;

    function openSidebar() {
        if (sidebar) sidebar.classList.remove('-translate-x-full');
        sidebarOpen = true;
    }
    function closeSidebar() {
        if (sidebar) sidebar.classList.add('-translate-x-full');
        sidebarOpen = false;
    }
    window.toggleSidebar = function() {
        if (sidebarOpen) {
            closeSidebar();
        } else {
            openSidebar();
        }
        if (mobileMenuOverlay) mobileMenuOverlay.classList.toggle('hidden');
    };

    // Hover functionality for desktop
    if (window.innerWidth >= 1024 && hoverTrigger && sidebar) {
        hoverTrigger.onmouseenter = () => {
            clearTimeout(hoverTimeout);
            openSidebar();
        };
        sidebar.onmouseenter = () => {
            clearTimeout(hoverTimeout);
        };
        sidebar.onmouseleave = () => {
            hoverTimeout = setTimeout(() => {
                closeSidebar();
            }, 300);
        };
        hoverTrigger.onmouseleave = () => {
            hoverTimeout = setTimeout(() => {
                closeSidebar();
            }, 300);
        };
    }
    // Mobile functionality
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            closeSidebar();
            if (mobileMenuOverlay) mobileMenuOverlay.classList.add('hidden');
        } else {
            closeSidebar();
        }
    });

    // Logout modal logic
    window.showLogoutModal = function() {
        if (!logoutModal) return;
        logoutModal.classList.remove('hidden');
        setTimeout(() => {
            const modalContent = logoutModal.querySelector('.modal-content');
            if (modalContent) {
                modalContent.style.transform = 'scale(0.9)';
                modalContent.style.opacity = '0';
                modalContent.style.transition = 'all 0.3s ease-out';
                setTimeout(() => {
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                }, 50);
            }
        }, 10);
    };
    window.hideLogoutModal = function() {
        if (!logoutModal) return;
        const modalContent = logoutModal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.style.transform = 'scale(0.9)';
            modalContent.style.opacity = '0';
            modalContent.style.transition = 'all 0.2s ease-in';
            setTimeout(() => {
                logoutModal.classList.add('hidden');
                modalContent.style.transform = '';
                modalContent.style.opacity = '';
                modalContent.style.transition = '';
            }, 200);
        } else {
            logoutModal.classList.add('hidden');
        }
    };
    window.handleLogout = function() {
        if (!confirmLogoutBtn) return;
        const btn = confirmLogoutBtn;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Logging out...';
        btn.disabled = true;
        if (logoutForm) {
            logoutForm.submit();
        } else {
            // Fallback logout
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = '/logout';
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            tempForm.appendChild(csrfToken);
            document.body.appendChild(tempForm);
            tempForm.submit();
        }
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    };
    if (logoutModal) {
        logoutModal.addEventListener('click', function(e) {
            if (e.target === logoutModal) {
                window.hideLogoutModal();
            }
        });
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && logoutModal && !logoutModal.classList.contains('hidden')) {
            window.hideLogoutModal();
        }
    });

    // Notification dropdown close on outside click
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('notifications-dropdown');
        const bell = document.querySelector('.fa-bell') ? document.querySelector('.fa-bell').parentElement : null;
        if (dropdown && bell && !dropdown.contains(e.target) && !bell.contains(e.target)) {
            dropdown.classList.add('hidden');
            window.notificationsVisible = false;
        }
    });

    // Initialize notification count update if function exists
    if (typeof window.updateNotificationCount === 'function') {
        window.updateNotificationCount();
        setInterval(window.updateNotificationCount, 10000);
    }

    // --- BEGIN: Greeting and Quote Logic ---
    function updateGreeting() {
        const hour = new Date().getHours();
        const greetingElement = document.getElementById('greeting');
        const waveEmojiElement = document.getElementById('wave-emoji');
        let greeting, waveEmoji;
        if (hour >= 5 && hour < 12) {
            greeting = 'Good Morning';
            waveEmoji = '👋';
        } else if (hour >= 12 && hour < 17) {
            greeting = 'Good Afternoon';
            waveEmoji = '👋';
        } else if (hour >= 17 && hour < 21) {
            greeting = 'Good Evening';
            waveEmoji = '👋';
        } else {
            greeting = 'Good Night';
            waveEmoji = '👋';
        }
        if (greetingElement) greetingElement.textContent = greeting;
        if (waveEmojiElement) waveEmojiElement.textContent = waveEmoji;
    }

    const quotes = [
        { text: "The best investment you can make is in yourself.", author: "Warren Buffett" },
        { text: "Land is the only thing in the world worth working for, worth fighting for, worth dying for.", author: "Margaret Mitchell" },
        { text: "Real estate cannot be lost or stolen, nor can it be carried away.", author: "Franklin D. Roosevelt" },
        { text: "Buy land, they're not making it anymore.", author: "Mark Twain" },
        { text: "The land is where our roots are. The children must be taught to feel and live in harmony with the Earth.", author: "Maria Montessori" },
        { text: "Every piece of land has a story to tell.", author: "Unknown" },
        { text: "Land is the basis of all wealth.", author: "John Locke" },
        { text: "The earth is what we all have in common.", author: "Wendell Berry" }
    ];
    let currentQuoteIndex = 0;
    function updateQuote() {
        const quoteElement = document.getElementById('quote');
        const authorElement = document.getElementById('quote-author');
        const quote = quotes[currentQuoteIndex];
        if (quoteElement) quoteElement.textContent = `"${quote.text}"`;
        if (authorElement) authorElement.textContent = quote.author;
        currentQuoteIndex = (currentQuoteIndex + 1) % quotes.length;
    }

    // Initialize greeting and quote
    updateGreeting();
    updateQuote();
    setInterval(updateGreeting, 60000);
    setInterval(updateQuote, 10000);
    // --- END: Greeting and Quote Logic ---

    // --- BEGIN: Notification Bell Interactivity ---
    window.notificationsVisible = false;
    window.toggleNotifications = function() {
        const dropdown = document.getElementById('notifications-dropdown');
        if (!dropdown) return;
        if (window.notificationsVisible) {
            dropdown.classList.add('hidden');
            window.notificationsVisible = false;
        } else {
            dropdown.classList.remove('hidden');
            window.loadNotifications();
            window.notificationsVisible = true;
        }
    };
    window.loadNotifications = function() {
        const route = document.body.dataset.userRole === 'admin' ? '/admin/notifications' : '/customer/notifications';
        const list = document.getElementById('notifications-list');
        if (!list) return;
        list.innerHTML = '<div class="p-4 text-center text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Loading notifications...</div>';
        fetch(route)
            .then(response => response.json())
            .then(data => {
                list.innerHTML = '';
                const notifications = Array.isArray(data) ? data : (data.data || []);
                if (!notifications || notifications.length === 0) {
                    list.innerHTML = '<div class="p-6 text-center text-yellow-500 font-semibold flex flex-col items-center justify-center"><i class="fas fa-bell-slash text-3xl mb-2"></i>No notifications yet</div>';
                    return;
                }
                notifications.forEach(notification => {
                    const item = document.createElement('div');
                    item.className = 'p-4 hover:bg-yellow-50 transition-colors duration-200 flex items-start gap-3';
                    item.innerHTML = `<div><i class="fas fa-bell text-yellow-500"></i></div><div><div class="font-semibold text-gray-800">${notification.title || 'Notification'}</div><div class="text-gray-600 text-sm">${notification.message || ''}</div><div class="text-xs text-gray-400 mt-1">${notification.created_at ? new Date(notification.created_at).toLocaleString() : ''}</div></div>`;
                    list.appendChild(item);
                });
            })
            .catch(() => {
                list.innerHTML = '<div class="p-4 text-center text-red-500">Failed to load notifications</div>';
            });
    };
    window.markAllAsRead = function() {
        // Optionally implement AJAX to mark all as read
        window.loadNotifications();
    };
    window.viewAllNotifications = function() {
        window.location.href = document.body.dataset.userRole === 'admin' ? '/admin/notifications' : '/customer/notifications';
    };
    // --- END: Notification Bell Interactivity ---

    // Auto-advance customer plot carousels
    document.querySelectorAll('[class^="plot-carousel-"]').forEach(function(carousel) {
        const plotIdMatch = carousel.className.match(/plot-carousel-(\d+)/);
        if (!plotIdMatch) return;
        const plotId = plotIdMatch[1];
        const slides = carousel.querySelectorAll('.carousel-slide');
        if (slides.length <= 1) return;
        let currentIndex = 0;
        setInterval(() => {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === currentIndex);
                slide.classList.toggle('opacity-100', i === currentIndex);
                slide.classList.toggle('z-10', i === currentIndex);
                slide.classList.toggle('opacity-0', i !== currentIndex);
                slide.classList.toggle('z-0', i !== currentIndex);
            });
            // Update dots if present
            const dots = document.querySelectorAll('.carousel-dot-' + plotId);
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-yellow-500', i === currentIndex);
            });
            // Update counter if present
            const counter = document.querySelector('.image-counter-' + plotId);
            if (counter) counter.textContent = currentIndex + 1;
            currentIndex = (currentIndex + 1) % slides.length;
        }, 4000);
    });

    // Auto-advance for plot details page carousel
    const carousel = document.getElementById('carousel');
    if (carousel) {
        const images = carousel.querySelectorAll('.carousel-img');
        const dots = carousel.querySelectorAll('.carousel-dot');
        if (images.length > 1) {
            let currentIndex = 0;
            setInterval(() => {
                images.forEach((img, i) => {
                    img.classList.toggle('opacity-100', i === currentIndex);
                    img.classList.toggle('z-10', i === currentIndex);
                    img.classList.toggle('opacity-0', i !== currentIndex);
                    img.classList.toggle('z-0', i !== currentIndex);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-yellow-500', i === currentIndex);
                    dot.classList.toggle('bg-white', i !== currentIndex);
                });
                currentIndex = (currentIndex + 1) % images.length;
            }, 4000);
        }
    }

    // Auto-advance for admin plot details page carousel
    const adminCarousel = document.getElementById('admin-carousel');
    if (adminCarousel) {
        const images = adminCarousel.querySelectorAll('.admin-carousel-img');
        const dots = adminCarousel.querySelectorAll('.admin-carousel-dot');
        if (images.length > 1) {
            let currentIndex = 0;
            setInterval(() => {
                images.forEach((img, i) => {
                    img.classList.toggle('opacity-100', i === currentIndex);
                    img.classList.toggle('z-10', i === currentIndex);
                    img.classList.toggle('opacity-0', i !== currentIndex);
                    img.classList.toggle('z-0', i !== currentIndex);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-yellow-500', i === currentIndex);
                    dot.classList.toggle('bg-white', i !== currentIndex);
                });
                currentIndex = (currentIndex + 1) % images.length;
            }, 4000);
        }
    }
});

// Make quick actions work globally
window.navigateTo = function(url) {
    window.location.href = url;
};
window.contactSupport = function() {
    const modal = document.getElementById('contact-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
};

// Support modal logic
window.closeContactModal = function() {
    const modal = document.getElementById('contact-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
};
window.submitContactForm = function() {
    const name = document.getElementById('contact-name');
    const email = document.getElementById('contact-email');
    const message = document.getElementById('contact-message');
    let valid = true;
    // Simple validation
    if (!name.value.trim()) {
        document.getElementById('name-error').textContent = 'Name is required.';
        document.getElementById('name-error').classList.remove('hidden');
        valid = false;
    } else {
        document.getElementById('name-error').classList.add('hidden');
    }
    if (!email.value.trim() || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.value)) {
        document.getElementById('email-error').textContent = 'Valid email is required.';
        document.getElementById('email-error').classList.remove('hidden');
        valid = false;
    } else {
        document.getElementById('email-error').classList.add('hidden');
    }
    if (!message.value.trim()) {
        document.getElementById('message-error').textContent = 'Message is required.';
        document.getElementById('message-error').classList.remove('hidden');
        valid = false;
    } else {
        document.getElementById('message-error').classList.add('hidden');
    }
    if (!valid) return;
    // Simulate sending (show loading, then success)
    const sendBtn = document.querySelector('#contact-modal button[onclick="submitContactForm()"]');
    if (sendBtn) {
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
    }
    setTimeout(() => {
        if (sendBtn) {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Send Message';
        }
        alert('Your message has been sent! Support will contact you soon.');
        window.closeContactModal();
        // Optionally clear fields
        name.value = '';
        email.value = '';
        message.value = '';
        document.getElementById('message-count').textContent = '0';
    }, 1200);
};

// Carousel navigation for customer plots
window.prevCarouselImage = function(plotId) {
    const imgs = document.querySelectorAll('.carousel-img-' + plotId);
    const dots = document.querySelectorAll('.carousel-dot-' + plotId);
    let idx = Array.from(imgs).findIndex(img => img.classList.contains('opacity-100'));
    imgs[idx].classList.remove('opacity-100', 'z-10');
    imgs[idx].classList.add('opacity-0', 'z-0');
    dots[idx].classList.remove('bg-yellow-500');
    idx = (idx - 1 + imgs.length) % imgs.length;
    imgs[idx].classList.add('opacity-100', 'z-10');
    imgs[idx].classList.remove('opacity-0', 'z-0');
    dots[idx].classList.add('bg-yellow-500');
}
window.nextCarouselImage = function(plotId) {
    const imgs = document.querySelectorAll('.carousel-img-' + plotId);
    const dots = document.querySelectorAll('.carousel-dot-' + plotId);
    let idx = Array.from(imgs).findIndex(img => img.classList.contains('opacity-100'));
    imgs[idx].classList.remove('opacity-100', 'z-10');
    imgs[idx].classList.add('opacity-0', 'z-0');
    dots[idx].classList.remove('bg-yellow-500');
    idx = (idx + 1) % imgs.length;
    imgs[idx].classList.add('opacity-100', 'z-10');
    imgs[idx].classList.remove('opacity-0', 'z-0');
    dots[idx].classList.add('bg-yellow-500');
}
