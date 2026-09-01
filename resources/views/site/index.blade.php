<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$site_settings->site_logo}}</title>
    <!-- Favicon -->
    <link rel="icon"
          type="image/png"
          href="{{ asset('uploads/site/' . $site_settings->site_logo) }}">

    <!-- Google Fonts (Cairo & Tajawal) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --brand-primary: #00419d;
            --brand-secondary: #002c6c;
            --brand-accent: #00a8ff;
            --brand-light: #eef5ff;
            --brand-gold: #ffb703;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --card-shadow: 0 10px 30px rgba(0, 65, 157, 0.08);
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            color: var(--text-dark);
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Top Bar Info */
        .top-bar {
            background-color: var(--brand-secondary);
            color: #ffffff;
            font-size: 0.875rem;
            padding: 8px 0;
        }

        /* Navbar Styling */
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: var(--transition-smooth);
        }

        .navbar-brand .logo-img {
            height: 52px;
            width: auto;
            object-fit: contain;
        }

        .nav-link {
            font-weight: 700;
            color: var(--text-dark) !important;
            padding: 0.5rem 1rem !important;
            transition: var(--transition-smooth);
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--brand-primary) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            width: 0;
            height: 3px;
            background-color: var(--brand-accent);
            transition: var(--transition-smooth);
            transform: translateX(50%);
            border-radius: 3px;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 70%;
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand-primary), #0056ce);
            color: #ffffff !important;
            font-weight: 700;
            padding: 0.6rem 1.6rem;
            border-radius: 50px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 65, 157, 0.3);
            transition: var(--transition-smooth);
        }

        .btn-brand:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 65, 157, 0.4);
            background: linear-gradient(135deg, #003380, var(--brand-primary));
        }

        .btn-outline-brand {
            border: 2px solid var(--brand-primary);
            color: var(--brand-primary);
            font-weight: 700;
            padding: 0.6rem 1.6rem;
            border-radius: 50px;
            background: transparent;
            transition: var(--transition-smooth);
        }

        .btn-outline-brand:hover {
            background-color: var(--brand-primary);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(238, 245, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%),
            url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            padding: 100px 0 80px 0;
            position: relative;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 900;
            color: var(--brand-secondary);
            line-height: 1.3;
        }

        .hero-title span {
            color: var(--brand-primary);
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(0, 65, 157, 0.1);
            color: var(--brand-primary);
            padding: 8px 18px;
            border-radius: 50px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .counter-box {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px 20px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: var(--transition-smooth);
            border: 1px solid rgba(0, 65, 157, 0.05);
        }

        .counter-box:hover {
            transform: translateY(-8px);
            border-color: var(--brand-accent);
        }

        .counter-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--brand-primary);
        }

        /* Section Header Utility */
        .section-tag {
            color: var(--brand-primary);
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: block;
        }

        .section-title {
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--brand-secondary);
            margin-bottom: 20px;
        }

        /* Vision & Mission Cards */
        .vm-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: var(--card-shadow);
            height: 100%;
            transition: var(--transition-smooth);
            border-top: 5px solid var(--brand-primary);
        }

        .vm-card:hover {
            transform: translateY(-5px);
        }

        .vm-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: var(--brand-light);
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 25px;
        }

        /* Principal's Speech Section */
        .speech-container {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%);
            border-radius: 30px;
            color: #ffffff;
            padding: 60px 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 44, 108, 0.25);
        }

        .speech-quote-icon {
            font-size: 6rem;
            opacity: 0.15;
            position: absolute;
            top: 20px;
            left: 30px;
        }

        .principal-img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Educational Stages */
        .stage-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            height: 100%;
            border: 1px solid rgba(0,0,0,0.03);
            position: relative;
            overflow: hidden;
        }

        .stage-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 65, 157, 0.12);
        }

        .stage-badge {
            background-color: var(--brand-light);
            color: var(--brand-primary);
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        /* Teachers Grid */
        .teacher-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            text-align: center;
        }

        .teacher-card:hover {
            transform: translateY(-8px);
        }

        .teacher-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .teacher-info {
            padding: 20px;
        }

        /* News & Activities Filter */
        .filter-btn {
            border: none;
            background: #ffffff;
            color: var(--text-dark);
            padding: 8px 22px;
            border-radius: 30px;
            font-weight: 700;
            margin: 4px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            transition: var(--transition-smooth);
        }

        .filter-btn.active, .filter-btn:hover {
            background: var(--brand-primary);
            color: #ffffff;
        }

        .news-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-5px);
        }

        .news-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        /* Contact & Registration Form */
        .reg-form-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: var(--card-shadow);
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 18px;
            border: 1px solid #e2e8f0;
            font-weight: 600;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(0, 65, 157, 0.1);
        }

        /* Footer */
        footer {
            background: var(--brand-secondary);
            color: #ffffff;
            padding-top: 70px;
            padding-bottom: 30px;
        }

        .footer-link {
            color: #cbd5e1;
            text-decoration: none;
            transition: var(--transition-smooth);
            display: block;
            margin-bottom: 10px;
        }

        .footer-link:hover {
            color: var(--brand-accent);
            padding-right: 6px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .social-icon:hover {
            background: var(--brand-accent);
            color: #ffffff;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

<!-- Top Contact Bar -->
<div class="top-bar d-none d-lg-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex gap-4">
            <span><i class="fas fa-envelope text-warning me-2"></i> info@learntobe-school.edu</span>
            <span><i class="fas fa-phone-alt text-warning me-2"></i> {{$site_settings->contact_phone}}</span>
            <span><i class="fas fa-clock text-warning me-2"></i> السبت - الخميس: 7:00 ص - 2:00 م</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{$site_settings->social_facebook}}" class="text-white text-decoration-none"><i class="fab fa-facebook-f me-2"></i></a>
            <a href="{{$site_settings->social_instagram}}" class="text-white text-decoration-none"><i class="fab fa-instagram me-2"></i></a>
            {{--<a href="#" class="text-white text-decoration-none"><i class="fab fa-twitter me-2"></i></a>
            <a href="#" class="text-white text-decoration-none"><i class="fab fa-youtube me-2"></i></a>--}}
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<nav class="navbar navbar-expand-lg sticky-top navbar-custom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3" href="#">
            <!-- Logo Display SVG/Canvas matching uploaded icon -->
            <img src="{{asset('uploads/site/'.$site_settings->site_logo)}}" width="30" height="30" alt="Logo">
            <div class="d-flex flex-column">
                <span class="fw-bold fs-4 text-dark lh-1" style="color: var(--brand-primary) !important;">LearnToBe</span>
                <small class="fw-bold text-muted" style="font-size: 0.75rem;">{{$site_settings->site_name}}</small>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#home">الرئيسة</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">عن المدرسة</a></li>
                <li class="nav-item"><a class="nav-link" href="#vision">رؤيتنا ورسالتنا</a></li>
                <li class="nav-item"><a class="nav-link" href="#speech">كلمة المديرة</a></li>
                <li class="nav-item"><a class="nav-link" href="#stages">الأقسام التعليمية</a></li>
                <li class="nav-item"><a class="nav-link" href="#teachers">المعلمون</a></li>
                <li class="nav-item"><a class="nav-link" href="#activities">الأخبار والأنشطة</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <a href="#register" class="btn btn-brand">
                    <i class="fas fa-user-plus me-2"></i> طلب تسجيل طالب
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="hero-section">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="hero-badge animate__animated animate__fadeInDown">
                    <i class="fas fa-award"></i> البيئة التعليمية الأمثل لأبنائك
                </div>
                <h1 class="hero-title mb-4 animate__animated animate__fadeInUp">
                    مستقبل إبداعي يبدأ هنا <br>
                    <span>نبني أجيال الغد</span> بالمعرفة والتميّز
                </h1>
                <p class="lead text-muted mb-4 fs-5 animate__animated animate__fadeInUp animate__delay-1s">
                    تسعى مدرسة <strong>Learn To Be</strong> لتقديم تعليم حديث يجمع بين الرقمنة والابتكار وغرس القيم الأخلاقية الأصيلة، لنضمن لبناء أطفالكم المستقبل الأفضل.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="#register" class="btn btn-brand btn-lg">
                        <i class="fas fa-paper-plane me-2"></i> قدم طلب التحاق الآن
                    </a>
                    <a href="#facilities" class="btn btn-outline-brand btn-lg">
                        <i class="fas fa-compass me-2"></i> استكشف مرافق المدرسة
                    </a>
                </div>
            </div>
            <div class="col-lg-6 position-relative text-center">
                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80" alt="Learn To Be Students" class="img-fluid rounded-4 shadow-lg border border-4 border-white">
            </div>
        </div>

        <!-- Stats Counters Grid -->
        <div class="row g-4 mt-5">
            <div class="col-6 col-md-3">
                <div class="counter-box">
                    <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                    <div class="counter-number" data-target="700">0</div>
                    <div class="fw-bold text-muted">طالب وطالبة</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="counter-box">
                    <i class="fas fa-chalkboard-teacher fa-2x text-primary mb-3"></i>
                    <div class="counter-number" data-target="40">0</div>
                    <div class="fw-bold text-muted">معلم متميز</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="counter-box">
                    <i class="fas fa-trophy fa-2x text-primary mb-3"></i>
                    <div class="counter-number" data-target="99">0</div>
                    <div class="fw-bold text-muted">نسبة النجاح %</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="counter-box">
                    <i class="fas fa-running fa-2x text-primary mb-3"></i>
                    <div class="counter-number" data-target="50">0</div>
                    <div class="fw-bold text-muted">نشاط لاصفي سنوياً</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section id="vision" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag">هويتنا وغايتنا</span>
            <h2 class="section-title">رؤيتنا، رسالتنا، وقيمنا الراسخة</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: var(--brand-primary);">رؤيتنا</h4>
                    <p class="text-muted leading-relaxed">
                        أن نكون الصرح التعليمي الرائد والمفضل في تقديم تعليم عصري مبتكر يُلهم الطلاب ويمكّنهم من قيادة المستقبل والمنافسة عالمياً.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="vm-card" style="border-top-color: var(--brand-accent);">
                    <div class="vm-icon" style="background: rgba(0, 168, 255, 0.1); color: var(--brand-accent);">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: var(--brand-primary);">رسالتنا</h4>
                    <p class="text-muted leading-relaxed">
                        توفير بيئة تفاعلية آمنة ومحفزة تتبنى أحدث الوسائل التكنولوجية، وتضمن بناء شخصية متوازنة تجمع بين التحصيل العلمي والأخلاق النبيلة.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="vm-card" style="border-top-color: var(--brand-gold);">
                    <div class="vm-icon" style="background: rgba(255, 183, 3, 0.1); color: var(--brand-gold);">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="color: var(--brand-primary);">قيمنا التنافسية</h4>
                    <ul class="list-unstyled text-muted lh-lg mb-0">
                        <li><i class="fas fa-check-circle text-primary me-2"></i> <strong>التمير العلمي:</strong> مناهج عالمية متطورة.</li>
                        <li><i class="fas fa-check-circle text-primary me-2"></i> <strong>الابتكار:</strong> دعم التفكير النقدي والإبداعي.</li>
                        <li><i class="fas fa-check-circle text-primary me-2"></i> <strong>الأخلاق والنزاهة:</strong> تعزيز الهوية والقيم.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Principal's Speech Section -->
<section id="speech" class="py-5" style="background-color: #f1f5f9;">
    <div class="container py-4">
        <div class="speech-container">
            <i class="fas fa-quote-left speech-quote-icon"></i>
            <div class="row align-items-center gy-4">
                <div class="col-lg-3 text-center">
                    <img src="{{asset('uploads/site/'.$site_settings->principal_image)}}" alt="مديرة المدرسة" class="principal-img mb-3">
                    <h5 class="fw-bold mb-1">{{$site_settings->principal_name}}</h5>
                    <small class="text-white-50">مديرة مدرسة {{$site_settings->site_name}}</small>
                </div>
                <div class="col-lg-9">
                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3">كلمة إدارة المدرسة</span>
                    <h3 class="fw-bold mb-3">أهلاً بكم في صرح "ليرن تو بي" التعليمي</h3>
                    <p class="fs-5 leading-relaxed opacity-90 mb-4">
                        {{$site_settings->principal_speech}}
                    </p>
                    <p class="mb-0 fw-semibold text-white-50">
                        نرحب بجميع أولياء الأمور والطلاب في رحلتنا نحو التميّز والنجاح الشامل.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Educational Stages -->
<section id="stages" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag">مسيرتنا التعلمية</span>
            <h2 class="section-title">الأقسام والمراحل الدراسية</h2>
        </div>

        <div class="row g-4">
            <!-- Kindergarten Stage -->
            <div class="col-md-6 col-lg-3">
                <div class="stage-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stage-badge">الروضة والتمهيدي</span>
                        <i class="fas fa-child fa-2x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">مرحلة الطفولة المبكرة</h4>
                    <p class="text-muted small mb-4">التعلم باللعب والأنشطة التفاعلية لتنمية المهارات الإدراكية والحركية واللغوية لدى الطفل.</p>
                    <ul class="list-unstyled small text-muted mb-4 lh-lg">
                        <li><i class="fas fa-check text-success me-2"></i> قاعات منتسوري مجهزة</li>
                        <li><i class="fas fa-check text-success me-2"></i> تعليم اللغات المبكر</li>
                        <li><i class="fas fa-check text-success me-2"></i> أنشطة حركية وفنية</li>
                    </ul>
                </div>
            </div>

            <!-- Primary Stage -->
            <div class="col-md-6 col-lg-3">
                <div class="stage-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stage-badge">المرحلة الابتدائية</span>
                        <i class="fas fa-shapes fa-2x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">تأسيس المهارات</h4>
                    <p class="text-muted small mb-4">التركيز على المفاهيم الأكاديمية الأساسية وتنمية القراءة والمهارات الرياضية والعلوم.</p>
                    <ul class="list-unstyled small text-muted mb-4 lh-lg">
                        <li><i class="fas fa-check text-success me-2"></i> مناهج معززة بالذكاءات</li>
                        <li><i class="fas fa-check text-success me-2"></i> حصص الروبوتيكس</li>
                        <li><i class="fas fa-check text-success me-2"></i> متابعة فردية لكل طالب</li>
                    </ul>
                </div>
            </div>

            <!-- Middle Stage -->
            <div class="col-md-6 col-lg-3">
                <div class="stage-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stage-badge">المرحلة المتوسطة</span>
                        <i class="fas fa-flask fa-2x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">التفكير التحليلي</h4>
                    <p class="text-muted small mb-4">تطوير مهارات حل المشكلات والتفكير العلمي والعمل الجماعي عبر مشاريع عمل متكاملة.</p>
                    <ul class="list-unstyled small text-muted mb-4 lh-lg">
                        <li><i class="fas fa-check text-success me-2"></i> مختبرات علمية متطورة</li>
                        <li><i class="fas fa-check text-success me-2"></i> نوادي المناظرة والتأليف</li>
                        <li><i class="fas fa-check text-success me-2"></i> البرمجة والتكنولوجيا</li>
                    </ul>
                </div>
            </div>

            <!-- High School Stage -->
            <div class="col-md-6 col-lg-3">
                <div class="stage-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="stage-badge">المرحلة الثانوية</span>
                        <i class="fas fa-university fa-2x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">الاستعداد الجامعي</h4>
                    <p class="text-muted small mb-4">إعداد الطلاب وتأهيلهم لاجتياز الاختبارات الوطنية والدولية والتوجيه الأكاديمي.</p>
                    <ul class="list-unstyled small text-muted mb-4 lh-lg">
                        <li><i class="fas fa-check text-success me-2"></i> إرشاد أكاديمي وجامعي</li>
                        <li><i class="fas fa-check text-success me-2"></i> شهادات دولية واعتراف</li>
                        <li><i class="fas fa-check text-success me-2"></i> دورات تحضيرية مكثفة</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- School Facilities -->
<section id="facilities" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag">مرافقنا التفاعلية</span>
            <h2 class="section-title">بيئة مجهزة بأحدث التقنيات</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="news-card">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" class="news-img" alt="الفصول الذكية">
                    <div class="p-4">
                        <h5 class="fw-bold text-primary mb-2">الفصول التفاعلية الذكية</h5>
                        <p class="text-muted small mb-0">جميع الفصول مزودة بشاشات تفاعلية وأجهزة عرض حديثة لتعزيز المشاركة الاستيعابية للطلاب.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="news-card">
                    <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=600&q=80" class="news-img" alt="مختبر الروبوت">
                    <div class="p-4">
                        <h5 class="fw-bold text-primary mb-2">معمل الذكاء الاصطناعي والروبوت</h5>
                        <p class="text-muted small mb-0">مساحات مخصصة لتجارب البرمجة والذكاء الاصطناعي وصناعة الروبوتات وتطبيقات STEM.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="news-card">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=600&q=80" class="news-img" alt="المجمع الرياضي">
                    <div class="p-4">
                        <h5 class="fw-bold text-primary mb-2">المجمع الرياضي والمسبح</h5>
                        <p class="text-muted small mb-0">ملاعب مغلقة ومكشوفة ومسبح نيساني نصف أولمبي لتطوير المهارات البدنية والرياضية.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Teachers Section -->
<section id="teachers" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag">نخبة التعليم</span>
            <h2 class="section-title">كادرنا التعليمي المتميز</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="teacher-card">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80" class="teacher-img" alt="د. أحمد الفارس">
                    <div class="teacher-info">
                        <h5 class="fw-bold mb-1">د. أحمد الفارس</h5>
                        <p class="text-primary small fw-bold mb-2">مشرف قسم العلوم والفيزياء</p>
                        <p class="text-muted small">دكتوراه في المناهج، خبرة 12 عاماً في التعليم التفاعلي.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card">
                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=400&q=80" class="teacher-img" alt="أ. سارة المنصور">
                    <div class="teacher-info">
                        <h5 class="fw-bold mb-1">أ. سارة المنصور</h5>
                        <p class="text-primary small fw-bold mb-2">معلمة اللغة الإنجليزية</p>
                        <p class="text-muted small">ماجستير لغويات تطبيقية، حاصلة على اعتماد TESOL الدولية.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80" class="teacher-img" alt="أ. مريم الخالد">
                    <div class="teacher-info">
                        <h5 class="fw-bold mb-1">أ. مريم الخالد</h5>
                        <p class="text-primary small fw-bold mb-2">مشرفة قسم الرياضيات</p>
                        <p class="text-muted small">خبيرة المناهج الدولية وتدريب القدرات والتميّز.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="teacher-card">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80" class="teacher-img" alt="أ. خالد الشهري">
                    <div class="teacher-info">
                        <h5 class="fw-bold mb-1">أ. خالد الشهري</h5>
                        <p class="text-primary small fw-bold mb-2">مدرب الحاسب والذكاء الاصطناعي</p>
                        <p class="text-muted small">مهندس حاسبات ومشرِف على فريق البرمجة الفائز بالميداليات.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News & Activities Section -->
<section id="activities" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="text-center mb-4">
            <span class="section-tag">الحياة المدرسية</span>
            <h2 class="section-title">أحدث الإعلانات والأنشطة</h2>
        </div>

        <!-- Filter Categories -->
        <div class="d-flex justify-content-center flex-wrap mb-4">
            <button class="filter-btn active" onclick="filterNews('all', this)">الكل</button>
            <button class="filter-btn" onclick="filterNews('announcement', this)">إعلانات</button>
            <button class="filter-btn" onclick="filterNews('sports', this)">أنشطة رياضية</button>
            <button class="filter-btn" onclick="filterNews('events', this)">فعاليات علمية</button>
        </div>

        <!-- News Grid -->
        <div class="row g-4" id="newsGrid">
            <!-- Item 1 -->
            <div class="col-md-4 news-item events">
                <div class="news-card">
                    <img src="https://images.unsplash.com/photo-1564981797816-1043664bf78d?auto=format&fit=crop&w=600&q=80" class="news-img" alt="معرض العلوم">
                    <div class="p-4">
                        <span class="badge bg-primary mb-2">فعاليات علمية</span>
                        <h5 class="fw-bold text-dark mb-2">افتتاح المعرض العلمي السنوي للمبتكرين الصغار</h5>
                        <p class="text-muted small mb-3">عرض طلاب مدرسة Learn To Be أكثر من 40 مشروعاً ابتكارياً في الذكاء الاصطناعي والطاقة المتجددة.</p>
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> 25 أغسطس 2026</small>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col-md-4 news-item announcement">
                <div class="news-card">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80" class="news-img" alt="فتح التسجيل">
                    <div class="p-4">
                        <span class="badge bg-warning text-dark mb-2">إعلانات</span>
                        <h5 class="fw-bold text-dark mb-2">بدء فتح باب التسجيل للعام الدراسي الجديد</h5>
                        <p class="text-muted small mb-3">تعلن الإدارة عن استمرار فتح التسجيل في جميع المراحل الدراسية مع تقديم منح للمتفوقين.</p>
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> 20 أغسطس 2026</small>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="col-md-4 news-item sports">
                <div class="news-card">
                    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=600&q=80" class="news-img" alt="الفعالية الرياضية">
                    <div class="p-4">
                        <span class="badge bg-success mb-2">أنشطة رياضية</span>
                        <h5 class="fw-bold text-dark mb-2">تتويج فريق المدرسة ببطولة دوري المدارس لكرة القدم</h5>
                        <p class="text-muted small mb-3">حققت المدرسة المركز الأول بعد أداء رائع وروح رياضية عالية أظهرها أبناؤنا الطلاب.</p>
                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> 15 أغسطس 2026</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration & Contact Section -->
<section id="register" class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <span class="section-tag">انضم لعائلتنا</span>
                <h2 class="section-title mb-4">قدم طلب التسجيل الآن معنا</h2>
                <p class="text-muted leading-relaxed mb-4">
                    يسعدنا انضمام أطفالكم إلى مدرسة Learn To Be. يرجى تعبئة الاستمارة التالية وسيقوم فريق القبول والتسجيل بالتواصل معكم في أقرب وقت لإتمام الإجراءات وتحديد موعد المقابلة.
                </p>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-light p-3 text-primary"><i class="fas fa-map-marker-alt fa-lg"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">موقع المدرسة</h6>
                        <small class="text-muted">{{$site_settings->contact_address}}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-light p-3 text-primary"><i class="fas fa-phone-alt fa-lg"></i></div>
                    <div>
                        <h6 class="fw-bold mb-0">الهاتف المباشر للتسجيل</h6>
                        <small class="text-muted">{{$site_settings->contact_phone}}</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="reg-form-card">
                    <h4 class="fw-bold text-primary mb-4 text-center">استمارة التحاق طالب جديد</h4>
                    <form id="studentRegForm" onsubmit="handleRegistration(event)">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم الطالب الكامل</label>
                                <input type="text" class="form-control" required placeholder="أدخل اسم الطالب">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">اسم ولي الأمر</label>
                                <input type="text" class="form-control" required placeholder="أدخل اسم ولي الأمر">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">رقم الهاتف / الواتساب</label>
                                <input type="tel" class="form-control" required placeholder="05xxxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">المرحلة الدراسية</label>
                                <select class="form-select" required>
                                    <option value="" selected disabled>اختر المرحلة</option>
                                    <option value="kg">الروضة والتمهيدي</option>
                                    <option value="primary">المرحلة الابتدائية</option>
                                    <option value="middle">المرحلة المتوسطة</option>
                                    <option value="high">المرحلة الثانوية</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">ملاحظات أو استفسارات إضافية</label>
                                <textarea class="form-control" rows="3" placeholder="اكتب أي معلومات تود إضافة تفاصيل عنها..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-brand w-100 py-3 mt-2">
                                    <i class="fas fa-paper-plane me-2"></i> إرسال الطلب الآن
                                </button>
                            </div>
                        </div>
                    </form>
                    <div id="formAlert" class="alert alert-success mt-3 d-none" role="alert">
                        <i class="fas fa-check-circle me-2"></i> تم استلام طلبك بنجاح! سيتواصل معك فريق التسجيل قريباً.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M50 10 L90 30 L50 50 L10 30 Z" fill="#ffffff"/>
                        <path d="M50 35 C30 35 15 50 15 70 C15 85 30 90 50 90 C70 90 85 85 85 70 C85 50 70 35 50 35 Z" stroke="#ffffff" stroke-width="8" fill="none"/>
                    </svg>
                    <span class="fs-4 fw-bold text-white">LearnToBe</span>
                </div>
                <p class="text-white-50 small leading-relaxed mb-4">
                    مدرسة ليرن تو بي الخاصة صرح تعليمي متميز يهدف إلى بناء جيل مبدع، متسلح بالمعرفة والمهارات التكنولوجية والأخلاق الحميدة.
                </p>
                <div class="d-flex">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3 text-white">روابط سريعة</h6>
                <a href="#home" class="footer-link">الرئيسة</a>
                <a href="#about" class="footer-link">عن المدرسة</a>
                <a href="#vision" class="footer-link">رؤيتنا ورسالتنا</a>
                <a href="#stages" class="footer-link">الأقسام التعليمية</a>
                <a href="#teachers" class="footer-link">المعلمون</a>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="fw-bold mb-3 text-white">المراحل الدراسية</h6>
                <a href="#stages" class="footer-link">الروضة والتمهيدي</a>
                <a href="#stages" class="footer-link">المرحلة الابتدائية</a>
                <a href="#stages" class="footer-link">المرحلة المتوسطة</a>
                <a href="#stages" class="footer-link">المرحلة الثانوية</a>
            </div>

            <div class="col-lg-4">
                <h6 class="fw-bold mb-3 text-white">النشرة البريدية</h6>
                <p class="text-white-50 small mb-3">اشترك معنا ليصلك أحدث إعلانات المدرسة والأنشطة التنافسية.</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="بريدك الإلكتروني">
                    <button class="btn btn-primary bg-primary border-0 fw-bold px-3" type="button">اشتراك</button>
                </div>
            </div>
        </div>

        <hr style="border-color: rgba(255, 255, 255, 0.1);">

        <div class="row align-items-center text-center text-md-start pt-3">
            <div class="col-md-6 text-white-50 small mb-2 mb-md-0">
                © 2026 جميع الحقوق محفوظة لمدرسة ليرن تو بي الخاصة (Learn To Be School).
            </div>
            <div class="col-md-6 text-md-end text-white-50 small">
                <a href="#" class="text-white-50 text-decoration-none me-3">سياسة الخصوصية</a>
                <a href="#" class="text-white-50 text-decoration-none">الشروط والأحكام</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Interactive Script -->
<script>
    // Number Counter Animation Function
    function animateCounters() {
        const counters = document.querySelectorAll('.counter-number');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const increment = Math.ceil(target / 80);

            const updateCounter = () => {
                count += increment;
                if (count < target) {
                    counter.innerText = count;
                    setTimeout(updateCounter, 25);
                } else {
                    counter.innerText = target;
                }
            };
            updateCounter();
        });
    }

    // Trigger Counter Animation when scrolled to hero/stats
    let animated = false;
    window.addEventListener('scroll', () => {
        const statsSection = document.querySelector('.hero-section');
        if (statsSection) {
            const position = statsSection.getBoundingClientRect();
            if (position.top < window.innerHeight && !animated) {
                animateCounters();
                animated = true;
            }
        }
    });

    // News Filter Functionality
    function filterNews(category, btnElement) {
        // Active Button Styling
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        // Filter Items
        const items = document.querySelectorAll('.news-item');
        items.forEach(item => {
            if (category === 'all' || item.classList.contains(category)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Handle Form Registration Submission
    function handleRegistration(e) {
        e.preventDefault();
        const alertBox = document.getElementById('formAlert');
        alertBox.classList.remove('d-none');
        document.getElementById('studentRegForm').reset();

        setTimeout(() => {
            alertBox.classList.add('d-none');
        }, 6000);
    }

    // Run counters initially if in view
    window.onload = function() {
        animateCounters();
    };
</script>
</body>
</html>
