@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Project View')</h1>
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
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Project View')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!--end::Toolbar-->
    <div id="kt_content_container_project" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            <div class="card mb-6">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                <img class="mw-70px mw-lg-100px" src="{{$project->project_logo != '' ? asset('/uploads/projects/' . $project->project_logo) : asset('assets/media/logos/logo_icon.png') }}" alt="image">

                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{$project->title}}</a>
                                        <form action="{{ route('projects.toggle_featured', $project->id) }}" method="POST" class="ms-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-icon {{ $project->is_featured ? 'btn-warning' : 'btn-light' }}" title="{{ $project->is_featured ? 'مشروع مميز' : 'جعل المشروع مميز' }}">
                                                <i class="bi {{ $project->is_featured ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <a  class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-outline ki-home fs-4 me-1"></i>{{$project->typeLookup['name_'. app()->getLocale()]}}</a>
                                        <a  class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-outline ki-map fs-4 me-1"></i>{{$project->area}} @lang('engineering.m²')</a>
                                        <a  class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                            <i class="ki-outline ki-dollar fs-4 me-1"></i>
                                            {{ number_format($project->project_cost, 0, '.', ',') }} {{ getSettings()->currency_symbol }}
                                        </a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold"><i class="la la-{{ $project->statusLookup->extra_2 }} text-{{ $project->statusLookup->extra_1 }} fs-2 fw-bold"></i> {{ $project->statusLookup->name_ar }}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">حالة المشروع</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->total_credits }}" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500"> إجمالي إيداعات المشروع</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->total_debits }}" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">إجمالي مصروفات المشروع</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->project_balance }}" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">الرصيد الحالي للمشروع</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->

                                @if($project->project_status_cd  >= getlookupId('project_status_cd',\App\Models\Projects::PROJECT_STATUS_UNITS_PRICED))
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->project_management_fees }}" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500"> رسوم المنصة</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->project_total_evaluation }}" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">قيمة المشروع النهائية   </div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->project_total_evaluation/1000 }}" data-kt-countup-prefix="سهم">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">إجمالي أسهم المشروع</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="0" data-kt-countup-prefix="سهم">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500"> أسهم مباعة</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->project_total_evaluation/1000 }}" data-kt-countup-prefix="سهم">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500"> أسهم شاغرة</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                @endif
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Progress-->
                                <!--<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                        <span class="fw-semibold fs-6 text-gray-500">Profile Compleation</span>
                                        <span class="fw-bold fs-6">50%</span>
                                    </div>
                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>-->
                                <!--end::Progress-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <li class="nav-item" role="presentation">
                            <a id="kt_activity_overview_tab" class="nav-link justify-content-center text-active-gray-800 active" data-bs-toggle="tab" role="tab" href="#kt_activity_overview">@lang('admin.Overview')</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a id="kt_activity_project_log_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_activity_project_log">@lang('admin.Project log')</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a id="kt_activity_project_balance_log_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_activity_project_balance_log">@lang('admin.Project Balance log')</a>
                        </li>
                        @if($project->project_status_cd  >= getlookupId('project_status_cd',\App\Models\Projects::PROJECT_STATUS_ACCEPTING_ENGINEERING_OFFERS))
                            <li class="nav-item" role="presentation">
                                <a id="kt_activity_consulting_quotations_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_activity_consulting_quotations">@lang('admin.Consulting Quotations') <span class="badge badge-success ms-1"><i class="ki-outline text-success"></i> {{$project->offers_count}} </span></a>
                            </li>
                        @endif

                        @if($project->project_status_cd  >= getlookupId('project_status_cd',\App\Models\Projects::PROJECT_STATUS_ACCEPTING_CONTRACTOR_OFFERS))
                        <li class="nav-item" role="presentation">
                            <a id="kt_contractors_quotations_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_contractors_quotations">@lang('admin.Contractors Quotations') <span class="badge badge-success ms-1"><i class="ki-outline text-success"></i> {{$project->contractor_offers_count}} </span></a>
                        </li>
                        @endif

                        @if($project->project_status_cd >=  getlookupId('project_status_cd',\App\Models\Projects::PROJECT_STATUS_UNITS_ADDED))
                            <li class="nav-item" role="presentation">
                                <a id="kt_activity_project_units_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_activity_project_units">@lang('admin.Project units')</a>
                            </li>
                        @endif

                        @if($project->project_status_cd >=  getlookupId('project_status_cd',\App\Models\Projects::PROJECT_STATUS_INVESTING))
                        <li class="nav-item" role="presentation">
                            <a id="kt_activity_register_shareholders_tab" class="nav-link justify-content-center text-active-gray-800" data-bs-toggle="tab" role="tab" href="#kt_activity_register_shareholders">@lang('admin.Register of shareholders')</a>
                        </li>
                        @endif

                    </ul>
                    <!--end::Navs-->

                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Timeline-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Tab Content-->
                    <div class="tab-content">
                        <input type="hidden" id="project_id" name="project_id" value="{{$project->id}}">
                        <!--begin::Tab panel-->
                        <div id="kt_activity_overview" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_overview_tab">
                            <!--begin::Post-->
                            <div class="content flex-row-fluid" id="kt_content">
                                <form method="post" action="{{ route('projects.store') }}" class="form" id="kt_add_project">
                                    @csrf
                                    <!--begin::Card - Land Info-->
                                    <div class="card card-flush">
                                        <!--begin::Card header-->
                                        <div class="card-header pt-8">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <!--begin::Input-->
                                                    <h3>@lang('admin.Land details')</h3>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body">
                                            <!--begin::Col-->
                                            <div class="col-md-6 fv-row">
                                                <div class="d-flex align-items-center gap-2">
                                                    <label class="required form-label">@lang('admin.Description of the land')</label>
                                                    <!--begin::Input-->
                                                    <select id="land_id" disabled name="land_id" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Land details')" class="form-select mb-2">
                                                        <option  data-lat="{{$land->lat}}"
                                                                 data-long="{{$land->long}}" data-investor_id="{{$land->investor_id}}" value="{{$land->id}}"  selected >
                                                            {{ Str::words($land->land_description, 3, '...') }}
                                                            - {{$land->area}} - {{$land->investor->full_name}}
                                                        </option>
                                                    </select>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Form-->
                                            <!-- Student details will be loaded here -->
                                            <div class="mt-10" id="land_details" style="display: none;">
                                                <!-- content will be injected here by AJAX -->
                                            </div>

                                            <!--end::Form-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Card - Map-->
                                    <div class="card card-flush mt-5" id="map_card">
                                        <div class="card-header">
                                            <h3 class="card-title">@lang('admin.Land Location Map')</h3>
                                        </div>
                                        <div class="card-body">
                                            <div id="map" style="height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>
                                            <input type="text" id="lat" name="lat" hidden>
                                            <input type="text" id="long" name="long" hidden>
                                        </div>
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Card - Land Info-->
                                    <div class="card card-flush mt-5">
                                        <!--begin::Card header-->
                                        <div class="card-header pt-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <!--begin::Input-->
                                                    <h3>@lang('admin.Student data')</h3>
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
                                            <div id="investor_details" style="display: none;">
                                                <!-- content will be injected here by AJAX -->
                                            </div>

                                            <!--end::Form-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                    <!--begin::Card - Land Info-->
                                    <div class="card card-flush mt-5">
                                        <!--begin::Card header-->
                                        <div class="card-header pt-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <!--begin::Input-->
                                                    <h3>@lang('admin.Project data')</h3>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body">
                                            <!--begin::Form-->
                                            <div class="row g-4 mb-15">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                                         <!--begin::Image placeholder-->
                                                         <style>.image-input-placeholder { background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                                         <!--end::Image placeholder-->
                                                         <!--begin::Image input-->
                                                         <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                             <div class="image-input-wrapper w-700px h-350px" style="background-image: url({{asset('/uploads/projects/cover_image/' . $project->cover_image)}});"></div>
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
                                                 </div>
                                            </div>
                                                <div class="row mt-4" id="existing-images">
                                                    <div id="land_images_container"
                                                         style="display: flex; overflow-x: auto; gap: 15px; padding-bottom: 10px;">
                                                        @foreach ($project_image as $image)
                                                            <div id="image-{{ $image->id }}"
                                                                 style="flex: 0 0 auto; position: relative; width: 200px; cursor: pointer;"
                                                                 data-image="{{ asset($image->file_path) }}"
                                                                 class="openImagePreview">
                                                                <div class="card shadow-sm">
                                                                    <img src="{{ asset($image->file_path) }}" class="card-img-top rounded"
                                                                         style="height: 180px; object-fit: cover; width: 100%;">
                                                                </div>
                                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-image-btn" data-id="{{ $image->id }}">
                                                                    &times;
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>

                                            <div class="row g-4 mb-15">
                                                <!--begin::Col-->
                                                <div class="col-md-4">
                                                    <h3>@lang('admin.Student data')</h3>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <!--begin::Input-->
                                                        <select disabled id="investor_id" name="investor_id" aria-label="Select a Language" data-control="select2" data-placeholder="@lang('admin.Student name')" class="form-select mb-2">
                                                            <option></option>
                                                            @foreach($investors as $investor)
                                                                <option value="{{$investor->id}}" @if($investor->id == $project->creator_investor_id) selected @endif>{{$investor->full_name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <!--end::Input-->
                                                    </div>
                                                </div>

                                                <div class="col-md-8 fv-row">
                                                    <label disabled class="form-label">@lang('admin.Project name')</label>
                                                    <input disabled class="form-control" name="title" value="{{$project->title}}">
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <div class="row g-4 mb-15">
                                                <div class="col-md-4 fv-row">
                                                    <label class="form-label">@lang('admin.Project type')</label>
                                                    <select disabled name="project_type_cd" class="form-select" data-control="select2" data-placeholder="@lang('admin.Project type')">
                                                        <option>{{getlookup($project->project_type_cd)->{'name_' . app()->getLocale()} }}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <label class="form-label">@lang('admin.Project space')</label>
                                                    <div class="input-group">
                                                        <input disabled class="form-control text-start" value="{{$project->area}}" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                                                        <span class="input-group-text">م2</span>
                                                    </div>
                                                    <!--begin::Hint-->
                                                    <div class="form-text text-info">@lang('admin.The building percentage is subject to regulatory requirements.')</div>
                                                    <!--end::Hint-->
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <label class="form-label">@lang('admin.Project cost')</label>
                                                    <div class="input-group">
                                                        <input disabled class="form-control text-start number_format" id="project_cost" value="{{$project->project_cost}}" name="project_cost" type="text" placeholder="@lang('admin.Enter The project cost')">
                                                        <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-4 mb-15">
                                                <div class="col-md-12 fv-row">
                                                    <label class="form-label mb-10">@lang('admin.Project creator description')</label>
                                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5">
                                                        {!! htmlspecialchars_decode($project->description) !!}
                                                    </div>
                                                </div>
                                            </div>


                        @php
                            $status = $project->evaluationstatusLookup;
                            $statusName = $status?->{'name_' . app()->getLocale()} ?? '-';
                            $statusColor = $status->extra_1 ?? 'secondary'; // Bootstrap default fallback
                            $statusIcon = $status->extra_2 ?? 'question-circle'; // FontAwesome or Metronic icon
                        @endphp
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-hover-primary fw-bold">
                                @lang('admin.Engineering consultant evaluation status'):
                            </span>
                            <span class="badge badge-light-{{ $statusColor }} fs-6">
                                <i class="la la-{{ $statusIcon }} text-{{ $statusColor }} me-1"></i>
                                {{ $statusName }}
                            </span>
                        </div>
                        <br>
                        @if($project->isEngineeringConsultantRecommendAccept())
                            <div class="row g-4 mb-15">
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-10">@lang('admin.Engineering Description')</label>
                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5">
                                        {!! htmlspecialchars_decode($project->engineering_consultant_description) !!}
                                    </div>
                                </div>
                            </div>
                        @elseif($project->isEngineeringConsultantRecommendReject())
                            <div class="row g-4 mb-15">
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-3">@lang('admin.Rejection Reason')</label>
                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5">
                                        {{$project->engineering_consultant_decline_reasons}}
                                    </div>
                                </div>
                            </div>


                        @endif
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </form>

                            </div>
                            <!--end::Post-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div id="kt_activity_project_log" class="card-body p-0 tab-pane fade show" role="tabpanel" aria-labelledby="kt_activity_project_log_tab">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_history_list">
                                        <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-center min-w-125px">@lang('admin.Notifications')</th>
                                            <th class="text-center min-w-125px">@lang('admin.Time')</th>
                                            <th class="text-center min-w-125px">@lang('admin.From')</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-semibold">
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end::Tab panel-->

                        <!--begin::Tab panel-->
                        <div id="kt_activity_project_balance_log" class="card-body p-0 tab-pane fade show" role="tabpanel" aria-labelledby="kt_activity_project_balance_log_tab">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Card body-->
                                <div class="card-body py-4">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_balance_log">
                                        <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-center min-w-125px">القيمة</th>
                                            <th class="text-center min-w-125px">نوع المستخدم</th>
                                            <th class="text-center min-w-125px">اسم المستخدم</th>
                                            <th class="text-center min-w-125px">الوصف</th>
                                            <th class="text-center min-w-125px">مرجع الحركة</th>
                                            <th class="text-center min-w-125px">تاريخ الحركة</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-semibold">
                                        </tbody>
                                    </table>

                                    <div class="d-flex flex-wrap flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column flex-grow-1 pe-8">
                                        <!--begin::Stats-->
                                        <div class="d-flex flex-wrap">
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-6 px-8 me-12 mt-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->total_credits }}" data-kt-countup-prefix="$">0</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500"> إجمالي إيداعات المشروع</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->

                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-6 px-8 me-12 mt-3">
                                                <!--begin::Numter-->
                                                <div class="d-flex align-items-center">
                                                    <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->total_debits }}" data-kt-countup-prefix="$">0</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500">إجمالي مصروفات المشروع</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->

                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-6 px-8 me-12 mt-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ $project->project_balance }}" data-kt-countup-prefix="$">0</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500">الرصيد الحالي للمشروع</div>
                                                <!--end::Label-->
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end::Tab panel-->

                        <!--begin::Tab panel-->
                        <div id="kt_activity_consulting_quotations" class="card-body p-0 tab-pane fade show" role="tabpanel" aria-labelledby="kt_activity_consulting_quotations_tab">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap justify-content-start">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{$project->offers->count()}}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Number of offers submitted')</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{ $project->awardedEngineeringOffer?->engineering_partner?->company_name ?? 'لم يتم الترسية بعد' }}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('admin.Approved offer')</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--begin::Stat-->
                                        @if($project->isAcceptingOffers())
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{$project->offers_end_date}}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Application closing date')</div>
                                            <!--end::Label-->
                                        </div>
                                        @endif


                                        @if($project->project_status_cd >= $engAwardingId)
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold">{{ $project->awardedEngineeringOffer?->duration}}@lang('engineering.day')</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500">مدة التنفيذ</div>
                                                <!--end::Label-->
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold">{{ $project->awardedEngineeringOffer?->total_price}} $</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500">سعر العرض </div>
                                                <!--end::Label-->
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold"  >{{ $project->awarded_engineering_reasons }}</div>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-500">سبب الترسية</div>
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold"  >{{ $project->awarded_engineering_date }}</div>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-500">
                                                    <i class="ki-outline ki-check fs-2 text-success me-2"></i>
                                                    تاريخ الترسية
                                                </div>
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold"  >{{ isset($project->awardedEngineeringUserInfo->name) }}</div>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-500">تمت بواسطة </div>
                                            </div>
                                            @if($project->project_status_cd >= $engAwardingApprovedId)
                                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-bold"  >{{ $project->awarded_engineering_creator_approval_date }}</div>
                                                    </div>
                                                    <div class="fw-semibold fs-6 text-gray-500">
                                                        <i class="ki-outline ki-double-check fs-2 text-success me-2"></i>
                                                        اعتماد الترسية من منشئ المشروع/ {{ $project->projectCreatorInfo->full_name }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <!--begin::Number-->
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-bold text-danger">لم يتم اعتماد الترسية من منشئ المشروع بعد</div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <!--end::Stat-->
                                    </div>
                                </div>
                                <!--end::Info-->
                                <!--begin::Card-->
                                <div class="card">
                                    @if($project->project_status_cd >= $engAwardingId)
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <!--begin::Search-->
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <input type="text" data-kt-project-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="@lang('admin.Search')" />
                                                    </div>
                                                    <!--end::Search-->
                                                </div>
                                                <!--begin::Card title-->
                                            </div>
                                            <!--end::Card header-->
                                            <div id="kt_land_view_details" class="collapse mb-5">
                                                <div class="py-5 px-10">
                                                    <form class="kt-form kt-form--label-right form-control" id="filters" method="GET" autocomplete="off">

                                                        <div class="form-group row">
                                                            <div class="col-form-label col-lg-3 col-sm-6">
                                                                <label class="form-control-label">@lang('admin.Project type')</label>
                                                                <select id="status_cd" class="form-select" data-control="select2" name="status_cd">
                                                                    <option value="" selected>@lang('admin.Select')..</option>
                                                                    @foreach(get_lookup_by_master_key('engineering_offer_status') as $val)
                                                                        <option value="{{$val->id}}">{{$val->{'name_' . app()->getLocale()} }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-form-label col-lg-2 col-sm-6">
                                                                <a href="javascript:void(0)" style="width: 100%" class="btn btn-info search_btn"><i class="la la-search"></i> @lang('admin.Search')</a>
                                                            </div>
                                                            <div class="col-form-label col-lg-2 col-sm-6">
                                                                <a href="javascript:void(0)" style="width: 100%" class="btn btn-secondary reset_search"><i class="la la-recycle"></i> @lang('admin.Reset')</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--begin::Card body-->
                                            <div class="card-body py-4">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_projects_offers_list">
                                                            <thead>
                                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                <th class="text-center min-w-125px">@lang('engineering.engineering partner')</th>
                                                                <th class="text-center min-w-125px">@lang('engineering.duration')</th>
                                                                <th class="text-center min-w-125px">@lang('engineering.offer_date')</th>
                                                                <th class="text-center min-w-200px">@lang('engineering.notes')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="text-gray-600 fw-semibold">
                                                            </tbody>
                                                        </table>
                                                        <!--end::Table-->

                                            </div>
                                            <!--end::Card body-->
                                    @else
                                        <h2 class="text-danger text-center mt-15">لم يتم الترسية بعد</h2>
                                    @endif
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end::Tab panel-->

                        <!--begin::Tab panel-->
                        <div id="kt_contractors_quotations" class="card-body p-0 tab-pane fade show" role="tabpanel" aria-labelledby="kt_contractors_quotations_tab_tab">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap justify-content-start">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{$project->contractor_offers->count()}}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Number of offers submitted')</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{ $project->awardedContractorOffer?->contractor?->company_name ?? 'لم يتم الاعتماد بعد' }}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('admin.Approved offer')</div>
                                            <!--end::Label-->
                                        </div>

                                        @if($project->isAcceptingContractorOffers())
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{$project->contractor_offers_end_date}}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('engineering.Application closing date')</div>
                                            <!--end::Label-->
                                        </div>
                                        @endif

                                        @if($project->project_status_cd >= $contractorAwardingId)
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold">{{ $project->awardedContractorOffer?->duration}}@lang('engineering.day')</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500">مدة التنفيذ </div>
                                                <!--end::Label-->
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold">{{ $project->awardedContractorOffer?->total_price}} $</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-500">سعر العرض </div>
                                                <!--end::Label-->
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold"  >{{ $project->awarded_contractor_reasons }}</div>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-500">سبب الترسية</div>
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold"  >{{ $project->awarded_contractor_date }}</div>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-500">
                                                    <i class="ki-outline ki-check fs-2 text-success me-2"></i>
                                                    تاريخ الترسية
                                                </div>
                                            </div>
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="fs-4 fw-bold"  >{{ isset($project->awardedContractorUserInfo->name) }}</div>
                                                </div>
                                                <div class="fw-semibold fs-6 text-gray-500">تمت بواسطة </div>
                                            </div>
                                            @if($project->project_status_cd >= $contractorAwardingApprovedId)
                                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-bold"  >{{ $project->awarded_contractor_creator_approval_date }}</div>
                                                    </div>
                                                    <div class="fw-semibold fs-6 text-gray-500">
                                                        <i class="ki-outline ki-double-check fs-2 text-success me-2"></i>
                                                        اعتماد الترسية من منشئ المشروع/ {{ $project->projectCreatorInfo->full_name }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                    <!--begin::Number-->
                                                    <div class="d-flex align-items-center">
                                                        <div class="fs-4 fw-bold text-danger">لم يتم اعتماد الترسية من منشئ المشروع بعد</div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <!--end::Stat-->
                                    </div>
                                </div>
                                <!--end::Info-->
                                <!--begin::Card-->
                                <div class="card">
                                        @if($project->project_status_cd >= $contractorAwardingId)
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <!--begin::Search-->
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <input type="text" data-kt-project-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="@lang('admin.Search')" />
                                                    </div>
                                                    <!--end::Search-->
                                                </div>
                                                <!--begin::Card title-->
                                            </div>
                                            <!--end::Card header-->
                                            <div id="kt_land_view_details" class="collapse mb-5">
                                                <div class="py-5 px-10">
                                                    <form class="kt-form kt-form--label-right form-control" id="filters" method="GET" autocomplete="off">

                                                        <div class="form-group row">
                                                            <div class="col-form-label col-lg-3 col-sm-6">
                                                                <label class="form-control-label">@lang('admin.Project type')</label>
                                                                <select id="status_cd" class="form-select" data-control="select2" name="status_cd">
                                                                    <option value="" selected>@lang('admin.Select')..</option>
                                                                    @foreach(get_lookup_by_master_key('engineering_offer_status') as $val)
                                                                        <option value="{{$val->id}}">{{$val->{'name_' . app()->getLocale()} }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-form-label col-lg-2 col-sm-6">
                                                                <a href="javascript:void(0)" style="width: 100%" class="btn btn-info search_btn"><i class="la la-search"></i> @lang('admin.Search')</a>
                                                            </div>
                                                            <div class="col-form-label col-lg-2 col-sm-6">
                                                                <a href="javascript:void(0)" style="width: 100%" class="btn btn-secondary reset_search"><i class="la la-recycle"></i> @lang('admin.Reset')</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--begin::Card body-->
                                            <div class="card-body py-4">
                                                        <!--begin::Table-->
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_contractor_offers_list">
                                                            <thead>
                                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                <th class="text-center min-w-125px">@lang('contractors.contractor')</th>
                                                                <th class="text-center min-w-125px">@lang('engineering.duration')</th>
                                                                <th class="text-center min-w-125px">@lang('engineering.offer_date')</th>
                                                                <th class="text-center min-w-125px">@lang('engineering.notes')</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="text-gray-600 fw-semibold">
                                                            </tbody>
                                                        </table>
                                                        <!--end::Table-->

                                            </div>
                                            <!--end::Card body-->
                                        @else
                                            <h2 class="text-danger text-center mt-15">لم يتم الترسية بعد</h2>
                                        @endif
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end::Tab panel-->

                        <!--begin::Tab panel-->
                        <div id="kt_activity_project_units" class="card-body p-0 tab-pane fade show" role="tabpanel" aria-labelledby="kt_activity_project_units_tab">
                            <!--begin::Timeline-->
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap justify-content-start">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">
                                                    {{ optional($units->first())->valuator_id
                                                        ? getUserData($units->first()->valuator_id)->name
                                                        : 'غير محدد' }}
                                                </div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('admin.Name of the appraiser')</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{ $total_share_price }}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('admin.Total appraisal price')</div>
                                            <!--end::Label-->
                                        </div>
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <div class="fs-4 fw-bold">{{ $number_of_shares }}</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">@lang('admin.Total number of names')</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->

                                </div>
                                <!--end::Info-->
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
                                                                                                <h5 class="mb-0 floor-number">🗂️ {{$floor->description}} </h5>
                                                                                                <div>
                                                                                                    <button type="button" class="btn btn-sm btn-secondary toggle-collapse">⯆</button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="collapse show card-collapse">
                                                                                                <div class="card-body">
                                                                                                    <div class="col-md-2 fv-row mb-3">
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

                                                                                                    <hr class="my-4">

                                                                                                    <h6 class="mb-3">🛏️ الوحدات في هذا الطابق</h6>

                                                                                                    <table class="table align-middle table-row-dashed fs-5 gy-3">
                                                                                                        <thead>
                                                                                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                                                            <th>رقم / رمز الوحدة</th>
                                                                                                            <th>نوع الوحدة</th>
                                                                                                            <th>مساحة الوحدة</th>
                                                                                                            <th>عدد الغرف</th>
                                                                                                            <th>عدد الحمامات</th>
                                                                                                            <th>تفاصيل التشطيبات</th>
                                                                                                            <th>سعر الوحدة </th>
                                                                                                            <th>عدد الأسهم</th>
                                                                                                        </tr>
                                                                                                        </thead>
                                                                                                        <tbody class="text-gray-600 fw-semibold">
                                                                                                            @foreach($floor->children as $unitIndex => $unit)
                                                                                                                <tr>
                                                                                                                    <td><span class="badge badge-light-info badge-lg fw-bold">{{$unit->description}}</span></td>
                                                                                                                    <td>{{getlookup($unit->unit_type_cd)->{'name_' . app()->getLocale()} }}</td>
                                                                                                                    <td>{{$unit->area}} م2</td>
                                                                                                                    <td>{{$unit->rooms}} غرفة</td>
                                                                                                                    <td>{{$unit->bathrooms}} حمام</td>
                                                                                                                    <td>{{$unit->finishing_details}}</td>
                                                                                                                    <td>{{number_format($unit->valuation_price)}} {{getSettings()->currency_symbol}}</td>
                                                                                                                    <td><span class="badge badge-light-success badge-lg fw-bold">{{$unit->valuation_price/1000}} سهم </span></td>
                                                                                                                </tr>
                                                                                                            @endforeach
                                                                                                        </tbody>
                                                                                                    </table>

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
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab Content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Timeline-->

        </div>
            <div class="modal fade" id="projectLogModal" tabindex="-1" aria-labelledby="projectLogModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="projectLogModalLabel">ملاحظات المشروع</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>
                        <div class="modal-body" id="projectLogNotesContent">
                            <!-- سيتم تعبئة الملاحظات هنا -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--end::Content container-->
    </div>
    </div>
    <!--end::Content-->
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Projects.Partial.viewProject_js")

@endsection

