<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Atsogo Estate Agency</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #23272f;
            margin: 0;
        }
        .hero {
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: #fff;
            padding: 3rem 1rem 2rem 1rem;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }
        .hero-logo {
            width: 90px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 4px 16px rgba(245,158,66,0.10));
            animation: popIn 1s cubic-bezier(.68,-0.55,.27,1.55);
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #f59e42;
            margin-bottom: 1rem;
            letter-spacing: -1px;
            text-shadow: 0 2px 16px rgba(245,158,66,0.10);
            animation: fadeInUp 1.2s 0.2s both;
        }
        .hero-desc {
            font-size: 1.15rem;
            color: #555;
            margin-bottom: 2rem;
            font-weight: 500;
            animation: fadeInUp 1.2s 0.4s both;
        }
        .cta-btn {
            background: linear-gradient(90deg, #fbbf24, #f59e42);
            color: #fff;
            font-weight: 700;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1.15rem;
            cursor: pointer;
            box-shadow: 0 4px 24px rgba(245, 158, 66, 0.10);
            transition: background 0.2s, transform 0.2s;
            text-decoration: none;
            letter-spacing: 1px;
            animation: fadeInUp 1.2s 0.6s both;
            display: inline-block;
        }
        .cta-btn:hover {
            background: linear-gradient(90deg, #f59e42, #fbbf24);
            transform: translateY(-2px) scale(1.04);
        }
        .hero-illustration {
            margin-top: 2.5rem;
            width: 320px;
            max-width: 90vw;
            animation: fadeInUp 1.2s 0.8s both;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            margin: 0 0 2.5rem 0;
            position: relative;
            z-index: 2;
            padding: 0 1rem;
        }
        .feature-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 2px 16px rgba(245,158,66,0.08);
            padding: 1.7rem 1.2rem 1.2rem 1.2rem;
            max-width: 300px;
            min-width: 220px;
            text-align: left;
            transition: transform 0.18s, box-shadow 0.18s;
            border-left: 6px solid #fbbf24;
            animation: fadeInUp 1.2s 1s both;
            flex: 1 1 220px;
        }
        .feature-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px rgba(245,158,66,0.13);
        }
        .feature-icon {
            font-size: 2rem;
            color: #f59e42;
            margin-bottom: 1rem;
            animation: popIn 1.2s;
        }
        .feature-title {
            font-weight: 700;
            font-size: 1.08rem;
            margin-bottom: 0.5rem;
            color: #f59e42;
        }
        .feature-desc {
            color: #555;
            font-size: 0.98rem;
        }
        footer {
            background: #fffbe6;
            border-top: 1px solid #ffe8a3;
            text-align: center;
            padding: 1.5rem 0 1rem 0;
            color: #bfa14a;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .features { flex-direction: column; align-items: center; }
            .feature-card { max-width: 95vw; }
        }
        @media (max-width: 600px) {
            .hero-title { font-size: 1.5rem; }
            .hero-desc { font-size: 0.98rem; }
            .hero-illustration { width: 180px; }
            .hero { padding: 2rem 0.5rem 1.5rem 0.5rem; }
        }
        @keyframes popIn {
            0% { transform: scale(0.7); opacity: 0; }
            80% { transform: scale(1.08); opacity: 1; }
            100% { transform: scale(1); }
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    @if(session('success'))
        <style>
            #logout-success-message {
                animation: fadeSlideIn 0.5s cubic-bezier(0.4,0,0.2,1);
                border-left: 6px solid #22c55e;
                background: #f0fdf4;
                color: #166534;
                box-shadow: 0 4px 24px 0 rgba(34,197,94,0.10);
                border-radius: 0.75rem;
                min-width: 220px;
                max-width: 90vw;
                padding: 14px 24px 14px 20px;
                font-size: 1rem;
                font-weight: 500;
                position: fixed;
                top: 2rem;
                left: 2rem;
                right: auto;
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            @keyframes fadeSlideIn {
                from { opacity: 0; transform: translateX(40px); }
                to { opacity: 1; transform: translateX(0); }
            }
            #logout-success-message .close-btn {
                opacity: 0;
                transition: opacity 0.2s;
                background: transparent;
                border: none;
                color: #22c55e;
                font-size: 1.2rem;
                cursor: pointer;
                margin-left: auto;
            }
            #logout-success-message:hover .close-btn {
                opacity: 1;
            }
        </style>
        <div id="logout-success-message">
            <span>{{ session('success') }}</span>
            <button onclick="dismissLogoutSuccessMessage()" class="close-btn" aria-label="Close">&times;</button>
        </div>
        <script>
            setTimeout(function() {
                var msg = document.getElementById('logout-success-message');
                if(msg) { msg.style.opacity = 0; msg.style.transform = 'translateX(40px)'; setTimeout(function(){ msg.remove(); }, 400); }
            }, 5000);
            function dismissLogoutSuccessMessage() {
                var msg = document.getElementById('logout-success-message');
                if(msg) { msg.style.opacity = 0; msg.style.transform = 'translateX(40px)'; setTimeout(function(){ msg.remove(); }, 400); }
            }
        </script>
    @endif
    <div class="hero">
        <div class="hero-content">
            <img src="https://img.icons8.com/ios-filled/100/ffa500/real-estate.png" alt="Atsogo Logo" class="hero-logo">
            <div class="hero-title">Welcome to Atsogo Estate Agency</div>
            <div class="hero-desc">Discover, reserve, and manage land plots with confidence. <br> Your trusted partner for real estate in Malawi.</div>
            <a href="{{ route('login') }}" class="cta-btn">Login / Register</a>
        </div>
        <img class="hero-illustration" src="https://assets10.lottiefiles.com/packages/lf20_2ks3pjua.json" alt="Modern Real Estate Illustration" onerror="this.style.display='none'">
        </div>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div class="feature-title">Browse Plots</div>
            <div class="feature-desc">Explore a wide range of available land plots with detailed information and beautiful images.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
            <div class="feature-title">Easy Reservations</div>
            <div class="feature-desc">Reserve your preferred plot online and track your reservation status in real time.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-comments"></i></div>
            <div class="feature-title">Inquiries & Support</div>
            <div class="feature-desc">Contact our team for any questions or support. We're here to help you succeed.</div>
            </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fas fa-star"></i></div>
            <div class="feature-title">Trusted & Secure</div>
            <div class="feature-desc">Your data and transactions are protected with industry-leading security and privacy.</div>
        </div>
    </div>
    {{-- Footer Section --}}
    <footer class="w-full bg-gradient-to-r from-yellow-50 to-yellow-100 border-t border-yellow-200 mt-12 py-10 px-4 rounded-b-3xl shadow-lg">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-3 mb-4 md:mb-0">
                <img src="https://img.icons8.com/ios-filled/48/ffa500/real-estate.png" alt="Atsogo Logo" class="w-10 h-10">
                <span class="font-bold text-yellow-700 text-lg">Atsogo Estate Agency</span>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-4 text-yellow-700 text-sm">
                <div class="flex items-center gap-2">
                    <i class="fas fa-phone-alt"></i>
                    <span>+265 888 052 362</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-envelope"></i>
                    <span>info@atsogo.mw</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Blantyre, Malawi</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://facebook.com/atsogoestate" target="_blank" class="text-yellow-600 hover:text-yellow-800 text-xl"><i class="fab fa-facebook"></i></a>
                <a href="https://wa.me/265888052362" target="_blank" class="text-green-600 hover:text-green-800 text-xl"><i class="fab fa-whatsapp"></i></a>
                <a href="mailto:info@atsogo.mw" class="text-yellow-600 hover:text-yellow-800 text-xl"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
        <div class="mt-8 text-center text-yellow-700 text-xs font-semibold tracking-wide">
            &copy; {{ date('Y') }} Atsogo Estate Agency. All rights reserved. | Designed with <i class="fas fa-heart text-red-500"></i> in Malawi.
        </div>
    </footer>
</body>
</html> 