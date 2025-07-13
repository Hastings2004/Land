<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Atsogo Estate Agency</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #23272f; margin: 0; }
        .hero { min-height: 80vh; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; }
        .hero-title { font-size: 2.5rem; font-weight: 700; color: #f59e42; margin-bottom: 1rem; }
        .hero-desc { font-size: 1.25rem; color: #555; margin-bottom: 2rem; }
        .cta-btn { background: linear-gradient(90deg, #f59e42, #fbbf24); color: #fff; font-weight: 600; padding: 0.75rem 2rem; border: none; border-radius: 0.5rem; font-size: 1.1rem; cursor: pointer; box-shadow: 0 2px 8px rgba(245, 158, 66, 0.1); transition: background 0.2s; text-decoration: none; }
        .cta-btn:hover { background: linear-gradient(90deg, #fbbf24, #f59e42); }
        .features { display: flex; flex-wrap: wrap; justify-content: center; gap: 2rem; margin: 3rem 0; }
        .feature-card { background: #fff; border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 2rem 1.5rem; max-width: 320px; text-align: left; }
        .feature-icon { font-size: 2rem; color: #f59e42; margin-bottom: 1rem; }
        footer { background: #fff; border-top: 1px solid #eee; text-align: center; padding: 1.5rem 0 1rem 0; color: #888; font-size: 1rem; position: relative; bottom: 0; width: 100%; }
    </style>
</head>
<body>
    <div class="hero">
        <div>
            <img src="https://img.icons8.com/ios-filled/100/ffa500/real-estate.png" alt="Atsogo Logo" style="width:80px; margin-bottom:1.5rem;">
            <div class="hero-title">Welcome to Atsogo Estate Agency</div>
            <div class="hero-desc">Find, reserve, and manage land plots with ease. Your trusted partner for real estate in Malawi.</div>
            <a href="{{ route('login') }}" class="cta-btn">Login / Register</a>
        </div>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-map-marked-alt"></i></div>
                <div class="font-bold mb-2">Browse Plots</div>
                <div>Explore a wide range of available land plots with detailed information and images.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="font-bold mb-2">Easy Reservations</div>
                <div>Reserve your preferred plot online and track your reservation status in real time.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-comments"></i></div>
                <div class="font-bold mb-2">Inquiries & Support</div>
                <div>Contact our team for any questions or support. We're here to help you succeed.</div>
            </div>
        </div>
    </div>
    <footer>
        &copy; {{ date('Y') }} Atsogo Estate Agency. All rights reserved.
    </footer>
</body>
</html> 