<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourEase Pro | Professional Tourism Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #1a365d;
        }

        .section-title p {
            color: #718096;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0066CC 0%, #004C99 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 102, 204, 0.3);
        }

        .btn-secondary {
            background: #00A859;
            color: white;
        }

        .btn-secondary:hover {
            background: #008749;
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border-color: #0066CC;
            color: #0066CC;
        }

        .btn-outline:hover {
            background: #0066CC;
            color: white;
        }

        .btn-cta {
            background: white;
            color: #0066CC;
            padding: 15px 30px;
            font-size: 1.1rem;
        }

        .btn-cta:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
        }

        /* Header Styles */
        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        #header.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0066CC 0%, #004C99 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a365d;
        }

        /* Navigation */
        .desktop-nav .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #4a5568;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #0066CC;
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #0066CC;
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
            font-size: 24px;
            color: #4a5568;
            cursor: pointer;
            padding: 10px;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 300px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1001;
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .mobile-menu.active {
            right: 0;
        }

        .close-menu {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 24px;
            color: #4a5568;
            cursor: pointer;
            padding: 10px;
        }

        .mobile-menu .nav-links {
            display: flex;
            flex-direction: column;
            gap: 20px;
            list-style: none;
        }

        .mobile-menu .nav-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Hero Section */
        .hero {
            padding: 150px 0 100px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .hero-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #1a365d;
            line-height: 1.2;
        }

        .hero-content h1 span {
            color: #0066CC;
        }

        .hero-content p {
            font-size: 1.1rem;
            color: #4a5568;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
        }

        .stats-container {
            display: flex;
            gap: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #0066CC;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
        }

        .hero-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .hero-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .hero-image:hover img {
            transform: scale(1.05);
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .feature-icon.booking {
            background: rgba(0, 102, 204, 0.1);
            color: #0066CC;
        }

        .feature-icon.customer {
            background: rgba(0, 168, 89, 0.1);
            color: #00A859;
        }

        .feature-icon.analytics {
            background: rgba(255, 107, 53, 0.1);
            color: #FF6B35;
        }

        .feature-card h3 {
            margin-bottom: 15px;
            color: #1a365d;
        }

        .feature-card p {
            color: #718096;
            margin-bottom: 20px;
        }

        /* About Section */
        .about-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-list {
            list-style: none;
            margin: 20px 0;
        }

        .about-list li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4a5568;
        }

        .about-list i {
            color: #00A859;
        }

        .about-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Testimonials */
        .testimonial-slider {
            max-width: 800px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin: 0 20px;
        }

        .testimonial-content {
            font-size: 1.1rem;
            color: #4a5568;
            font-style: italic;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            color: #1a365d;
            margin-bottom: 5px;
        }

        .author-info p {
            color: #718096;
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, #0066CC 0%, #004C99 100%);
            color: white;
            text-align: center;
            padding: 100px 0;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* Footer */
        footer {
            background: #1a202c;
            color: white;
            padding: 80px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: white;
        }

        .footer-column p {
            color: #a0aec0;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #a0aec0;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .footer-column p i {
            margin-right: 10px;
            color: #718096;
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #2d3748;
            color: #a0aec0;
            font-size: 0.9rem;
        }

        .copyright a {
            color: #a0aec0;
            text-decoration: none;
        }

        .copyright a:hover {
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-container,
            .about-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
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
            
            .stats-container {
                justify-content: center;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .hero {
                padding: 120px 0 80px;
            }
            
            .section {
                padding: 60px 0;
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
            
            .stats-container {
                flex-direction: column;
                gap: 20px;
            }
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
                    <li><a href="#features">Features</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
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
                <li><a href="#features">Features</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">Log In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Transform Your Tourism Business with <span>TourEase Pro</span></h1>
                <p>A comprehensive, cloud-based tourism management system designed to streamline operations, increase efficiency, and deliver exceptional customer experiences for travel agencies and tour operators worldwide.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i> Start Free Trial
                    </a>
                    <button class="btn btn-outline" id="heroDemoBtn">
                        <i class="fas fa-play-circle"></i> Watch Demo
                    </button>
                </div>
                <div class="stats-container">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Businesses</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="TourEase Dashboard" onerror="this.src='https://via.placeholder.com/800x600/0066CC/FFFFFF?text=TourEase+Dashboard'">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features</h2>
                <p>TourEase Pro provides a complete suite of tools to manage every aspect of your tourism business efficiently.</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon booking">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Advanced Booking Management</h3>
                    <p>Handle reservations, cancellations, and scheduling with our intuitive interface. Real-time availability updates prevent overbooking and streamline operations.</p>
                    <button class="btn btn-outline feature-learn-more">Learn More</button>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon customer">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Customer Relationship Management</h3>
                    <p>Track customer interactions, preferences, and history to provide personalized experiences and build lasting relationships with your clients.</p>
                    <button class="btn btn-outline feature-learn-more">Learn More</button>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon analytics">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Real-Time Analytics & Reporting</h3>
                    <p>Make data-driven decisions with comprehensive dashboards, performance metrics, and customizable reports that highlight key business insights.</p>
                    <button class="btn btn-outline feature-learn-more">Learn More</button>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about" id="about">
        <div class="container about-container">
            <div class="about-content">
                <h2>Why Choose TourEase Pro?</h2>
                <p>TourEase Pro was developed by tourism industry veterans who understand the unique challenges faced by travel businesses. Our platform is the result of 10+ years of research and development.</p>
                <p>We combine cutting-edge technology with deep industry expertise to deliver a solution that adapts to your workflow, not the other way around.</p>
                <ul class="about-list">
                    <li><i class="fas fa-check-circle"></i> <strong>Cloud-Based:</strong> Access your data securely from anywhere, anytime</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Scalable:</strong> Grows with your business from startup to enterprise</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Integrated Payments:</strong> Process transactions securely with multiple payment options</li>
                    <li><i class="fas fa-check-circle"></i> <strong>Multi-language Support:</strong> Serve customers in their preferred language</li>
                </ul>
                <button class="btn btn-secondary" id="readStoryBtn">
                    <i class="fas fa-book-open"></i> Read Our Story
                </button>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80" alt="TourEase Team" onerror="this.src='https://via.placeholder.com/800x600/00A859/FFFFFF?text=TourEase+Team'">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Clients Say</h2>
                <p>Hear from tourism businesses that have transformed their operations with TourEase Pro.</p>
            </div>
            
            <div class="testimonial-slider">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        TourEase Pro has revolutionized how we manage our tours. Bookings are up 40% and operational efficiency has improved dramatically. The customer support team is exceptional.
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Sarah Johnson" onerror="this.src='https://via.placeholder.com/60x60/FF6B35/FFFFFF?text=SJ'">
                        </div>
                        <div class="author-info">
                            <h4>Sarah Johnson</h4>
                            <p>CEO, Adventure Tours Co.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="cta">
        <div class="container">
            <h2>Ready to Transform Your Tourism Business?</h2>
            <p>Join over 500 tourism businesses worldwide that trust TourEase Pro to streamline their operations and deliver exceptional experiences.</p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="btn btn-cta">
                    <i class="fas fa-rocket"></i> Start Your Free Trial
                </a>
                <button class="btn btn-outline" style="background-color: transparent; color: white; border-color: white;" id="ctaScheduleBtn">
                    <i class="fas fa-calendar-alt"></i> Schedule a Demo
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>TourEase Pro</h3>
                    <p>The leading tourism management system for travel agencies, tour operators, and destination management companies worldwide.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#">Pricing</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API Reference</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Community</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Tourism Avenue, Suite 1000</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-TOUR</p>
                    <p><i class="fas fa-envelope"></i> info@toureasepro.com</p>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2023 TourEase Pro. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>

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
        updateHeader(); // Initialize on load

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
            closeMobileMenu();
        });

        document.getElementById('ctaScheduleBtn').addEventListener('click', () => {
            alert('Scheduling functionality would open here.');
            closeMobileMenu();
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
            const scrollPosition = window.scrollY + 100;
            
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

        // Image error handling
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                const altText = this.alt || 'Image';
                this.src = `https://via.placeholder.com/800x600/0066CC/FFFFFF?text=${encodeURIComponent(altText)}`;
            });
        });

        // Lazy loading for images
        const lazyLoadImages = () => {
            const images = document.querySelectorAll('img');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                if (img.dataset.src) {
                    imageObserver.observe(img);
                }
            });
        };

        // Initialize on DOM content loaded
        document.addEventListener('DOMContentLoaded', () => {
            lazyLoadImages();
            updateActiveLink();
        });

        // Keyboard accessibility
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
        });
    </script>
</body>
</html>