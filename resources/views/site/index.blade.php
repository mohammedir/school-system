<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدرسة ليرن تو بي | Learn to Be School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lalezar&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* ============ RESET & BASE ============ */
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
        :root{
            --ink:#142033;
            --ink-soft:#243349;
            --paper:#F3F6F4;
            --paper-alt:#EAF1EC;
            --teal:#0B6E63;
            --teal-dark:#084F47;
            --teal-light:#E4F1EE;
            --amber:#E7A33E;
            --amber-dark:#C6811F;
            --coral:#EF6F53;
            --coral-dark:#D45539;
            --text:#24303D;
            --text-soft:#5B6B77;
            --white:#FFFFFF;
            --border:#E1E7E4;
            --radius-lg:22px;
            --radius-md:14px;
            --radius-sm:8px;
            --shadow-sm:0 4px 14px -6px rgba(20,32,51,.12);
            --shadow-md:0 14px 34px -14px rgba(20,32,51,.24);
            --shadow-lg:0 24px 60px -20px rgba(20,32,51,.32);
            --font-display:'Lalezar', cursive;
            --font-body:'Cairo', sans-serif;
            --ease:cubic-bezier(.4,0,.2,1);
        }
        html{scroll-behavior:smooth;}
        body{
            font-family:var(--font-body);
            color:var(--text);
            background:var(--paper);
            line-height:1.7;
            overflow-x:hidden;
            -webkit-font-smoothing:antialiased;
        }
        img{max-width:100%;display:block;}
        button{font-family:inherit;cursor:pointer;border:none;background:none;}
        a{color:inherit;text-decoration:none;}
        ul{list-style:none;}
        input,textarea,select{font-family:inherit;font-size:1rem;}
        .container{width:100%;max-width:1220px;margin-inline:auto;padding-inline:24px;}
        h1,h2,h3,h4{font-family:var(--font-display);font-weight:400;color:var(--ink);line-height:1.25;}
        ::selection{background:var(--amber);color:var(--ink);}

        @media (prefers-reduced-motion: reduce){
            *{animation-duration:.001ms !important;animation-iteration-count:1 !important;transition-duration:.001ms !important;scroll-behavior:auto !important;}
        }

        /* ============ UTILITIES ============ */
        .eyebrow{
            display:inline-flex;align-items:center;gap:8px;
            font-size:.8rem;font-weight:700;letter-spacing:.5px;
            color:var(--teal-dark);background:var(--teal-light);
            padding:6px 16px;border-radius:99px;margin-bottom:16px;
        }
        .eyebrow::before{content:"";width:6px;height:6px;border-radius:50%;background:var(--coral);}
        .section{padding:100px 0;position:relative;}
        .section-head{max-width:640px;margin-bottom:56px;}
        .section-head.center{margin-inline:auto;text-align:center;}
        .section-title{font-size:clamp(2rem,4vw,2.9rem);}
        .section-sub{color:var(--text-soft);font-size:1.05rem;margin-top:14px;}
        .reveal{
            opacity: 1 !important;
            transform: translateY(0) !important;
            opacity:0;transform:translateY(28px);
            transition:opacity .7s var(--ease),
            transform .7s var(--ease);
        }
        .reveal.in-view{opacity:1;transform:translateY(0);}
        .reveal-delay-1.in-view{transition-delay:.1s;}
        .reveal-delay-2.in-view{transition-delay:.2s;}
        .reveal-delay-3.in-view{transition-delay:.3s;}

        .btn{
            display:inline-flex;align-items:center;justify-content:center;gap:10px;
            padding:15px 30px;border-radius:99px;font-weight:700;font-size:.98rem;
            transition:transform .25s var(--ease),box-shadow .25s var(--ease),background .25s var(--ease);
            white-space:nowrap;
        }
        .btn:active{transform:scale(.97);}
        .btn-primary{background:var(--amber);color:var(--ink);box-shadow:0 10px 24px -8px rgba(231,163,62,.55);}
        .btn-primary:hover{background:var(--amber-dark);transform:translateY(-2px);}
        .btn-coral{background:var(--coral);color:var(--white);box-shadow:0 10px 24px -8px rgba(239,111,83,.5);}
        .btn-coral:hover{background:var(--coral-dark);transform:translateY(-2px);}
        .btn-outline{background:transparent;color:var(--white);border:1.5px solid rgba(255,255,255,.55);}
        .btn-outline:hover{background:rgba(255,255,255,.12);}
        .btn-ghost{background:var(--white);color:var(--teal-dark);border:1.5px solid var(--border);}
        .btn-ghost:hover{border-color:var(--teal);color:var(--teal);}
        .btn-sm{padding:10px 20px;font-size:.85rem;}

        /* dotted path divider — signature element */
        .path-divider{display:flex;align-items:center;justify-content:center;gap:10px;margin:0 auto 46px;max-width:900px;}
        .path-divider .dash{flex:1;height:0;border-top:2.5px dashed var(--border);}
        .path-divider .node{width:9px;height:9px;border-radius:50%;background:var(--coral);flex-shrink:0;}

        /* ============ HEADER ============ */
        .site-header{
            position:fixed;inset-inline:0;top:0;z-index:900;
            padding:18px 0;transition:all .35s var(--ease);
        }
        .site-header .container{display:flex;align-items:center;justify-content:space-between;gap:20px;}
        .site-header.scrolled{background:rgba(243,246,244,.92);backdrop-filter:blur(10px);box-shadow:var(--shadow-sm);padding:12px 0;}
        .brand{display:flex;align-items:center;gap:12px;}
        .brand-mark{
            width:46px;height:46px;border-radius:14px;background:linear-gradient(135deg,var(--teal),var(--teal-dark));
            display:flex;align-items:center;justify-content:center;color:var(--white);
            font-family:var(--font-display);font-size:1.3rem;flex-shrink:0;box-shadow:var(--shadow-sm);
        }
        .brand-text{display:flex;flex-direction:column;line-height:1.15;}
        .brand-text b{font-family:var(--font-display);font-size:1.15rem;color:var(--ink);}
        .site-header.scrolled .brand-text b, .site-header:not(.scrolled) .brand-text b{color:var(--ink);}
        .brand-text span{font-size:.68rem;letter-spacing:1.5px;color:var(--text-soft);text-transform:uppercase;}

        .nav-desktop{display:flex;align-items:center;gap:34px;}
        .nav-desktop a{font-weight:600;font-size:.95rem;position:relative;color:var(--ink);}
        .site-header:not(.scrolled) .nav-desktop a, .site-header:not(.scrolled) .brand-text b, .site-header:not(.scrolled) .brand-text span{color:var(--white);}
        .nav-desktop a::after{content:"";position:absolute;bottom:-6px;inset-inline:0;height:2px;background:var(--coral);transform:scaleX(0);transition:transform .3s var(--ease);}
        .nav-desktop a:hover::after{transform:scaleX(1);}
        .header-cta{display:flex;align-items:center;gap:12px;}
        .hamburger{display:none;width:44px;height:44px;border-radius:12px;align-items:center;justify-content:center;background:rgba(255,255,255,.15);}
        .site-header.scrolled .hamburger{background:var(--paper-alt);}
        .hamburger span,.hamburger span::before,.hamburger span::after{content:"";display:block;width:20px;height:2px;background:var(--white);position:relative;transition:.3s;}
        .site-header.scrolled .hamburger span, .site-header.scrolled .hamburger span::before, .site-header.scrolled .hamburger span::after{background:var(--ink);}
        .hamburger span::before{position:absolute;top:-7px;}
        .hamburger span::after{position:absolute;top:7px;}

        .mobile-nav{position:fixed;inset:0;background:var(--ink);z-index:950;display:flex;flex-direction:column;padding:26px 24px;transform:translateY(-100%);transition:transform .4s var(--ease);}
        .mobile-nav.open{transform:translateY(0);}
        .mobile-nav-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:40px;}
        .mobile-nav-top .close-x{width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.1);color:var(--white);font-size:1.4rem;display:flex;align-items:center;justify-content:center;}
        .mobile-nav a{display:block;color:var(--white);font-size:1.5rem;font-family:var(--font-display);padding:16px 0;border-bottom:1px solid rgba(255,255,255,.1);}
        .mobile-nav .btn{margin-top:30px;}

        /* ============ HERO ============ */
        .hero{position:relative;min-height:100vh;overflow:hidden;background:var(--ink);}
        .hero-slide{position:absolute;inset:0;opacity:0;visibility:hidden;transition:opacity 1s var(--ease);}
        .hero-slide.active{opacity:1;visibility:visible;z-index:2;}
        .hero-slide video, .hero-slide .hero-illustration{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
        .hero-slide::before{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,20,35,.55) 0%,rgba(10,20,35,.35) 45%,rgba(10,20,35,.88) 100%);z-index:1;}
        .hero-illustration{background-size:cover;background-position:center;}
        .slide-1 .hero-illustration{background:radial-gradient(circle at 20% 20%,#1a5f57,#0b2a3a 70%);}
        .slide-3 .hero-illustration{background:radial-gradient(circle at 80% 30%,#2d7d6f,#0f1f30 75%);}

        .hero-inner{position:relative;z-index:3;min-height:100vh;display:flex;flex-direction:column;justify-content:center;padding-top:80px;}
        .hero-content{max-width:680px;}
        .hero-content .eyebrow{background:rgba(255,255,255,.14);color:var(--white);backdrop-filter:blur(4px);}
        .hero-content .eyebrow::before{background:var(--amber);}
        .hero-title{font-size:clamp(2.4rem,6vw,4.4rem);color:var(--white);margin-bottom:20px;}
        .hero-title em{font-style:normal;color:var(--amber);}
        .hero-text{color:rgba(255,255,255,.85);font-size:1.1rem;max-width:520px;margin-bottom:34px;}
        .hero-actions{display:flex;flex-wrap:wrap;gap:16px;}

        .hero-nav-arrows{position:absolute;inset-inline:0;top:50%;transform:translateY(-50%);z-index:4;display:flex;justify-content:space-between;padding-inline:24px;pointer-events:none;}
        .hero-arrow{pointer-events:auto;width:48px;height:48px;border-radius:50%;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.3);color:var(--white);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(6px);transition:background .25s;}
        .hero-arrow:hover{background:rgba(255,255,255,.28);}

        .hero-bottom-bar{position:absolute;bottom:28px;inset-inline:0;z-index:4;display:flex;align-items:center;justify-content:space-between;padding-inline:24px;}
        .hero-dots{display:flex;gap:10px;}
        .hero-dot{width:9px;height:9px;border-radius:50%;background:rgba(255,255,255,.4);transition:.3s;}
        .hero-dot.active{background:var(--amber);width:26px;border-radius:6px;}
        .video-controls{display:flex;gap:10px;opacity:0;pointer-events:none;transition:opacity .3s;}
        .video-controls.visible{opacity:1;pointer-events:auto;}
        .vc-btn{width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.3);color:var(--white);display:flex;align-items:center;justify-content:center;backdrop-filter:blur(6px);}
        .vc-btn:hover{background:rgba(255,255,255,.28);}
        .vc-btn svg{width:18px;height:18px;}

        .scroll-cue{position:absolute;bottom:96px;left:50%;transform:translateX(-50%);z-index:4;color:rgba(255,255,255,.7);display:flex;flex-direction:column;align-items:center;gap:6px;font-size:.75rem;}
        .scroll-cue svg{width:16px;animation:bob 1.8s infinite;}
        @keyframes bob{0%,100%{transform:translateY(0);}50%{transform:translateY(6px);}}

        /* ============ VISION ============ */
        .vision-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;}
        .vision-card{background:var(--white);border-radius:var(--radius-lg);padding:38px 30px;box-shadow:var(--shadow-sm);border:1px solid var(--border);transition:transform .35s var(--ease),box-shadow .35s var(--ease);}
        .vision-card:hover{transform:translateY(-8px);box-shadow:var(--shadow-md);}
        .vision-icon{width:56px;height:56px;border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:22px;color:var(--white);}
        .vision-card:nth-child(1) .vision-icon{background:var(--teal);}
        .vision-card:nth-child(2) .vision-icon{background:var(--coral);}
        .vision-card:nth-child(3) .vision-icon{background:var(--amber);}
        .vision-card h3{font-size:1.5rem;margin-bottom:12px;}
        .vision-card p{color:var(--text-soft);font-size:.98rem;}

        /* ============ PRINCIPAL ============ */
        .principal{background:var(--ink);border-radius:var(--radius-lg);overflow:hidden;display:grid;grid-template-columns:.85fr 1.15fr;box-shadow:var(--shadow-lg);}
        .principal-photo{position:relative;min-height:420px;background:linear-gradient(160deg,var(--teal),#0a3b35);display:flex;align-items:flex-end;padding:28px;}
        .principal-avatar{width:100%;height:100%;position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:6rem;color:rgba(255,255,255,.18);}
        .principal-photo-tag{position:relative;z-index:2;background:rgba(255,255,255,.12);backdrop-filter:blur(6px);color:var(--white);padding:12px 18px;border-radius:12px;font-size:.85rem;}
        .principal-photo-tag b{display:block;font-family:var(--font-body);font-weight:800;font-size:1.05rem;}
        .principal-body{padding:48px 44px;display:flex;flex-direction:column;justify-content:center;}
        .quote-mark{font-family:var(--font-display);font-size:4rem;color:var(--amber);line-height:.6;margin-bottom:10px;}
        .principal-body p{color:rgba(255,255,255,.86);font-size:1.08rem;margin-bottom:22px;}
        .principal-sign{color:var(--amber);font-family:var(--font-display);font-size:1.6rem;}
        .principal-sign span{display:block;font-family:var(--font-body);font-size:.85rem;color:rgba(255,255,255,.6);font-weight:600;margin-top:4px;}

        /* ============ FACILITIES ============ */
        .facility-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
        .facility-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius-md);padding:28px;display:flex;gap:18px;align-items:flex-start;transition:border-color .3s,transform .3s;}
        .facility-card:hover{border-color:var(--teal);transform:translateY(-4px);}
        .facility-icon{width:52px;height:52px;border-radius:14px;background:var(--teal-light);color:var(--teal-dark);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
        .facility-icon svg{width:26px;height:26px;}
        .facility-card h4{font-family:var(--font-body);font-weight:800;font-size:1.05rem;margin-bottom:6px;color:var(--ink);}
        .facility-card p{color:var(--text-soft);font-size:.9rem;}

        /* ============ STAFF ============ */
        .stage-path{display:flex;align-items:center;justify-content:space-between;max-width:820px;margin:0 auto 50px;position:relative;}
        .stage-path::before{content:"";position:absolute;top:24px;inset-inline:30px;height:0;border-top:2.5px dashed var(--border);z-index:0;}
        .stage-btn{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;gap:10px;background:none;flex:1;}
        .stage-num{width:48px;height:48px;border-radius:50%;background:var(--white);border:2.5px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--text-soft);transition:.3s;}
        .stage-btn span{font-weight:700;font-size:.9rem;color:var(--text-soft);transition:.3s;}
        .stage-btn.active .stage-num{background:var(--coral);border-color:var(--coral);color:var(--white);}
        .stage-btn.active span{color:var(--ink);}
        .stage-btn:hover .stage-num{border-color:var(--coral);}

        .teacher-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;}
        .teacher-card{background:var(--white);border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--border);box-shadow:var(--shadow-sm);transition:transform .3s,box-shadow .3s;}
        .teacher-card:hover{transform:translateY(-6px);box-shadow:var(--shadow-md);}
        .teacher-media{height:190px;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:3.2rem;color:rgba(255,255,255,.85);position:relative;}
        .teacher-media::after{content:attr(data-badge);position:absolute;top:12px;inset-inline-start:12px;background:rgba(255,255,255,.9);color:var(--ink);font-size:.7rem;font-weight:800;padding:5px 11px;border-radius:99px;}
        .teacher-info{padding:22px;}
        .teacher-info h4{font-family:var(--font-body);font-weight:800;font-size:1.12rem;color:var(--ink);}
        .teacher-info .role{color:var(--coral);font-weight:700;font-size:.85rem;margin:4px 0 14px;}
        .teacher-info p{color:var(--text-soft);font-size:.88rem;margin-bottom:16px;}

        /* ============ ACHIEVEMENTS ============ */
        .filter-bar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:38px;}
        .filter-btn{padding:10px 22px;border-radius:99px;border:1.5px solid var(--border);font-weight:700;font-size:.88rem;color:var(--text-soft);transition:.25s;}
        .filter-btn.active,.filter-btn:hover{background:var(--ink);color:var(--white);border-color:var(--ink);}
        .ach-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
        .ach-card{background:var(--white);border-radius:var(--radius-md);padding:26px;border:1px solid var(--border);position:relative;overflow:hidden;transition:transform .3s;}
        .ach-card:hover{transform:translateY(-5px);}
        .ach-ribbon{position:absolute;top:0;left:0;background:var(--amber);color:var(--ink);font-size:.68rem;font-weight:800;padding:5px 14px 6px;border-radius:0 0 10px 0;}
        .ach-card[data-cat="event"] .ach-ribbon{background:var(--teal);color:var(--white);}
        .ach-card[data-cat="achievement"] .ach-ribbon{background:var(--coral);color:var(--white);}
        .ach-icon{width:50px;height:50px;border-radius:12px;background:var(--paper-alt);color:var(--teal-dark);display:flex;align-items:center;justify-content:center;margin:20px 0 16px;}
        .ach-icon svg{width:24px;height:24px;}
        .ach-card h4{font-size:1.05rem;font-weight:800;font-family:var(--font-body);margin-bottom:8px;color:var(--ink);}
        .ach-card p{color:var(--text-soft);font-size:.88rem;}
        .ach-date{display:block;margin-top:14px;font-size:.78rem;color:var(--amber-dark);font-weight:700;}

        /* ============ CTA BAND ============ */
        .cta-band{background:linear-gradient(120deg,var(--teal-dark),var(--teal));border-radius:var(--radius-lg);padding:60px 50px;display:flex;align-items:center;justify-content:space-between;gap:30px;flex-wrap:wrap;color:var(--white);}
        .cta-band h3{color:var(--white);font-size:2rem;max-width:520px;}
        .cta-band p{color:rgba(255,255,255,.8);margin-top:10px;}

        /* ============ COMPLAINTS ============ */
        .complaints-wrap{display:grid;grid-template-columns:.9fr 1.1fr;gap:44px;align-items:center;}
        .complaints-side h2{margin-bottom:16px;}
        .complaints-side p{color:var(--text-soft);margin-bottom:24px;}
        .complaints-points li{display:flex;gap:12px;align-items:flex-start;margin-bottom:16px;color:var(--text);}
        .complaints-points svg{width:20px;height:20px;color:var(--teal);flex-shrink:0;margin-top:2px;}
        .form-card{background:var(--white);border-radius:var(--radius-lg);padding:36px;border:1px solid var(--border);box-shadow:var(--shadow-sm);}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
        .field{margin-bottom:18px;}
        .field label{display:block;font-size:.85rem;font-weight:700;color:var(--ink);margin-bottom:8px;}
        .field input,.field select,.field textarea{
            width:100%;padding:13px 16px;border:1.5px solid var(--border);border-radius:var(--radius-sm);
            background:var(--paper);transition:border-color .25s;
        }
        .field input:focus,.field select:focus,.field textarea:focus{outline:none;border-color:var(--teal);}
        .field textarea{resize:vertical;min-height:110px;}
        .form-msg{display:none;margin-top:16px;padding:14px 18px;border-radius:var(--radius-sm);background:var(--teal-light);color:var(--teal-dark);font-weight:700;font-size:.9rem;}
        .form-msg.show{display:block;animation:fadein .4s;}
        @keyframes fadein{from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:translateY(0);}}

        /* ============ FOOTER ============ */
        .site-footer{background:var(--ink);color:rgba(255,255,255,.72);padding:80px 0 26px;}
        .footer-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1.2fr;gap:40px;margin-bottom:60px;}
        .footer-brand p{margin-top:16px;font-size:.92rem;line-height:1.8;max-width:280px;}
        .footer-col h5{color:var(--white);font-family:var(--font-body);font-weight:800;margin-bottom:20px;font-size:.98rem;}
        .footer-col li{margin-bottom:12px;font-size:.92rem;}
        .footer-col a:hover{color:var(--amber);}
        .footer-social{display:flex;gap:10px;margin-top:18px;}
        .footer-social a{width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;}
        .footer-social a:hover{background:var(--coral);}
        .footer-social svg{width:16px;height:16px;}
        .footer-bottom{border-top:1px solid rgba(255,255,255,.1);padding-top:24px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px;font-size:.82rem;}

        /* ============ MODALS ============ */
        .modal-overlay{position:fixed;inset:0;background:rgba(10,16,26,.72);backdrop-filter:blur(4px);z-index:1000;display:flex;align-items:center;justify-content:center;padding:24px;opacity:0;visibility:hidden;transition:opacity .3s var(--ease);}
        .modal-overlay.open{opacity:1;visibility:visible;}
        .modal-box{background:var(--white);border-radius:var(--radius-lg);max-width:640px;width:100%;max-height:88vh;overflow-y:auto;position:relative;transform:translateY(24px) scale(.97);transition:transform .35s var(--ease);}
        .modal-overlay.open .modal-box{transform:translateY(0) scale(1);}
        .modal-close{position:absolute;top:16px;left:16px;width:40px;height:40px;border-radius:50%;background:var(--paper);display:flex;align-items:center;justify-content:center;z-index:2;color:var(--ink);}
        .modal-close:hover{background:var(--border);}

        .teacher-modal-media{height:220px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.85);font-family:var(--font-display);font-size:4rem;position:relative;border-radius:var(--radius-lg) var(--radius-lg) 0 0;overflow:hidden;}
        .teacher-modal-media video{width:100%;height:100%;object-fit:cover;}
        .teacher-modal-body{padding:32px 34px 38px;}
        .tm-role{color:var(--coral);font-weight:700;font-size:.9rem;margin:6px 0 18px;}
        .tm-tags{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;}
        .tm-tag{background:var(--paper-alt);color:var(--teal-dark);font-size:.8rem;font-weight:700;padding:7px 14px;border-radius:99px;}
        .tm-bio{color:var(--text-soft);margin-bottom:18px;}
        .tm-quote{border-inline-start:3px solid var(--amber);padding-inline-start:16px;font-style:normal;color:var(--ink);font-weight:600;}

        .register-modal .modal-box{max-width:600px;}
        .register-header{background:linear-gradient(120deg,var(--teal-dark),var(--teal));color:var(--white);padding:34px 34px 26px;border-radius:var(--radius-lg) var(--radius-lg) 0 0;}
        .register-header h3{color:var(--white);font-size:1.9rem;}
        .register-header p{color:rgba(255,255,255,.82);margin-top:8px;font-size:.92rem;}
        .register-body{padding:30px 34px 34px;}

        .toast{position:fixed;bottom:26px;left:50%;transform:translateX(-50%) translateY(120%);background:var(--ink);color:var(--white);padding:16px 26px;border-radius:99px;font-weight:700;font-size:.9rem;z-index:1100;transition:transform .4s var(--ease);display:flex;align-items:center;gap:10px;box-shadow:var(--shadow-lg);}
        .toast.show{transform:translateX(-50%) translateY(0);}
        .toast svg{width:18px;height:18px;color:var(--amber);}

        /* ============ RESPONSIVE ============ */
        @media(max-width:980px){
            .nav-desktop,.header-cta .btn{display:none;}
            .hamburger{display:flex;}
            .vision-grid,.facility-grid,.teacher-grid,.ach-grid{grid-template-columns:repeat(2,1fr);}
            .principal{grid-template-columns:1fr;}
            .principal-photo{min-height:260px;}
            .complaints-wrap{grid-template-columns:1fr;}
            .footer-grid{grid-template-columns:1fr 1fr;}
        }
        @media(max-width:640px){
            .section{padding:70px 0;}
            .vision-grid,.facility-grid,.teacher-grid,.ach-grid{grid-template-columns:1fr;}
            .form-row{grid-template-columns:1fr;}
            .footer-grid{grid-template-columns:1fr;gap:34px;}
            .cta-band{flex-direction:column;text-align:center;padding:44px 26px;}
            .stage-path{flex-wrap:wrap;gap:18px 0;}
            .stage-path::before{display:none;}
            .hero-nav-arrows{display:none;}
            .principal-body{padding:34px 26px;}
        }
    </style>
</head>
<body>

<!-- ============ HEADER ============ -->
<header class="site-header" id="siteHeader">
    <div class="container">
        <div class="brand">
            <div class="brand-mark">
                <img src="{{asset('uploads/logo/white_logo.png')}}" alt="شعار المدرسة" width="45" height="45">
            </div>
            <div class="brand-text">
                <b style="color:#fff">مدرسة يرن تو بي</b>
                <span style="color:rgba(255,255,255,.5)">Learn to Be School</span>
            </div>
        </div>
        <nav class="nav-desktop">
            <a href="#home">الرئيسية</a>
            <a href="#about">عن المدرسة</a>
            <a href="#staff">الطاقم التدريسي</a>
            <a href="#facilities">الأقسام</a>
            <a href="#achievements">الإنجازات</a>
            <a href="#complaints">الشكاوى</a>
            <a href="#contact">تواصل معنا</a>
        </nav>
        <div class="header-cta">
            {{--<button class="btn btn-primary btn-sm js-open-register">تسجيل طالب جديد</button>--}}
            <button class="hamburger" id="hamburgerBtn" aria-label="فتح القائمة"><span></span></button>
        </div>
    </div>
</header>

<!-- ============ MOBILE NAV ============ -->
<div class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-top">
        <div class="brand-text" style="color:#fff"><b style="color:#fff">ليرن تو بي</b></div>
        <button class="close-x" id="mobileCloseBtn">&times;</button>
    </div>
    <a href="#home">الرئيسية</a>
    <a href="#about">عن المدرسة</a>
    <a href="#staff">الطاقم التدريسي</a>
    <a href="#facilities">الأقسام</a>
    <a href="#achievements">الإنجازات</a>
    <a href="#complaints">الشكاوى</a>
    <a href="#contact">تواصل معنا</a>
</div>

<!-- ============ HERO ============ -->
<section class="hero" id="home">
    <div class="hero-slide slide-1 active" data-type="illustration">
        <div class="hero-illustration"></div>
    </div>
    <div class="hero-slide slide-2" data-type="video">
        <video muted loop playsinline poster="">
            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
        </video>
    </div>
    <div class="hero-slide slide-3" data-type="illustration">
        <div class="hero-illustration"></div>
    </div>

    <div class="hero-inner container">
        <div class="hero-content">
            <span class="eyebrow">مدرسة دولية معتمدة من قبل وزارة التربية والتعليم</span>
            <h1 class="hero-title">لأنّ كل طفل يستحقّ أن يتعلّم <em>كيف يكون</em></h1>
            <p class="hero-text">في ليرن تو بي، لا نكتفي بتلقين المعرفة، بل نبني شخصية الطالب وثقته بنفسه خطوة بخطوة، من الروضة وحتى الثانوية.</p>
            <div class="hero-actions">
                <button class="btn btn-primary js-open-register">سجّل طفلك الآن</button>
                <a href="#about" class="btn btn-outline">تعرّف على المدرسة</a>
            </div>
        </div>
    </div>

    <div class="hero-nav-arrows">
        <button class="hero-arrow" id="heroPrev" aria-label="السابق">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M9 6l6 6-6 6"/></svg>
        </button>
        <button class="hero-arrow" id="heroNext" aria-label="التالي">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M15 6l-6 6 6 6"/></svg>
        </button>
    </div>

    <div class="scroll-cue">
        مرّر للأسفل
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M6 13l6 6 6-6"/></svg>
    </div>

    <div class="hero-bottom-bar">
        <div class="video-controls" id="videoControls">
            <button class="vc-btn" id="playPauseBtn" aria-label="تشغيل/إيقاف الفيديو">
                <svg id="playIcon" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                <svg id="pauseIcon" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M6 5h4v14H6zM14 5h4v14h-4z"/></svg>
            </button>
            <button class="vc-btn" id="muteBtn" aria-label="كتم/تشغيل الصوت">
                <svg id="soundOnIcon" viewBox="0 0 24 24" fill="currentColor"><path d="M4 9v6h4l5 5V4L8 9H4z"/></svg>
                <svg id="soundOffIcon" viewBox="0 0 24 24" fill="currentColor" style="display:none"><path d="M4 9v6h4l5 5V4L8 9H4zm11.5 3l2.5 2.5 1.4-1.4L16.9 11l2.5-2.5-1.4-1.4L15 9.6l-2.5-2.5-1.4 1.4L13.6 11l-2.5 2.5 1.4 1.4L15 12.4z"/></svg>
            </button>
        </div>
        <div class="hero-dots" id="heroDots"></div>
    </div>
</section>

<!-- ============ ABOUT / VISION ============ -->
<section class="section" id="about">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow">هويتنا</span>
            <h2 class="section-title">رؤيتنا، رسالتنا، وقيمنا</h2>
            <p class="section-sub">ثلاثة مبادئ توجّه كل قرار نتّخذه داخل أسوار المدرسة</p>
        </div>
        <div class="vision-grid">
            <div class="vision-card reveal">
                <div class="vision-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><path d="M12 2v4M12 18v4M4.9 4.9l2.8 2.8M16.3 16.3l2.8 2.8M2 12h4M18 12h4M4.9 19.1l2.8-2.8M16.3 7.7l2.8-2.8"/><circle cx="12" cy="12" r="4"/></svg></div>
                <h3>رؤيتنا</h3>
                <p>أن نكون بيئة تعليمية رائدة تُخرّج أجيالاً واثقة، قادرة على التفكير النقدي والتعلّم مدى الحياة.</p>
            </div>
            <div class="vision-card reveal reveal-delay-1">
                <div class="vision-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg></div>
                <h3>رسالتنا</h3>
                <p>نقدّم منهجاً متوازناً يجمع بين العلوم الأكاديمية والمهارات الحياتية، برعاية طاقم تربوي متخصص.</p>
            </div>
            <div class="vision-card reveal reveal-delay-2">
                <div class="vision-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="26" height="26"><path d="M12 2l3 7 7 1-5.5 5 1.5 7-6-4-6 4 1.5-7L2 10l7-1z"/></svg></div>
                <h3>قيمنا</h3>
                <p>الاحترام، الفضول، المسؤولية، والانتماء؛ قيم نغرسها يومياً داخل الصف وخارجه.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ PRINCIPAL ============ -->
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="principal reveal">
            <div class="principal-photo">
                <div class="principal-avatar"><img src="{{asset('uploads/site/warda.jpg')}}"></div>
                <div class="principal-photo-tag">
                    <b>أ. وردة ضبان</b>
                    مديرة مدرسة ليرن تو بي
                </div>
            </div>
            <div class="principal-body">
                <span class="quote-mark">“</span>
                <p>نؤمن في ليرن تو بي أن التعليم الحقيقي لا يقاس بالعلامات وحدها، بل بقدرة الطالب على اكتشاف ذاته وشغفه. مهمتنا أن نمنح كل طالب المساحة ليخطئ، يتعلّم، ويكبر بثقة. نرحّب بكم في عائلتنا التربوية، حيث كل طفل قصة نجاح تنتظر أن تُكتب.</p>
                <div class="principal-sign">وردة ضبان
                    <span>مديرة المدرسة</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ FACILITIES ============ -->
<section class="section" id="facilities">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">مرافقنا</span>
            <h2 class="section-title">أقسام المدرسة ومرافقها</h2>
            <p class="section-sub">مساحات مصمّمة لدعم التعلّم العملي والإبداع في كل مرحلة دراسية</p>
        </div>
        <div class="facility-grid" id="facilityGrid"></div>
    </div>
</section>

<!-- ============ STAFF ============ -->
<section class="section" id="staff" style="background:var(--paper-alt)">
    <div class="container">
        <div class="section-head center reveal">
            <span class="eyebrow">طاقمنا التدريسي</span>
            <h2 class="section-title">مسار النمو التعليمي</h2>
            <p class="section-sub">فريق تربوي متخصص يرافق طفلك في كل مرحلة من مراحل رحلته الدراسية</p>
        </div>

        <div class="stage-path" id="stagePath"></div>
        <div class="teacher-grid" id="teacherGrid"></div>
    </div>
</section>

<!-- ============ ACHIEVEMENTS ============ -->
<section class="section" id="achievements">
    <div class="container">
        <div class="section-head reveal">
            <span class="eyebrow">قصص نفخر بها</span>
            <h2 class="section-title">الإنجازات، الفعاليات، والجوائز</h2>
            <p class="section-sub">لمحة عمّا حققته مدرستنا وطلابنا على مدار الأعوام الماضية</p>
        </div>
        <div class="filter-bar" id="filterBar"></div>
        <div class="ach-grid" id="achGrid"></div>
    </div>
</section>

<!-- ============ CTA BAND ============ -->
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="cta-band reveal">
            <div>
                <h3>هل أنت مستعد لتبدأ رحلة طفلك معنا؟</h3>
                <p>التسجيل مفتوح الآن للعام الدراسي القادم لجميع المراحل.</p>
            </div>
            <button class="btn btn-primary js-open-register">سجّل الآن</button>
        </div>
    </div>
</section>

<!-- ============ COMPLAINTS ============ -->
<section class="section" id="complaints" style="background:var(--paper-alt)">
    <div class="container complaints-wrap">
        <div class="complaints-side reveal">
            <span class="eyebrow">صوتك مسموع</span>
            <h2 class="section-title">الشكاوى والاقتراحات</h2>
            <p>نحرص على الاستماع لملاحظات أولياء الأمور والطلاب بجدية تامة، ويلتزم فريقنا بالرد خلال 48 ساعة عمل.</p>
            <ul class="complaints-points">
                <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> سرّية تامة لجميع البيانات المقدَّمة</li>
                <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> متابعة مباشرة من إدارة المدرسة</li>
                <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg> إمكانية إرفاق تفاصيل إضافية عند الحاجة</li>
            </ul>
        </div>
        <div class="form-card reveal reveal-delay-1">
            <form id="complaintForm" method="POST" action="{{ route('complaints.store') }}">
                @csrf
                <div class="form-row">
                    <div class="field">
                        <label>الاسم الكامل</label>
                        <input type="text" name="complainant_name" required placeholder="اسمك">
                    </div>
                    <div class="field">
                        <label>رقم الهاتف</label>
                        <input type="tel" name="phone_number" required placeholder="05xxxxxxxx">
                    </div>
                </div>
                <div class="field">
                    <label>نوع الطلب</label>
                    <select name="type" required>
                        <option value="">اختر النوع</option>
                        <option value="complaint">شكوى</option>
                        <option value="suggestion">اقتراح</option>
                        <option value="inquiry">استفسار</option>
                    </select>
                </div>
                <div class="field">
                    <label>تفاصيل الرسالة</label>
                    <textarea name="details" required placeholder="اكتب رسالتك هنا..."></textarea>
                </div>
                <button type="submit" class="btn btn-coral" style="width:100%">إرسال الرسالة</button>
                <div class="form-msg" id="complaintMsg" style="display:none;"></div>
            </form>
        </div>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="site-footer" id="contact">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="brand">
                    <div class="brand-mark">
                        <img src="{{asset('uploads/logo/white_logo.png')}}" alt="شعار المدرسة" width="45" height="45">
                    </div>
                    <div class="brand-text">
                        <b style="color:#fff">مدرسة يرن تو بي</b>
                        <span style="color:rgba(255,255,255,.5)">Learn to Be School</span>
                    </div>
                </div>
                <p>مدرسة دولية تجمع بين الأصالة والحداثة في التعليم، لتؤهّل جيلاً واثقاً وقادراً على صناعة الفرق.</p>
                <div class="footer-social">
                    <a href="https://www.facebook.com/Wemaketheimpossible" aria-label="فيسبوك"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 22v-9h3l1-4h-4V7c0-1 0.5-2 2-2h2V1h-3c-3 0-5 2-5 5v3H6v4h3v9z"/></svg></a>
                    <a href="https://www.instagram.com/learn_to_be1" aria-label="انستغرام"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg></a>
                    <a href="#" aria-label="يوتيوب"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12s0-3.5-.4-5a3 3 0 0 0-2.1-2.1C17.9 4.5 12 4.5 12 4.5s-5.9 0-7.5.4A3 3 0 0 0 2.4 7C2 8.5 2 12 2 12s0 3.5.4 5a3 3 0 0 0 2.1 2.1c1.6.4 7.5.4 7.5.4s5.9 0 7.5-.4A3 3 0 0 0 21.6 17c.4-1.5.4-5 .4-5zM10 15.5v-7l6 3.5z"/></svg></a>
                </div>
            </div>
            <div class="footer-col">
                <h5>روابط سريعة</h5>
                <ul>
                    <li><a href="#about">عن المدرسة</a></li>
                    <li><a href="#staff">الطاقم التدريسي</a></li>
                    <li><a href="#facilities">الأقسام</a></li>
                    <li><a href="#achievements">الإنجازات</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>المراحل الدراسية</h5>
                <ul>
                    <li>الروضة</li>
                    <li>المرحلة الابتدائية</li>
                    <li>المرحلة المتوسطة</li>
                    <li>المرحلة الثانوية</li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>تواصل معنا</h5>
                <ul>
                    <li>غزة -الصحابة - شارع مدوخ</li>
                    <li>059-5100043</li>
                    <li>learntobe2017@gmail.com</li>
                    <li>السبت – الخميس</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2026 مدرسة ليرن تو بي. جميع الحقوق محفوظة.</span>
            <span>صُمم بعناية من أجل مستقبل أبنائنا</span>
        </div>
    </div>
</footer>

<!-- ============ TEACHER MODAL ============ -->
<div class="modal-overlay" id="teacherModal">
    <div class="modal-box">
        <button class="modal-close" data-close><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
        <div id="teacherModalContent"></div>
    </div>
</div>

<!-- ============ REGISTER MODAL ============ -->
<div class="modal-overlay register-modal" id="registerModal">
    <div class="modal-box">
        <button class="modal-close" data-close>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
        <div class="register-header">
            <h3>تسجيل طالب جديد</h3>
            <p>عبّئ النموذج وسيتواصل معك فريق القبول والتسجيل خلال يومي عمل</p>
        </div>
        <div class="register-body">
            <!-- زر عرض شروط التسجيل والأسعار -->
            <div style="text-align: center; margin-bottom: 20px;">
                <button type="button" class="btn btn-info" id="showRegistrationDetailsBtn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 30px; border-radius: 50px; font-size: 16px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                    <i class="fas fa-info-circle"></i> 📋 عرض شروط التسجيل والأسعار
                </button>
            </div>

            <form id="registerStudentForm" method="POST" action="{{ route('register.student.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="field">
                        <label>رقم هوية الطالب</label>
                        <input type="text" name="student_id_number" required placeholder="ادخل رقم الهوية">
                    </div>
                    <div class="field">
                        <label>اسم الطالب رباعي</label>
                        <input type="text" name="student_full_name" required placeholder="الاسم الكامل">
                    </div>
                    <div class="field">
                        <label>تاريخ الميلاد</label>
                        <input type="date" name="birth_date" required>
                    </div>
                    <div class="field">
                        <label>عنوان السكن</label>
                        <input type="text" name="address" required placeholder="ادخل عنوان السكن الحالي">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>المرحلة الدراسية</label>
                        <select required name="age_group_id" id="age_group">
                            <option value="">اختر المرحلة</option>
                            @foreach(get_lookup_by_master_key('age_group') as $age_group)
                                <option value="{{$age_group->id}}">{{$age_group->name_ar}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>@lang('admin.Class')</label>
                        <select required name="class_id" id="class">
                            <option value="">اختر الفصل</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>اسم ولي الأمر</label>
                        <input type="text" name="guardian_name" required placeholder="الاسم الكامل">
                    </div>
                    <div class="field">
                        <label>رقم هوية ولي الامر</label>
                        <input type="text" name="guardian_id_number" required placeholder="رقم الهوية">
                    </div>
                    <div class="field">
                        <label>رقم الهاتف</label>
                        <input type="tel" name="phone_number" required placeholder="05xxxxxxxx">
                    </div>
                    <div class="field">
                        <label>إشعار التحويل</label>
                        <input type="file" name="transfer_notice" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="field">
                    <label>ملاحظات إضافية (اختياري)</label>
                    <textarea name="additional_notes" placeholder="أي معلومات إضافية تودّ إخبارنا بها"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">إرسال طلب التسجيل</button>
                <div class="form-msg" id="registerMsg" style="display:none;"></div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- ✅ نافذة عرض شروط التسجيل والأسعار -->
<!-- ============================================ -->
<div class="modal-overlay" id="registrationDetailsModal">
    <div class="modal-box" style="max-width: 800px;">
        <button class="modal-close" data-close id="closeDetailsModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>
        <div class="register-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 20px 20px 0 0;">
            <h3 style="color: white; font-size: 24px; margin-bottom: 10px;">📋 شروط التسجيل والأسعار</h3>
            <p style="color: rgba(255,255,255,0.9); font-size: 14px;">تعرف على شروط التسجيل والرسوم الدراسية لكل مرحلة</p>
        </div>
        <div class="register-body" style="padding: 30px; max-height: 500px; overflow-y: auto;">
            <!-- محتوى الشروط والأسعار -->
            <div id="registrationDetailsContent">
                <!-- سيتم ملؤها بواسطة JavaScript -->
            </div>
        </div>
    </div>
</div>

<style>
    /* ✅ ستايل زر عرض التفاصيل */
    #showRegistrationDetailsBtn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 14px 35px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    #showRegistrationDetailsBtn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }

    #showRegistrationDetailsBtn:active {
        transform: translateY(0px);
    }

    /* ✅ ستايل بطاقات الشروط */
    .detail-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        border-right: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        background: #f0f0ff;
        transform: translateX(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .detail-card .stage-title {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .detail-card .stage-title .badge {
        background: #667eea;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .detail-card .price {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
        margin: 10px 0;
    }

    .detail-card .price span {
        font-size: 14px;
        font-weight: 400;
        color: #718096;
    }

    .detail-card .conditions {
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }

    .detail-card .conditions li {
        padding: 5px 0;
        padding-right: 25px;
        position: relative;
        color: #4a5568;
        font-size: 14px;
    }

    .detail-card .conditions li::before {
        content: "✅";
        position: absolute;
        right: 0;
        top: 5px;
    }

    .detail-card .conditions li.rejected::before {
        content: "❌";
    }

    /* ✅ ستايل التبويبات */
    .tabs-container {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 10px 25px;
        border: 2px solid #e2e8f0;
        border-radius: 30px;
        background: white;
        color: #4a5568;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 14px;
    }

    .tab-btn:hover {
        border-color: #667eea;
        color: #667eea;
    }

    .tab-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<!-- ============ TOAST ============ -->
<div class="toast" id="toast">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
    <span id="toastText">تم الإرسال بنجاح</span>
</div>
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<script>

    $(document).ready(function () {
        // إرسال نموذج التسجيل
        // =============================================
        $('#registerStudentForm').on('submit', function(e) {
            e.preventDefault();

            var form = this;
            var formData = new FormData(form);
            var msgDiv = $('#registerMsg');
            var submitBtn = $(this).find('button[type="submit"]');

            // إخفاء أي رسالة سابقة
            msgDiv.hide().removeClass('success error');

            // تعطيل الزر أثناء الإرسال
            submitBtn.prop('disabled', true).text('جاري الإرسال...');

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // عرض رسالة نجاح
                        msgDiv.html('✅ ' + response.message)
                            .addClass('success')
                            .fadeIn(500);

                        // إعادة تعيين الفورم
                        form.reset();

                        // إخفاء الرسالة بعد 5 ثواني
                        setTimeout(function() {
                            msgDiv.fadeOut(500);
                        }, 5000);

                        // إغلاق المودال بعد 2 ثانية
                        setTimeout(function() {
                            closeModal(document.getElementById('registerModal'));
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    // عرض أخطاء التحقق
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += '<div>❌ ' + value[0] + '</div>';
                        });
                        msgDiv.html(errorMessages)
                            .addClass('error')
                            .fadeIn(500);
                    } else {
                        msgDiv.html('❌ ' + (xhr.responseJSON?.message || 'حدث خطأ أثناء التسجيل'))
                            .addClass('error')
                            .fadeIn(500);
                    }
                },
                complete: function() {
                    // إعادة تفعيل الزر
                    submitBtn.prop('disabled', false).text('إرسال طلب التسجيل');
                }
            });
        });

        // =============================================
            // عرض نافذة شروط التسجيل
            // =============================================
            $('#showRegistrationDetailsBtn').on('click', function() {
                var modal = document.getElementById('registrationDetailsModal');
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';

                // ملء المحتوى
                loadRegistrationDetails();
            });
            // =============================================
            // إغلاق نافذة التفاصيل
            // =============================================
            $('#closeDetailsModal').on('click', function() {
            closeDetailsModal();
        });
            // إغلاق عند النقر على الخلفية
            $('#registrationDetailsModal').on('click', function(e) {
            if (e.target === this) {
            closeDetailsModal();
        }
        });
            // إغلاق عند الضغط على ESC
            $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
            closeDetailsModal();
        }
        });
            function closeDetailsModal() {
            var modal = document.getElementById('registrationDetailsModal');
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
            // =============================================
            // تحميل محتوى شروط التسجيل
            // =============================================
            function loadRegistrationDetails() {
            var content = document.getElementById('registrationDetailsContent');

            // بيانات الشروط والأسعار (يمكن جلبها من الـ Controller)
            var stagesData = [
        {
            id: 'kg',
            name: 'الروضة',
            age: '3 - 5 سنوات',
            price: '100 شيقل',
            priceYearly: '',
            badge: 'مرحلة مبكرة',
            conditions: [
            'عمر الطفل بين 3 و 5 سنوات',
            'شهادة ميلاد سارية المفعول',
            'بطاقة تطعيم سارية المفعول',
            'صورة شخصية حديثة',
            'الزي المدرسي موحد'
            ],
            rejected: [
            'عمر أقل من 3 سنوات',
            'عدم اكتمال ملف التطعيمات'
            ]
        },
        {
            id: 'primary',
            name: 'الابتدائية',
            age: '6 - 11 سنوات',
            price: '120 شيقل',
            priceYearly: '',
            badge: 'المرحلة الأساسية',
            conditions: [
            'عمر الطفل بين 6 و 11 سنوات',
            'شهادة الميلاد سارية المفعول',
            'بطاقة تطعيم سارية المفعول',
            'شهادة من مدرسة سابقة (إن وجدت)',
            'صورة شخصية حديثة'
            ],
            rejected: [
            'عمر أقل من 6 سنوات',
            'عدم اكتمال ملف التطعيمات'
            ]
        },
        {
            id: 'middle',
            name: 'المتوسطة',
            age: '12 - 14 سنوات',
            price: '120 شيقل',
            priceYearly: '',
            badge: 'المرحلة المتوسطة',
            conditions: [
            'عمر الطفل بين 12 و 14 سنوات',
            'شهادة الميلاد سارية المفعول',
            'شهادة اجتياز الصف السادس',
            'بطاقة تطعيم سارية المفعول',
            'صورة شخصية حديثة'
            ],
            rejected: [
            'عمر أقل من 12 سنة',
            'عدم اجتياز الصف السادس'
            ]
        },
        {
            id: 'secondary',
            name: 'الثانوية',
            age: '15 - 17 سنوات',
            price: '150 شيقل عدا الثاني عشر 200 شيقل',
            priceYearly: '',
            badge: 'المرحلة الثانوية',
            conditions: [
            'عمر الطفل بين 15 و 17 سنوات',
            'شهادة الميلاد سارية المفعول',
            'شهادة اجتياز الصف الثالث متوسط',
            'صورة شخصية حديثة',
            'ملف أكاديمي كامل'
            ],
            rejected: [
            'عمر أقل من 15 سنة',
            'عدم اجتياز الصف الثالث متوسط'
            ]
        }
            ];

            var html = '';

            // إضافة تبويبات المراحل
            html += '<div class="tabs-container">';
            stagesData.forEach(function(stage, index) {
            html += '<button class="tab-btn ' + (index === 0 ? 'active' : '') + '" data-tab="' + stage.id + '">' + stage.name + '</button>';
        });
            html += '</div>';

            // إضافة محتوى كل مرحلة
            stagesData.forEach(function(stage, index) {
            html += '<div class="tab-content ' + (index === 0 ? 'active' : '') + '" id="tab-' + stage.id + '">';
            html += '<div class="detail-card">';
            html += '<div class="stage-title">';
            html += stage.name;
            html += ' <span class="badge">' + stage.badge + '</span>';
            html += '</div>';
            html += '<p style="color: #718096; margin: 5px 0;"><strong>العمر المناسب:</strong> ' + stage.age + '</p>';
            html += '<div class="price">' + stage.price + ' <span>/ شهرياً</span></div>';
            html += '<p style="color: #718096; margin: 5px 0;"><strong>الرسوم السنوية:</strong> ' + stage.priceYearly + '</p>';
            html += '<hr style="margin: 15px 0; border: none; border-top: 2px dashed #e2e8f0;">';
            html += '<h4 style="color: #2d3748; margin-bottom: 10px;">📌 شروط التسجيل:</h4>';
            html += '<ul class="conditions">';
            stage.conditions.forEach(function(condition) {
            html += '<li>' + condition + '</li>';
        });
            html += '</ul>';
            html += '<h4 style="color: #2d3748; margin: 15px 0 10px 0;">🚫 حالات الرفض:</h4>';
            html += '<ul class="conditions">';
            stage.rejected.forEach(function(reject) {
            html += '<li class="rejected">' + reject + '</li>';
        });
            html += '</ul>';
            html += '</div>';
            html += '</div>';
        });

            // إضافة معلومات إضافية
            html += `
            <div style="background: #ebf8ff; border-radius: 15px; padding: 20px; margin-top: 20px; border-right: 4px solid #3182ce;">
                <h4 style="color: #2b6cb0; margin-bottom: 10px;">💡 معلومات إضافية</h4>
                <ul style="list-style: none; padding: 0; color: #2d3748;">
                    <li style="padding: 5px 0; padding-right: 25px; position: relative;">
                        <span style="position: absolute; right: 0;">📚</span>
                        الكتب الدراسية غير مشمولة في الرسوم
                    </li>
                    <li style="padding: 5px 0; padding-right: 25px; position: relative;">
                        <span style="position: absolute; right: 0;">👔</span>
                        الزي المدرسي غير مشمول في الرسوم وسعره 50 شيقل
                    </li>
                    <li style="padding: 5px 0; padding-right: 25px; position: relative;">
                        <span style="position: absolute; right: 0;">📅</span>
                        التسجيل متاح طوال العام الدراسي
                    </li>
                    <li style="padding: 5px 0; padding-right: 25px; position: relative;">
                        <span style="position: absolute; right: 0;">🏆</span>
                        خصم 10% للأشقاء عند التسجيل معاً
                    </li>
                </ul>
            </div>
        `;

            content.innerHTML = html;

            // =============================================
            // تفعيل التبويبات
            // =============================================
            document.querySelectorAll('#registrationDetailsContent .tab-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
            // إزالة الـ active من جميع الأزرار
            document.querySelectorAll('#registrationDetailsContent .tab-btn').forEach(function(b) {
            b.classList.remove('active');
        });
            // إضافة الـ active للزر الحالي
            this.classList.add('active');

            // إخفاء جميع المحتويات
            document.querySelectorAll('#registrationDetailsContent .tab-content').forEach(function(content) {
            content.classList.remove('active');
        });

            // إظهار المحتوى المحدد
            var tabId = this.dataset.tab;
            document.getElementById('tab-' + tabId).classList.add('active');
        });
        });
        }
        });
        $('#age_group').on('change', function () {
            var ageGroupId = $(this).val();
            var classSelect = $('#class');

            // تعطيل الـ select أثناء التحميل
            classSelect.prop('disabled', true);
            classSelect.html('<option value="" disabled selected>@lang("admin.Loading")...</option>');

            if (ageGroupId) {
                $.ajax({
                    url: '{{ url("/sites-get-classes-by-age-group") }}',
                    type: 'GET',
                    data: {
                        age_group_id: ageGroupId
                    },
                    success: function (response) {
                        classSelect.prop('disabled', false);
                        classSelect.html('<option value="" disabled selected>@lang("admin.Select")</option>');

                        if (response.data && response.data.length > 0) {
                            $.each(response.data, function (key, value) {
                                classSelect.append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                            });
                        } else {
                            classSelect.append('<option value="" disabled>@lang("admin.No classes found")</option>');
                        }

                        // تحديث Select2
                        classSelect.trigger('change');
                    },
                    error: function (xhr) {
                        classSelect.prop('disabled', false);
                        classSelect.html('<option value="" disabled selected>@lang("admin.Error loading data")</option>');
                        classSelect.trigger('change');
                    }
                });
            } else {
                classSelect.prop('disabled', false);
                classSelect.html('<option value="" disabled selected>@lang("admin.Select")</option>');
                classSelect.trigger('change');
            }
        });
    /* ============================================================
       DATA
    ============================================================ */
    const stages = [
        {id:'kg', label:'الروضة'},
        {id:'primary', label:'الابتدائية'},
        {id:'middle', label:'المتوسطة'},
        {id:'secondary', label:'الثانوية'},
    ];

    const stageColors = {kg:'linear-gradient(135deg,#EF6F53,#c9492f)',primary:'linear-gradient(135deg,#0B6E63,#083f39)',middle:'linear-gradient(135deg,#E7A33E,#a9701c)',secondary:'linear-gradient(135deg,#142033,#3a4a63)'};
    const stageLabels = {kg:'الروضة',primary:'ابتدائي',middle:'متوسط',secondary:'ثانوي'};

    const teachers = [
        {id:1,stage:'kg',name:'ريم عودة',initials:'ر.ع',role:'معلمة رياض أطفال',subject:'المهارات المبكرة واللغة',qualification:'بكالوريوس رياض أطفال',experience:'7 سنوات خبرة',bio:'متخصصة في تنمية المهارات الحركية واللغوية للأطفال عبر اللعب التربوي الموجّه.',quote:'الطفولة المبكرة أساس كل تعلّم لاحق.',media:{type:'image'}},
        {id:2,stage:'kg',name:'دانا حمدان',initials:'د.ح',role:'معلمة أنشطة',subject:'الفنون والموسيقى',qualification:'دبلوم تربية فنية',experience:'5 سنوات خبرة',bio:'تؤمن بأن التعبير الفني وسيلة أساسية لبناء ثقة الطفل بنفسه منذ الصغر.',quote:'كل رسمة طفل هي قصة تستحق أن تُروى.',media:{type:'image'}},
        {id:3,stage:'kg',name:'سارة نمر',initials:'س.ن',role:'مشرفة الروضة',subject:'التطور الاجتماعي والعاطفي',qualification:'ماجستير تربية الطفولة',experience:'9 سنوات خبرة',bio:'تقود فريق الروضة بخبرة واسعة في بناء بيئات صفية آمنة ومحفزة للاستكشاف.',quote:'نغرس حب المدرسة قبل أن نغرس الحروف.',media:{type:'image'}},

        {id:4,stage:'primary',name:'ليان قاسم',initials:'ل.ق',role:'معلمة لغة عربية',subject:'الصفوف 1-3',qualification:'بكالوريوس لغة عربية',experience:'8 سنوات خبرة',bio:'تستخدم أساليب القصة التفاعلية لتقريب اللغة العربية من قلوب طلابها الصغار.',quote:'اللغة هويتنا، ونحن نبنيها كلمة كلمة.',media:{type:'image'}},
        {id:5,stage:'primary',name:'أحمد الخطيب',initials:'أ.خ',role:'معلم رياضيات',subject:'الصفوف 3-6',qualification:'بكالوريوس رياضيات',experience:'10 سنوات خبرة',bio:'يبسّط المفاهيم الرياضية المعقّدة عبر أنشطة عملية ومشاريع صفية ممتعة.',quote:'الرياضيات لغة عالمية نتعلّمها باللعب.',media:{type:'video',src:'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4'}},
        {id:6,stage:'primary',name:'نور صالح',initials:'ن.ص',role:'معلمة علوم',subject:'الصفوف 1-6',qualification:'بكالوريوس علوم عامة',experience:'6 سنوات خبرة',bio:'تحوّل حصة العلوم إلى مختبر تجارب حيّ يشجّع الفضول والسؤال المستمر.',quote:'كل سؤال طفل بداية اكتشاف جديد.',media:{type:'image'}},

        {id:7,stage:'middle',name:'يوسف عمر',initials:'ي.ع',role:'معلم إنجليزي',subject:'الصفوف 7-9',qualification:'بكالوريوس لغة إنجليزية',experience:'11 سنة خبرة',bio:'يركّز على المهارات التواصلية العملية ليتمكن الطلاب من استخدام اللغة بثقة.',quote:'اللغة جسر نحو عالم أوسع.',media:{type:'image'}},
        {id:8,stage:'middle',name:'هالة زيدان',initials:'ه.ز',role:'معلمة حاسوب',subject:'الصفوف 7-9',qualification:'بكالوريوس علوم حاسوب',experience:'4 سنوات خبرة',bio:'تقدّم مقدمة في البرمجة والتفكير الحاسوبي بأسلوب تفاعلي ومشاريع فعلية.',quote:'التفكير المنطقي مهارة القرن الحادي والعشرين.',media:{type:'image'}},
        {id:9,stage:'middle',name:'خالد ياسين',initials:'خ.ي',role:'معلم اجتماعيات',subject:'الصفوف 7-9',qualification:'بكالوريوس تاريخ وجغرافيا',experience:'9 سنوات خبرة',bio:'يربط الأحداث التاريخية بالواقع المعاصر لتعميق فهم الطلاب لهويتهم ومحيطهم.',quote:'من يفهم الماضي، يقرأ الحاضر بوعي.',media:{type:'image'}},

        {id:10,stage:'secondary',name:'رنا أبو ليلى',initials:'ر.أ',role:'معلمة فيزياء',subject:'الصفوف 10-12',qualification:'ماجستير فيزياء',experience:'12 سنة خبرة',bio:'تُعِدّ طلابها لمرحلة الجامعة عبر تجارب مخبرية متقدمة ومناقشات علمية عميقة.',quote:'الفيزياء طريقة لفهم الكون من حولنا.',media:{type:'image'}},
        {id:11,stage:'secondary',name:'محمود درويش',initials:'م.د',role:'معلم لغة عربية وأدب',subject:'الصفوف 10-12',qualification:'ماجستير أدب عربي',experience:'14 سنة خبرة',bio:'يشعل شغف الطلاب بالنصوص الأدبية والكتابة الإبداعية استعداداً للثانوية العامة.',quote:'من يقرأ جيداً، يكتب حياته بثقة.',media:{type:'image'}},
        {id:12,stage:'secondary',name:'ديمة حسن',initials:'د.ح',role:'مرشدة توجيه جامعي',subject:'إرشاد ومسارات مستقبلية',qualification:'ماجستير إرشاد تربوي',experience:'8 سنوات خبرة',bio:'تواكب طلاب الثانوية في اختيار التخصص الجامعي المناسب لميولهم وقدراتهم.',quote:'كل طالب مسار فريد يستحق التوجيه الصحيح.',media:{type:'image'}},
    ];

    const facilities = [
        {icon:'flask',title:'مختبر العلوم',desc:'مساحة مجهزة بالكامل للتجارب العملية في الفيزياء والكيمياء والأحياء.'},
        {icon:'monitor',title:'قاعة الحاسوب',desc:'أجهزة حديثة لتعليم البرمجة والمهارات الرقمية لجميع المراحل.'},
        {icon:'book',title:'المكتبة',desc:'أكثر من 5000 عنوان تشجّع القراءة الحرة وأبحاث الطلاب.'},
        {icon:'ball',title:'الملعب الرياضي',desc:'ملعب متعدد الأغراض لكرة القدم والسلة وألعاب القوى.'},
        {icon:'palette',title:'قاعة الفنون',desc:'مساحة إبداعية للرسم والنحت والأشغال اليدوية.'},
        {icon:'theater',title:'المسرح المدرسي',desc:'منصة للفعاليات المدرسية والعروض المسرحية والموسيقية.'},
    ];

    const icons = {
        flask:'<path d="M9 2v6L4 20a1 1 0 0 0 1 2h14a1 1 0 0 0 1-2L15 8V2"/><path d="M9 2h6M8 15h8"/>',
        monitor:'<rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/>',
        book:'<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13z"/><path d="M20 17v3"/>',
        ball:'<circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18M6 6l12 12M18 6L6 18"/>',
        palette:'<path d="M12 2a10 10 0 1 0 0 20c1.5 0 2-1 2-2s-.5-1.5-.5-2.5S14 16 15 16h3a3 3 0 0 0 3-3c0-6-4.5-11-9-11z"/><circle cx="7.5" cy="10.5" r="1"/><circle cx="12" cy="7.5" r="1"/><circle cx="16.5" cy="10.5" r="1"/>',
        theater:'<path d="M4 4h16v6a8 8 0 0 1-16 0V4z"/><path d="M4 20h16M9 20v-3M15 20v-3"/>',
        award:'<circle cx="12" cy="8" r="6"/><path d="M9 14l-2 7 5-3 5 3-2-7"/>',
        calendar:'<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        trophy:'<path d="M8 4h8v5a4 4 0 0 1-8 0V4z"/><path d="M8 4H4v2a4 4 0 0 0 4 4M16 4h4v2a4 4 0 0 1-4 4"/><path d="M12 13v4M9 21h6M10 17h4v4h-4z"/>',
    };

    const achievements = [
        {cat:'award',icon:'trophy',title:'المركز الأول في أولمبياد الرياضيات',desc:'حصد فريق المدرسة المركز الأول على مستوى المحافظة في أولمبياد الرياضيات للمدارس.',date:'مارس 2026'},
        {cat:'event',icon:'calendar',title:'أسبوع العلوم والابتكار',desc:'فعالية سنوية يعرض فيها الطلاب مشاريعهم العلمية أمام أولياء الأمور والمجتمع المحلي.',date:'أبريل 2026'},
        {cat:'achievement',icon:'award',title:'اعتماد دولي لجودة التعليم',desc:'حصلت المدرسة على شهادة اعتماد دولية تقديراً لجودة برامجها التعليمية والإدارية.',date:'يناير 2026'},
        {cat:'award',icon:'trophy',title:'بطولة كرة القدم المدرسية',desc:'فاز فريق المدرسة ببطولة الدوري المدرسي للمرة الثالثة على التوالي.',date:'ديسمبر 2025'},
        {cat:'event',icon:'calendar',title:'معرض الفنون السنوي',desc:'معرض يحتفي بإبداعات طلاب قسم الفنون من جميع المراحل الدراسية.',date:'مايو 2026'},
        {cat:'achievement',icon:'award',title:'تكريم أفضل 10 مدارس محلياً',desc:'صُنّفت ليرن تو بي ضمن أفضل عشر مدارس في التقييم التربوي السنوي للمنطقة.',date:'يونيو 2026'},
    ];

    /* ============================================================
       RENDER: FACILITIES
    ============================================================ */
    const facilityGrid = document.getElementById('facilityGrid');
    facilities.forEach(f=>{
        facilityGrid.innerHTML += `
    <div class="facility-card reveal">
      <div class="facility-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">${icons[f.icon]}</svg></div>
      <div><h4>${f.title}</h4><p>${f.desc}</p></div>
    </div>`;
    });

    /* ============================================================
       RENDER: STAGE PATH + TEACHERS
    ============================================================ */
    const stagePath = document.getElementById('stagePath');
    stages.forEach((s,i)=>{
        const btn = document.createElement('button');
        btn.className = 'stage-btn' + (i===0?' active':'');
        btn.dataset.stage = s.id;
        btn.innerHTML = `<span class="stage-num">${i+1}</span><span>${s.label}</span>`;
        stagePath.appendChild(btn);
    });

    const teacherGrid = document.getElementById('teacherGrid');
    function renderTeachers(stageId){
        teacherGrid.innerHTML = '';
        teachers.filter(t=>t.stage===stageId).forEach(t=>{
            const card = document.createElement('div');
            card.className = 'teacher-card reveal in-view.blade.php';
            card.innerHTML = `
      <div class="teacher-media" data-badge="${stageLabels[t.stage]}" style="background:${stageColors[t.stage]}">${t.initials}</div>
      <div class="teacher-info">
        <h4>${t.name}</h4>
        <div class="role">${t.role}</div>
        <p>${t.subject}</p>
        <button class="btn btn-ghost btn-sm js-open-teacher" data-id="${t.id}">عرض الملف الكامل</button>
      </div>`;
            teacherGrid.appendChild(card);
        });
    }
    renderTeachers('kg');

    stagePath.addEventListener('click',e=>{
        const btn = e.target.closest('.stage-btn');
        if(!btn) return;
        stagePath.querySelectorAll('.stage-btn').forEach(b=>b.classList.remove('active'));
        btn.classList.add('active');
        renderTeachers(btn.dataset.stage);
    });

    /* ============================================================
       RENDER: ACHIEVEMENTS + FILTER
    ============================================================ */
    const catLabels = {all:'الكل',award:'جوائز',event:'فعاليات',achievement:'إنجازات'};
    const filterBar = document.getElementById('filterBar');
    Object.keys(catLabels).forEach(cat=>{
        const b = document.createElement('button');
        b.className = 'filter-btn' + (cat==='all'?' active':'');
        b.dataset.cat = cat;
        b.textContent = catLabels[cat];
        filterBar.appendChild(b);
    });

    const achGrid = document.getElementById('achGrid');
    function renderAchievements(cat){
        achGrid.innerHTML = '';
        achievements.filter(a=>cat==='all' || a.cat===cat).forEach(a=>{
            const ribbonText = a.cat==='award'?'جائزة':a.cat==='event'?'فعالية':'إنجاز';
            achGrid.innerHTML += `
      <div class="ach-card reveal in-view" data-cat="${a.cat}">
        <span class="ach-ribbon">${ribbonText}</span>
        <div class="ach-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">${icons[a.icon]}</svg></div>
        <h4>${a.title}</h4>
        <p>${a.desc}</p>
        <span class="ach-date">${a.date}</span>
      </div>`;
        });
    }
    renderAchievements('all');

    filterBar.addEventListener('click',e=>{
        const b = e.target.closest('.filter-btn');
        if(!b) return;
        filterBar.querySelectorAll('.filter-btn').forEach(x=>x.classList.remove('active'));
        b.classList.add('active');
        renderAchievements(b.dataset.cat);
    });

    /* ============================================================
       TEACHER MODAL
    ============================================================ */
    const teacherModal = document.getElementById('teacherModal');
    const teacherModalContent = document.getElementById('teacherModalContent');

    document.addEventListener('click',e=>{
        const btn = e.target.closest('.js-open-teacher');
        if(!btn) return;
        const t = teachers.find(x=>x.id==btn.dataset.id);
        const mediaHtml = t.media.type==='video'
            ? `<video controls poster="" style="width:100%;height:100%;object-fit:cover;"><source src="${t.media.src}" type="video/mp4"></video>`
            : `${t.initials}`;
        teacherModalContent.innerHTML = `
    <div class="teacher-modal-media" style="background:${stageColors[t.stage]}">${mediaHtml}</div>
    <div class="teacher-modal-body">
      <h3>${t.name}</h3>
      <div class="tm-role">${t.role} · ${stageLabels[t.stage]}</div>
      <div class="tm-tags">
        <span class="tm-tag">${t.qualification}</span>
        <span class="tm-tag">${t.experience}</span>
      </div>
      <p class="tm-bio">${t.bio}</p>
      <p class="tm-quote">${t.quote}</p>
    </div>`;
        openModal(teacherModal);
    });

    /* ============================================================
       REGISTER MODAL
    ============================================================ */
    const registerModal = document.getElementById('registerModal');
    document.querySelectorAll('.js-open-register').forEach(b=>{
        b.addEventListener('click',()=>openModal(registerModal));
    });

    /* ============================================================
       MODAL HELPERS
    ============================================================ */
    function openModal(modal){
        modal.classList.add('open');
        document.body.style.overflow='hidden';
    }
    function closeModal(modal){
        modal.classList.remove('open');
        document.body.style.overflow='';
    }
    document.querySelectorAll('.modal-overlay').forEach(overlay=>{
        overlay.addEventListener('click',e=>{
            if(e.target===overlay || e.target.closest('[data-close]')) closeModal(overlay);
        });
    });
    document.addEventListener('keydown',e=>{
        if(e.key==='Escape'){
            document.querySelectorAll('.modal-overlay.open').forEach(closeModal);
            closeMobileNav();
        }
    });

    /* ============================================================
       HEADER SCROLL
    ============================================================ */
    const siteHeader = document.getElementById('siteHeader');
    window.addEventListener('scroll',()=>{
        siteHeader.classList.toggle('scrolled', window.scrollY>40);
    });

    /* ============================================================
       MOBILE NAV
    ============================================================ */
    const mobileNav = document.getElementById('mobileNav');
    document.getElementById('hamburgerBtn').addEventListener('click',()=>mobileNav.classList.add('open'));
    document.getElementById('mobileCloseBtn').addEventListener('click',closeMobileNav);
    mobileNav.querySelectorAll('a').forEach(a=>a.addEventListener('click',closeMobileNav));
    function closeMobileNav(){ mobileNav.classList.remove('open'); }

    /* ============================================================
       HERO SLIDER
    ============================================================ */
    const slides = document.querySelectorAll('.hero-slide');
    const heroDots = document.getElementById('heroDots');
    const videoControls = document.getElementById('videoControls');
    let currentSlide = 0;
    let heroInterval;

    slides.forEach((_,i)=>{
        const dot = document.createElement('button');
        dot.className = 'hero-dot' + (i===0?' active':'');
        dot.addEventListener('click',()=>goToSlide(i));
        heroDots.appendChild(dot);
    });
    const dotEls = heroDots.querySelectorAll('.hero-dot');

    function goToSlide(i){
        slides[currentSlide].classList.remove('active');
        dotEls[currentSlide].classList.remove('active');
        const activeVideo = slides[currentSlide].querySelector('video');
        if(activeVideo) activeVideo.pause();

        currentSlide = (i+slides.length)%slides.length;
        slides[currentSlide].classList.add('active');
        dotEls[currentSlide].classList.add('active');

        const isVideo = slides[currentSlide].dataset.type==='video';
        videoControls.classList.toggle('visible', isVideo);
        if(isVideo){
            const v = slides[currentSlide].querySelector('video');
            v.play().catch(()=>{});
            updatePlayIcon(true);
            updateMuteIcon(v.muted);
        }
    }
    document.getElementById('heroNext').addEventListener('click',()=>{goToSlide(currentSlide+1); resetHeroInterval();});
    document.getElementById('heroPrev').addEventListener('click',()=>{goToSlide(currentSlide-1); resetHeroInterval();});
    function resetHeroInterval(){
        clearInterval(heroInterval);
        heroInterval = setInterval(()=>goToSlide(currentSlide+1),7000);
    }
    resetHeroInterval();

    /* video play/pause + mute controls */
    function updatePlayIcon(isPlaying){
        document.getElementById('playIcon').style.display = isPlaying?'none':'block';
        document.getElementById('pauseIcon').style.display = isPlaying?'block':'none';
    }
    function updateMuteIcon(isMuted){
        document.getElementById('soundOnIcon').style.display = isMuted?'none':'block';
        document.getElementById('soundOffIcon').style.display = isMuted?'block':'none';
    }
    document.getElementById('playPauseBtn').addEventListener('click',()=>{
        const v = slides[currentSlide].querySelector('video');
        if(!v) return;
        if(v.paused){ v.play(); updatePlayIcon(true); } else { v.pause(); updatePlayIcon(false); }
    });
    document.getElementById('muteBtn').addEventListener('click',()=>{
        const v = slides[currentSlide].querySelector('video');
        if(!v) return;
        v.muted = !v.muted;
        updateMuteIcon(v.muted);
    });

    /* ============================================================
       FORMS
    ============================================================ */
    document.getElementById('registerForm').addEventListener('submit',e=>{
        e.preventDefault();
        document.getElementById('registerMsg').classList.add('show');
        showToast('تم إرسال طلب التسجيل بنجاح');
        setTimeout(()=>{ closeModal(registerModal); e.target.reset(); document.getElementById('registerMsg').classList.remove('show'); },1800);
    });
    document.getElementById('complaintForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const msgDiv = document.getElementById('complaintMsg');
        const submitBtn = form.querySelector('.btn-coral');

        // إخفاء أي رسالة سابقة
        msgDiv.style.display = 'none';
        msgDiv.className = 'form-msg';

        // تعطيل الزر أثناء الإرسال
        submitBtn.disabled = true;
        submitBtn.textContent = 'جاري الإرسال...';

        // إرسال البيانات
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // عرض رسالة نجاح
                    msgDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
                    msgDiv.className = 'form-msg success show';
                    msgDiv.style.display = 'block';

                    // إعادة تعيين الفورم
                    form.reset();

                    // إخفاء الرسالة بعد 5 ثواني
                    setTimeout(() => {
                        msgDiv.style.display = 'none';
                        msgDiv.className = 'form-msg';
                    }, 5000);
                } else {
                    // عرض أخطاء التحقق
                    let errorMessages = '';
                    if (data.errors) {
                        Object.values(data.errors).forEach(error => {
                            errorMessages += '<div class="error-item">❌ ' + error[0] + '</div>';
                        });
                    } else {
                        errorMessages = '❌ ' + data.message;
                    }

                    msgDiv.innerHTML = errorMessages;
                    msgDiv.className = 'form-msg error show';
                    msgDiv.style.display = 'block';
                }
            })
            .catch(error => {
                // عرض رسالة خطأ عامة
                msgDiv.innerHTML = '❌ حدث خطأ في الاتصال، يرجى المحاولة مرة أخرى';
                msgDiv.className = 'form-msg error show';
                msgDiv.style.display = 'block';
            })
            .finally(() => {
                // إعادة تفعيل الزر
                submitBtn.disabled = false;
                submitBtn.textContent = 'إرسال الرسالة';
            });
    });

    const toast = document.getElementById('toast');
    function showToast(text){
        document.getElementById('toastText').textContent = text;
        toast.classList.add('show');
        setTimeout(()=>toast.classList.remove('show'),3000);
    }

    /* ============================================================
       SCROLL REVEAL
    ============================================================ */
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(prefersReduced){
        document.querySelectorAll('.reveal').forEach(el=>el.classList.add('in-view.blade.php'));
    } else {
        const io = new IntersectionObserver((entries)=>{
            entries.forEach(entry=>{
                if(entry.isIntersecting){ entry.target.classList.add('in-view.blade.php'); io.unobserve(entry.target); }
            });
        },{threshold:.15});
        document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
    }
</script>
</body>
</html>
