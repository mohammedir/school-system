@extends('admin.layouts.master')

@section('content')

    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container"
             class="container-xxl d-flex flex-stack flex-wrap gap-2">

            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">

                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">
                    إضافة مدرس جديد
                </h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">

                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>

                    <li class="breadcrumb-item text-gray-600">
                        إدارة المعلمين
                    </li>

                    <li class="breadcrumb-item text-gray-600">
                        إضافة مدرس
                    </li>

                </ul>

            </div>

        </div>
    </div>
    <!--end::Toolbar-->


    <!--begin::Content-->
    <div id="kt_content_container"
         class="container-xxl">

        <form action="{{ route('admin.teachers.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="teacher_form">

            @csrf

            <div class="card">

                <!--begin::Card header-->
                <div class="card-header">

                    <div class="card-title">
                        <h2>بيانات المدرس</h2>
                    </div>

                </div>
                <!--end::Card header-->


                <!--begin::Card body-->
                <div class="card-body">

                    <!--begin::Tabs-->
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
                    <!--end::Tabs-->


                    <div class="tab-content">

                        <!--==================================================-->
                        <!-- البيانات الشخصية -->
                        <!--==================================================-->

                        <div class="tab-pane fade show active"
                             id="personal_data"
                             role="tabpanel">

                            <div class="row">

                                <!-- اسم المدرس -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label required">
                                        اسم المدرس
                                    </label>

                                    <input type="text"
                                           name="teacher_name"
                                           value="{{ old('teacher_name') }}"
                                           class="form-control form-control-solid @error('teacher_name') is-invalid @enderror"
                                           placeholder="أدخل اسم المدرس"
                                           required>

                                    @error('teacher_name')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                <!-- رقم الهوية -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label">
                                        رقم الهوية
                                    </label>

                                    <input type="text"
                                           name="national_id"
                                           value="{{ old('national_id') }}"
                                           class="form-control form-control-solid @error('national_id') is-invalid @enderror"
                                           placeholder="أدخل رقم الهوية">

                                    @error('national_id')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                <!-- البريد -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label required">
                                        البريد الإلكتروني
                                    </label>

                                    <input type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="form-control form-control-solid @error('email') is-invalid @enderror"
                                           placeholder="example@email.com"
                                           required>

                                    @error('email')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                <!-- الهاتف -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label required">
                                        رقم الهاتف
                                    </label>

                                    <input type="text"
                                           name="phone_number"
                                           value="{{ old('phone_number') }}"
                                           class="form-control form-control-solid @error('phone_number') is-invalid @enderror"
                                           placeholder="059XXXXXXXX"
                                           required>

                                    @error('phone_number')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                <!-- كلمة المرور -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label required">
                                        كلمة المرور
                                    </label>

                                    <input type="password"
                                           name="password"
                                           class="form-control form-control-solid @error('password') is-invalid @enderror"
                                           placeholder="أدخل كلمة المرور"
                                           required>

                                    @error('password')
                                    <div class="text-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                <!-- تأكيد كلمة المرور -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label required">
                                        تأكيد كلمة المرور
                                    </label>

                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control form-control-solid"
                                           placeholder="أعد كتابة كلمة المرور"
                                           required>

                                </div>


                                <!-- تاريخ الميلاد -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label">
                                        تاريخ الميلاد
                                    </label>

                                    <input type="date"
                                           name="birth_date"
                                           value="{{ old('birth_date') }}"
                                           class="form-control form-control-solid">

                                </div>


                                <!-- الجنس -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label">
                                        الجنس
                                    </label>

                                    <select name="gender"
                                            class="form-select form-select-solid"
                                            data-control="select2"
                                            data-placeholder="اختر الجنس">

                                        <option></option>

                                        <option value="male"
                                            {{ old('gender') == 'male' ? 'selected' : '' }}>
                                            ذكر
                                        </option>

                                        <option value="female"
                                            {{ old('gender') == 'female' ? 'selected' : '' }}>
                                            أنثى
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>


                        <!--==================================================-->
                        <!-- بيانات العنوان -->
                        <!--==================================================-->

                        <div class="tab-pane fade"
                             id="address_data"
                             role="tabpanel">

                            <div class="row">

                                <!-- العنوان -->
                                <div class="col-md-12 mb-5">

                                    <label class="form-label">
                                        العنوان بالتفصيل
                                    </label>

                                    <textarea name="address"
                                              rows="3"
                                              class="form-control form-control-solid"
                                              placeholder="أدخل عنوان المدرس">{{ old('address') }}</textarea>

                                </div>
                                </div>
                            </div>

                        </div>


                        <!--==================================================-->
                        <!-- البيانات المهنية -->
                        <!--==================================================-->
{{--
                        <div class="tab-pane fade"
                             id="professional_data"
                             role="tabpanel">

                            <div class="row">

                                <!-- المرحلة -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label">
                                        المرحلة الدراسية
                                    </label>

                                    <select name="age_group_id"
                                            class="form-select form-select-solid"
                                            data-control="select2"
                                            data-placeholder="اختر المرحلة">

                                        <option></option>

                                        @foreach($ageGroups as $ageGroup)

                                            <option value="{{ $ageGroup->id }}"
                                                {{ old('age_group_id') == $ageGroup->id ? 'selected' : '' }}>

                                                {{ $ageGroup->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

--}}
                                <!-- سنوات الخبرة -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label">
                                        سنوات الخبرة
                                    </label>

                                    <input type="number"
                                           name="experience_years"
                                           value="{{ old('experience_years') }}"
                                           min="0"
                                           class="form-control form-control-solid"
                                           placeholder="مثال: 5">

                                </div>


                                <!-- التخصصات -->
                                <div class="col-md-12 mb-5">

                                    <label class="form-label">
                                        التخصصات
                                    </label>

                                    <textarea name="specializations"
                                              rows="3"
                                              class="form-control form-control-solid"
                                              placeholder="مثال: رياضيات، فيزياء">{{ old('specializations') }}</textarea>

                                </div>


                                <!-- المؤهلات -->
                                <div class="col-md-12 mb-5">

                                    <label class="form-label">
                                        المؤهلات العلمية
                                    </label>

                                    <textarea name="qualifications"
                                              rows="3"
                                              class="form-control form-control-solid"
                                              placeholder="أدخل المؤهلات العلمية">{{ old('qualifications') }}</textarea>

                                </div>


                                <!-- الشهادات -->
                                <div class="col-md-12 mb-5">

                                    <label class="form-label">
                                        الشهادات والدورات
                                    </label>

                                    <textarea name="certificates"
                                              rows="3"
                                              class="form-control form-control-solid"
                                              placeholder="أدخل الشهادات والدورات">{{ old('certificates') }}</textarea>

                                </div>


                                <!-- الخبرات السابقة -->
                                <div class="col-md-12 mb-5">

                                    <label class="form-label">
                                        نبذة تعريفية عن المدرس
                                    </label>

                                    <textarea name="previous_experience"
                                              rows="4"
                                              class="form-control form-control-solid"
                                              placeholder="أدخل الخبرات السابقة">{{ old('previous_experience') }}</textarea>

                                </div>

                            </div>

                        </div>


                        <!--==================================================-->
                        <!-- الملفات -->
                        <!--==================================================-->

                        <div class="tab-pane fade"
                             id="files_data"
                             role="tabpanel">

                            <div class="row">

                                <!-- الصورة الشخصية -->
                                <div class="col-md-6 mb-7">

                                    <label class="form-label">
                                        الصورة الشخصية
                                    </label>

                                    <input type="file"
                                           name="profile_image"
                                           accept="image/*"
                                           class="form-control form-control-solid">

                                    <div class="form-text">
                                        JPG, JPEG, PNG - الحد الأقصى 2MB
                                    </div>

                                </div>


                                <!-- CV -->
                                <div class="col-md-6 mb-7">

                                    <label class="form-label">
                                        السيرة الذاتية
                                    </label>

                                    <input type="file"
                                           name="cv_file"
                                           accept=".pdf,.doc,.docx"
                                           class="form-control form-control-solid">

                                    <div class="form-text">
                                        PDF, DOC, DOCX
                                    </div>

                                </div>


                                <!-- الشهادات -->
                                <div class="col-md-6 mb-7">

                                    <label class="form-label">
                                        ملف الشهادات
                                    </label>

                                    <input type="file"
                                           name="certificates_file"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="form-control form-control-solid">

                                </div>


                                <!-- صورة الهوية -->
                                <div class="col-md-6 mb-7">

                                    <label class="form-label">
                                        صورة الهوية
                                    </label>

                                    <input type="file"
                                           name="id_photo"
                                           accept="image/*,.pdf"
                                           class="form-control form-control-solid">

                                </div>


                                <!-- حسن السيرة والسلوك -->
                                <div class="col-md-6 mb-7">

                                    <label class="form-label">
                                        شهادة حسن السيرة والسلوك
                                    </label>

                                    <input type="file"
                                           name="certificate_good_conduct"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="form-control form-control-solid">

                                </div>

                            </div>

                        </div>


                        <!--==================================================-->
                        <!-- بيانات إضافية -->
                        <!--==================================================-->

                        <div class="tab-pane fade"
                             id="additional_data"
                             role="tabpanel">

                            <div class="row">

                                <!-- الحالة -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label required">
                                        حالة المدرس
                                    </label>

                                    <select name="status"
                                            class="form-select form-select-solid"
                                            data-control="select2"
                                            required>

                                        <option value="pending"
                                            {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                            قيد المراجعة
                                        </option>

                                        <option value="active"
                                            {{ old('status') == 'active' ? 'selected' : '' }}>
                                            نشط
                                        </option>

                                        <option value="inactive"
                                            {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            غير نشط
                                        </option>

                                        <option value="suspended"
                                            {{ old('status') == 'suspended' ? 'selected' : '' }}>
                                            موقوف
                                        </option>

                                    </select>

                                </div>


                                <!-- التوفر -->
                                <div class="col-md-6 mb-5">

                                    <label class="form-label">
                                        نوع التوظيف
                                    </label>

                                    <select name="availability"
                                            class="form-select form-select-solid"
                                            data-control="select2">

                                        <option value="">
                                            اختر نوع التوظيف
                                        </option>

                                        <option value="full_time"
                                            {{ old('availability') == 'full_time' ? 'selected' : '' }}>
                                            دوام كامل
                                        </option>

                                        <option value="part_time"
                                            {{ old('availability') == 'part_time' ? 'selected' : '' }}>
                                            دوام جزئي
                                        </option>

                                        <option value="freelance"
                                            {{ old('availability') == 'freelance' ? 'selected' : '' }}>
                                            عمل حر
                                        </option>

                                    </select>

                                </div>


                                <!-- ملاحظات -->
                                <div class="col-md-12 mb-5">

                                    <label class="form-label">
                                        ملاحظات
                                    </label>

                                    <textarea name="notes"
                                              rows="5"
                                              class="form-control form-control-solid"
                                              placeholder="أدخل أي ملاحظات إضافية">{{ old('notes') }}</textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                <!--end::Card body-->


                <!--begin::Card footer-->
                <div class="card-footer d-flex justify-content-end py-6">

                    <a href="{{ route('admin.teachers.list') }}"
                       class="btn btn-light me-3">

                        إلغاء

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <span class="indicator-label">
                            حفظ المدرس
                        </span>

                        <span class="indicator-progress">
                            جاري الحفظ...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>

                    </button>

                </div>
                <!--end::Card footer-->

            </div>

        </form>

    </div>
    <!--end::Content-->

@endsection


@section('js')

    <script>

        $(document).ready(function () {

            /*
            |--------------------------------------------------------------------------
            | منع الإرسال المتكرر
            |--------------------------------------------------------------------------
            */

            $('#teacher_form').on('submit', function () {

                let button = $(this).find('button[type="submit"]');

                button.attr('disabled', true);

                button.find('.indicator-label').hide();

                button.find('.indicator-progress').show();

            });

        });

    </script>

@endsection
