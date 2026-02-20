<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourEase Pro | Discover Your Next Adventure</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #2d3748;
            overflow-x: hidden;
            background: #ffffff;
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section {
            padding: 100px 0;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .section-title p {
            color: #718096;
            font-size: 1.15rem;
            max-width: 700px;
            margin: 20px auto 0;
            line-height: 1.8;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            border: 2px solid transparent;
            gap: 10px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(240, 147, 251, 0.4);
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(240, 147, 251, 0.5);
        }

        .btn-outline {
            background: transparent;
            border-color: #667eea;
            color: #667eea;
        }

        .btn-outline:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        /* Header Styles */
        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        #header.scrolled {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.98);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transition: transform 0.3s;
        }

        .logo:hover .logo-icon {
            transform: rotate(-10deg) scale(1.1);
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Navigation */
        .desktop-nav .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #4a5568;
            font-weight: 500;
            position: relative;
            transition: color 0.3s;
            font-size: 15px;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #667eea;
        }

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 28px;
            color: #667eea;
            cursor: pointer;
            padding: 10px;
            transition: transform 0.3s;
        }

        .mobile-menu-btn:hover {
            transform: rotate(90deg);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 320px;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            gap: 40px;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-menu.active {
            right: 0;
        }

        .close-menu {
            align-self: flex-end;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            font-size: 28px;
            color: white;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .close-menu:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .mobile-menu .nav-links {
            display: flex;
            flex-direction: column;
            gap: 25px;
            list-style: none;
        }

        .mobile-menu .nav-links a {
            color: white;
            font-size: 18px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-menu .nav-links a:hover {
            color: white;
            padding-left: 10px;
        }

        .mobile-menu .nav-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .mobile-menu .btn {
            background: white;
            color: #667eea;
            border: none;
        }

        /* Hero Section */
        .hero {
            padding: 180px 0 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            margin-bottom: 30px;
            color: white;
            line-height: 1.1;
            font-weight: 800;
        }

        .hero-content h1 span {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 60px;
        }

        .hero-buttons .btn {
            background: white;
            color: #667eea;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .hero-buttons .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .hero-buttons .btn-outline {
            background: transparent;
            border-color: white;
            color: white;
        }

        .hero-buttons .btn-outline:hover {
            background: white;
            color: #667eea;
        }

        .stats-container {
            display: flex;
            gap: 50px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .hero-image {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.6s;
        }

        .hero-image:hover {
            transform: perspective(1000px) rotateY(0deg) scale(1.02);
        }

        .hero-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        /* Features Section */
        .features {
            background: linear-gradient(180deg, #f7fafc 0%, #ffffff 100%);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
        }

        .feature-card {
            background: white;
            padding: 45px 35px;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.4s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 25px;
            transition: transform 0.4s;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-10deg);
        }

        .feature-icon.booking {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .feature-icon.customer {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
        }

        .feature-icon.analytics {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3);
        }

        .feature-card h3 {
            margin-bottom: 15px;
            color: #2d3748;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .feature-card p {
            color: #718096;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        /* Destinations Section */
        .destinations {
            background: white;
        }

        .destination-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .destination-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .destination-image {
            position: relative;
            height: 280px;
            overflow: hidden;
        }

        .destination-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s;
        }

        .destination-card:hover .destination-image img {
            transform: scale(1.15);
        }

        .destination-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .destination-content {
            padding: 30px;
        }

        .destination-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #2d3748;
        }

        .destination-location {
            color: #718096;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .destination-location i {
            color: #f5576c;
        }

        .destination-description {
            color: #4a5568;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .destination-price {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }

        .destination-actions {
            display: flex;
            gap: 12px;
        }

        /* Gallery Section */
        .gallery {
            background: linear-gradient(180deg, #f7fafc 0%, #ffffff 100%);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .gallery-item {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            transition: all 0.4s;
            cursor: pointer;
            position: relative;
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 1;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .gallery-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .gallery-content {
            padding: 20px;
        }

        .gallery-content h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .gallery-content p {
            color: #718096;
            font-size: 0.875rem;
        }

        /* About Section */
        .about {
            background: white;
        }

        .about-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .about-content p {
            color: #4a5568;
            margin-bottom: 20px;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .about-list {
            list-style: none;
            margin: 30px 0;
        }

        .about-list li {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: #4a5568;
            font-size: 1.05rem;
        }

        .about-list i {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .about-image {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Testimonials */
        .testimonials {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .testimonials .section-title h2 {
            color: white;
            -webkit-text-fill-color: white;
        }

        .testimonials .section-title h2::after {
            background: white;
        }

        .testimonials .section-title p {
            color: rgba(255, 255, 255, 0.9);
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 50px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            margin: 0 auto;
        }

        .testimonial-content {
            font-size: 1.3rem;
            color: white;
            font-style: italic;
            margin-bottom: 35px;
            line-height: 1.9;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .author-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            color: white;
            margin-bottom: 5px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .author-info p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            text-align: center;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .cta h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 25px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }

        .cta p {
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto 50px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            line-height: 1.8;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 25px;
            position: relative;
            z-index: 1;
        }

        .cta .btn {
            background: white;
            color: #f5576c;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .cta .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
            padding: 100px 0 30px;
            position: relative;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 70px;
        }

        .footer-column h3 {
            font-size: 1.4rem;
            margin-bottom: 25px;
            color: white;
            font-weight: 700;
        }

        .footer-column p {
            color: #cbd5e0;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 10px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .social-icons a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .copyright {
            text-align: center;
            padding-top: 35px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e0;
            font-size: 0.95rem;
        }

        .copyright a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .copyright a:hover {
            color: white;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 20px;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-container {
            background: white;
            border-radius: 30px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
            border-radius: 30px 30px 0 0;
        }

        .modal-title {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-content {
            padding: 40px;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 35px;
        }

        @media (min-width: 768px) {
            .modal-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .modal-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
        }

        .modal-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
            display: block;
        }

        .modal-image-placeholder {
            width: 100%;
            height: 350px;
            background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #718096;
            font-size: 1rem;
            border-radius: 20px;
        }

        .modal-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .detail-section {
            background: linear-gradient(135deg, #f7fafc 0%, #ffffff 100%);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
        }

        .detail-label {
            font-size: 0.875rem;
            color: #718096;
            margin-bottom: 8px;
            display: block;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1.05rem;
            color: #2d3748;
            font-weight: 500;
        }

        .price-value {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .coordinates {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .coordinate-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px solid #e2e8f0;
        }

        .modal-actions .btn {
            flex: 1;
        }

        /* Utility Classes */
        .grid {
            display: grid;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-container,
            .about-container {
                grid-template-columns: 1fr;
                gap: 50px;
            }
            
            .hero-content h1 {
                font-size: 3rem;
            }
            
            .section-title h2 {
                font-size: 2.5rem;
            }

            .hero-image {
                transform: none;
            }
        }

        @media (max-width: 768px) {
            .desktop-nav {
                display: none;
            }
            
            .nav-buttons:not(.mobile-menu .nav-buttons) {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn {
                width: 100%;
            }
            
            .stats-container {
                flex-direction: column;
                gap: 20px;
            }

            .stat-item {
                width: 100%;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .cta-buttons .btn {
                width: 100%;
            }
            
            .hero {
                padding: 150px 0 100px;
            }
            
            .section {
                padding: 70px 0;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .cta h2 {
                font-size: 2.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .destination-actions {
                flex-direction: column;
            }

            .destination-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 1.75rem;
            }
            
            .cta h2 {
                font-size: 2rem;
            }
            
            .modal-header {
                padding: 20px 25px;
            }
            
            .modal-content {
                padding: 25px;
            }
            
            .coordinates {
                grid-template-columns: 1fr;
            }

            .modal-grid {
                grid-template-columns: 1fr;
            }

            .btn {
                padding: 14px 24px;
                font-size: 14px;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header id="header">
        <div class="container header-container">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <div class="logo-text">TourEase Pro</div>
            </div>
            
            <nav class="desktop-nav">
                <ul class="nav-links">
                    <li><a href="#home" class="active">Home</a></li>
                    <li><a href="#destinations">Destinations</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <button class="close-menu" id="closeMenu">
                <i class="fas fa-times"></i>
            </button>
            <ul class="nav-links">
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#destinations">Destinations</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn">Log In</a>
                <a href="{{ route('register') }}" class="btn">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Transform Your Tourism Business with <span>TourEase Pro</span></h1>
                <p>Discover breathtaking destinations, manage your tours seamlessly, and deliver unforgettable experiences to your customers with our comprehensive tourism management platform.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn">
                        <i class="fas fa-rocket"></i> Start Free Trial
                    </a>
                    <button class="btn btn-outline" id="heroDemoBtn">
                        <i class="fas fa-play-circle"></i> Watch Demo
                    </button>
                </div>
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Happy Businesses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfaction Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
            <div class="hero-image float-animation">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="TourEase Dashboard" onerror="this.src='https://via.placeholder.com/800x600/667eea/FFFFFF?text=TourEase+Dashboard'">
            </div>
        </div>
    </section>


    <!-- Destinations Section -->
    <section class="section destinations" id="destinations">
        <div class="container">
            <div class="section-title">
                <h2>Popular Destinations</h2>
                <p>Explore our featured destinations and plan your next unforgettable adventure</p>
            </div>

            <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px;">
                @forelse($destinations as $destination)
                    <div class="destination-card">
                        <div class="destination-image">
                            @if($destination->image)
                                <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}">
                            @else
                                <div style="width: 100%; height: 280px; background: linear-gradient(135deg, #f7fafc 0%, #e2e8f0 100%); display: flex; align-items: center; justify-content: center; color: #718096;">
                                    <i class="fas fa-image" style="font-size: 3rem; opacity: 0.3;"></i>
                                </div>
                            @endif
                            @if($destination->price)
                                <div class="destination-badge">Featured</div>
                            @endif
                        </div>

                        <div class="destination-content">
                            <h3>{{ $destination->name }}</h3>
                            <p class="destination-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $destination->location }}
                            </p>
                            <p class="destination-description">{{ Str::limit($destination->description, 100) }}</p>

                            @if($destination->price)
                                <div class="destination-price">₱{{ number_format($destination->price, 2) }}</div>
                            @endif

                            <div class="destination-actions">
                                <button data-destination-id="{{ $destination->id }}"
                                        data-destination-name="{{ $destination->name }}"
                                        data-destination-location="{{ $destination->location }}"
                                        data-destination-description="{{ $destination->description }}"
                                        data-destination-price="{{ $destination->price ? '₱' . number_format($destination->price, 2) : '' }}"
                                        data-destination-image="{{ $destination->image ? asset('storage/' . $destination->image) : '' }}"
                                        data-destination-latitude="{{ $destination->latitude }}"
                                        data-destination-longitude="{{ $destination->longitude }}"
                                        class="btn btn-outline view-details-btn" style="flex: 1;">
                                    <i class="fas fa-eye"></i> View Details
                                </button>
                                <a href="{{ auth()->check() ? route('booking.create', ['destination_id' => $destination->id]) : route('login', ['redirect_to' => route('booking.create', ['destination_id' => $destination->id])]) }}" class="btn btn-primary" style="flex: 1;">
                                    <i class="fas fa-calendar-check"></i> Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #718096;">
                        <i class="fas fa-map-marked-alt" style="font-size: 4rem; opacity: 0.3; margin-bottom: 20px;"></i>
                        <p style="font-size: 1.1rem;">No destinations available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ route('destinations.index') }}" class="btn btn-primary">
                    <i class="fas fa-th-large"></i> View All Destinations
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section gallery" id="gallery">
        <div class="container">
            <div class="section-title">
                <h2>Photo Gallery</h2>
                <p>Discover the beauty of our destinations through stunning photography</p>
            </div>

            <div class="gallery-grid">
                @forelse($galleries as $gallery)
                    <div class="gallery-item">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="gallery-image">
                        <div class="gallery-content">
                            <h3>{{ $gallery->title }}</h3>
                            @if($gallery->description)
                                <p>{{ Str::limit($gallery->description, 50) }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #718096;">
                        <i class="fas fa-images" style="font-size: 4rem; opacity: 0.3; margin-bottom: 20px;"></i>
                        <p style="font-size: 1.1rem;">No photos available at the moment.</p>
                    </div>
                @endforelse
            </div>

            <div style="text-align: center; margin-top: 50px;">
                <a href="{{ route('gallery.index') }}" class="btn btn-primary">
                    <i class="fas fa-images"></i> View Full Gallery
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about" id="about">
        <div class="container about-container">
            <div class="about-content">
                <h2>Why Choose TourEase Pro?</h2>
                <p>TourEase Pro was developed by tourism industry veterans who understand the unique challenges faced by travel businesses. Our platform combines cutting-edge technology with deep industry expertise.</p>
                <p>We're committed to helping tourism businesses thrive in an increasingly competitive landscape by providing tools that adapt to your workflow.</p>
                <ul class="about-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Cloud-Based Platform:</strong> Access your data securely from anywhere, anytime</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Scalable Solution:</strong> Grows with your business from startup to enterprise</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Integrated Payments:</strong> Process transactions securely with multiple payment options</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Multi-language Support:</strong> Serve customers in their preferred language</span>
                    </li>
                </ul>
                <button class="btn btn-secondary" id="readStoryBtn">
                    <i class="fas fa-book-open"></i> Read Our Story
                </button>
            </div>
            <div class="about-image float-animation">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="TourEase Team" onerror="this.src='https://via.placeholder.com/800x600/667eea/FFFFFF?text=TourEase+Team'">
            </div>
        </div>
    </section>

    

    

    <!-- Feedback Section -->
    <section class="section" id="feedback" style="background: linear-gradient(180deg, #ffffff 0%, #f7fafc 100%);">
        <div class="container">
            <!-- Success Message -->
            @if(session('success'))
            <div style="max-width: 700px; margin: 0 auto 30px; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 15px; padding: 20px 30px; display: flex; align-items: center; gap: 15px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.2);">
                <div style="width: 50px; height: 50px; background: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-check" style="color: white; font-size: 1.25rem;"></i>
                </div>
                <div>
                    <h4 style="color: #065f46; font-weight: 700; margin-bottom: 5px;">Thank You!</h4>
                    <p style="color: #047857; margin: 0;">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
            <div style="max-width: 700px; margin: 0 auto 30px; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-radius: 15px; padding: 20px 30px; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2);">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                    <div style="width: 50px; height: 50px; background: #dc2626; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-exclamation-triangle" style="color: white; font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <h4 style="color: #991b1b; font-weight: 700;">Please correct the following errors:</h4>
                    </div>
                </div>
                <ul style="margin: 0; padding-left: 20px; color: #b91c1c;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>TourEase Pro</h3>
                    <p>The leading tourism management system for travel agencies, tour operators, and destination management companies worldwide.</p>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#destinations">Destinations</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#about">About</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API Reference</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Us</h3>

    <!-- Destination Details Modal -->
    <div class="modal-overlay" id="destinationModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Destination Details</div>
                <button class="modal-close" id="modalCloseBtn" aria-label="Close modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-content">
                <div class="modal-grid">
                    <div class="modal-image-container">
                        <img id="modalImage" src="" alt="Destination Image" class="modal-image">
                        <div id="modalImagePlaceholder" class="modal-image-placeholder" style="display: none;">
                            <i class="fas fa-image" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p style="margin-top: 10px;">No Image Available</p>
                        </div>
                    </div>
                    
                    <div class="modal-details">
                        <div class="detail-section">
                            <span class="detail-label">Destination</span>
                            <h3 id="modalName" class="detail-value" style="font-size: 1.75rem; font-weight: 700; margin-bottom: 10px;"></h3>
                            <span class="detail-label">Location</span>
                            <p id="modalLocation" class="detail-value" style="color: #f5576c;">
                                <i class="fas fa-map-marker-alt"></i> <span id="modalLocationText"></span>
                            </p>
                        </div>
                        
                        <div class="detail-section">
                            <span class="detail-label">Price</span>
                            <div id="modalPrice" class="price-value">Not specified</div>
                        </div>
                        
                        <div class="detail-section">
                            <span class="detail-label">Description</span>
                            <p id="modalDescription" class="detail-value"></p>
                        </div>
                        
                        <div class="detail-section">
                            <span class="detail-label">Coordinates</span>
                            <div class="coordinates">
                                <div class="coordinate-item">
                                    <span class="detail-label">Latitude</span>
                                    <div id="modalLatitude" class="detail-value">N/A</div>
                                </div>
                                <div class="coordinate-item">
                                    <span class="detail-label">Longitude</span>
                                    <div id="modalLongitude" class="detail-value">N/A</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </a>
                    <button class="btn btn-outline" id="modalCloseBtn2">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Header scroll effect
        const header = document.getElementById('header');
        const updateHeader = () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        };
        window.addEventListener('scroll', updateHeader);
        updateHeader();

        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMenu = document.getElementById('closeMenu');
        
        const openMobileMenu = () => {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        
        const closeMobileMenu = () => {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = 'auto';
        };
        
        mobileMenuBtn.addEventListener('click', openMobileMenu);
        closeMenu.addEventListener('click', closeMobileMenu);

        // Close mobile menu when clicking on links
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Demo button functionality
        document.getElementById('heroDemoBtn').addEventListener('click', () => {
            alert('Demo video would play here. Redirecting to demo page...');
        });

        document.getElementById('ctaScheduleBtn').addEventListener('click', () => {
            alert('Scheduling functionality would open here.');
        });

        // Read story button
        document.getElementById('readStoryBtn').addEventListener('click', () => {
            alert('Redirecting to our story page...');
        });

        // Feature learn more buttons
        document.querySelectorAll('.feature-learn-more').forEach(button => {
            button.addEventListener('click', (e) => {
                const featureTitle = e.target.closest('.feature-card').querySelector('h3').textContent;
                alert(`Loading more information about: ${featureTitle}`);
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const headerHeight = header.offsetHeight;
                    const targetPosition = targetElement.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update active nav link
                    document.querySelectorAll('.nav-links a').forEach(link => {
                        link.classList.remove('active');
                    });
                    this.classList.add('active');
                }
            });
        });

        // Update active nav link on scroll
        const sections = document.querySelectorAll('section[id]');
        const updateActiveLink = () => {
            const scrollPosition = window.scrollY + 150;
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                const sectionId = section.getAttribute('id');
                
                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    document.querySelectorAll('.nav-links a').forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${sectionId}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        };
        
        window.addEventListener('scroll', updateActiveLink);

        // Destination Modal Functions
        function openDestinationModal(id, name, location, description, price, image, latitude, longitude) {
            document.getElementById('modalTitle').textContent = name;
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalLocationText').textContent = location;
            document.getElementById('modalDescription').textContent = description;
            
            const priceElement = document.getElementById('modalPrice');
            if (price && price !== '') {
                priceElement.textContent = price;
                priceElement.classList.add('price-value');
            } else {
                priceElement.textContent = 'Not specified';
                priceElement.classList.remove('price-value');
                priceElement.style.fontSize = '1rem';
                priceElement.style.color = '#718096';
            }
            
            const modalImage = document.getElementById('modalImage');
            const modalImagePlaceholder = document.getElementById('modalImagePlaceholder');
            
            if (image && image !== '') {
                modalImage.src = image;
                modalImage.alt = name;
                modalImage.style.display = 'block';
                modalImagePlaceholder.style.display = 'none';
                
                modalImage.onerror = function() {
                    this.style.display = 'none';
                    modalImagePlaceholder.style.display = 'flex';
                };
            } else {
                modalImage.style.display = 'none';
                modalImagePlaceholder.style.display = 'flex';
            }
            
            document.getElementById('modalLatitude').textContent = latitude || 'N/A';
            document.getElementById('modalLongitude').textContent = longitude || 'N/A';
            
            const modal = document.getElementById('destinationModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDestinationModal() {
            const modal = document.getElementById('destinationModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Modal event listeners
        document.getElementById('modalCloseBtn').addEventListener('click', closeDestinationModal);
        document.getElementById('modalCloseBtn2').addEventListener('click', closeDestinationModal);

        document.getElementById('destinationModal').addEventListener('click', (e) => {
            if (e.target.id === 'destinationModal') {
                closeDestinationModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && document.getElementById('destinationModal').classList.contains('active')) {
                closeDestinationModal();
            }
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });

        // Add event listeners to View Details buttons
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.view-details-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = button.getAttribute('data-destination-id');
                    const name = button.getAttribute('data-destination-name');
                    const location = button.getAttribute('data-destination-location');
                    const description = button.getAttribute('data-destination-description');
                    const price = button.getAttribute('data-destination-price');
                    const image = button.getAttribute('data-destination-image');
                    const latitude = button.getAttribute('data-destination-latitude');
                    const longitude = button.getAttribute('data-destination-longitude');

                    openDestinationModal(id, name, location, description, price, image, latitude, longitude);
                });
            });
            
            updateActiveLink();
        });

        // Star Rating Functions for Feedback Form
        let currentRating = 0;

        function highlightStars(rating) {
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                if (i <= rating) {
                    star.style.color = '#fbbf24';
                    star.style.transform = 'scale(1.2)';
                } else {
                    star.style.color = '#e2e8f0';
                    star.style.transform = 'scale(1)';
                }
            }
        }

        function resetStars() {
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                if (i <= currentRating) {
                    star.style.color = '#fbbf24';
                    star.style.transform = 'scale(1)';
                } else {
                    star.style.color = '#e2e8f0';
                    star.style.transform = 'scale(1)';
                }
            }
            
            const ratingText = document.getElementById('ratingText');
            if (currentRating > 0) {
                const texts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
                ratingText.textContent = texts[currentRating] + ' - Click to change';
            } else {
                ratingText.textContent = 'Click on a star to rate';
            }
        }

        function selectRating(rating) {
            currentRating = rating;
            document.getElementById('selectedRating').value = rating;
            
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                if (i <= rating) {
                    star.style.color = '#fbbf24';
                } else {
                    star.style.color = '#e2e8f0';
                }
            }
            
            const ratingText = document.getElementById('ratingText');
            const texts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            ratingText.textContent = texts[rating] + ' - Thank you!';
        }
    </script>
</body>
</html>