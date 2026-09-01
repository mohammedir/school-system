@extends('admin.layouts.master')

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">إدارة بيانات الموقع</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Home')</li>
                    <li class="breadcrumb-item text-gray-600">إدارة الموقع</li>
                    <li class="breadcrumb-item text-gray-600">تعديل المحتوى والبيانات</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show ms-lg-6 me-lg-6" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success fs-4"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header card-header-stretch border-bottom-0">
                    <!--begin::Title-->
                    <div class="card-title">
                        <h3 class="fw-bold m-0 text-gray-800">إعدادات ومحتوى صفحات الموقع</h3>
                    </div>
                    <!--end::Title-->

                    <!--begin::Tabs Header-->
                    <div class="card-toolbar">
                        <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_general" role="tab">
                                    <i class="bi bi-sliders me-2"></i>البيانات العامة والهوية
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_about" role="tab">
                                    <i class="bi bi-person-badge me-2"></i>الرؤية وكلمة المديرة
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_sections" role="tab">
                                    <i class="bi bi-grid-3x3-gap me-2"></i>الأقسام التعليمية
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_contact" role="tab">
                                    <i class="bi bi-geo-alt me-2"></i>التواصل والتواصل الاجتماعي
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--end::Tabs Header-->
                </div>

                <div class="card-body border-top p-9">
                    <form action="{{ route('admin.site_management.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="tab-content" id="myTabContent">

                            <!-- ================= TAB 1: General & Identity ================= -->
                            <div class="tab-pane fade show active" id="kt_tab_general" role="tabpanel">
                                <h4 class="fw-bold text-gray-800 mb-7">الهوية البصرية والنصوص الرئيسية</h4>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">شعار المدرسة (Logo)</label>
                                    <div class="col-lg-9">
                                        <input type="file" name="site_logo" class="form-control form-control-solid" accept="image/*">
                                        <div class="form-text">القياس الموصى به: 250x250 بكسل بحجم لا يتعدى 2MB.</div>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label required fw-semibold fs-6">اسم المدرسة</label>
                                    <div class="col-lg-9">
                                        <input
                                            type="text"
                                            name="site_name"
                                            class="form-control form-control-solid"
                                            value="{{ $site_settings->site_name ?? 'مدرسة ليرن تو بي (Learn To Be)' }}"
                                            required
                                        />                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">عنوان الواجهة الرئيسية (Hero Title)</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="hero_title" class="form-control form-control-solid" value="{{ $site_settings->hero_title ?? 'مستقبل تعليمي مشرق لبناء أجيال الغد' }}" />
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">وصف الواجهة (Hero Subtitle)</label>
                                    <div class="col-lg-9">
                                        <textarea name="hero_subtitle" class="form-control form-control-solid" rows="3">{{ $site_settings->hero_subtitle ?? 'نقدم بيئة تعليمية متكاملة تدمج بين الجودة الأكاديمية والتطوير التربوي.' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= TAB 2: Vision & Principal Word ================= -->
                            <div class="tab-pane fade" id="kt_tab_about" role="tabpanel">
                                <h4 class="fw-bold text-gray-800 mb-7">الرؤية والرسالة وكلمة المديرة</h4>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">رؤية المدرسة</label>
                                    <div class="col-lg-9">
                                        <textarea name="school_vision" class="form-control form-control-solid" rows="4">{{ $site_settings->school_vision ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">رسالة المدرسة</label>
                                    <div class="col-lg-9">
                                        <textarea name="school_mission" class="form-control form-control-solid" rows="4">{{ $site_settings->school_mission ?? '' }}</textarea>
                                    </div>
                                </div>

                                <hr class="my-7" />

                                <h5 class="fw-bold text-gray-800 mb-5">كلمة مديرة المدرسة</h5>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">اسم المديرة</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="principal_name" class="form-control form-control-solid" value="{{ $site_settings->principal_name ?? '' }}" />
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">صورة المديرة</label>
                                    <div class="col-lg-9">
                                        <input type="file" name="principal_image" class="form-control form-control-solid" accept="image/*">
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">نص كلمة المديرة</label>
                                    <div class="col-lg-9">
                                        <textarea name="principal_speech" class="form-control form-control-solid" rows="6">{{ $settings['principal_speech'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= TAB 3: School Sections ================= -->
                            <div class="tab-pane fade" id="kt_tab_sections" role="tabpanel">
                                <h4 class="fw-bold text-gray-800 mb-7">إعدادات الأقسام والخدمات التعليمية</h4>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">قسم الروضة والتمهيدي</label>
                                    <div class="col-lg-9">
                                        <textarea name="section_kindergarten" class="form-control form-control-solid" rows="3">{{ $settings['section_kindergarten'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">المرحلة الأساسية (الابتدائية)</label>
                                    <div class="col-lg-9">
                                        <textarea name="section_primary" class="form-control form-control-solid" rows="3">{{ $settings['section_primary'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">المرحلة الإعدادية والتانوية</label>
                                    <div class="col-lg-9">
                                        <textarea name="section_secondary" class="form-control form-control-solid" rows="3">{{ $settings['section_secondary'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">مركز الدورات والأنشطة التدريبية</label>
                                    <div class="col-lg-9">
                                        <textarea name="section_center" class="form-control form-control-solid" rows="3">{{ $settings['section_center'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- ================= TAB 4: Contact & Socials ================= -->
                            <div class="tab-pane fade" id="kt_tab_contact" role="tabpanel">
                                <h4 class="fw-bold text-gray-800 mb-7">معلومات الاتصال وروافد التواصل</h4>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">رقم الهاتف الرئيسية</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="contact_phone" class="form-control form-control-solid" value="{{ $site_settings->contact_phone ?? '' }}" />
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">رقم الواتساب</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="contact_whatsapp" class="form-control form-control-solid" value="{{ $site_settings->contact_whatsapp ?? '' }}" />
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">البريد الإلكتروني الرسمي</label>
                                    <div class="col-lg-9">
                                        <input type="email" name="contact_email" class="form-control form-control-solid" value="{{ $site_settings->contact_email ?? '' }}" />
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">العنوان</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="contact_address" class="form-control form-control-solid" value="{{ $site_settings->contact_address ?? '' }}" />
                                    </div>
                                </div>

                                <hr class="my-7" />

                                <h5 class="fw-bold text-gray-800 mb-5">روابط منصات التواصل الاجتماعي</h5>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">رابط فيسبوك</label>
                                    <div class="col-lg-9">
                                        <input type="url" name="social_facebook" class="form-control form-control-solid" value="{{ $site_settings->social_facebook ?? '' }}" placeholder="https://facebook.com/..." />
                                    </div>
                                </div>

                                <div class="row mb-6">
                                    <label class="col-lg-3 col-form-label fw-semibold fs-6">رابط انستغرام</label>
                                    <div class="col-lg-9">
                                        <input type="url" name="social_instagram" class="form-control form-control-solid" value="{{ $site_settings->social_instagram ?? '' }}" placeholder="https://instagram.com/..." />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer d-flex justify-content-end py-6 px-9 bg-transparent border-top">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">إلغاء التغييرات</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>حفظ التعديلات
                            </button>
                        </div>
                    </form>
                </div>

            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->

@endsection

@section('js')
    @include("admin.SitesManagement.Partial.site_mangement_js")
@endsection
