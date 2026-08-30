@extends('teacher.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('engineering.profile')</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('teachers.dashboard')}}" class="text-gray-600 text-hover-primary">@lang('engineering.home')</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.profile')</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ $teacher->profile_image ? asset($teacher->profile_image) : asset('assets/media/avatars/blank.png') }}" alt="teacher image"/>
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->

                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $teacher->teacher_name }}</a>

                                        <!-- حالة المدرس -->
                                        @if($teacher->status == 'active')
                                            <a href="#" id="badge_status">
                                                <i class="ki-duotone ki-verify fs-2hx text-primary">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        @elseif($teacher->status == 'suspended')
                                            <a href="#" id="badge_status">
                                                <i class="ki-duotone ki-shield-cross fs-2hx text-danger">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </a>
                                        @elseif($teacher->status == 'pending')
                                            <a href="#" id="badge_status">
                                                <i class="ki-duotone ki-watch fs-2hx text-warning">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </a>
                                        @endif
                                    </div>

                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <!-- التخصصات -->
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            {{ $teacher->specializations ?? __('engineering.Not specified') }}
                                        </a>

                                        <!-- العنوان -->
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ $teacher->address ?? __('engineering.Not specified') }}
                                        </a>

                                        <!-- البريد الإلكتروني -->
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ $teacher->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <div class="d-flex flex-wrap">
                                        <!-- الأرباح -->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Earnings')</div>
                                        </div>

                                        <!-- المشاريع -->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="80">0</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Projects')</div>
                                        </div>

                                        <!-- نسبة النجاح -->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                            </div>
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Success Rate')</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- نسبة اكتمال الملف الشخصي -->
                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                        <span class="fw-semibold fs-6 text-gray-500">نسبة اكتمال الملف الشخصي</span>
                                        <span class="fw-bold fs-6">50%</span>
                                    </div>
                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#">@lang('engineering.Overview')</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('teachers.settings') }}">@lang('engineering.Settings')</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">@lang('engineering.Profile Details')</h3>
                    </div>
                    <a href="{{ route('teachers.profile.edit') }}" class="btn btn-sm btn-primary align-self-center">@lang('engineering.Edit Profile')</a>
                </div>

                <div class="card-body p-9">
                    <!-- الاسم -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">أسم المدرس</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->teacher_name }}</span>
                        </div>
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">الإيميل</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->email }}</span>
                            @if($teacher->email_verified_at != null)
                                <span class="badge badge-success">متحقق</span>
                            @else
                                <span class="badge badge-warning">غير متحقق</span>
                            @endif
                        </div>
                    </div>

                    <!-- رقم الهاتف -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">رقم الجوال</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->phone_number }}</span>
                        </div>
                    </div>

                    <!-- الرقم الوطني -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">رقم الهوية</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->national_id ?? __('engineering.Not specified') }}</span>
                        </div>
                    </div>

                    <!-- تاريخ الميلاد -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">تاريخ الميلاد</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->birth_date ? date('d/m/Y', strtotime($teacher->birth_date)) : __('engineering.Not specified') }}</span>
                        </div>
                    </div>

                    <!-- الجنس -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">الجنس</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">
                                @if($teacher->gender == 'male')
                                    ذكر
                                @elseif($teacher->gender == 'female')
                                    انثى
                                @else
                                    غير محدد
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- العنوان -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">العنوان</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->address ?? __('engineering.Not specified') }}</span>
                        </div>
                    </div>

                    <!-- المرحلة الدراسية -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">المراحلة الدراسية</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">
                                {{ $teacher->ageGroup->name ?? __('engineering.Not specified') }}
                            </span>
                        </div>
                    </div>

                    <!-- التخصصات -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">التخصص</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->specializations ?? __('engineering.Not specified') }}</span>
                        </div>
                    </div>

                    <!-- سنوات الخبرة -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">سنوات الخبرة</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->experience_years ?? '0' }} @lang('engineering.years')</span>
                        </div>
                    </div>

                    <!-- المؤهلات العلمية -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">المؤهل العلمي</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ $teacher->qualifications ?? __('engineering.Not specified') }}</span>
                        </div>
                    </div>

                    <!-- الحالة -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">الحالة</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6">
                                @if($teacher->status == 'active')
                                    <span class="badge badge-success">نشط</span>
                                @elseif($teacher->status == 'pending')
                                    <span class="badge badge-warning">قيد الانتظار</span>
                                @elseif($teacher->status == 'inactive')
                                    <span class="badge badge-secondary">غير نشط</span>
                                @elseif($teacher->status == 'suspended')
                                    <span class="badge badge-danger">معلق</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- التوفر -->
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">التوفر</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">
                                @if($teacher->availability == 'full_time')
                                    دوام كامل
                                @elseif($teacher->availability == 'part_time')
                                    دوام جزئي
                                @elseif($teacher->availability == 'freelance')
                                    بالقطعة
                                @else
                                    @lang('engineering.Not specified')
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- إشعارات الحالة -->
                    @if($teacher->status == 'pending')
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                            <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                                    <div class="fs-6 text-gray-700">@lang('engineering.Your request is still under review. Please be patient.')</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($teacher->status == 'suspended' && isset($teacher->notes))
                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6 mt-5">
                            <i class="ki-duotone ki-information fs-2tx text-danger me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                                    <div class="fs-6 text-gray-700 mb-2">
                                        @lang('engineering.Your request has been rejected. Please check the reason below.')
                                    </div>
                                    <div class="fs-6 text-danger">
                                        <strong>@lang('engineering.Rejection Reason'):</strong> {{ $teacher->notes }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- المرفقات -->
            <div class="row gy-5 g-xl-10">
                <div class="col-xl-4">
                    <div class="card card-flush h-xl-100">
                        <div class="card-header pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">المرفقات</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="hover-scroll-overlay-y pe-6 me-n6" style="height: 415px">
                                <!-- السيرة الذاتية -->
                                @if($teacher->cv_file)
                                    <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                                        <div class="d-flex flex-stack mb-3">
                                            <div class="me-3">
                                                <span class="text-gray-800 text-hover-primary fw-bold">CV</span>
                                            </div>
                                            <div class="m-0">
                                                <button class="btn btn-sm btn-light btn-active-light-primary me-3"
                                                        data-url="{{ asset($teacher->cv_file) }}"
                                                        onclick="openInNewTab(this)">
                                                    <span class="indicator-label">@lang('engineering.download')</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- الشهادات -->
                                @if($teacher->certificates_file)
                                    <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                                        <div class="d-flex flex-stack mb-3">
                                            <div class="me-3">
                                                <span class="text-gray-800 text-hover-primary fw-bold">الشهادة</span>
                                            </div>
                                            <div class="m-0">
                                                <button class="btn btn-sm btn-light btn-active-light-primary me-3"
                                                        data-url="{{ asset($teacher->certificates_file) }}"
                                                        onclick="openInNewTab(this)">
                                                    <span class="indicator-label">@lang('engineering.download')</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- صورة الهوية -->
                                @if($teacher->id_photo)
                                    <div class="border border-dashed border-gray-300 rounded px-7 py-3 mb-6">
                                        <div class="d-flex flex-stack mb-3">
                                            <div class="me-3">
                                                <span class="text-gray-800 text-hover-primary fw-bold">الصورة الشخصية</span>
                                            </div>
                                            <div class="m-0">
                                                <button class="btn btn-sm btn-light btn-active-light-primary me-3"
                                                        data-url="{{ asset($teacher->id_photo) }}"
                                                        onclick="openInNewTab(this)">
                                                    <span class="indicator-label">@lang('engineering.download')</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openInNewTab(button) {
            const url = button.getAttribute('data-url');
            if (url) {
                window.open(url, '_blank');
            }
        }
    </script>
@endsection
