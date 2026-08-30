<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <base href="../../../" />
    <title>تسجيل مدرس جديد</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{asset('/uploads/logo/white_logo.png')}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    @if(App::getLocale() == 'ar')
        <link href="{{asset('assets/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    @endif

    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>

<div class="d-flex flex-column flex-root">
    <style>
        body {
            background-image: url({{ asset('assets/media/auth/bg2.jpg') }});
        }
        [data-bs-theme="dark"] body {
            background-image: url({{ asset('assets/media/auth/bg4-dark.jpg') }});
        }
        .scrollable-form-wrapper {
            max-height: 550px;
            overflow-y: auto;
            width: 100%;
        }
        .form-section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin: 20px 0 15px 0;
        }
        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
        }
        .file-upload-wrapper input[type="file"] {
            cursor: pointer;
        }
    </style>

    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                    <div class="scrollable-form-wrapper">
                        <form method="POST" class="form w-100" novalidate="novalidate" id="kt_sign_up_form"
                              action="{{ route('teachers.register') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Heading -->
                            <div class="text-center mb-11">
                                <h1 class="text-gray-900 fw-bolder mb-3">إنشاء حساب مدرس</h1>
                                <p class="text-muted">سجل بياناتك للانضمام إلى فريق التدريس</p>
                            </div>

                            <!-- المعلومات الشخصية -->
                            <div class="form-section-title">المعلومات الشخصية</div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="الاسم الكامل" name="teacher_name"
                                       autocomplete="off" class="form-control bg-transparent" required />
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="رقم الهوية الوطنية" name="national_id"
                                       autocomplete="off" class="form-control bg-transparent" />
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="رقم الهاتف" name="phone_number"
                                       autocomplete="off" class="form-control bg-transparent" required />
                            </div>

                            <div class="fv-row mb-8">
                                <input type="email" placeholder="البريد الإلكتروني" name="email"
                                       autocomplete="off" class="form-control bg-transparent" required />
                            </div>

                            <div class="row mb-8">
                                <div class="col-md-6">
                                    <input type="date" placeholder="تاريخ الميلاد" name="birth_date"
                                           class="form-control bg-transparent" />
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="gender" data-control="select2"
                                            data-placeholder="الجنس">
                                        <option value="">الجنس</option>
                                        <option value="male">ذكر</option>
                                        <option value="female">أنثى</option>
                                    </select>
                                </div>
                            </div>

                            <!-- معلومات العنوان -->
                            <div class="form-section-title">معلومات العنوان</div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="العنوان التفصيلي" name="address"
                                       autocomplete="off" class="form-control bg-transparent" />
                            </div>

                            <!-- المعلومات المهنية -->
                            <div class="form-section-title">المعلومات المهنية</div>

                            <div class="fv-row mb-8">
                                <select class="form-select" name="age_group_id" id="age_group_id"
                                        data-control="select2" data-placeholder="المرحلة الدراسية">
                                    <option value="">اختر المرحلة الدراسية</option>
                                    @foreach(get_lookup_by_master_key('age_group') as $age_group)
                                        <option value="{{$age_group->id}}">{{$age_group->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="fv-row mb-8">
                                <input type="text" placeholder="التخصصات (افصل بينها بفاصلة)"
                                       name="specializations" autocomplete="off"
                                       class="form-control bg-transparent" />
                            </div>

                            <div class="fv-row mb-8">
                                <input type="number" placeholder="عدد سنوات الخبرة"
                                       name="experience_years" autocomplete="off"
                                       class="form-control bg-transparent" min="0" max="50" />
                            </div>

                            <div class="fv-row mb-8">
                                <textarea placeholder="المؤهلات العلمية" name="qualifications"
                                          class="form-control bg-transparent" rows="2"></textarea>
                            </div>

                            <div class="fv-row mb-8">
                                <textarea placeholder="الشهادات والدورات" name="certificates"
                                          class="form-control bg-transparent" rows="2"></textarea>
                            </div>

                            <div class="fv-row mb-8">
                                <textarea placeholder="الخبرات السابقة" name="previous_experience"
                                          class="form-control bg-transparent" rows="3"></textarea>
                            </div>

                            <div class="fv-row mb-8">
                                <select class="form-select" name="availability" data-control="select2"
                                        data-placeholder="نوع التوفر">
                                    <option value="">نوع التوفر</option>
                                    <option value="full_time">دوام كامل</option>
                                    <option value="part_time">دوام جزئي</option>
                                    <option value="freelance">حر</option>
                                </select>
                            </div>

                            <!-- الملفات -->
                            <div class="form-section-title">الملفات المرفقة</div>

                            <div class="fv-row mb-8">
                                <label class="form-label">الصورة الشخصية</label>
                                <input type="file" name="profile_image" id="profile_image"
                                       class="form-control bg-transparent" accept="image/*" />
                                <small class="text-muted">الصور فقط (JPG, PNG, GIF) - الحد الأقصى 2MB</small>
                            </div>

                            <div class="fv-row mb-8">
                                <label class="form-label">السيرة الذاتية (CV)</label>
                                <input type="file" name="cv_file" id="cv_file"
                                       class="form-control bg-transparent" accept=".pdf,.doc,.docx" />
                                <small class="text-muted">PDF, DOC, DOCX - الحد الأقصى 5MB</small>
                            </div>

                            <div class="fv-row mb-8">
                                <label class="form-label">الشهادات والدورات</label>
                                <input type="file" name="certificates_file" id="certificates_file"
                                       class="form-control bg-transparent" accept=".pdf,.doc,.docx" />
                                <small class="text-muted">PDF, DOC, DOCX - الحد الأقصى 5MB</small>
                            </div>

                            <div class="fv-row mb-8">
                                <label class="form-label">صورة الهوية</label>
                                <input type="file" name="id_photo" id="id_photo"
                                       class="form-control bg-transparent" accept="image/*" />
                                <small class="text-muted">الصور فقط (JPG, PNG) - الحد الأقصى 2MB</small>
                            </div>
                            <div class="fv-row mb-8">
                                <label class="form-label">شهادة حسن سير وسلوك</label>
                                <input type="file" name="certificate_good_conduct" id="certificate_good_conduct"
                                       class="form-control bg-transparent" />
                            </div>

                            <!-- كلمة المرور -->
                            <div class="form-section-title">كلمة المرور</div>

                            <div class="fv-row mb-8" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password"
                                               placeholder="كلمة المرور" name="password"
                                               autocomplete="off" required />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                              data-kt-password-meter-control="visibility">
                                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                </div>
                                <div class="text-muted">استخدم 8 أحرف على الأقل مع مزيج من الحروف والأرقام والرموز</div>
                            </div>

                            <div class="fv-row mb-8">
                                <input placeholder="تأكيد كلمة المرور" name="password_confirmation"
                                       type="password" autocomplete="off"
                                       class="form-control bg-transparent" required />
                            </div>

                            <!-- الموافقة على الشروط -->
                            <div class="fv-row mb-8">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="toc" value="1" required />
                                    <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                                        أوافق على <a href="#" class="ms-1 link-primary">الشروط والأحكام</a>
                                    </span>
                                </label>
                            </div>

                            <!-- زر الإرسال -->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                    <span class="indicator-label">تسجيل</span>
                                    <span class="indicator-progress">
                                        جاري التسجيل...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>

                            <!-- تسجيل الدخول -->
                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                لديك حساب بالفعل؟
                                <a href="{{ route('teachers.login') }}" class="link-primary fw-semibold">
                                    تسجيل الدخول
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- الجانب الأيمن -->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <div class="d-flex flex-center flex-lg-start flex-column">
                <a href="index.html" class="mb-7">
                    <img alt="Logo" class="mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
                         src="{{asset('/uploads/logo/white_logo.png')}}" />
                </a>
                <div class="text-center">
                    <h3 class="text-white">انضم إلى فريق التدريس</h3>
                    <p class="text-white-50">كن جزءاً من رحلتنا التعليمية</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>

<!-- الكود الخاص بالصفحة -->
<script>
    $(document).ready(function() {

    });

    // معالجة إرسال النموذج
    $('#kt_sign_up_form').on('submit', function(e) {
        e.preventDefault();

        var form = this;
        var formData = new FormData(form);
        var submitBtn = $('#kt_sign_up_submit');

        submitBtn.prop('disabled', true);
        submitBtn.find('.indicator-label').hide();
        submitBtn.find('.indicator-progress').show();

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التسجيل بنجاح!',
                        text: response.message,
                        confirmButtonText: 'حسناً'
                    }).then(function() {
                        window.location.href = '{{ route("teachers.login") }}';
                    });
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON?.errors;
                var errorMessage = '';

                if (errors) {
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                } else {
                    errorMessage = xhr.responseJSON?.message || 'حدث خطأ أثناء التسجيل';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'خطأ في التسجيل',
                    html: errorMessage,
                    confirmButtonText: 'حسناً'
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                submitBtn.find('.indicator-label').show();
                submitBtn.find('.indicator-progress').hide();
            }
        });
    });
</script>

</body>
</html>
