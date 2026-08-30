@extends('teacher.layouts.master')
@section('content')
    <style>
        .card-header {
            background-color: #f5f5f5;
        }

        .card {
            border-radius: 12px;
        }
    </style>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif


    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('engineering.Enter Project Units')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.dashboardController')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.My projects')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.Enter Units')</li>
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
            <!--begin::Card - Project Info-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <h3>@lang('engineering.Project Data')</h3>
                        <div class="d-flex align-items-center gap-2">
                            <!--begin::Input-->
                            <select disabled id="project_id" name="project_id" aria-label="Select a Language"
                                    data-control="select2" data-placeholder="@lang('engineering.Project Data')"
                                    class="form-select mb-2">
                                <option></option>
                                @foreach($offers as $offer)
                                    <option value="{{$offer->project->id}}"
                                            @if($project_id == $offer->project->id ) selected @endif>{{ $offer->project->title }}</option>
                                @endforeach
                            </select>
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

            <!--begin::Card -  Units Details-->
            <div class="card card-flush mt-5">
                <div class="card-header pt-8">
                    <h5>📑 إضافة الطوابق والوحدات</h5>
                </div>
                <div class="card-body">
                    {{--<form action="{{ route('engineering.my_projects.saveProjectUnits') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ getEngineeringOffer($offers_id)->project->id }}">
                        <div class="container py-5">
                            <div id="floors_repeater">
                                <div data-repeater-list="floors">
                                    <div data-repeater-item class="card mb-5 shadow-sm">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">🗂️ بيانات الطابق</h5>
                                            <button type="button" data-repeater-delete class="btn btn-sm btn-danger">
                                                🗑️ حذف الطابق
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">رقم/وصف الطابق</label>
                                                <input type="text" name="description" class="form-control" placeholder="مثلاً الطابق الأرضي، الأول، الثاني ...">
                                            </div>

                                            <hr class="my-4">

                                            <h6 class="mb-3">🛏️ الوحدات في هذا الطابق</h6>

                                            <!-- nested repeater للـ units داخل هذا الطابق -->
                                            <div class="units-repeater">
                                                <div data-repeater-list="units">
                                                    <div data-repeater-item class="row align-items-end mb-3">
                                                        <div class="col-md-2">
                                                            <label class="form-label required">رقم / رمز الوحدة</label>
                                                            <input type="text" name="description" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label required">نوع الوحدة</label>
                                                            <input type="text" name="unit_type_cd" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label required">المساحة</label>
                                                            <input type="number" name="area" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label class="form-label">عدد الغرف</label>
                                                            <input type="number" name="rooms" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">عدد الحمامات</label>
                                                            <input type="number" name="bathrooms" class="form-control">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">تفاصيل التشطبيات</label>
                                                            <textarea name="finishing_details" class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-center">
                                                            <button type="button" data-repeater-delete class="btn btn-sm btn-light-danger">
                                                                ❌ حذف
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" data-repeater-create class="btn btn-light-primary btn-sm mt-2">
                                                    ➕ إضافة وحدة
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" data-repeater-create class="btn btn-success mt-3">
                                    ➕ إضافة طابق
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-primary mt-4" type="submit">حفظ</button>
                    </form>--}}
                    <style>
                        /*.floor-wrapper {
                            margin-bottom: 20px;
                            padding: 15px;
                            border: 1px solid #dee2e6;
                            border-radius: 5px;
                            background-color: #f8f9fa;
                        }*/
                        /*.unit-wrapper {
                            margin-top: 15px;
                            padding: 10px;
                            border: 1px dashed #adb5bd;
                            border-radius: 5px;
                            background-color: #fff;
                        }*/
                        .floor-header, .unit-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 10px;
                        }
                    </style>

                    <div class="wrapper">
                        <div class="content-wrapper">
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary mt-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">@lang('engineering.Manage Floors and Units')</h3>
                                                </div>
                                                {{--<form action="{{ route('engineering.my_projects.saveProjectUnits') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="project_id" value="{{$project_id}}">

                                                    <div class="card-body">
                                                        <h4>@lang('engineering.Floors')</h4>
                                                        <div id="floors-repeater">
                                                            <!-- Floors will be added here -->
                                                            @foreach($floors as $floorIndex => $floor)
                                                                <div class="floor-wrapper">
                                                                    <div class="floor-header">
                                                                        <h5>@lang('engineering.Floor') <span class="floor-number">{{ $floorIndex + 1 }}</span></h5>
                                                                        <button type="button" class="btn btn-danger btn-xs remove-floor">
                                                                            <i class="fas fa-times"></i> @lang('admin.Delete')
                                                                        </button>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="required">@lang('engineering.Floor Name')</label>
                                                                                <input type="text" class="form-control" name="floors[{{ $floorIndex }}][description]" value="{{ $floor->description }}" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <h6 class="mt-2">@lang('engineering.Units')</h6>
                                                                    <div class="units-repeater">
                                                                        @foreach($floor->children as $unitIndex => $unit)
                                                                            <div class="unit-wrapper">
                                                                                <div class="unit-header">
                                                                                    <h6>@lang('engineering.Unit')</h6>
                                                                                    <button type="button" class="btn btn-danger btn-xs remove-unit">
                                                                                        <i class="fas fa-times"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-2 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label class="required">@lang('engineering.Unit Name')</label>
                                                                                            <input type="text" class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][description]" value="{{ $unit->description }}" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label class="required">@lang('engineering.Unit Type')</label>
                                                                                            <select class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][unit_type_cd]" required>
                                                                                                @foreach(get_lookup_by_master_key('unit_type') as $unit_type)
                                                                                                    <option value="{{ $unit_type->id }}" {{ $unit_type->id == $unit->unit_type_cd ? 'selected' : '' }}>
                                                                                                        {{ $unit_type->name_ar }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label class="required">@lang('engineering.Area') (م2)</label>
                                                                                            <input type="number" step="0.01" class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][area]" value="{{ $unit->area }}" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label>@lang('engineering.Number of rooms')</label>
                                                                                            <input type="number" class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][rooms]" value="{{ $unit->rooms }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label>@lang('engineering.Number of bathrooms')</label>
                                                                                            <input type="number" class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][bathrooms]" value="{{ $unit->bathrooms }}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-2 mt-4">
                                                                                        <div class="form-group">
                                                                                            <label>@lang('engineering.Finishing details')</label>
                                                                                            <input type="text" class="form-control" name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][finishing_details]" value="{{ $unit->finishing_details }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <button type="button" class="btn btn-info btn-xs add-unit mt-4">
                                                                        <i class="fas fa-plus"></i> @lang('engineering.Add Unit')
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button type="button" id="add-floor" class="btn btn-default mt-2">
                                                            <i class="fas fa-plus"></i> @lang('engineering.Add a floor')
                                                        </button>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary">@lang('admin.Submit')</button>
                                                    </div>
                                                </form>--}}
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <form action="{{ route('engineering.my_projects.saveProjectUnits') }}"
                                                      method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="project_id" value="{{$project_id}}">
                                                    <div class="container py-5">
                                                        <div id="floors-repeater">
                                                            @foreach($floors as $floorIndex => $floor)
                                                                <div class="card mb-5 shadow-sm floor-wrapper">
                                                                    <div
                                                                        class="card-header d-flex justify-content-between align-items-center">
                                                                        <h5 class="mb-0 floor-number">🗂️ بيانات
                                                                            الطابق </h5>
                                                                        <div>
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-secondary toggle-collapse">
                                                                                ⯆
                                                                            </button>
                                                                            @if(!$project->isUnitsAdded())
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-info copy-floor">
                                                                                    📄 نسخ الطابق
                                                                                </button>
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-danger remove-floor">
                                                                                    🗑️ حذف الطابق
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="collapse show card-collapse">
                                                                        <div class="card-body">
                                                                            <div class="col-md-2 fv-row mb-3">
                                                                                <label class="required form-label">صورة
                                                                                    الطابق</label>
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
                                                                                <div
                                                                                    class="image-input image-input-outline image-input-placeholder"
                                                                                    data-kt-image-input="true">
                                                                                    <div
                                                                                        class="image-input-wrapper w-700px h-350px"
                                                                                        style="background-image: url({{asset('/uploads/projects/' . $floor->image)}});"></div>
                                                                                    <!--end::Preview existing avatar-->
                                                                                    <!--begin::Label-->
                                                                                    @if(!$project->isUnitsAdded())
                                                                                        <label
                                                                                            class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                                                                            data-kt-image-input-action="change"
                                                                                            data-bs-toggle="tooltip"
                                                                                            title="@lang('admin.Change avatar')">
                                                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                                                <span
                                                                                                    class="path1"></span>
                                                                                                <span
                                                                                                    class="path2"></span>
                                                                                            </i>
                                                                                            <!--begin::Inputs-->
                                                                                            <input type="hidden"
                                                                                                   name="floors[{{ $floorIndex }}][hidden_image]"
                                                                                                   value="{{$floor->image}}">
                                                                                            <input type="file"
                                                                                                   name="floors[{{ $floorIndex }}][image]"
                                                                                                   accept=".png, .jpg, .jpeg"/>
                                                                                            <input type="hidden"
                                                                                                   name="floors[{{$floorIndex}}][avatar_remove]"/>

                                                                                            <!--end::Inputs-->
                                                                                        </label>
                                                                                    @endif
                                                                                    <!--end::Label-->
                                                                                    <!--begin::Cancel-->
                                                                                    <span
                                                                                        class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                                                                        data-kt-image-input-action="cancel"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                                                                    <!--end::Cancel-->
                                                                                    <!--begin::Remove-->
                                                                                    @if(!$project->isUnitsAdded())
                                                                                        <span
                                                                                            class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                                                                            data-kt-image-input-action="remove"
                                                                                            data-bs-toggle="tooltip"
                                                                                            title="@lang('admin.Remove avatar')">
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
                                                                            <small class="text-muted">الحد الاقصى للحجم
                                                                                الصورة 2MB ويقبل فقط صيغ
                                                                                jpeg,png,jpg</small>

                                                                            <div class="mb-5">
                                                                                <label class="form-label required">رقم/وصف
                                                                                    الطابق</label>
                                                                                <input
                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                    @endif type="text"
                                                                                    name="floors[{{ $floorIndex }}][description]"
                                                                                    class="form-control"
                                                                                    placeholder="مثلاً الطابق الأرضي، الأول، الثاني ..."
                                                                                    value="{{$floor->description}}"
                                                                                    required>
                                                                            </div>

                                                                            <hr class="my-4">

                                                                            <h6 class="mb-3">🛏️ الوحدات في هذا
                                                                                الطابق</h6>

                                                                            <!-- nested repeater للـ units داخل هذا الطابق -->
                                                                            <div class="units-repeater">
                                                                                @foreach($floor->children as $unitIndex => $unit)
                                                                                    <div class="unit-wrapper">
                                                                                        <div
                                                                                            class="row align-items-end mb-3">
                                                                                            <div class="col-md-2">
                                                                                                <label
                                                                                                    class="form-label required">رقم
                                                                                                    / رمز الوحدة</label>
                                                                                                <input
                                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                                    @endif type="text"
                                                                                                    name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][description]"
                                                                                                    class="form-control"
                                                                                                    required
                                                                                                    value="{{$unit->description}}">
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label
                                                                                                    class="form-label required">نوع
                                                                                                    الوحدة</label>
                                                                                                <select
                                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                                    @endif class="form-control"
                                                                                                    name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][unit_type_cd]"
                                                                                                    required>
                                                                                                    @foreach(get_lookup_by_master_key('unit_type') as $unit_type)
                                                                                                        <option
                                                                                                            value="{{ $unit_type->id }}" {{ $unit_type->id == $unit->unit_type_cd ? 'selected' : '' }}>
                                                                                                            {{ $unit_type->name_ar }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label
                                                                                                    class="form-label required">المساحة</label>
                                                                                                <input
                                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                                    @endif type="number"
                                                                                                    name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][area]"
                                                                                                    class="form-control"
                                                                                                    required
                                                                                                    value="{{$unit->area}}">
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label
                                                                                                    class="form-label">عدد
                                                                                                    الغرف</label>
                                                                                                <input
                                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                                    @endif type="number"
                                                                                                    name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][rooms]"
                                                                                                    class="form-control"
                                                                                                    value="{{$unit->rooms}}">
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label
                                                                                                    class="form-label">عدد
                                                                                                    الحمامات</label>
                                                                                                <input
                                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                                    @endif type="number"
                                                                                                    name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][bathrooms]"
                                                                                                    class="form-control"
                                                                                                    value="{{$unit->bathrooms}}">
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label
                                                                                                    class="form-label">تفاصيل
                                                                                                    التشطبيات</label>
                                                                                                <textarea
                                                                                                    @if($project->isUnitsAdded()) disabled
                                                                                                    @endif name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][finishing_details]"
                                                                                                    class="form-control">{{$unit->finishing_details}}</textarea>
                                                                                            </div>
                                                                                            @if(!$project->isUnitsAdded())
                                                                                                <div
                                                                                                    class="col-md-1 d-flex align-items-center">
                                                                                                    <button
                                                                                                        type="button"
                                                                                                        class="btn btn-sm btn-light-danger remove-unit">
                                                                                                        ❌ حذف
                                                                                                    </button>
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                            @if(!$project->isUnitsAdded())
                                                                                <button type="button"
                                                                                        class="btn btn-light-primary btn-sm mt-2 add-unit">
                                                                                    ➕ إضافة وحدة
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @if(!$project->isUnitsAdded())
                                                            <button type="button" id="add-floor"
                                                                    class="btn btn-success mt-3">
                                                                ➕ إضافة طابق
                                                            </button>
                                                        @endif
                                                    </div>
                                                    @if(!$project->isUnitsAdded())
                                                        <div class="card-footer">
                                                            <input type="hidden" name="action" id="hidden-action">
                                                            <button type="submit" name="action" value="submit"
                                                                    id="normal-submit" class="btn btn-primary">
                                                                <span
                                                                    class="indicator-label">@lang('admin.Submit')</span>
                                                                <span class="indicator-progress">@lang('admin.Please wait...')
                                                                    <span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                            <button type="submit" name="action"
                                                                    value="send_to_valuation" id="valuation-submit"
                                                                    class="btn btn-success">
                                                                <span class="indicator-label">إرسال للتثمين</span>
                                                                <span class="indicator-progress">@lang('admin.Please wait...')
                                                                    <span
                                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>

                                                        </div>
                                                    @endif

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <!-- Floor Template (hidden) -->
                    <div id="floor-template" style="display: none;">
                        {{--<div class="floor-wrapper">
                            <div class="floor-header">
                                <h5>@lang('engineering.Floor')<span class="floor-number">1</span></h5>
                                <button type="button" class="btn btn-danger btn-xs remove-floor">
                                    <i class="fas fa-times"></i> @lang('admin.Delete')
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="required">@lang('engineering.Floor Name')</label>
                                        <input type="text" class="form-control" name="floors[0][description]" required>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mt-2">@lang('engineering.Units')</h6>
                            <div class="units-repeater">
                                <!-- Units will be added here -->
                            </div>
                            <button type="button" class="btn btn-info btn-xs add-unit mt-4">
                                <i class="fas fa-plus"></i> @lang('engineering.Add Unit')
                            </button>
                        </div>--}}
                        <div class="card mb-5 shadow-sm floor-wrapper">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 floor-number">🗂️ بيانات الطابق 1</h5>
                                <div>
                                    <button type="button" class="btn btn-sm btn-info copy-floor">📄 نسخ الطابق</button>
                                    <button type="button" data-repeater-delete
                                            class="btn btn-sm btn-danger remove-floor">
                                        🗑️ حذف الطابق
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-md-2 fv-row mb-3">
                                    <label class="required form-label">صورة الطابق</label>
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
                                        <div class="image-input-wrapper w-700px h-350px"
                                             style="background-image: url({{asset('/uploads/project.jpg/')}});"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Label-->
                                        <label
                                            class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                            title="@lang('admin.Change avatar')">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--begin::Inputs-->
                                            <input type="hidden" name="floors[0][hidden_image]">
                                            <input type="file" name="floors[0][image]" accept=".png, .jpg, .jpeg"/>
                                            <input type="hidden" name="floors[0][avatar_remove]"/>
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Cancel-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                            title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span
                                            class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                            title="@lang('admin.Remove avatar')">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->


                                </div>
                                <small class="text-muted">الحد الاقصى للحجم الصورة 2MB ويقبل فقط صيغ
                                    jpeg,png,jpg</small>
                                <div class="mb-5">
                                    <label class="form-label required">رقم/وصف الطابق</label>
                                    <input type="text" name="floors[0][description]" class="form-control"
                                           placeholder="مثلاً الطابق الأرضي، الأول، الثاني ..." required>
                                </div>

                                <hr class="my-4">

                                <h6 class="mb-3">🛏️ الوحدات في هذا الطابق</h6>

                                <!-- nested repeater للـ units داخل هذا الطابق -->
                                <div class="units-repeater">
                                    <!-- Units will be added here -->
                                </div>
                                <button type="button" class="btn btn-light-primary btn-sm mt-2 add-unit">
                                    <i class="fas fa-plus"></i> @lang('engineering.Add Unit')
                                </button>

                            </div>
                        </div>

                    </div>

                    <!-- Unit Template (hidden) -->
                    <div id="unit-template" style="display: none;">
                        {{--<div class="unit-wrapper">
                            <div class="unit-header">
                                <h6>@lang('engineering.Unit')</h6>
                                <button type="button" class="btn btn-danger btn-xs remove-unit">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label class="required">@lang('engineering.Unit Name')</label>
                                        <input type="text" class="form-control" name="floors[0][units][0][description]" required>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label class="required">@lang('engineering.Unit Type')</label>
                                        <select class="form-control" name="floors[0][units][0][unit_type_cd]" required>
                                            @foreach(get_lookup_by_master_key('unit_type') as $unit_type)
                                                <option value="{{ $unit_type->id }}">{{ $unit_type->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label class="required">@lang('engineering.Area') (م2)</label>
                                        <input type="number" step="0.01" class="form-control" name="floors[0][units][0][area]" required>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label>@lang('engineering.Number of rooms')</label>
                                        <input type="number" step="0.01" class="form-control" name="floors[0][units][0][rooms]">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label>@lang('engineering.Number of bathrooms') </label>
                                        <input type="number" step="0.01" class="form-control" name="floors[0][units][0][bathrooms]">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label>@lang('engineering.Finishing details') </label>
                                        <input type="text" step="0.01" class="form-control" name="floors[0][units][0][finishing_details]">
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                        <div class="unit-wrapper">
                            <div class="row align-items-end mb-3">
                                <div class="col-md-2">
                                    <label class="form-label required">رقم / رمز الوحدة</label>
                                    <input type="text" name="floors[0][units][0][description]" class="form-control"
                                           required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">نوع الوحدة</label>
                                    <select class="form-control" name="floors[0][units][0][unit_type_cd]" required>
                                        @foreach(get_lookup_by_master_key('unit_type') as $unit_type)
                                            <option value="{{ $unit_type->id }}">
                                                {{ $unit_type->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">المساحة</label>
                                    <input type="number" name="floors[0][units][0][area]" class="form-control" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">عدد الغرف</label>
                                    <input type="number" name="floors[0][units][0][rooms]" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">عدد الحمامات</label>
                                    <input type="number" name="floors[0][units][0][bathrooms]" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">تفاصيل التشطبيات</label>
                                    <textarea name="floors[0][units][0][finishing_details]"
                                              class="form-control"></textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" data-repeater-delete
                                            class="btn btn-sm btn-light-danger remove-unit">
                                        ❌ حذف
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Card-->

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("teacher.projects_management.my_projects.Partial.enter_units_js")
    <script>
        $(document).ready(function () {
            // Initialize floor counter
            let unitCounters = {};

            // 🟢 اجعل floorCount يساوي عدد الطوابق المعروضة فعلا
            let floorCount = $('#floors-repeater .floor-wrapper').length;

            // 🟢 املا unitCounters بالوحدات الحالية
            initializeUnitCounters();


            // Add floor button click handler
            $('#add-floor').click(function () {
                addFloor();
            });

            // Function to add a new floor
            function addFloor() {
                const floorTemplate = $('#floor-template').html();
                const $newFloor = $(floorTemplate);
                const currentFloorIndex = floorCount;

                // Update floor index in all inputs
                $newFloor.find('[name^="floors["]').each(function () {
                    let name = $(this).attr('name')
                        .replace(/floors\[\d+\]/g, `floors[${currentFloorIndex}]`)
                        .replace(/floors\[\d+\]\[units\]\[\d+\]/g, `floors[${currentFloorIndex}][units][0]`);
                    $(this).attr('name', name);
                });

                // Update floor number display
                $newFloor.find('.floor-number').text('🗂️ بيانات الطابق');

                // generate unique id
                let uniqueId = 'imageInput_' + Date.now();
                $newFloor.find('.image-input').attr('id', uniqueId);

                // Add to DOM
                $('#floors-repeater').append($newFloor);

                // activate image-input plugin
                new KTImageInput(document.getElementById(uniqueId));


                // Initialize unit counter for this floor
                unitCounters[currentFloorIndex] = 0;

                // Add first unit to the new floor
                addUnit(currentFloorIndex);

                // Handle unit addition for this floor
                /*$newFloor.find('.add-unit').click(function() {
                    addUnit(currentFloorIndex);
                });*/
                $newFloor.find('.remove-floor').click(function () {
                    addUnit(currentFloorIndex);
                });

                floorCount++;
            }

            // Function to add a new unit to a floor
            function addUnit(floorIndex) {
                const unitTemplate = $('#unit-template').html();
                const $newUnit = $(unitTemplate);
                const currentUnitIndex = unitCounters[floorIndex];

                // Update unit index in all inputs
                $newUnit.find('[name^="floors["]').each(function () {
                    let name = $(this).attr('name')
                        .replace(/floors\[\d+\]\[units\]\[\d+\]/g, `floors[${floorIndex}][units][${currentUnitIndex}]`);
                    $(this).attr('name', name);
                });

                // Add to DOM
                $(`#floors-repeater .floor-wrapper:eq(${floorIndex}) .units-repeater`).append($newUnit);

                // Handle unit removal
                $newUnit.find('.remove-unit').click(function () {
                    $(this).closest('.unit-wrapper').remove();
                });

                unitCounters[floorIndex]++;
            }

            // Function to update floor numbers display
            function updateFloorNumbers() {
                $('#floors-repeater .floor-wrapper').each(function (index) {
                    $(this).find('.floor-number').text(index + 1);
                });
            }

            // Fix array indices before form submission
            $('#propertyForm').on('submit', function () {
                $('#floors-repeater .floor-wrapper').each(function (floorIndex) {
                    // Update floor inputs
                    $(this).find('[name^="floors["]').each(function () {
                        let name = $(this).attr('name')
                            .replace(/floors\[\d+\]/g, `floors[${floorIndex}]`);
                        $(this).attr('name', name);
                    });

                    // Update unit inputs for this floor
                    $(this).find('.unit-wrapper').each(function (unitIndex) {
                        $(this).find('[name^="floors["]').each(function () {
                            let name = $(this).attr('name')
                                .replace(/floors\[\d+\]\[units\]\[\d+\]/g, `floors[${floorIndex}][units][${unitIndex}]`);
                            $(this).attr('name', name);
                        });
                    });
                });
                return true;
            });

            function initializeUnitCounters() {
                unitCounters = {};
                $('#floors-repeater .floor-wrapper').each(function (floorIndex) {
                    let existingUnitsCount = $(this).find('.unit-wrapper').length;
                    unitCounters[floorIndex] = existingUnitsCount;
                });
            }

            $(document).on('click', '.remove-floor', function () {
                $(this).closest('.floor-wrapper').remove();
                /*updateFloorNumbers();*/
            });
            // حذف وحدة لأي طابق
            $(document).on('click', '.remove-unit', function () {
                $(this).closest('.unit-wrapper').remove();
            });

// إضافة وحدة لأي طابق
            $(document).on('click', '.add-unit', function () {
                const $floor = $(this).closest('.floor-wrapper');
                const floorIndex = $floor.index();

                const unitTemplate = $('#unit-template').html();
                const $newUnit = $(unitTemplate);

                // حساب كم وحدة موجودة حاليا
                const unitCount = $floor.find('.unit-wrapper').length;

                // ضبط أسماء الحقول
                $newUnit.find('[name^="floors["]').each(function () {
                    let name = $(this).attr('name')
                        .replace(/floors\[\d+\]\[units\]\[\d+\]/g, `floors[${floorIndex}][units][${unitCount}]`);
                    $(this).attr('name', name);
                });

                // إضافته داخل الطابق
                $floor.find('.units-repeater').append($newUnit);
            });

            // عند محاولة إرسال النموذج
            $('form').on('submit', function (e) {
                var floorCount = $('#floors-repeater .floor-wrapper').length;

                if (floorCount === 0) {
                    e.preventDefault(); // منع الإرسال
                    alert('يجب إضافة طابق واحد على الأقل قبل حفظ البيانات.');
                }
            });

            $(document).on('click', '.toggle-collapse', function () {
                const $collapse = $(this).closest('.floor-wrapper').find('.card-collapse');
                $collapse.collapse('toggle');

                // تبديل الأيقونة
                $collapse.on('shown.bs.collapse', () => {
                    $(this).text('⯅');
                });
                $collapse.on('hidden.bs.collapse', () => {
                    $(this).text('⯆');
                });
            });


            // عند الضغط على زر نسخ الطابق
            $(document).on('click', '.copy-floor', function () {
                // تحديد الطابق الحالي
                let floor = $(this).closest('.floor-wrapper');

                // عمل نسخة عميقة منه
                let clone = floor.clone();

                // generate unique id
                let uniqueId = 'imageInput_' + Date.now();
                clone.find('.image-input').attr('id', uniqueId);

                // أضف النسخة إلى قائمة الطوابق
                $('#floors-repeater').append(clone);

                // activate image-input plugin
                new KTImageInput(document.getElementById(uniqueId));

                // تحديث الفهارس داخل النموذج
                updateFloorIndexes();
            });

            function updateFloorIndexes() {
                // إعادة ترقيم الفهارس بعد الإضافة
                $('#floors-repeater .floor-wrapper').each(function (floorIndex) {
                    $(this).find('.floor-number').text('🗂️ بيانات الطابق ');

                    // وصف الطابق
                    $(this).find('input[name^="floors"]').each(function () {
                        this.name = this.name.replace(/floors\[\d+\]/, 'floors[' + floorIndex + ']');
                    });

                    // الوحدات داخل الطابق
                    $(this).find('.units-repeater .unit-wrapper').each(function (unitIndex) {
                        $(this).find('input, select, textarea').each(function () {
                            this.name = this.name
                                .replace(/floors\[\d+\]\[units\]\[\d+\]/, 'floors[' + floorIndex + '][units][' + unitIndex + ']');
                        });
                    });
                });
            }
        });

    </script>

@endsection

