{{-- resources/views/teacher/profile/edit.blade.php --}}

@extends('teacher.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('engineering.Edit Profile')</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('teachers.dashboard')}}" class="text-gray-600 text-hover-primary">@lang('engineering.home')</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{route('teachers.profile.show')}}" class="text-gray-600 text-hover-primary">@lang('engineering.profile')</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.Edit Profile')</li>
                </ul>
            </div>
        </div>
    </div>

    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <h3 class="card-title">@lang('engineering.Edit Profile')</h3>
                <div class="card-toolbar">
                    <a href="{{ route('teachers.profile.show') }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2"></i> الرجوع
                    </a>
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body">
                <!-- عرض رسائل النجاح أو الخطأ -->
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                        <i class="ki-duotone ki-check-circle fs-2hx text-success me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h5 class="mb-1">@lang('engineering.Success')</h5>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                        <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <h5 class="mb-1">@lang('engineering.Errors')</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('teachers.profile.update') }}" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    @method('PUT')

                    <!-- صورة الملف الشخصي -->
                    <div class="d-flex flex-column align-items-center mb-10">
                        <div class="symbol symbol-150px symbol-circle mb-5">
                            <img src="{{ $teacher->profile_image ? asset($teacher->profile_image) : asset('assets/media/avatars/blank.png') }}"
                                 alt="Profile Image"
                                 id="profileImagePreview" />
                        </div>
                        <div class="mb-3">
                            <label for="profile_image" class="btn btn-sm btn-primary">
                                <i class="ki-duotone ki-camera fs-2 me-1"></i>
                                تعديل الصورة الشخصية
                            </label>
                            <input type="file"
                                   id="profile_image"
                                   name="profile_image"
                                   class="d-none"
                                   accept="image/*"
                                   onchange="previewImage(event, 'profileImagePreview')" />
                        </div>
                        <small class="text-muted">الصيغ المسموحة: JPG, PNG, GIF. Max size: 2MB</small>
                    </div>

                    <div class="row g-9 mb-8">
                        <!-- العمود الأيسر -->
                        <div class="col-md-6">
                            <!-- الاسم -->
                            <div class="fv-row mb-8">
                                <label class="required fw-semibold fs-6 mb-2">اسم المدرس</label>
                                <input type="text"
                                       name="teacher_name"
                                       class="form-control form-control-solid @error('teacher_name') is-invalid @enderror"
                                       placeholder="ادخل اسم المدرس"
                                       value="{{ old('teacher_name', $teacher->teacher_name) }}" />
                                @error('teacher_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="fv-row mb-8">
                                <label class="required fw-semibold fs-6 mb-2">البريد اللإلكتروني</label>
                                <input type="email"
                                       name="email"
                                       class="form-control form-control-solid @error('email') is-invalid @enderror"
                                       placeholder="ادخل الايميل"
                                       value="{{ old('email', $teacher->email) }}" />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- رقم الهاتف -->
                            <div class="fv-row mb-8">
                                <label class="required fw-semibold fs-6 mb-2">رقم الجوال</label>
                                <input type="text"
                                       name="phone_number"
                                       class="form-control form-control-solid @error('phone_number') is-invalid @enderror"
                                       placeholder="ادخل رقم الجوال"
                                       value="{{ old('phone_number', $teacher->phone_number) }}" />
                                @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الرقم الوطني -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">رقم الهوية</label>
                                <input type="text"
                                       name="national_id"
                                       class="form-control form-control-solid @error('national_id') is-invalid @enderror"
                                       placeholder="ادخل رقم الهوية"
                                       value="{{ old('national_id', $teacher->national_id) }}" />
                                @error('national_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- تاريخ الميلاد -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">تاريخ الميلاد</label>
                                <input type="date"
                                       name="birth_date"
                                       class="form-control form-control-solid @error('birth_date') is-invalid @enderror"
                                       value="{{ old('birth_date', $teacher->birth_date) }}" />
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الجنس -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">الجنس</label>
                                <select name="gender" class="form-select form-select-solid @error('gender') is-invalid @enderror">
                                    <option value="">اختر الجنس</option>
                                    <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                                    <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>انثى</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- العمود الأيمن -->
                        <div class="col-md-6">
                            <!-- العنوان -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">العنوان</label>
                                <input type="text"
                                       name="address"
                                       class="form-control form-control-solid @error('address') is-invalid @enderror"
                                       placeholder="ادخل العنوان"
                                       value="{{ old('address', $teacher->address) }}" />
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- المرحلة الدراسية -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">المراحل الدراسية</label>
                                <select name="age_group_id" class="form-select form-select-solid @error('age_group_id') is-invalid @enderror">
                                    <option value="">اختر المرحلة</option>

                                    @foreach(get_lookup_by_master_key('age_group') as $age_group)
                                        <option value="{{ $age_group->id }}"
                                            {{ $age_group->id == old('age_group_id', $teacher->age_group_id) ? 'selected' : '' }}>
                                            {{ $age_group->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('age_group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- المعلومات المهنية -->
                    <div class="row g-9 mb-8">
                        <div class="col-md-12">
                            <h4 class="mb-5">معلومات مهنية</h4>
                            <hr class="mb-5">
                        </div>

                        <div class="col-md-6">
                            <!-- التخصصات -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">التخصص</label>
                                <textarea name="specializations"
                                          class="form-control form-control-solid @error('specializations') is-invalid @enderror"
                                          rows="3"
                                          placeholder="ادخل التخصص">{{ old('specializations', $teacher->specializations) }}</textarea>
                                @error('specializations')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- المؤهلات العلمية -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">المؤهل العلمي</label>
                                <textarea name="qualifications"
                                          class="form-control form-control-solid @error('qualifications') is-invalid @enderror"
                                          rows="3"
                                          placeholder="@lang('engineering.Enter qualifications')">{{ old('qualifications', $teacher->qualifications) }}</textarea>
                                @error('qualifications')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- سنوات الخبرة -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">سنوات الخبرة</label>
                                <input type="number"
                                       name="experience_years"
                                       class="form-control form-control-solid @error('experience_years') is-invalid @enderror"
                                       placeholder="ادخل سنوات الخبرة"
                                       value="{{ old('experience_years', $teacher->experience_years) }}"
                                       min="0" max="50" />
                                @error('experience_years')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- التوفر -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">التوفر</label>
                                <select name="availability" class="form-select form-select-solid @error('availability') is-invalid @enderror">
                                    <option value="">@lang('engineering.Select availability')</option>
                                    <option value="full_time" {{ old('availability', $teacher->availability) == 'full_time' ? 'selected' : '' }}>دوام كامل</option>
                                    <option value="part_time" {{ old('availability', $teacher->availability) == 'part_time' ? 'selected' : '' }}>دوام جزئي</option>
                                    <option value="freelance" {{ old('availability', $teacher->availability) == 'freelance' ? 'selected' : '' }}>بالقطعة</option>
                                </select>
                                @error('availability')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الشهادات -->
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">الشهادات</label>
                                <textarea name="certificates"
                                          class="form-control form-control-solid @error('certificates') is-invalid @enderror"
                                          rows="3"
                                          placeholder="@lang('engineering.Enter certificates')">{{ old('certificates', $teacher->certificates) }}</textarea>
                                @error('certificates')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- الخبرات السابقة -->
                    <div class="row g-9 mb-8">
                        <div class="col-md-12">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">الخبرات السابقة</label>
                                <textarea name="previous_experience"
                                          class="form-control form-control-solid @error('previous_experience') is-invalid @enderror"
                                          rows="4"
                                          placeholder="ادخل الخبرات السابقة">{{ old('previous_experience', $teacher->previous_experience) }}</textarea>
                                @error('previous_experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- المرفقات -->
                    <div class="row g-9 mb-8">
                        <div class="col-md-12">
                            <h4 class="mb-5">المرفقات</h4>
                            <hr class="mb-5">
                        </div>

                        <div class="col-md-4">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">CV</label>
                                @if($teacher->cv_file)
                                    <div class="mb-2">
                                        <a href="{{ asset($teacher->cv_file) }}" target="_blank" class="text-primary">
                                            <i class="ki-duotone ki-file fs-2"></i> عرض ال CV
                                        </a>
                                    </div>
                                @endif
                                <input type="file"
                                       name="cv_file"
                                       class="form-control form-control-solid @error('cv_file') is-invalid @enderror"
                                       accept=".pdf,.doc,.docx" />
                                <small class="text-muted">الصيغ المسموحة: PDF, DOC, DOCX, JPG, PNG. Max size: 5MB</small>
                                @error('cv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">ملف الشهادات</label>
                                @if($teacher->certificates_file)
                                    <div class="mb-2">
                                        <a href="{{ asset($teacher->certificates_file) }}" target="_blank" class="text-primary">
                                            <i class="ki-duotone ki-file fs-2"></i> عرض ملف الشهادات
                                        </a>
                                    </div>
                                @endif
                                <input type="file"
                                       name="certificates_file"
                                       class="form-control form-control-solid @error('certificates_file') is-invalid @enderror"
                                       accept=".pdf,.doc,.docx,.jpeg,.png,.jpg" />
                                <small class="text-muted">الصيغ المسموحة: PDF, DOC, DOCX, JPG, PNG. Max size: 5MB</small>
                                @error('certificates_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">صورة الهوية الشخصية</label>
                                @if($teacher->id_photo)
                                    <div class="mb-2">
                                        <a href="{{ asset($teacher->id_photo) }}" target="_blank" class="text-primary">
                                            <i class="ki-duotone ki-file fs-2"></i> عرض صورة الهوية
                                        </a>
                                    </div>
                                @endif
                                <input type="file"
                                       name="id_photo"
                                       class="form-control form-control-solid @error('id_photo') is-invalid @enderror"
                                       accept=".pdf,.jpeg,.png,.jpg" />
                                <small class="text-muted">الصيغ المسموحة: PDF, DOC, DOCX, JPG, PNG. Max size: 5MB</small>
                                @error('id_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- تغيير كلمة المرور -->
                    <div class="row g-9 mb-8">
                        <div class="col-md-12">
                            <h4 class="mb-5">تغيير كلمة المررو</h4>
                            <hr class="mb-5">
                            <small class="text-muted d-block mb-5">اترك هذا الحقل فارغًا إذا كنت لا ترغب في تغيير كلمة المرور</small>
                        </div>

                        <div class="col-md-4">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">كلمة المرور الحالية</label>
                                <input type="password"
                                       name="current_password"
                                       class="form-control form-control-solid @error('current_password') is-invalid @enderror"
                                       placeholder="كلمة المرور الحالية" />
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">كلمة المرور الجديدة</label>
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-solid @error('password') is-invalid @enderror"
                                       placeholder="كلمة المرور الجديدة" />
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="fv-row mb-8">
                                <label class="fw-semibold fs-6 mb-2">تأكيد كلمة المرور الجديدة</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control form-control-solid"
                                       placeholder="تأكيد كلمة المرور الجديدة" />
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('teachers.profile.show') }}" class="btn btn-light">
                                    @lang('engineering.Cancel')
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ki-duotone ki-check fs-2 me-1"></i>
                                    @lang('engineering.Save Changes')
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->

    <script>
        // معاينة الصورة قبل التحميل
        function previewImage(event, elementId) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById(elementId);
                imgElement.src = reader.result;
            };
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }

        // عرض/إخفاء حقول كلمة المرور
        document.addEventListener('DOMContentLoaded', function() {
            const passwordFields = document.querySelectorAll('input[name="password"], input[name="password_confirmation"], input[name="current_password"]');
            passwordFields.forEach(field => {
                field.addEventListener('input', function() {
                    const hasValue = document.querySelector('input[name="password"]').value.length > 0;
                    document.querySelector('input[name="current_password"]').disabled = !hasValue;
                    document.querySelector('input[name="password_confirmation"]').disabled = !hasValue;
                });
            });
        });
    </script>
@endsection
