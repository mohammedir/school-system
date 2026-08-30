@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Starting the investment phase')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Projects')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Starting the investment phase')</li>
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
    <div id="kt_content_container_project" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Card - Project Info-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <h3>@lang('engineering.Project Data')</h3>
                        <div class="d-flex align-items-center gap-2">
                            <!--begin::Input-->
                            <input class="form-control" type="text" name="project_title" id="project_title"  disabled value="{{$project->title}}">
                            <input class="form-control" type="hidden" name="project_id" id="project_id"  disabled value="{{$project->id}}">
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Form-->
                    <!-- Student details will be loaded here -->
                    <div id="project_details" style="display: none;">
                        <!-- content will be injected here by AJAX -->
                    </div>

                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Card-->
            <div class="card card-flush mt-5">
                <div class="card-header pt-8">
                    <h5>📑 عرض الوحدات </h5>
                </div>
                <div class="card-body">
                    <div class="wrapper">
                        <div class="content-wrapper">
                            <div id="floors-repeater">
                                @foreach($floors as $floorIndex => $floor)
                                    <div class="card mb-5 shadow-sm floor-wrapper">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0 floor-number">🗂️ بيانات الطابق </h5>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-secondary toggle-collapse">⯆</button>
                                            </div>
                                        </div>
                                        <div class="collapse show card-collapse">
                                            <div class="card-body">
                                                <div class="col-md-2 fv-row mb-3">
                                                    <label class="required form-label">صورة الطابق</label>
                                                    {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                                    <!--begin::Image placeholder-->
                                                    <style>.image-input-placeholder { background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                                    <!--end::Image placeholder-->
                                                    <!--begin::Image input-->
                                                    <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                        <div class="image-input-wrapper w-700px h-350px" style="background-image: url({{asset('/uploads/projects/' . $floor->image)}});"></div>
                                                        <!--end::Preview existing avatar-->
                                                        <!--begin::Label-->
                                                        @if(!$project->isUnitsAdded())
                                                            <label class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="@lang('admin.Change avatar')">
                                                                <i class="ki-duotone ki-pencil fs-7">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <!--begin::Inputs-->
                                                                <input type="hidden" name="floors[{{ $floorIndex }}][hidden_image]" value="{{$floor->image}}">
                                                                <input type="file" name="floors[{{ $floorIndex }}][image]" accept=".png, .jpg, .jpeg" />
                                                                <input type="hidden" name="floors[{{$floorIndex}}][avatar_remove]" />

                                                                <!--end::Inputs-->
                                                            </label>
                                                        @endif
                                                        <!--end::Label-->
                                                        <!--begin::Cancel-->
                                                        <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                                        <!--end::Cancel-->
                                                        <!--begin::Remove-->
                                                        @if(!$project->isUnitsAdded())
                                                            <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="@lang('admin.Remove avatar')">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                                        @endif
                                                        <!--end::Remove-->
                                                    </div>
                                                    <!--end::Image input-->


                                                </div>
                                                <small class="text-muted">الحد الأدنى للأبعاد: 350 × 700 بكسل</small>
                                                <div class="mb-3">
                                                    <label class="form-label">رقم/وصف الطابق</label>
                                                    <input readonly type="text" name="floors[{{ $floorIndex }}][description]" class="form-control" placeholder="مثلاً الطابق الأرضي، الأول، الثاني ..." value="{{$floor->description}}">
                                                </div>

                                                <hr class="my-4">

                                                <h6 class="mb-3">🛏️ الوحدات في هذا الطابق</h6>

                                                <!-- nested repeater للـ units داخل هذا الطابق -->
                                                <div class="units-repeater">
                                                    @foreach($floor->children as $unitIndex => $unit)
                                                        <div class="unit-wrapper">
                                                            <div  class="row align-items-end mb-3">
                                                                <div class="col-md-2">
                                                                    <label class="form-label required">رقم / رمز الوحدة</label>
                                                                    <input disabled type="text" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][description]" class="form-control" required value="{{$unit->description}}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label required">نوع الوحدة</label>
                                                                    <select disabled class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][unit_type_cd]" required>
                                                                        @foreach(get_lookup_by_master_key('unit_type') as $unit_type)
                                                                            <option value="{{ $unit_type->id }}" {{ $unit_type->id == $unit->unit_type_cd ? 'selected' : '' }}>
                                                                                {{ $unit_type->name_ar }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label required">المساحة</label>
                                                                    <input disabled type="number" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][area]" class="form-control" required value="{{$unit->area}}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label">عدد الغرف</label>
                                                                    <input disabled type="number" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][rooms]" class="form-control" value="{{$unit->rooms}}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label">عدد الحمامات</label>
                                                                    <input disabled type="number" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][bathrooms]" class="form-control" value="{{$unit->bathrooms}}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="form-label">تفاصيل التشطبيات</label>
                                                                    <textarea disabled name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][finishing_details]" class="form-control">{{$unit->finishing_details}}</textarea>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="form-label">@lang('admin.Valuation price')</label>
                                                                    <div class="input-group">
                                                                        <input type="hidden" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][unit_id]" value="{{$unit->id}}">
                                                                        <input  disabled   type="text" value="{{$unit->valuation_price}}" class="form-control valuation_price_input number_format" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][valuation_price]" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
                                                                        <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label">@lang('admin.Number of shares')</label>
                                                                    <div class="input-group">
                                                                        <input  disabled   type="text" value="{{$unit->valuation_price/1000}}" class="form-control valuation_price_input number_format" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][valuation_price]" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            <!--end::Card-->
            <div class="card card-flush mt-5">
                <div class="card-header pt-8 text-primary">
                    <h5>إضافة صورة المشروع وتحديد كونه مميز او لا</h5>
                </div>
                <div class="card-body">
                    <div class="wrapper">
                        <div class="content-wrapper">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('projects.project_start_investing', $project->id) }}" method="POST" enctype="multipart/form-data" class="card p-5 shadow-sm">
                                @csrf
                                <!-- صورة المشروع -->
                                <div class="mb-4">
                                    <label class="form-label required fw-semibold">
                                        الرجاء ارفاق الصورة التي ستظهر للمشروع في الموقع
                                    </label>
                                    <div class="mb-3">
                                        {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                        <!--begin::Image placeholder-->
                                        <style>.image-input-placeholder { background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                        <!--end::Image placeholder-->
                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                            <div class="image-input-wrapper w-700px h-350px" style="background-image: url({{asset('/uploads/projects/' . 1)}});"></div>
                                            <!--end::Preview existing avatar-->
                                            <!--begin::Label-->
                                            <label class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="@lang('admin.Change avatar')">
                                                <i class="ki-duotone ki-pencil fs-7">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <!--begin::Inputs-->
                                                <input type="hidden" name="hidden_image" value="">
                                                <input type="file" name="cover_image" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />

                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Cancel-->
                                            <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                            <!--end::Cancel-->
                                            <!--begin::Remove-->
                                            <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="@lang('admin.Remove avatar')">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->
                                    </div>
                                    <small class="text-muted d-block">
                                        <i class="bi bi-info-circle me-1"></i>
                                        الحد الأدنى للأبعاد: 600 × 500 بكسل
                                    </small>
                                </div>

                                <div class="row g-4 mb-15">
                                    <div class="col-md-12">
                                        <label class="form-label">@lang('admin.Project photos')</label>
                                        <input type="file" id="land_images" class="form-control" name="project_images[]" multiple accept="image/*">
                                        <input type="hidden" name="deleted_images" id="deleted_images" value="[]">

                                        <div class="row mt-4" id="preview_images" style="gap: 15px;"></div>
                                    </div>
                                </div>
                                <!-- حقل مميز -->
                                <div class="mb-4 form-check">
                                    <input
                                        type="checkbox"
                                        name="project_special"
                                        id="is_special"
                                        class="form-check-input"
                                        value="1">
                                    <label class="form-check-label ms-2" for="is_special">
                                        هل تريد تحديد المشروع كمميز؟
                                    </label>
                                </div>

                                <!-- زر الإرسال -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-floppy2-fill me-1"></i> @lang('admin.Turning the project into an investment opportunity')
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    <script>
        const $input = $('input[name="project_id"]');

        function loadProjectDetails(project_id) {
            if (project_id) {
                $.ajax({
                    url: '{{ route("projects.getProjectsDetails") }}',
                    type: 'GET',
                    data: { id: project_id },
                    success: function (response) {
                        console.log(response);
                        $('#project_details').html(response).fadeIn();
                    },
                    error: function () {
                        $('#project_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                    }
                });
            } else {
                $('#project_details').fadeOut().html('');
            }
        }

        // Handle ENTER press
        $input.on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                loadProjectDetails($(this).val());
            }
        });
        // Also handle blur (when user leaves the field)
        $input.on('blur', function () {
            loadProjectDetails($(this).val());
        });

        // Optionally: Load initially if value is pre-filled
        if ($input.val()) {
            loadProjectDetails($input.val());
        }

    </script>
    <script>
        let selectedImages = [];

        document.getElementById('land_images').addEventListener('change', function (event) {
            const newFiles = Array.from(event.target.files);

            // أضف الملفات الجديدة إلى المصفوفة الأصلية
            selectedImages = selectedImages.concat(newFiles);

            updatePreview();
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

@endsection

