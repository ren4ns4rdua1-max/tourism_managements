<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourEase Pro | Explore Your Amazing City</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --coral: #FF5A5F;
            --teal: #38CCCC;
            --dark: #1B2A3B;
            --gray: #6C7A89;
            --light: #F8F9FA;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        body { font-family: 'Poppins', sans-serif; color: var(--dark); overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        img { max-width: 100%; display: block; }

        /* ===== KEYFRAMES ===== */
        @keyframes fadeInDown  { from { opacity:0; transform:translateY(-30px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeInUp    { from { opacity:0; transform:translateY(40px);  } to { opacity:1; transform:translateY(0); } }
        @keyframes slideSearch { from { opacity:0; transform:translateY(30px) scaleX(0.92); } to { opacity:1; transform:translateY(0) scaleX(1); } }
        @keyframes float       { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-12px); } }
        @keyframes bgKenBurns  { 0% { transform:scale(1) translate(0,0); } 100% { transform:scale(1.08) translate(-2%,-1%); } }
        @keyframes tabIn       { 0% { transform:scale(1); } 40% { transform:scale(1.13); } 70% { transform:scale(0.96); } 100% { transform:scale(1); } }
        @keyframes pulseRing   { 0% { transform:scale(0.8); opacity:1; } 100% { transform:scale(1.9); opacity:0; } }
        @keyframes shimmerBtn  { 0% { background-position:-200% center; } 100% { background-position:200% center; } }
        @keyframes loaderFill  { from { width:0; } to { width:100%; } }
        @keyframes ripple      { 0% { transform:scale(0); opacity:.6; } 100% { transform:scale(4); opacity:0; } }
        @keyframes scrollBob   { 0%,100% { transform:translateY(0); } 50% { transform:translateY(6px); } }
        @keyframes dotSlide    { 0%,100% { opacity:1; } 50% { opacity:.3; } }

        /* ===== PAGE LOADER ===== */
        #page-loader {
            position:fixed; inset:0; background:var(--dark); z-index:99999;
            display:flex; flex-direction:column; align-items:center; justify-content:center; gap:18px;
            transition:opacity .5s, visibility .5s;
        }
        #page-loader.hidden { opacity:0; visibility:hidden; pointer-events:none; }
        .loader-logo { font-size:2rem; font-weight:800; color:var(--white); }
        .loader-logo span { color:var(--coral); }
        .loader-bar { width:200px; height:3px; background:rgba(255,255,255,.12); border-radius:2px; overflow:hidden; }
        .loader-bar-inner { height:100%; background:var(--coral); border-radius:2px; animation:loaderFill 1.3s ease forwards; }

        /* ===== BACK TO TOP ===== */
        #btt {
            position:fixed; bottom:28px; right:28px; z-index:900;
            width:44px; height:44px; border-radius:50%; background:var(--coral);
            color:#fff; border:none; font-size:.95rem; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 4px 14px rgba(255,90,95,.45);
            opacity:0; transform:translateY(20px);
            transition:opacity .3s, transform .3s, box-shadow .2s;
        }
        #btt.show { opacity:1; transform:translateY(0); }
        #btt:hover { box-shadow:0 8px 22px rgba(255,90,95,.55); transform:translateY(-4px); }

        /* ===== NAVBAR ===== */
        #navbar {
            position:fixed; top:0; left:0; width:100%; z-index:1000;
            padding:18px 0; transition:all .4s cubic-bezier(.4,0,.2,1);
            animation:fadeInDown .7s ease both;
        }
        #navbar.scrolled { background:var(--white); box-shadow:var(--shadow); padding:12px 0; }
        #navbar.scrolled .nav-link { color:var(--dark); }
        #navbar.scrolled .logo    { color:var(--dark); }
        .nav-container { max-width:1200px; margin:0 auto; padding:0 20px; display:flex; align-items:center; justify-content:space-between; }
        .logo { font-size:1.6rem; font-weight:800; color:#fff; letter-spacing:-.5px; transition:transform .3s; }
        .logo:hover { transform:scale(1.05); }
        .logo span { color:var(--coral); }
        .nav-links { display:flex; list-style:none; gap:28px; align-items:center; }
        .nav-link {
            font-size:.875rem; font-weight:500; color:rgba(255,255,255,.9);
            position:relative; transition:color .2s, transform .2s;
        }
        .nav-link::after {
            content:''; position:absolute; bottom:-4px; left:0; width:0; height:2px;
            background:var(--coral); transition:width .3s ease;
        }
        .nav-link:hover { color:var(--coral); transform:translateY(-2px); }
        .nav-link:hover::after { width:100%; }
        #navbar.scrolled .nav-link { color:var(--dark); }
        .nav-btn {
            background:var(--coral); color:#fff !important; padding:8px 20px; border-radius:4px;
            font-weight:600; font-size:.875rem; overflow:hidden; position:relative;
            transition:transform .2s, box-shadow .2s;
        }
        .nav-btn::after { content:''; position:absolute; inset:0; background:rgba(255,255,255,.16); transform:translateX(-110%) skewX(-15deg); transition:transform .4s; }
        .nav-btn:hover::after { transform:translateX(110%) skewX(-15deg); }
        .nav-btn:hover { transform:translateY(-2px); box-shadow:0 6px 18px rgba(255,90,95,.4); }
        .nav-login {
            font-size:.875rem; font-weight:500; color:rgba(255,255,255,.9);
            padding:8px 16px; border-radius:4px; border:1px solid rgba(255,255,255,.5);
            transition:all .25s;
        }
        #navbar.scrolled .nav-login { color:var(--dark); border-color:var(--dark); }
        .nav-login:hover { background:var(--coral); border-color:var(--coral); color:#fff !important; transform:translateY(-2px); }

        /* ===== HERO ===== */
        .hero { position:relative; min-height:100vh; display:flex; flex-direction:column; justify-content:center; overflow:hidden; }
        .hero-bg { position:absolute; inset:0; background:url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80') center/cover no-repeat; animation:bgKenBurns 14s ease-in-out infinite alternate; }
        .hero::before { content:''; position:absolute; inset:0; background:linear-gradient(to bottom,rgba(0,0,0,.5),rgba(0,0,0,.18) 55%,rgba(0,0,0,.55)); z-index:1; }
        .hero-particle { position:absolute; border-radius:50%; background:rgba(255,255,255,.1); animation:float 7s ease-in-out infinite; z-index:1; }
        .hp1 { width:80px; height:80px; top:14%; left:5%;  animation-delay:0s;   }
        .hp2 { width:40px; height:40px; top:22%; right:7%; animation-delay:1.8s; }
        .hp3 { width:60px; height:60px; bottom:18%; left:9%; animation-delay:3.2s; }
        .hp4 { width:25px; height:25px; bottom:28%; right:13%; animation-delay:.9s; }
        .hero-content {
            position:relative; z-index:2; text-align:center; color:#fff;
            padding:110px 20px 60px; max-width:900px; margin:0 auto;
        }
        .hero-content h1 {
            font-size:clamp(3rem,6vw,5.2rem); font-weight:800; line-height:1.02;
            margin-bottom:10px; text-shadow:0 2px 20px rgba(0,0,0,.3);
            animation:fadeInDown .9s .3s both;
        }
        .hero-content h1 .highlight { display:block; font-style:italic; font-weight:300; font-size:clamp(1.5rem,4vw,3rem); animation:fadeInDown .9s .55s both; }
        .hero-sub { font-size:1rem; opacity:.9; margin-bottom:40px; font-weight:300; animation:fadeInUp .9s .75s both; }

        .search-box {
            background:#fff; border-radius:6px; display:flex; align-items:center; overflow:hidden;
            box-shadow:0 8px 30px rgba(0,0,0,.22); max-width:700px; margin:0 auto 22px;
            animation:slideSearch .9s .9s both;
            transition:box-shadow .3s, transform .3s;
        }
        .search-box:focus-within { box-shadow:0 12px 40px rgba(255,90,95,.28); transform:translateY(-3px); }
        .search-ig { display:flex; flex:1; align-items:center; padding:0 20px; gap:10px; min-height:56px; }
        .search-ig i { color:var(--coral); font-size:1.1rem; }
        .search-ig input { border:none; outline:none; font-family:'Poppins',sans-serif; font-size:.95rem; color:var(--dark); width:100%; background:transparent; }
        .sdiv { width:1px; height:30px; background:#e0e0e0; }
        .search-btn {
            background:var(--coral); color:#fff; border:none; padding:0 32px; height:56px;
            font-family:'Poppins',sans-serif; font-size:1rem; font-weight:600; cursor:pointer;
            position:relative; overflow:hidden; transition:background .2s;
        }
        .search-btn:hover { background:#e0474c; }
        .search-btn .ripple { position:absolute; border-radius:50%; background:rgba(255,255,255,.4); pointer-events:none; animation:ripple .6s linear; }

        .filter-tabs { display:flex; justify-content:center; gap:8px; flex-wrap:wrap; animation:fadeInUp .9s 1.1s both; }
        .filter-tab {
            background:rgba(255,255,255,.15); backdrop-filter:blur(10px); color:#fff;
            border:1px solid rgba(255,255,255,.35); padding:8px 20px; border-radius:25px;
            font-size:.85rem; font-weight:500; cursor:pointer; display:flex; align-items:center; gap:6px;
            transition:all .25s cubic-bezier(.22,.68,0,1.5);
        }
        .filter-tab:hover { transform:translateY(-3px); }
        .filter-tab.active, .filter-tab:hover { background:#fff; color:var(--coral); border-color:#fff; animation:tabIn .4s ease; }

        .scroll-hint {
            position:absolute; bottom:28px; left:50%; transform:translateX(-50%); z-index:2;
            display:flex; flex-direction:column; align-items:center; gap:6px;
            color:rgba(255,255,255,.65); font-size:.68rem; letter-spacing:2px; text-transform:uppercase;
            animation:fadeInUp 1s 1.5s both;
        }
        .scroll-mouse { width:22px; height:38px; border:2px solid rgba(255,255,255,.5); border-radius:11px; display:flex; align-items:flex-start; justify-content:center; padding:5px; }
        .scroll-mouse::after { content:''; width:4px; height:7px; background:rgba(255,255,255,.8); border-radius:2px; animation:scrollBob 1.6s ease-in-out infinite; }

        /* ===== TRUST ===== */
        .trust-section { background:#fff; padding:50px 0; box-shadow:0 2px 10px rgba(0,0,0,.06); }
        .trust-grid { max-width:1200px; margin:0 auto; padding:0 20px; display:grid; grid-template-columns:repeat(4,1fr); gap:30px; }
        .trust-item { text-align:center; padding:20px; transition:transform .3s; }
        .trust-item:hover { transform:translateY(-7px); }
        .trust-icon {
            width:70px; height:70px; border-radius:50%; margin:0 auto 16px;
            display:flex; align-items:center; justify-content:center; font-size:1.8rem;
            background:linear-gradient(135deg,#fff5f5,#ffe8e8); color:var(--coral);
            position:relative; transition:transform .3s;
        }
        .trust-item:hover .trust-icon::before {
            content:''; position:absolute; inset:-6px; border-radius:50%;
            border:2px solid rgba(255,90,95,.3); animation:pulseRing 1s linear infinite;
        }
        .trust-item h4 { font-size:1rem; font-weight:700; margin-bottom:8px; color:var(--dark); }
        .trust-item p  { font-size:.8rem; color:var(--gray); line-height:1.5; }

        /* ===== COMMONS ===== */
        .section    { padding:80px 0; }
        .container  { max-width:1200px; margin:0 auto; padding:0 20px; }
        .sec-label  { font-size:.75rem; font-weight:600; color:var(--coral); text-transform:uppercase; letter-spacing:2px; margin-bottom:6px; }
        .sec-head   { font-size:clamp(1.5rem,3vw,2.2rem); font-weight:700; color:var(--dark); margin-bottom:10px; }
        .sec-head span { color:var(--coral); }
        .sec-hdr    { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:30px; }
        .view-all   { font-size:.85rem; font-weight:600; color:var(--coral); display:flex; align-items:center; gap:6px; transition:gap .2s, opacity .2s; }
        .view-all:hover { gap:10px; opacity:.8; }
        .view-all:hover i { transform:translateX(4px); }
        .view-all i { transition:transform .2s; }

        /* ===== DESTINATIONS ===== */
        .destinations-section { background:#fff; }
        .dest-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }
        .dest-card {
            position:relative; border-radius:10px; overflow:hidden; cursor:pointer;
            box-shadow:0 4px 15px rgba(0,0,0,.08); transition:transform .35s cubic-bezier(.22,.68,0,1.2), box-shadow .35s;
        }
        .dest-card:hover { transform:translateY(-9px) scale(1.02); box-shadow:0 22px 44px rgba(0,0,0,.18); }
        .dest-card img { width:100%; height:200px; object-fit:cover; transition:transform .5s; }
        .dest-card:hover img { transform:scale(1.11); }
        .dest-overlay { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(0,0,0,.8),transparent); padding:30px 15px 15px; transition:padding .3s; }
        .dest-card:hover .dest-overlay { padding-bottom:22px; }
        .dest-overlay h4 { color:#fff; font-size:1rem; font-weight:700; }
        .dest-overlay p  { color:rgba(255,255,255,.75); font-size:.75rem; }
        .dest-badge { position:absolute; top:12px; right:12px; background:var(--coral); color:#fff; font-size:.65rem; font-weight:700; padding:3px 8px; border-radius:20px; opacity:0; transform:translateY(-8px); transition:opacity .3s, transform .3s; z-index:2; }
        .dest-card:hover .dest-badge { opacity:1; transform:translateY(0); }

        .carousel-dots { display:flex; justify-content:center; gap:6px; margin-top:25px; }
        .dot { width:8px; height:8px; border-radius:50%; background:#d0d0d0; cursor:pointer; transition:all .3s; }
        .dot.active { width:24px; border-radius:4px; background:var(--coral); }

        /* ===== TOUR PACKAGES ===== */
        .tours-section { background:var(--light); }
        .tours-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; }
        .tour-card { background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.07); transition:all .35s cubic-bezier(.22,.68,0,1.2); }
        .tour-card:hover { transform:translateY(-7px); box-shadow:0 18px 32px rgba(0,0,0,.14); }
        .tour-img-wrap { position:relative; overflow:hidden; }
        .tour-img-wrap img { width:100%; height:160px; object-fit:cover; transition:transform .5s; }
        .tour-card:hover .tour-img-wrap img { transform:scale(1.09); }
        .tour-img-wrap::after { content:'✈ Book'; position:absolute; inset:0; background:rgba(255,90,95,.78); color:#fff; font-size:.9rem; font-weight:700; display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .3s; }
        .tour-card:hover .tour-img-wrap::after { opacity:1; }
        .tour-price-badge { position:absolute; top:10px; right:10px; background:var(--coral); color:#fff; font-size:.75rem; font-weight:700; padding:3px 8px; border-radius:3px; z-index:1; transition:transform .3s; }
        .tour-card:hover .tour-price-badge { transform:scale(1.1); }
        .tour-body { padding:14px; }
        .tour-loc   { font-size:.75rem; color:var(--gray); font-weight:600; margin-bottom:4px; }
        .tour-title { font-size:.9rem; font-weight:700; color:var(--dark); margin-bottom:8px; line-height:1.3; }
        .tour-meta  { display:flex; align-items:center; gap:10px; font-size:.75rem; color:var(--gray); margin-bottom:12px; }
        .btn-sm { flex:1; padding:7px 0; border-radius:4px; font-size:.75rem; font-weight:600; text-align:center; cursor:pointer; border:none; font-family:'Poppins',sans-serif; transition:all .25s; position:relative; overflow:hidden; }
        .btn-book { background:var(--coral); color:#fff; }
        .btn-book:hover { background:#e0474c; transform:translateY(-2px); box-shadow:0 4px 12px rgba(255,90,95,.35); }
        .btn-view { background:transparent; border:1px solid #e0e0e0; color:var(--dark); }
        .btn-view:hover { border-color:var(--coral); color:var(--coral); transform:translateY(-2px); }

        /* ===== FUN FACTS ===== */
        .facts-section { background:linear-gradient(135deg,var(--teal),#2db5a3); padding:70px 0; position:relative; overflow:hidden; }
        .facts-section::before { content:''; position:absolute; inset:0; background:url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=60') center/cover; opacity:.1; }
        .facts-section::after { content:''; position:absolute; bottom:-1px; left:0; right:0; height:50px; background:var(--white); clip-path:ellipse(55% 100% at 50% 100%); }
        .facts-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; position:relative; }
        .fact-item { text-align:center; color:#fff; }
        .fact-num { font-size:clamp(2rem,4vw,3rem); font-weight:800; line-height:1; margin-bottom:6px; }
        .fact-lbl { font-size:.85rem; opacity:.85; }
        .facts-title { text-align:center; color:#fff; font-size:clamp(1.5rem,3vw,2rem); font-weight:700; margin-bottom:8px; }
        .facts-sub   { text-align:center; color:rgba(255,255,255,.8); font-size:.9rem; margin-bottom:50px; }

        /* ===== HOTELS ===== */
        .hotels-section { background:#fff; }
        .hotels-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; }
        .hotel-card { background:#fff; border-radius:10px; overflow:hidden; border:1px solid #f0f0f0; box-shadow:0 2px 10px rgba(0,0,0,.06); transition:all .35s cubic-bezier(.22,.68,0,1.2); }
        .hotel-card:hover { transform:translateY(-7px); box-shadow:0 18px 32px rgba(0,0,0,.14); border-color:rgba(255,90,95,.2); }
        .hotel-card img { width:100%; height:150px; object-fit:cover; transition:transform .5s; }
        .hotel-card:hover img { transform:scale(1.07); }
        .hotel-body { padding:14px; }
        .hotel-loc  { font-size:.75rem; color:var(--gray); font-weight:600; margin-bottom:4px; }
        .hotel-name { font-size:.9rem; font-weight:700; color:var(--dark); margin-bottom:6px; }
        .hotel-stars{ color:#FFB800; font-size:.7rem; margin-bottom:6px; }
        .hotel-desc { font-size:.75rem; color:var(--gray); line-height:1.5; margin-bottom:10px; }
        .hotel-price{ font-size:.9rem; font-weight:700; color:var(--coral); margin-bottom:10px; }
        .hotel-price span { font-size:.7rem; font-weight:400; color:var(--gray); }
        .hotel-footer { display:flex; justify-content:space-between; align-items:center; font-size:.75rem; color:var(--gray); }

        /* ===== WHY + TESTIMONIAL ===== */
        .wt-section { background:var(--light); padding:80px 0; }
        .wt-grid { display:grid; grid-template-columns:1fr 1fr; gap:50px; }
        .why-content h2 { font-size:clamp(1.4rem,2.5vw,1.8rem); font-weight:700; margin-bottom:16px; }
        .why-content p  { font-size:.875rem; color:var(--gray); line-height:1.8; margin-bottom:16px; }
        .why-list { list-style:none; margin-bottom:24px; }
        .why-list li { display:flex; align-items:flex-start; gap:10px; font-size:.85rem; color:var(--gray); margin-bottom:10px; transition:transform .2s, color .2s; }
        .why-list li:hover { transform:translateX(7px); color:var(--dark); }
        .why-list i { color:var(--coral); margin-top:2px; flex-shrink:0; transition:transform .2s; }
        .why-list li:hover i { transform:scale(1.35); }
        .btn-coral { display:inline-flex; align-items:center; gap:8px; background:var(--coral); color:#fff; padding:12px 24px; border-radius:5px; font-weight:600; font-size:.875rem; border:none; cursor:pointer; font-family:'Poppins',sans-serif; transition:all .25s; position:relative; overflow:hidden; }
        .btn-coral::after { content:''; position:absolute; inset:0; background:rgba(255,255,255,.16); transform:translateX(-110%) skewX(-15deg); transition:transform .4s; }
        .btn-coral:hover::after { transform:translateX(110%) skewX(-15deg); }
        .btn-coral:hover { background:#e0474c; transform:translateY(-3px); box-shadow:0 8px 22px rgba(255,90,95,.35); }
        .test-area { display:flex; flex-direction:column; justify-content:center; }
        .test-card { background:#fff; border-radius:12px; padding:30px; box-shadow:0 5px 20px rgba(0,0,0,.07); border-left:4px solid var(--coral); transition:transform .3s, box-shadow .3s; }
        .test-card:hover { transform:translateY(-5px); box-shadow:0 14px 32px rgba(0,0,0,.1); }
        .test-quote { font-size:3rem; color:var(--coral); line-height:1; margin-bottom:-10px; }
        .test-text  { font-size:.9rem; color:var(--gray); line-height:1.8; font-style:italic; margin-bottom:20px; }
        .test-author{ display:flex; align-items:center; gap:12px; }
        .test-avatar{ width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid var(--coral); }
        .test-info h4 { font-size:.9rem; font-weight:700; color:var(--dark); }
        .test-info p  { font-size:.75rem; color:var(--gray); }
        .test-stars   { color:#FFB800; font-size:.75rem; margin-top:3px; }

        /* ===== RESTAURANTS ===== */
        .rest-section { background:#fff; }
        .rest-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:20px; }
        .rest-card { border-radius:10px; overflow:hidden; box-shadow:0 3px 12px rgba(0,0,0,.08); transition:all .35s cubic-bezier(.22,.68,0,1.2); background:#fff; }
        .rest-card:hover { transform:translateY(-7px) scale(1.01); box-shadow:0 18px 32px rgba(0,0,0,.14); }
        .rest-card .img-w { overflow:hidden; }
        .rest-card img { width:100%; height:180px; object-fit:cover; transition:transform .5s; }
        .rest-card:hover img { transform:scale(1.08); }
        .rest-body  { padding:14px; }
        .rest-name  { font-size:.95rem; font-weight:700; color:var(--dark); margin-bottom:4px; }
        .rest-stars { color:#FFB800; font-size:.7rem; margin-bottom:6px; }
        .rest-meta  { display:flex; justify-content:space-between; font-size:.75rem; color:var(--gray); margin-bottom:10px; }
        .rest-footer{ display:flex; gap:8px; }

        /* ===== ARTICLES ===== */
        .art-section { background:var(--light); }
        .art-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:24px; }
        .art-card { background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.06); transition:all .35s cubic-bezier(.22,.68,0,1.2); }
        .art-card:hover { transform:translateY(-7px); box-shadow:0 18px 32px rgba(0,0,0,.12); }
        .art-card .img-w { overflow:hidden; }
        .art-card img { width:100%; height:180px; object-fit:cover; transition:transform .5s; }
        .art-card:hover img { transform:scale(1.08); }
        .art-body { padding:16px; }
        .art-tag   { font-size:.7rem; font-weight:600; color:var(--coral); text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
        .art-title { font-size:.9rem; font-weight:700; color:var(--dark); line-height:1.4; margin-bottom:8px; }
        .art-meta  { font-size:.75rem; color:var(--gray); }

        /* ===== NEWSLETTER ===== */
        .nl-section { background:linear-gradient(135deg,#2db5a3,var(--teal)); padding:70px 0; text-align:center; position:relative; overflow:hidden; }
        .nl-section::before { content:''; position:absolute; width:300px; height:300px; border-radius:50%; background:rgba(255,255,255,.07); top:-80px; left:-80px; animation:float 8s ease-in-out infinite; }
        .nl-section::after  { content:''; position:absolute; width:200px; height:200px; border-radius:50%; background:rgba(255,255,255,.05); bottom:-60px; right:-60px; animation:float 6s ease-in-out infinite reverse; }
        .nl-section h2 { font-size:clamp(1.5rem,3vw,2.2rem); font-weight:700; color:#fff; margin-bottom:10px; position:relative; }
        .nl-section p  { color:rgba(255,255,255,.85); font-size:.9rem; margin-bottom:30px; position:relative; }
        .nl-form { display:flex; max-width:500px; margin:0 auto; border-radius:6px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.15); position:relative; transition:transform .3s, box-shadow .3s; }
        .nl-form:focus-within { transform:translateY(-4px); box-shadow:0 14px 36px rgba(0,0,0,.2); }
        .nl-form input  { flex:1; padding:16px 20px; border:none; outline:none; font-family:'Poppins',sans-serif; font-size:.9rem; }
        .nl-form button { padding:16px 28px; background:var(--dark); color:#fff; border:none; font-family:'Poppins',sans-serif; font-size:.9rem; font-weight:600; cursor:pointer; transition:background .2s; }
        .nl-form button:hover { background:#111; }

        /* ===== FOOTER ===== */
        footer { background:#1B2A3B; color:rgba(255,255,255,.7); padding:60px 0 0; }
        .footer-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1.5fr; gap:40px; padding-bottom:50px; }
        .footer-logo { font-size:1.5rem; font-weight:800; color:#fff; margin-bottom:14px; }
        .footer-logo span { color:var(--coral); }
        .footer-desc { font-size:.82rem; line-height:1.7; margin-bottom:20px; }
        .socials { display:flex; gap:10px; }
        .socials a { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.1); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.7); font-size:.85rem; transition:all .3s cubic-bezier(.22,.68,0,1.5); }
        .socials a:hover { background:var(--coral); color:#fff; transform:translateY(-5px) scale(1.1); }
        .footer-col h4 { color:#fff; font-size:1rem; font-weight:700; margin-bottom:20px; }
        .flinks { list-style:none; }
        .flinks li { margin-bottom:10px; }
        .flinks a { font-size:.82rem; color:rgba(255,255,255,.6); transition:color .2s, padding-left .2s; }
        .flinks a:hover { color:var(--coral); padding-left:6px; }
        .fcontact { display:flex; align-items:flex-start; gap:10px; font-size:.82rem; margin-bottom:12px; }
        .fcontact i { color:var(--coral); margin-top:2px; flex-shrink:0; }
        .footer-bottom { border-top:1px solid rgba(255,255,255,.08); padding:20px 0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
        .footer-bottom p { font-size:.78rem; color:rgba(255,255,255,.4); }
        .footer-bottom a { color:rgba(255,255,255,.4); font-size:.78rem; transition:color .2s; }
        .footer-bottom a:hover { color:var(--coral); }

        /* ===== MODAL ===== */
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,.55); backdrop-filter:blur(5px); display:none; align-items:center; justify-content:center; z-index:9999; padding:20px; opacity:0; transition:opacity .3s; }
        .modal-overlay.active { display:flex; opacity:1; }
        .modal-box { background:#fff; border-radius:12px; overflow:hidden; max-width:820px; width:100%; max-height:90vh; overflow-y:auto; box-shadow:0 25px 60px rgba(0,0,0,.25); transform:scale(.85) translateY(30px); transition:transform .4s cubic-bezier(.22,.68,0,1.2); }
        .modal-overlay.active .modal-box { transform:scale(1) translateY(0); }
        .modal-hdr { background:linear-gradient(135deg,var(--coral),#e0474c); color:#fff; padding:20px 28px; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:5; }
        .modal-hdr h3 { font-size:1.2rem; font-weight:700; }
        .modal-close { background:rgba(255,255,255,.2); border:none; color:#fff; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:1rem; display:flex; align-items:center; justify-content:center; transition:all .25s; }
        .modal-close:hover { background:rgba(255,255,255,.35); transform:rotate(90deg); }
        .modal-body { padding:28px; display:grid; grid-template-columns:1fr 1fr; gap:28px; }
        .modal-img { border-radius:8px; width:100%; height:280px; object-fit:cover; }
        .modal-placeholder { width:100%; height:280px; background:#f0f4f8; border-radius:8px; display:flex; align-items:center; justify-content:center; color:var(--gray); font-size:.875rem; }
        .modal-details { display:flex; flex-direction:column; gap:16px; }
        .modal-block { background:#f8f9fa; border-radius:8px; padding:14px 18px; transition:background .2s; }
        .modal-block:hover { background:#f0f2f5; }
        .modal-lbl { font-size:.72rem; color:var(--gray); font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; }
        .modal-val { font-size:.95rem; color:var(--dark); font-weight:500; }
        .modal-price { font-size:1.6rem; font-weight:800; color:var(--coral); }
        .modal-coords { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .modal-actions { padding:0 28px 28px; display:flex; gap:12px; }
        .modal-actions .btn-coral { flex:1; justify-content:center; }
        .btn-outline-d { flex:1; display:inline-flex; align-items:center; justify-content:center; gap:8px; background:transparent; border:2px solid #e0e0e0; color:var(--dark); padding:12px 24px; border-radius:5px; font-weight:600; font-size:.875rem; cursor:pointer; font-family:'Poppins',sans-serif; transition:all .25s; }
        .btn-outline-d:hover { border-color:var(--coral); color:var(--coral); transform:translateY(-2px); }

        /* ===== SCROLL REVEAL ===== */
        .reveal { opacity:0; transform:translateY(40px); transition:opacity .7s cubic-bezier(.22,.68,0,1.2), transform .7s cubic-bezier(.22,.68,0,1.2); }
        .reveal.rl { transform:translateX(-40px); }
        .reveal.rr { transform:translateX(40px); }
        .reveal.rz { transform:scale(.88); }
        .reveal.visible { opacity:1 !important; transform:none !important; }

        .stagger > * { opacity:0; transform:translateY(30px); transition:opacity .6s cubic-bezier(.22,.68,0,1.2), transform .6s cubic-bezier(.22,.68,0,1.2); }
        .stagger.visible > *:nth-child(1) { opacity:1; transform:none; transition-delay:.05s; }
        .stagger.visible > *:nth-child(2) { opacity:1; transform:none; transition-delay:.15s; }
        .stagger.visible > *:nth-child(3) { opacity:1; transform:none; transition-delay:.25s; }
        .stagger.visible > *:nth-child(4) { opacity:1; transform:none; transition-delay:.35s; }
        .stagger.visible > *:nth-child(5) { opacity:1; transform:none; transition-delay:.45s; }

        /* ===== RESPONSIVE ===== */
        @media (max-width:1024px) { .trust-grid { grid-template-columns:repeat(2,1fr); } .facts-grid { grid-template-columns:repeat(2,1fr); gap:30px; } .footer-grid { grid-template-columns:1fr 1fr; } .wt-grid { grid-template-columns:1fr; } }
        @media (max-width:768px) { .nav-links { display:none; } .modal-body { grid-template-columns:1fr; } .footer-grid { grid-template-columns:1fr; } .trust-grid { grid-template-columns:1fr 1fr; } }
        @media (max-width:480px) { .search-box { flex-direction:column; border-radius:8px; } .search-btn { width:100%; } .trust-grid { grid-template-columns:1fr; } .facts-grid { grid-template-columns:1fr 1fr; } .modal-actions { flex-direction:column; } }
    </style>
</head>
<body>

<!-- PAGE LOADER -->
<div id="page-loader">
    <div class="loader-logo">Tour<span>Ease</span></div>
    <div class="loader-bar"><div class="loader-bar-inner"></div></div>
</div>

<!-- BACK TO TOP -->
<button id="btt" title="Back to top"><i class="fas fa-chevron-up"></i></button>

<!-- NAVBAR -->
<nav id="navbar">
    <div class="nav-container">
        <div class="logo">Tour<span>Ease</span></div>
        <ul class="nav-links">
            <li><a href="#home"         class="nav-link">Home</a></li>
            <li><a href="#about"        class="nav-link">About</a></li>
            <li><a href="#destinations" class="nav-link">Tour</a></li>
            <li><a href="#gallery"      class="nav-link">Hotels</a></li>
            <li><a href="#features"     class="nav-link">Blog</a></li>
            <li><a href="#contact"      class="nav-link">Contact</a></li>
        </ul>
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('register') }}" class="nav-btn">Get Started</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="hero-particle hp1"></div>
    <div class="hero-particle hp2"></div>
    <div class="hero-particle hp3"></div>
    <div class="hero-particle hp4"></div>
    <div class="hero-content">
        <h1>Explore<span class="highlight">your amazing city</span></h1>
        <p class="hero-sub">Get best places to stay, eat, discover and travel in Philippines</p>
        <div class="search-box">
            <div class="search-ig"><i class="fas fa-search"></i><input type="text" placeholder="Find your location here..."></div>
            <div class="sdiv"></div>
            <div class="search-ig" style="max-width:160px;"><i class="fas fa-map-marker-alt"></i><input type="text" placeholder="Where"></div>
            <button class="search-btn" id="searchBtn">Search</button>
        </div>
        <div class="filter-tabs">
            <button class="filter-tab active"><i class="fas fa-utensils"></i> Restaurant</button>
            <button class="filter-tab"><i class="fas fa-hotel"></i> Hotels</button>
            <button class="filter-tab"><i class="fas fa-plane"></i> Places</button>
            <button class="filter-tab"><i class="fas fa-ship"></i> Cruising</button>
        </div>
    </div>
    <div class="scroll-hint"><div class="scroll-mouse"></div><span>Scroll</span></div>
</section>

<!-- TRUST -->
<section class="trust-section">
    <div class="trust-grid stagger">
        <div class="trust-item reveal"><div class="trust-icon"><i class="fas fa-tag"></i></div><h4>Best Price Guarantee</h4><p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p></div>
        <div class="trust-item reveal"><div class="trust-icon"><i class="fas fa-heart"></i></div><h4>Travelers Love Us</h4><p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p></div>
        <div class="trust-item reveal"><div class="trust-icon"><i class="fas fa-user-tie"></i></div><h4>Best Travel Agent</h4><p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p></div>
        <div class="trust-item reveal"><div class="trust-icon"><i class="fas fa-headset"></i></div><h4>Our Dedicated Support</h4><p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p></div>
    </div>
</section>

<!-- FEATURED DESTINATIONS -->
<section class="section destinations-section" id="destinations">
    <div class="container">
        <div class="sec-hdr">
            <div class="reveal rl"><div class="sec-label">Hello World</div><h2 class="sec-head"><span>Featured</span> Destination</h2></div>
            <a href="{{ route('destinations.index') }}" class="view-all reveal rr">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="dest-grid stagger">
            @forelse($destinations as $destination)
            <div class="dest-card reveal"
                 data-id="{{ $destination->id }}"
                 data-name="{{ $destination->name }}"
                 data-location="{{ $destination->location }}"
                 data-description="{{ $destination->description }}"
                 data-price="{{ $destination->price ? '₱' . number_format($destination->price, 2) : '' }}"
                 data-image="{{ $destination->image ? asset('storage/' . $destination->image) : '' }}"
                 data-lat="{{ $destination->latitude }}"
                 data-lng="{{ $destination->longitude }}">
                <div class="dest-badge">View</div>
                @if($destination->image)
                    <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" onerror="this.src='https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=400&q=80'">
                @else
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=400&q=80" alt="{{ $destination->name }}">
                @endif
                <div class="dest-overlay"><h4>{{ $destination->name }}</h4><p>{{ $destination->location }}</p></div>
            </div>
            @empty
            <div class="dest-card reveal"><div class="dest-badge">View</div><img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&q=80" alt="Australia"><div class="dest-overlay"><h4>Australia</h4><p>15 listing</p></div></div>
            <div class="dest-card reveal"><div class="dest-badge">View</div><img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=400&q=80" alt="Paris"><div class="dest-overlay"><h4>Paris, Italy</h4><p>15 listing</p></div></div>
            <div class="dest-card reveal"><div class="dest-badge">View</div><img src="https://images.unsplash.com/photo-1543872084-c7bd3822856f?w=400&q=80" alt="Tokyo"><div class="dest-overlay"><h4>Tokyo, Japan</h4><p>15 listing</p></div></div>
            <div class="dest-card reveal"><div class="dest-badge">View</div><img src="https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=400&q=80" alt="San Francisco"><div class="dest-overlay"><h4>San Francisco, USA</h4><p>15 listing</p></div></div>
            @endforelse
        </div>
        <div class="carousel-dots reveal"><div class="dot active"></div><div class="dot"></div><div class="dot"></div></div>
    </div>
</section>

<!-- TOUR PACKAGES -->
<section class="section tours-section" id="features">
    <div class="container">
        <div class="sec-hdr">
            <div class="reveal rl"><div class="sec-label">Current Offers</div><h2 class="sec-head">Top <span>Tour Packages</span></h2></div>
            <a href="{{ route('destinations.index') }}" class="view-all reveal rr">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="tours-grid stagger">
            @forelse($destinations->take(5) as $destination)
            <div class="tour-card reveal">
                <div class="tour-img-wrap">
                    @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" onerror="this.src='https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=400&q=80'">
                    @else
                        <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=400&q=80" alt="{{ $destination->name }}">
                    @endif
                    @if($destination->price)<div class="tour-price-badge">₱{{ number_format($destination->price, 0) }}</div>@endif
                </div>
                <div class="tour-body">
                    <div class="tour-loc">📍 {{ $destination->location }}</div>
                    <div class="tour-title">{{ $destination->name }}</div>
                    <div class="tour-meta"><span><i class="fas fa-star" style="color:#FFB800"></i> 4.8</span><span><i class="fas fa-clock"></i> 5 Days</span></div>
                    <p style="font-size:.75rem;color:var(--gray);margin-bottom:12px;line-height:1.5;">{{ Str::limit($destination->description, 80) }}</p>
                </div>
                <div style="padding:0 14px 14px;display:flex;gap:8px;">
                    <a href="{{ route('login') }}" class="btn-sm btn-book" style="flex:1;text-align:center;display:block;padding:7px 0;border-radius:4px;font-size:.75rem;font-weight:600;font-family:'Poppins',sans-serif;">Book Now</a>
                    <button class="btn-sm btn-view view-details-btn"
                            data-id="{{ $destination->id }}" data-name="{{ $destination->name }}"
                            data-location="{{ $destination->location }}" data-description="{{ $destination->description }}"
                            data-price="{{ $destination->price ? '₱' . number_format($destination->price, 2) : '' }}"
                            data-image="{{ $destination->image ? asset('storage/' . $destination->image) : '' }}"
                            data-lat="{{ $destination->latitude }}" data-lng="{{ $destination->longitude }}">Details</button>
                </div>
            </div>
            @empty
            @php $demoTours=[['Paris, Italy','$200','https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=400&q=80'],['Paris, Italy','$300','https://images.unsplash.com/photo-1543872084-c7bd3822856f?w=400&q=80'],['Paris, Italy','$400','https://images.unsplash.com/photo-1485738422979-f5c462d49f74?w=400&q=80'],['Paris, Italy','$600','https://images.unsplash.com/photo-1470004914212-05527e49370b?w=400&q=80'],['Paris, Italy','$500','https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=400&q=80']]; @endphp
            @foreach($demoTours as $demo)
            <div class="tour-card reveal">
                <div class="tour-img-wrap"><img src="{{ $demo[2] }}" alt="{{ $demo[0] }}"><div class="tour-price-badge">{{ $demo[1] }}</div></div>
                <div class="tour-body">
                    <div class="tour-loc">📍 {{ $demo[0] }}</div>
                    <div class="tour-title">The Beauty Of Paris</div>
                    <div class="tour-meta"><span><i class="fas fa-star" style="color:#FFB800"></i> 4.5</span><span><i class="fas fa-clock"></i> 3 Days</span></div>
                    <p style="font-size:.75rem;color:var(--gray);margin-bottom:12px;line-height:1.5;">Explore amazing destinations with our guided tour packages.</p>
                </div>
                <div style="padding:0 14px 14px;display:flex;gap:8px;">
                    <a href="{{ route('login') }}" class="btn-sm btn-book" style="flex:1;text-align:center;display:block;padding:7px 0;border-radius:4px;font-size:.75rem;font-weight:600;font-family:'Poppins',sans-serif;">Book Now</a>
                    <button class="btn-sm btn-view">Details</button>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>


<!-- POPULAR HOTELS -->
<section class="section hotels-section" id="gallery">
    <div class="container">
        <div class="sec-hdr">
            <div class="reveal rl"><div class="sec-label">Luxury Offers</div><h2 class="sec-head">Popular <span>Hotels & Rooms</span></h2></div>
            <a href="{{ route('gallery.index') }}" class="view-all reveal rr">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="hotels-grid stagger">
            @forelse($galleries->take(5) as $gallery)
            <div class="hotel-card reveal">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=80'">
                <div class="hotel-body">
                    <div class="hotel-loc">📍 Philippines</div>
                    <div class="hotel-name">{{ $gallery->title }}</div>
                    <div class="hotel-stars">★★★★★</div>
                    <div class="hotel-desc">{{ Str::limit($gallery->description ?? 'Beautiful hotel with amazing views and top-class amenities.', 70) }}</div>
                    <div class="hotel-price">$42 <span>/ night</span></div>
                    <div class="hotel-footer"><span><i class="fas fa-eye"></i> 2 Reviews</span><a href="{{ route('login') }}" style="color:var(--coral);font-weight:600;font-size:.75rem;">Book Now</a></div>
                </div>
            </div>
            @empty
            @foreach(range(1,5) as $i)
            <div class="hotel-card reveal">
                <img src="https://images.unsplash.com/photo-{{ ['1566073771259-6a8506099945','1564501049412-61d2ac2d9e1f','1571003123894-1f0594d2b5d9','1596436889106-be35e843f974','1611892440504-42a792e24d32'][$i-1] }}?w=400&q=80" alt="Hotel">
                <div class="hotel-body">
                    <div class="hotel-loc">📍 Paris, Italy</div>
                    <div class="hotel-name">Hotel Ruby</div>
                    <div class="hotel-stars">★★★★★</div>
                    <div class="hotel-desc">Far far away, behind the mountains, far from the countries.</div>
                    <div class="hotel-price">$42 <span>/ night</span></div>
                    <div class="hotel-footer"><span><i class="fas fa-eye"></i> 2 Reviews</span><a href="{{ route('login') }}" style="color:var(--coral);font-weight:600;font-size:.75rem;">Book Now</a></div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>


<!-- RESTAURANTS -->
<section class="section rest-section">
    <div class="container">
        <div class="sec-hdr">
            <div class="reveal rl"><div class="sec-label">Latest Offers</div><h2 class="sec-head">Popular <span>Restaurants</span></h2></div>
            <a href="{{ route('destinations.index') }}" class="view-all reveal rr">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="rest-grid stagger">
            @foreach(range(1,4) as $i)
            <div class="rest-card reveal">
                <div class="img-w"><img src="{{ ['https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400&q=80','https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=400&q=80','https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=400&q=80','https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=400&q=80'][$i-1] }}" alt="Restaurant"></div>
                <div class="rest-body">
                    <div class="rest-name">Luxury Restaurant</div>
                    <div class="rest-stars">★★★★★</div>
                    <div class="rest-meta"><span>📍 Paris, Italy</span><span><i class="fas fa-eye"></i> 2 Reviews</span></div>
                    <div class="rest-footer">
                        <a href="{{ route('login') }}" style="background:var(--coral);color:white;font-size:.75rem;font-weight:600;padding:6px 14px;border-radius:4px;font-family:'Poppins',sans-serif;transition:transform .2s;">Book Now</a>
                        <button class="btn-sm btn-view" style="max-width:90px;">Details</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ARTICLES -->
<section class="section art-section">
    <div class="container">
        <div class="sec-hdr">
            <div class="reveal rl"><h2 class="sec-head">Tips & <span>Articles</span></h2></div>
            <a href="#" class="view-all reveal rr">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="art-grid stagger">
            @foreach(range(1,4) as $i)
            <div class="art-card reveal">
                <div class="img-w"><img src="{{ ['https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=500&q=80','https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=500&q=80','https://images.unsplash.com/photo-1543872084-c7bd3822856f?w=500&q=80','https://images.unsplash.com/photo-1485738422979-f5c462d49f74?w=500&q=80'][$i-1] }}" alt="Article"></div>
                <div class="art-body">
                    <div class="art-tag">Travel Tips</div>
                    <div class="art-title">Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</div>
                    <div class="art-meta"><i class="fas fa-calendar"></i> May 1, 2024</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="nl-section" id="contact">
    <div class="container" style="position:relative;z-index:1;">
        <h2 class="reveal">Subscribe to our Newsletter</h2>
        <p class="reveal">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
        <div class="nl-form reveal rz">
            <input type="email" placeholder="Enter your email address">
            <button type="button">Subscribe</button>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="reveal rl">
                <div class="footer-logo">Tour<span>Ease</span></div>
                <p class="footer-desc">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                <div class="socials"><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-instagram"></i></a></div>
            </div>
            <div class="footer-col reveal"><h4>Information</h4><ul class="flinks"><li><a href="#">About</a></li><li><a href="#">Services</a></li><li><a href="#">Team Add-O-Collect</a></li><li><a href="#">Latest Events</a></li><li><a href="#">Contact us</a></li></ul></div>
            <div class="footer-col reveal"><h4>Customer Support</h4><ul class="flinks"><li><a href="#">FAQ</a></li><li><a href="#">Payment Options</a></li><li><a href="#">Booking Tips</a></li><li><a href="#">How it Works</a></li><li><a href="#">Contact us</a></li></ul></div>
            <div class="footer-col reveal rr">
                <h4>Have a Question?</h4>
                <div class="fcontact"><i class="fas fa-map-marker-alt"></i><span>203 Fake St. Mountain View, San Francisco, California, USA</span></div>
                <div class="fcontact"><i class="fas fa-phone"></i><span>+1 502 500 35</span></div>
                <div class="fcontact"><i class="fas fa-envelope"></i><span>info@toureasepro.com</span></div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2024 All rights reserved | TourEase Pro</p>
            <div style="display:flex;gap:16px;"><a href="#">Privacy Policy</a><a href="#">Terms of Service</a></div>
        </div>
    </div>
</footer>

<!-- MODAL -->
<div class="modal-overlay" id="destinationModal">
    <div class="modal-box">
        <div class="modal-hdr">
            <h3 id="modalTitle">Destination Details</h3>
            <button class="modal-close" id="modalCloseBtn"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div>
                <img id="modalImage" src="" alt="" class="modal-img" style="display:none;">
                <div id="modalPlaceholder" class="modal-placeholder"><i class="fas fa-image" style="margin-right:8px;"></i> No Image Available</div>
            </div>
            <div class="modal-details">
                <div class="modal-block">
                    <div class="modal-lbl">Destination</div>
                    <div class="modal-val" id="modalName" style="font-size:1.2rem;font-weight:700;"></div>
                    <div class="modal-lbl" style="margin-top:8px;">Location</div>
                    <div class="modal-val" style="color:var(--coral);">📍 <span id="modalLocation"></span></div>
                </div>
                <div class="modal-block"><div class="modal-lbl">Price</div><div class="modal-price" id="modalPrice">Not specified</div></div>
                <div class="modal-block"><div class="modal-lbl">Description</div><div class="modal-val" id="modalDescription" style="font-size:.875rem;line-height:1.7;"></div></div>
                <div class="modal-block">
                    <div class="modal-lbl">Coordinates</div>
                    <div class="modal-coords">
                        <div style="background:#fff;padding:10px;border-radius:5px;border:1px solid #eee;"><div class="modal-lbl">Latitude</div><div class="modal-val" id="modalLat">N/A</div></div>
                        <div style="background:#fff;padding:10px;border-radius:5px;border:1px solid #eee;"><div class="modal-lbl">Longitude</div><div class="modal-val" id="modalLng">N/A</div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <a href="{{ route('login') }}" class="btn-coral"><i class="fas fa-calendar-check"></i> Book Now</a>
            <button class="btn-outline-d" id="modalCloseBtn2"><i class="fas fa-times"></i> Close</button>
        </div>
    </div>
</div>

<script>
// PAGE LOADER
window.addEventListener('load', () => setTimeout(() => document.getElementById('page-loader').classList.add('hidden'), 1300));

// NAVBAR + BACK TO TOP
const navbar = document.getElementById('navbar');
const btt = document.getElementById('btt');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
    btt.classList.toggle('show', window.scrollY > 400);
});
btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

// FILTER TABS
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
});

// SEARCH RIPPLE
document.getElementById('searchBtn').addEventListener('click', function(e) {
    const r = document.createElement('span');
    r.className = 'ripple';
    const rect = this.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    r.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px;`;
    this.appendChild(r);
    setTimeout(() => r.remove(), 600);
});

// SMOOTH SCROLL
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const href = a.getAttribute('href');
        if (href === '#') return;
        const target = document.querySelector(href);
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});

// DESTINATION CLICK
document.querySelectorAll('.dest-card').forEach(card => {
    card.addEventListener('click', () => {
        if (!card.dataset.name) return;
        openModal(card.dataset.name, card.dataset.location, card.dataset.description,
                  card.dataset.price, card.dataset.image, card.dataset.lat, card.dataset.lng);
    });
});

// VIEW DETAILS BUTTONS
document.querySelectorAll('.view-details-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.stopPropagation();
        openModal(btn.dataset.name, btn.dataset.location, btn.dataset.description,
                  btn.dataset.price, btn.dataset.image, btn.dataset.lat, btn.dataset.lng);
    });
});

// MODAL
function openModal(name, location, description, price, image, lat, lng) {
    document.getElementById('modalTitle').textContent = name || 'Destination Details';
    document.getElementById('modalName').textContent = name || '';
    document.getElementById('modalLocation').textContent = location || '';
    document.getElementById('modalDescription').textContent = description || '';
    const priceEl = document.getElementById('modalPrice');
    if (price && price !== '') { priceEl.textContent = price; priceEl.className = 'modal-price'; }
    else { priceEl.textContent = 'Not specified'; priceEl.style.cssText = 'font-size:1rem;color:var(--gray);'; }
    const img = document.getElementById('modalImage'), ph = document.getElementById('modalPlaceholder');
    if (image && image !== '') {
        img.src = image; img.style.display = 'block'; ph.style.display = 'none';
        img.onerror = () => { img.style.display = 'none'; ph.style.display = 'flex'; };
    } else { img.style.display = 'none'; ph.style.display = 'flex'; }
    document.getElementById('modalLat').textContent = lat || 'N/A';
    document.getElementById('modalLng').textContent = lng || 'N/A';
    const modal = document.getElementById('destinationModal');
    modal.style.display = 'flex';
    requestAnimationFrame(() => modal.classList.add('active'));
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    const modal = document.getElementById('destinationModal');
    modal.classList.remove('active');
    setTimeout(() => { modal.style.display = 'none'; }, 300);
    document.body.style.overflow = '';
}
document.getElementById('modalCloseBtn').addEventListener('click', closeModal);
document.getElementById('modalCloseBtn2').addEventListener('click', closeModal);
document.getElementById('destinationModal').addEventListener('click', e => { if (e.target.id === 'destinationModal') closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// SCROLL REVEAL
const ro = new IntersectionObserver(entries => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); ro.unobserve(e.target); } }), { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => ro.observe(el));

const so = new IntersectionObserver(entries => entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); so.unobserve(e.target); } }), { threshold: 0.1 });
document.querySelectorAll('.stagger').forEach(el => so.observe(el));

// ANIMATED COUNTER
function animCounter(el, target) {
    const dur = 2000, start = performance.now();
    const tick = now => {
        const p = Math.min((now - start) / dur, 1);
        const ease = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.floor(ease * target).toLocaleString();
        if (p < 1) requestAnimationFrame(tick);
        else el.textContent = target.toLocaleString();
    };
    requestAnimationFrame(tick);
}
const factObs = new IntersectionObserver(entries => entries.forEach(e => {
    if (e.isIntersecting) { e.target.querySelectorAll('.fact-num[data-target]').forEach(el => animCounter(el, +el.dataset.target)); factObs.unobserve(e.target); }
}), { threshold: 0.3 });
const fs = document.querySelector('.facts-section');
if (fs) factObs.observe(fs);

// CAROUSEL DOTS
document.querySelectorAll('.carousel-dots').forEach(dots => {
    dots.querySelectorAll('.dot').forEach(dot => {
        dot.addEventListener('click', () => { dots.querySelectorAll('.dot').forEach(d => d.classList.remove('active')); dot.classList.add('active'); });
    });
});
</script>
</body>
</html>