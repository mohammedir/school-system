@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Edit Student')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Student management')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.View Student')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Edit Student')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Container-->
    <div id="kt_content_container_land" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <form method="post" action="{{ route('students.update', $student->id) }}" class="form" id="kt_edit_student">
                @csrf
                <!--begin::Card - Student Details-->
                <div class="card card-flush mt-5">
                    <div class="card-header pt-8">
                        <h5>@lang('admin.Student data')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 mb-15">
                            <div class="col-md-2 fv-row">
                                <label class="form-label">@lang('admin.Student Photo')</label>
                                {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                <!--begin::Image placeholder-->
                                <style>.image-input-placeholder {
                                        background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}");
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                    }</style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline image-input-placeholder"
                                     data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-400px h-300px"
                                         style="background-image: url({{ $student->student_avatar ? asset($student->student_avatar) : asset('images/default-avatar.png') }});">
                                    </div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <!--begin::Cancel-->
                                    <!--end::Cancel-->
                                </div>
                                <!--end::Image input-->
                            </div>
                            <small class="text-muted">الحد الأدنى للأبعاد: 300 × 400 بكسل</small>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Student ID Number')</label>
                                <input class="form-control" value="{{$student->student_id}}" name="student_id" id="student_id"
                                       placeholder="@lang('admin.Student ID Number')" maxlength="9">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Student Name')</label>
                                <input class="form-control" value="{{$student->first_name}}" name="first_name" id="first_name"
                                       placeholder="@lang('admin.Student Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Father Name')</label>
                                <input class="form-control" value="{{$student->father_name}}" name="father_name" id="father_name"
                                       placeholder="@lang('admin.Father Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Grandfather Name')</label>
                                <input class="form-control" value="{{$student->grandfather_name}}" name="grandfather_name" id="grandfather_name"
                                       placeholder="@lang('admin.Grandfather Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.last Name')</label>
                                <input class="form-control" value="{{$student->last_name}}" name="last_name" id="last_name"
                                       placeholder="@lang('admin.last Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">العنوان</label>
                                <input class="form-control" value="{{$student->address}}" name="address" id="address"
                                       placeholder="ادخل العنوان">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Gender')</label>
                                <select class="form-select" name="gender" id="gender" data-control="select2"
                                        data-placeholder="@lang('admin.Select')">
                                    <option value="" disabled selected>@lang('admin.Select')</option>
                                    <option value="male" @if($student->gender == "male") selected @endif >@lang('admin.male')</option>
                                    <option value="female" @if($student->gender == "female") selected @endif >@lang('admin.female')</option>
                                </select>
                            </div>
                            <!-- تاريخ الميلاد -->
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Birth Date')</label>
                                <input type="date" class="form-control" value="{{$student->birth_date}}" id="birth_date" name="birth_date"
                                       placeholder="@lang('admin.Select birth date')">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Age Group')</label>
                                <select class="form-select" name="age_group" id="age_group" data-control="select2"
                                        data-placeholder="@lang('admin.Select')">
                                    <option value="" disabled selected>@lang('admin.Select')</option>
                                    @foreach(get_lookup_by_master_key('age_group') as $age_group)
                                        <option value="{{$age_group->id}}" @if($age_group->id == $student->age_group) selected @endif>
                                            {{$age_group->name_ar}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Class')</label>
                                <select class="form-select" disabled name="class" id="class" data-control="select2"
                                        data-placeholder="@lang('admin.Select')">
                                    <option value="" selected>@lang('admin.Select')</option>
                                    <!-- سيتم ملؤها بواسطة Ajax -->
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">

                            <!-- الحالة الصحية -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Health Status')</label>
                                <select class="form-select" name="health_status" id="health_status" data-control="select2"
                                        data-placeholder="@lang('admin.Select health status')">
                                    <option value="" disabled selected>@lang('admin.Select health status')</option>
                                    <option value="healthy" @if($student->health_status == 'healthy') selected @endif >@lang('admin.Healthy')</option>
                                    <option value="special_needs" @if($student->health_status == 'special_needs') selected @endif >@lang('admin.Special Needs')</option>
                                    <option value="chronic_disease" @if($student->health_status == 'chronic_disease') selected @endif >@lang('admin.Chronic Disease')</option>
                                </select>
                            </div>
                            <!-- حقل وصف الحالة الصحية (يظهر فقط عند اختيار special_needs أو chronic_disease) -->
                            <div class="col-md-3" id="health_status_description_container" style="display: none;">
                                <label class="form-label required">@lang('admin.Health Status Description')</label>
                                <textarea class="form-control" name="health_status_description" id="health_status_description"
                                          rows="2" placeholder="@lang('admin.Enter health status description')">{{$student->health_status_description}}</textarea>
                            </div>
                            <!-- حالة اليتم -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.orphan status')</label>
                                <select class="form-select" name="orphan_status" id="orphan_status" data-control="select2"
                                        data-placeholder="@lang('admin.Select orphan status')">
                                    <option value="" disabled selected>@lang('admin.Select orphan status')</option>
                                    <option value="not_an_orphan" @if($student->orphan_status == 'not_an_orphan') selected @endif >@lang('admin.Not an orphan')</option>
                                    <option value="father_is_an_orphan" @if($student->orphan_status == 'father_is_an_orphan') selected @endif >@lang('admin.Father is an orphan')</option>
                                    <option value="mother_is_an_orphan"@if($student->orphan_status == 'mother_is_an_orphan') selected @endif >@lang('admin.Mother is an orphan')</option>
                                    <option value="both_mother_and_father_are_orphans" @if($student->orphan_status == 'both_mother_and_father_are_orphans') selected @endif >@lang('admin.Both mother and father are orphans')</option>
                                </select>
                            </div>
                            <!-- حالة المواطنة -->
                            <div class="col-md-3">
                                <label class="form-label required">حالة المواطنة</label>
                                <select class="form-select" name="citizenship_status" id="citizenship_status" data-control="select2"
                                        data-placeholder="اختر حالة المواطنة">
                                    <option value="" disabled selected>اختر حالة المواطنة</option>
                                    <option value="citizen" @if($student->citizenship_status == "citizen") selected @endif>مواطن</option>
                                    <option value="refugee" @if($student->citizenship_status == "refugee") selected @endif>لاجيء</option>
                                </select>
                            </div>
                            <!-- هوية ولي الامر -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Parent ID Number')</label>
                                <input class="form-control" value="{{$student->parent_id}}" id="parent_id" name="parent_id" type="text"
                                       maxlength="9" data-rule-minlength="9"
                                       placeholder="@lang('admin.Enter parent ID number')">
                            </div>

                            <!-- اسم ولي الامر -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Parent Name')</label>
                                <input class="form-control" value="{{$student->parent_name}}" id="parent_name" name="parent_name" type="text"
                                       placeholder="@lang('admin.Enter parent full name')">
                            </div>

                            <!-- رقم التواصل -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Contact number')</label>
                                <input class="form-control" value="{{$student->mobile}}" id="mobile" name="mobile" type="text"
                                       maxlength="10" data-rule-minlength="10"
                                       placeholder="@lang('admin.Enter Mobile number')">
                            </div>

                            <!-- رقم التواصل بديل -->
                            <div class="col-md-3">
                                <label class="form-label">@lang('admin.Alternative contact number')</label>
                                <input class="form-control" value="{{$student->alternate_mobile}}" id="alternate_mobile" name="alternate_mobile" type="text"
                                       maxlength="10"
                                       placeholder="@lang('admin.Enter Mobile number')">
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </form>


        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    <style>
        #preview_images {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }

        .position-relative {
            position: relative;
        }
    </style>
    <script>
        let selectedImages = [];

        document.getElementById('land_images').addEventListener('change', function (event) {
            const newFiles = Array.from(event.target.files);
            const file = event.target.files[0];

            if (file) {
                const maxSize = 3 * 1024 * 1024; // ✅ 3MB

                if (file.size > maxSize) {
                    alert('حجم الصورة يجب أن لا يتجاوز 3 ميغابايت (3MB)');
                    event.target.value = ''; // مسح الملف المختار
                } else {
                    // أضف الملفات الجديدة إلى المصفوفة الأصلية
                    selectedImages = selectedImages.concat(newFiles);

                    updatePreview();
                }
            }

        });

        function updatePreview() {
            const preview = document.getElementById('preview_images');
            preview.innerHTML = '';

            selectedImages.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.className = 'position-relative'; // إزالة col من bootstrap

                    col.innerHTML = `
                <div class="card shadow-sm h-100">
                    <div class="card-body p-2 d-flex align-items-center justify-content-center">
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;" />
                    </div>
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-image" data-index="${index}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                    preview.appendChild(col);
                };

                reader.readAsDataURL(file);
            });

            // تحديث ملفات input
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => dataTransfer.items.add(file));
            document.getElementById('land_images').files = dataTransfer.files;
        }

        // حذف صورة عند الضغط على زر X
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-image')) {
                const btn = e.target.closest('.remove-image');
                const index = parseInt(btn.getAttribute('data-index'));

                selectedImages.splice(index, 1); // حذف من المصفوفة
                updatePreview(); // إعادة عرض الصور
            }
        });
    </script>


    @include("admin.Students.Partial.viewStudent_js")

@endsection

