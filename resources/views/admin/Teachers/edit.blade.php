@extends('admin.layouts.master')

@section('content')

    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container"
             class="container-xxl d-flex flex-stack flex-wrap gap-2">

            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">

                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">
                    تعديل بيانات المدرس
                </h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>

                    <li class="breadcrumb-item text-gray-600">
                        إدارة المعلمين
                    </li>

                    <li class="breadcrumb-item text-gray-600">
                        تعديل المدرس
                    </li>
                </ul>

            </div>

        </div>
    </div>


    <div id="kt_content_container" class="container-xxl">

        {{-- أخطاء التحقق --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.teachers.update', $teacher->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="card">

                {{-- Card Header --}}
                <div class="card-header">

                    <div class="card-title">
                        <h2>بيانات المدرس</h2>
                    </div>

                    <div class="card-toolbar">

                        <a href="{{ route('admin.teachers.list') }}"
                           class="btn btn-light me-3">

                            <i class="ki-duotone ki-arrow-right fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            رجوع
                        </a>

                        <button type="submit" class="btn btn-primary">

                            <i class="ki-duotone ki-check fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>

                            حفظ التعديلات

                        </button>

                    </div>

                </div>


                {{-- Card Body --}}
                <div class="card-body">

                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">

                        <li class="nav-item">
                            <a class="nav-link active"
                               data-bs-toggle="tab"
                               href="#personal_data">
                                البيانات الشخصية
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               data-bs-toggle="tab"
                               href="#address_data">
                                بيانات العنوان
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               data-bs-toggle="tab"
                               href="#professional_data">
                                البيانات المهنية
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               data-bs-toggle="tab"
                               href="#files_data">
                                الملفات
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               data-bs-toggle="tab"
                               href="#additional_data">
                                بيانات إضافية
                            </a>
                        </li>

                    </ul>


                    <div class="tab-content">


                        {{-- ================================================= --}}
                        {{-- البيانات الشخصية --}}
                        {{-- ================================================= --}}

                        <div class="tab-pane fade show active"
                             id="personal_data"
                             role="tabpanel">

                            <div class="row">

                                {{-- اسم المدرس --}}
                                <div class="col-md-6 mb-7">

                                    <label class="required fw-semibold fs-6 mb-2">
                                        اسم المدرس
                                    </label>

                                    <input type="text"
                                           name="teacher_name"
                                           class="form-control form-control-solid"
                                           value="{{ old('teacher_name', $teacher->teacher_name) }}"
                                           required>

                                </div>


                                {{-- الرقم الوطني --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        الرقم الوطني
                                    </label>

                                    <input type="text"
                                           name="national_id"
                                           class="form-control form-control-solid"
                                           value="{{ old('national_id', $teacher->national_id) }}">

                                </div>


                                {{-- البريد --}}
                                <div class="col-md-6 mb-7">

                                    <label class="required fw-semibold fs-6 mb-2">
                                        البريد الإلكتروني
                                    </label>

                                    <input type="email"
                                           name="email"
                                           class="form-control form-control-solid"
                                           value="{{ old('email', $teacher->email) }}"
                                           required>

                                </div>


                                {{-- الهاتف --}}
                                <div class="col-md-6 mb-7">

                                    <label class="required fw-semibold fs-6 mb-2">
                                        رقم الهاتف
                                    </label>

                                    <input type="text"
                                           name="phone_number"
                                           class="form-control form-control-solid"
                                           value="{{ old('phone_number', $teacher->phone_number) }}"
                                           required>

                                </div>


                                {{-- كلمة المرور --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        كلمة المرور الجديدة
                                    </label>

                                    <input type="password"
                                           name="password"
                                           class="form-control form-control-solid"
                                           placeholder="اتركها فارغة لعدم تغيير كلمة المرور"
                                           autocomplete="new-password">

                                    <div class="form-text">
                                        إذا تركت الحقل فارغًا، ستبقى كلمة المرور الحالية كما هي.
                                    </div>

                                </div>


                                {{-- تأكيد كلمة المرور --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        تأكيد كلمة المرور الجديدة
                                    </label>

                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control form-control-solid"
                                           placeholder="أعد كتابة كلمة المرور الجديدة"
                                           autocomplete="new-password">

                                </div>


                                {{-- تاريخ الميلاد --}}
                                <div class="col-md-4 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        تاريخ الميلاد
                                    </label>

                                    <input type="date"
                                           name="birth_date"
                                           class="form-control form-control-solid"
                                           value="{{ old('birth_date', $teacher->birth_date) }}">

                                </div>


                                {{-- الجنس --}}
                                <div class="col-md-4 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        الجنس
                                    </label>

                                    <select name="gender"
                                            class="form-select form-select-solid">

                                        <option value="">
                                            اختر الجنس
                                        </option>

                                        <option value="male"
                                            {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>
                                            ذكر
                                        </option>

                                        <option value="female"
                                            {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>
                                            أنثى
                                        </option>

                                    </select>

                                </div>


                                {{-- الحالة --}}
                                <div class="col-md-4 mb-7">

                                    <label class="required fw-semibold fs-6 mb-2">
                                        حالة المدرس
                                    </label>

                                    <select name="status"
                                            class="form-select form-select-solid"
                                            required>

                                        <option value="pending"
                                            {{ old('status', $teacher->status) == 'pending' ? 'selected' : '' }}>
                                            قيد المراجعة
                                        </option>

                                        <option value="active"
                                            {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>
                                            نشط
                                        </option>

                                        <option value="inactive"
                                            {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>
                                            غير نشط
                                        </option>

                                        <option value="suspended"
                                            {{ old('status', $teacher->status) == 'suspended' ? 'selected' : '' }}>
                                            موقوف
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>




                        <div class="tab-pane fade"
                             id="professional_data"
                             role="tabpanel">

                            <div class="row">


                                {{-- سنوات الخبرة --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        سنوات الخبرة
                                    </label>

                                    <input type="number"
                                           name="experience_years"
                                           min="0"
                                           class="form-control form-control-solid"
                                           value="{{ old('experience_years', $teacher->experience_years) }}">

                                </div>


                                {{-- التخصصات --}}
                                <div class="col-md-12 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        التخصصات
                                    </label>

                                    <textarea name="specializations"
                                              class="form-control form-control-solid"
                                              rows="3">{{ old('specializations', $teacher->specializations) }}</textarea>

                                </div>


                                {{-- المؤهلات --}}
                                <div class="col-md-12 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        المؤهلات العلمية
                                    </label>

                                    <textarea name="qualifications"
                                              class="form-control form-control-solid"
                                              rows="3">{{ old('qualifications', $teacher->qualifications) }}</textarea>

                                </div>


                                {{-- الشهادات --}}
                                <div class="col-md-12 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        الشهادات والدورات
                                    </label>

                                    <textarea name="certificates"
                                              class="form-control form-control-solid"
                                              rows="3">{{ old('certificates', $teacher->certificates) }}</textarea>

                                </div>


                                {{-- الخبرات السابقة --}}
                                <div class="col-md-12 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        نبذة تعريفية عن المدرس
                                    </label>

                                    <textarea name="previous_experience"
                                              class="form-control form-control-solid"
                                              rows="4">{{ old('previous_experience', $teacher->previous_experience) }}</textarea>

                                </div>


                                {{-- التفرغ --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        نوع التفرغ
                                    </label>

                                    <select name="availability"
                                            class="form-select form-select-solid">

                                        <option value="">
                                            اختر
                                        </option>

                                        <option value="full_time"
                                            {{ old('availability', $teacher->availability) == 'full_time' ? 'selected' : '' }}>
                                            دوام كامل
                                        </option>

                                        <option value="part_time"
                                            {{ old('availability', $teacher->availability) == 'part_time' ? 'selected' : '' }}>
                                            دوام جزئي
                                        </option>

                                        <option value="freelance"
                                            {{ old('availability', $teacher->availability) == 'freelance' ? 'selected' : '' }}>
                                            عمل حر
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>



                        {{-- ================================================= --}}
                        {{-- الملفات --}}
                        {{-- ================================================= --}}

                        <div class="tab-pane fade"
                             id="files_data"
                             role="tabpanel">

                            <div class="row">

                                {{-- صورة الملف الشخصي --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        صورة المدرس
                                    </label>

                                    @if($teacher->profile_image)

                                        <div class="mb-3">

                                            <img src="{{ asset($teacher->profile_image) }}"
                                                 class="rounded"
                                                 style="width:100px;height:100px;object-fit:cover;"
                                                 alt="صورة المدرس">

                                        </div>

                                    @endif

                                    <input type="file"
                                           name="profile_image"
                                           class="form-control form-control-solid"
                                           accept="image/*">

                                    <div class="form-text">
                                        اترك الحقل فارغًا للاحتفاظ بالصورة الحالية.
                                    </div>

                                </div>


                                {{-- صورة الهوية --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        صورة الهوية
                                    </label>

                                    @if($teacher->id_photo)

                                        <div class="mb-3">

                                            <a href="{{ asset('uploads/teachers/' . $teacher->id_photo) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-light-primary">

                                                عرض الملف الحالي

                                            </a>

                                        </div>

                                    @endif

                                    <input type="file"
                                           name="id_photo"
                                           class="form-control form-control-solid"
                                           accept="image/*">

                                    <div class="form-text">
                                        اترك الحقل فارغًا للاحتفاظ بالملف الحالي.
                                    </div>

                                </div>


                                {{-- CV --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        السيرة الذاتية
                                    </label>

                                    @if($teacher->cv_file)

                                        <div class="mb-3">

                                            <a href="{{ asset('uploads/teachers/' . $teacher->cv_file) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-light-primary">

                                                عرض السيرة الذاتية الحالية

                                            </a>

                                        </div>

                                    @endif

                                    <input type="file"
                                           name="cv_file"
                                           class="form-control form-control-solid">

                                    <div class="form-text">
                                        اترك الحقل فارغًا للاحتفاظ بالسيرة الحالية.
                                    </div>

                                </div>


                                {{-- الشهادات --}}
                                <div class="col-md-6 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        ملف الشهادات
                                    </label>

                                    @if($teacher->certificates_file)

                                        <div class="mb-3">

                                            <a href="{{ asset('uploads/teachers/' . $teacher->certificates_file) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-light-primary">

                                                عرض الشهادات الحالية

                                            </a>

                                        </div>

                                    @endif

                                    <input type="file"
                                           name="certificates_file"
                                           class="form-control form-control-solid">

                                    <div class="form-text">
                                        اترك الحقل فارغًا للاحتفاظ بالملف الحالي.
                                    </div>

                                </div>


                                {{-- حسن السيرة والسلوك --}}
                                <div class="col-md-12 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        شهادة حسن السيرة والسلوك
                                    </label>

                                    @if($teacher->certificate_good_conduct)

                                        <div class="mb-3">

                                            <a href="{{ asset('uploads/teachers/' . $teacher->certificate_good_conduct) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-light-primary">

                                                عرض الشهادة الحالية

                                            </a>

                                        </div>

                                    @endif

                                    <input type="file"
                                           name="certificate_good_conduct"
                                           class="form-control form-control-solid">

                                    <div class="form-text">
                                        اترك الحقل فارغًا للاحتفاظ بالملف الحالي.
                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- ================================================= --}}
                        {{-- بيانات إضافية --}}
                        {{-- ================================================= --}}

                        <div class="tab-pane fade"
                             id="additional_data"
                             role="tabpanel">

                            <div class="row">

                                <div class="col-md-12 mb-7">

                                    <label class="fw-semibold fs-6 mb-2">
                                        ملاحظات
                                    </label>

                                    <textarea name="notes"
                                              class="form-control form-control-solid"
                                              rows="5">{{ old('notes', $teacher->notes) }}</textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

@endsection
