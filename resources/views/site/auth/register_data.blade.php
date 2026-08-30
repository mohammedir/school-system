<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="advanced search, agency, agent, classified, directory, house, listing, property, real estate, real estate agency, real estate agent, realestate, gaza, reconstruction, contractors, gaza rebuilding, rebuilding, construction, gaza construction, gaza construction company, gaza rebuild">
    <meta name="description" content="One-Thousand - استثمار واحد. ألف فرصة">
    <meta name="CreativeLayers" content="ATFN" />
    <!-- css file -->
    <link rel="stylesheet" href="{{ asset('site_assets/css/bootstrap.rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/ace-responsive-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/ud-custom-spacing.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('site_assets/css/jquery-ui.min.css') }}" />
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="{{ asset('site_assets/css/responsive.css') }}" />
    <!-- Title -->
    <title>ألف | إنشاء حساب</title>
    <!-- Favicon -->
    <link href="{{ asset('site_assets/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="{{ asset('site_assets/images/favicon.ico') }}" sizes="128x128" rel="shortcut icon" />
    <!-- Apple Touch Icon -->
    <link href="{{ asset('site_assets/images/apple-touch-icon-60x60.png') }}" sizes="60x60" rel="apple-touch-icon" />
    <link href="{{ asset('site_assets/images/apple-touch-icon-72x72.png') }}" sizes="72x72" rel="apple-touch-icon" />
    <link href="{{ asset('site_assets/images/apple-touch-icon-114x114.png') }}" sizes="114x114" rel="apple-touch-icon" />
    <link href="{{ asset('site_assets/images/apple-touch-icon-180x180.png') }}" sizes="180x180" rel="apple-touch-icon" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        label.error {
            color: #dc3545 !important; /* أحمر مثل Bootstrap */
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        input.error, select.error, textarea.error {
            border-color: #dc3545 !important;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view.blade.php the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bgc-f7">

<div class="wrapper ovh">
    <div class="preloader"></div>
    <div class="body_content">
        <!-- Our Compare Area -->

        <section class="our-compare pt60 pb60">
            <img src="{{ asset('site_assets/images/icon/register-page-icon.svg') }}" alt="" class="login-bg-icon wow fadeInLeft" data-wow-delay="300ms" />
            <div class="container">
                <div class="row wow fadeInRight" data-wow-delay="300ms">
                    <div class="col-lg-6">
                        <div class="log-reg-form signup-modal form-style1 bgc-white p50 p30-sm default-box-shadow2 bdrs12">
                            <div class="text-center mb40">
                                <img class="mb25" src="{{ asset('site_assets/images/header-logo2.svg') }}" alt="" />
                                <img src="{{ asset('site_assets/images/logo.png') }}" width="300px" height="65px"/>
                                <div class="border-top border-dashed my-4"></div>

                                <h2>{{ __('investors.create_account') }}</h2>
                                <p class="text">سجّل بياناتك الآن و انضم إلى شبكة موثوقة من المقاولين، الشركاء الهندسيين، القانونيين والمثمنين العقاريين!</p>
                            </div>
                            <form id="register_form" action="{{ route('investors.register_data') }}" method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                                @csrf

                                <!-- اختيار نوع الحساب -->
                                <div class="mb25 fv-row">
                                    <label class="form-label fw600 dark-color">نوع الحساب</label>
                                    <select class="form-select" data-control="select2" name="user_type" id="user_type_selector" required>
                                        <option value="">-- اختر نوع الحساب --</option>
                                        <option value="contractor">مقاول</option>
                                        <option value="eng">شريك هندسي</option>
                                        <option value="appraiser">مثمن عقاري</option>
                                        <option value="legal">شريك قانوني</option>
                                    </select>
                                </div>

                                <!-- المقاول -->
                                <div class="user-section user-contractor d-none">
                                    <div class="mb-3">
                                        <label for="contractor_name">اسم المقاول</label>
                                        <input type="text" name="contractor_name" id="contractor_name" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="contractor_mobile">رقم الجوال</label>
                                        <input type="text" name="contractor_mobile" id="contractor_mobile" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="contractor_phone">رقم الهاتف</label>
                                        <input type="text" name="contractor_phone" id="contractor_phone" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="contractor_email">البريد الإلكتروني</label>
                                        <input type="email" name="contractor_email" id="contractor_email" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="province_contractor">المحافظة</label>
                                        <select class="form-select location_province" name="contractor_province_cd" id="province_contractor" data-control="select2">
                                            <option value="" selected>-- اختر المحافظة --</option>
                                            @foreach ($data['provinces'] as $val)
                                                <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_cities_contractor">المدينة</label>
                                        <select class="form-select location_city" id="location_cities_contractor" name="contractor_city_cd" data-control="select2">
                                            <option value="" selected>-- اختر المدينة --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_areas_contractor">الحي</label>
                                        <select class="form-select" id="location_areas_contractor" name="contractor_district_cd" data-control="select2">
                                            <option value="" selected>-- اختر الحي --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="contractor_address">العنوان بالتفصيل</label>
                                        <input type="text" name="contractor_address" id="contractor_address" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="contractor_experience">سنوات الخبرة</label>
                                        <input type="number" name="contractor_experience" id="contractor_experience" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="contractor_specialties">التخصصات</label>
                                        <textarea name="contractor_specialties" id="contractor_specialties" class="form-control"></textarea>
                                    </div>
                                </div>

                                <!-- الشريك الهندسي -->
                                <div class="user-section user-eng d-none">
                                    <div class="mb-3">
                                        <label for="eng_name">الاسم كاملاً</label>
                                        <input type="text" name="eng_name" id="eng_name" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="eng_mobile">رقم الجوال</label>
                                        <input type="text" name="eng_mobile" id="eng_mobile" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="eng_email">الإيميل</label>
                                        <input type="email" name="eng_email" id="eng_email" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="province_eng">المحافظة</label>
                                        <select class="form-select location_province" name="eng_province_cd" id="province_eng" data-control="select2">
                                            <option value="" selected>-- اختر المحافظة --</option>
                                            @foreach ($data['provinces'] as $val)
                                                <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_cities_eng">المدينة</label>
                                        <select class="form-select location_city" id="location_cities_eng" name="eng_city_cd" data-control="select2">
                                            <option value="" selected>-- اختر المدينة --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_areas_eng">الحي</label>
                                        <select class="form-select" id="location_areas_eng" name="eng_district_cd" data-control="select2">
                                            <option value="" selected>-- اختر الحي --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="eng_address">العنوان</label>
                                        <input type="text" name="eng_address" id="eng_address" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="eng_experience">سنوات الخبرة</label>
                                        <input type="number" name="eng_experience" id="eng_experience" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="eng_specialties">التخصصات</label>
                                        <textarea name="eng_specialties" id="eng_specialties" class="form-control"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="eng_website">الموقع الإلكتروني</label>
                                        <input type="url" name="eng_website" id="eng_website" class="form-control" />
                                    </div>
                                </div>

                                <!-- المثمن العقاري -->
                                <div class="user-section user-appraiser d-none">
                                    <div class="mb-3">
                                        <label for="appraiser_name">الاسم</label>
                                        <input type="text" name="appraiser_name" id="appraiser_name" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="appraiser_mobile">رقم الجوال</label>
                                        <input type="text" name="appraiser_mobile" id="appraiser_mobile" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="appraiser_email">الإيميل</label>
                                        <input type="email" name="appraiser_email" id="appraiser_email" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="province_appraiser">المحافظة</label>
                                        <select class="form-select location_province" name="appraiser_province_cd" id="province_appraiser" data-control="select2">
                                            <option value="" selected>-- اختر المحافظة --</option>
                                            @foreach ($data['provinces'] as $val)
                                                <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_cities_appraiser">المدينة</label>
                                        <select class="form-select location_city" id="location_cities_appraiser" name="appraiser_city_cd" data-control="select2">
                                            <option value="" selected>-- اختر المدينة --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_areas_appraiser">الحي</label>
                                        <select class="form-select" id="location_areas_appraiser" name="appraiser_district_cd" data-control="select2">
                                            <option value="" selected>-- اختر الحي --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="appraiser_address">العنوان التفصيلي</label>
                                        <input type="text" name="appraiser_address" id="appraiser_address" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="appraiser_experience">سنوات الخبرة في التثمين العقاري</label>
                                        <input type="number" name="appraiser_experience" id="appraiser_experience" class="form-control" />
                                    </div>
                                </div>

                                <!-- الشريك القانوني -->
                                <div class="user-section user-legal d-none">
                                    <div class="mb-3">
                                        <label for="legal_name">الاسم</label>
                                        <input type="text" name="legal_name" id="legal_name" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="legal_mobile">رقم الجوال</label>
                                        <input type="text" name="legal_mobile" id="legal_mobile" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="legal_email">الإيميل</label>
                                        <input type="email" name="legal_email" id="legal_email" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="province_legal">المحافظة</label>
                                        <select class="form-select location_province" name="legal_province_cd" id="province_legal" data-control="select2">
                                            <option value="" selected>-- اختر المحافظة --</option>
                                            @foreach ($data['provinces'] as $val)
                                                <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_cities_legal">المدينة</label>
                                        <select class="form-select location_city" id="location_cities_legal" name="legal_city_cd" data-control="select2">
                                            <option value="" selected>-- اختر المدينة --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_areas_legal">الحي</label>
                                        <select class="form-select" id="location_areas_legal" name="legal_district_cd" data-control="select2">
                                            <option value="" selected>-- اختر الحي --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="legal_address">العنوان التفصيلي</label>
                                        <input type="text" name="legal_address" id="legal_address" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="legal_experience">سنوات الخبرة</label>
                                        <input type="number" name="legal_experience" id="legal_experience" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="legal_company">اسم الشركة</label>
                                        <input type="text" name="legal_company" id="legal_company" class="form-control" />
                                    </div>

                                    <div class="mb-3">
                                        <label for="legal_license">رقم الترخيص</label>
                                        <input type="text" name="legal_license" id="legal_license" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button id="register_submit" class="ud-btn btn-thm" type="submit">
                                        تسجيل <i class="fal fa-arrow-right-long"></i>
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a class="scrollToHome" href="#"><i class="fas fa-angle-up"></i></a>
    </div>
</div>

<script src="{{ asset('site_assets/js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('site_assets/js/ace-responsive-menu.js') }}"></script>
<script src="{{ asset('site_assets/js/jquery.mmenu.all.js') }}"></script>
<script src="{{ asset('site_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('site_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('site_assets/js/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('site_assets/js/wow.min.js') }}"></script>
<!-- Custom script for all pages -->
<script src="{{ asset('site_assets/js/script.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>


<!-- Select2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>

<script>
    $(document).ready(function () {
        // إظهار القسم المناسب حسب اختيار نوع المستخدم
        $('#user_type_selector').on('change', function () {
            $('.user-section').addClass('d-none');
            const type = $(this).val();
            if (type) {
                $('.user-' + type).removeClass('d-none');
            }
        });

        // تفعيل select2 لجميع عناصر select2
        function initSelect2() {
            $('select[data-control="select2"]').select2({
                theme: 'bootstrap-5', // ✅ <-- theme bootstrap
                width: '100%',
                dir: "rtl",
                dropdownParent: $(document.body),
                language: {
                    noResults: function () {
                        return "لا توجد نتائج";
                    }
                }
            });
        }
        initSelect2();

        // إظهار القسم مباشرة إذا كان موجود في URL مثل ?type=contractor
        function showUserSectionFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const type = urlParams.get('type');
            if (type) {
                $('#user_type_selector').val(type).trigger('change');
            }
        }
        showUserSectionFromURL();


        // دالة لتحميل المدن بناءً على المحافظة، مع المعرفات الخاصة بكل نوع
        function loadCities(provinceId, citySelectId, areaSelectId) {
            const citySelect = $(citySelectId);
            const areaSelect = $(areaSelectId);

            citySelect.empty().append('<option value="">-- اختر المدينة --</option>');
            areaSelect.empty().append('<option value="">-- اختر الحي --</option>');

            if (provinceId) {
                // تحديد container الـ select2 للمدينة (blockUI عليه)
                const citySelect2Container = citySelect.next('.select2-container');

                // تفعيل blockUI على الـ select2 container
                citySelect2Container.block({
                    message: '<div class="spinner-border text-primary" role="status"></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.1,
                        cursor: 'wait'
                    }
                });

                $.ajax({
                    method: "POST",
                    url: '{{ url("/") }}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: provinceId, '_token': '{{ csrf_token() }}' },
                    success: function (data) {
                        citySelect.empty().append('<option value="">-- اختر المدينة --</option>');
                        citySelect.append(data.children);
                        citySelect.trigger('change.select2');
                    },
                    error: function () {
                        citySelect.empty().append('<option value="">خطأ في تحميل المدن</option>');
                    },
                    complete: function() {
                        // إزالة الـ blockUI
                        citySelect2Container.unblock();
                    }
                });
            }
        }

        // دالة لتحميل الأحياء بناءً على المدينة
        function loadAreas(cityId, areaSelectId) {
            const areaSelect = $(areaSelectId);
            areaSelect.empty().append('<option value="">-- اختر الحي --</option>');

            if (cityId) {
                // تحديد container الـ select2 للحي
                const areaSelect2Container = areaSelect.next('.select2-container');

                areaSelect2Container.block({
                    message: '<div class="spinner-border text-primary" role="status"></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.1,
                        cursor: 'wait'
                    }
                });

                $.ajax({
                    method: "POST",
                    url: '{{ url("/") }}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: cityId, '_token': '{{ csrf_token() }}' },
                    success: function (data) {
                        areaSelect.empty().append('<option value="">-- اختر الحي --</option>');
                        areaSelect.append(data.children);
                        areaSelect.trigger('change.select2');
                    },
                    error: function () {
                        areaSelect.empty().append('<option value="">خطأ في تحميل الأحياء</option>');
                    },
                    complete: function() {
                        areaSelect2Container.unblock();
                    }
                });
            }
        }

        // عند تغيير المحافظة لكل قسم
        $(document).on("change", "select.location_province", function () {
            const province_id = $(this).val();

            const provinceId = $(this).attr('id');
            const suffix = provinceId.replace('province_', '');

            loadCities(province_id, '#location_cities_' + suffix, '#location_areas_' + suffix);
        });

        // عند تغيير المدينة لكل قسم
        $(document).on("change", "select.location_city", function () {
            const city_id = $(this).val();

            const cityId = $(this).attr('id');
            const suffix = cityId.replace('location_cities_', '');

            loadAreas(city_id, '#location_areas_' + suffix);
        });
    });
</script>


<script>
    $(function () {
        const $form = $('#register_form');
        const $btn = $('#register_submit');

        function getValidationRules(type) {
            const base = {
                user_type: { required: true }
            };

            const rules = {
                contractor: {
                    contractor_name: { required: true },
                    contractor_mobile: { required: true },
                    contractor_phone: { required: true },
                    contractor_email: { required: true, email: true },
                    contractor_province_cd: { required: true },
                    contractor_city_cd: { required: true },
                    contractor_district_cd: { required: true },
                    contractor_address: { required: true },
                    contractor_experience: { required: true },
                    contractor_specialties: { required: true },
                },
                eng: {
                    eng_name: { required: true },
                    eng_mobile: { required: true },
                    eng_email: { required: true, email: true },
                    eng_province_cd: { required: true },
                    eng_city_cd: { required: true },
                    eng_district_cd: { required: true },
                    eng_address: { required: true },
                    eng_experience: { required: true },
                    eng_website: { required: true },
                    eng_specialties: { required: true },
                },
                appraiser: {
                    appraiser_name: { required: true },
                    appraiser_mobile: { required: true },
                    appraiser_email: { required: true, email: true },
                    appraiser_province_cd: { required: true },
                    appraiser_city_cd: { required: true },
                    appraiser_district_cd: { required: true },
                    appraiser_address: { required: true },
                    appraiser_experience: { required: true },
                },
                legal: {
                    legal_name: { required: true },
                    legal_mobile: { required: true },
                    legal_email: { required: true, email: true },
                    legal_province_cd: { required: true },
                    legal_city_cd: { required: true },
                    legal_district_cd: { required: true },
                    legal_address: { required: true },
                    legal_experience: { required: true },
                    legal_company: { required: true },
                    legal_license: { required: true },
                }
            };

            return Object.assign({}, base, rules[type] || {});
        }

        $form.validate({
            ignore: [],
            rules: getValidationRules($('#user_type_selector').val()),
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form, e) {
                e.preventDefault();


                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.redirect) {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم التسجيل بنجاح!',
                                text: 'سيتم توجيهك الآن...',
                                confirmButtonText: 'حسناً'
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'تم التسجيل!',
                                text: 'تمت العملية بنجاح.',
                                confirmButtonText: 'حسناً'
                            });
                        }
                    },
                    error: function (xhr) {
                        let msg = "{{ __('investors.register_error') }}";
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            msg = '';
                            $.each(xhr.responseJSON.errors, function (key, val) {
                                msg += val[0] + '<br>';
                            });
                        }
                        Swal.fire({
                            html: msg,
                            icon: 'error',
                            confirmButtonText: "{{ __('investors.ok') }}"
                        });
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html('{{ __("investors.register") }} <i class="fal fa-arrow-right-long"></i>');
                    }
                });
            }
        });

        // تحديث قواعد التحقق تلقائيًا عند تغيير نوع المستخدم
        $('#user_type_selector').on('change', function () {
            const newRules = getValidationRules($(this).val());
            $form.validate().settings.rules = newRules;
        });
    });
</script>


</body>
</html>
