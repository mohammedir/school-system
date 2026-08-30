@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Project evaluation by sahmi')</h1>
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
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Project adoption')</li>
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
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <label class="form-label">@lang('admin.Project Creator')</label>
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
                            <label class="form-label">@lang('admin.Project name')</label>
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
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="form-label">@lang('admin.Project cost')</label>
                            <div class="input-group">
                                <input disabled class="form-control text-start number_format" id="project_cost" value="{{$project->project_cost}}" name="project_cost" type="text" placeholder="@lang('admin.Enter The project cost')">
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="{{ route('projects.project_adoption',$project->id) }}" class="form mt-15" id="kt_project_adoption">
                        @csrf
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
                        @else
                            <div class="row g-4 mb-15">
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-3">@lang('admin.Rejection Reason')</label>
                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5">
                                        {{$project->engineering_consultant_decline_reasons}}
                                    </div>
                                </div>
                            </div>


                        @endif

                        <div class="row g-4">
                            <input type="hidden" value="{{$project->id}}" id="project_id" name="project_id">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9 text-end">
                                <button data-land-id="{{ $land->id }}" type="submit" name="action" value="acceptable" class="btn btn-success" data-kt-project-adoption-action="submit">
                                    <span class="indicator-label"><i class="bi bi-check-circle"></i> @lang('admin.Accept project')</span>
                                    <span class="indicator-progress">@lang('admin.Please wait...')
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <button type="button" class="btn btn-danger btn-outline me-5" data-bs-toggle="modal" data-bs-target="#kt_modal_no_need_edit"><i class="bi bi-x-circle"></i> @lang('admin.Reject project')</button>
                                <button type="button" class="btn btn-secondary btn-outline me-10"  data-kt-project-evaluation-engineering-consultant-action="cancel" style="margin-inline-start: inherit"><i class="bi bi-x-circle"></i> @lang('admin.Discard')</button>
                            </div>
                        </div>
                    </form>

                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

            <div class="modal fade" id="kt_modal_no_need_edit" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_modify_price_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">@lang('admin.Rejection Reason')</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body px-5 my-7">
                            <!--begin::Form-->
                            <form id="kt_modal_rejected_project_adoption_notes_form" class="form"  method="post" action="{{ route('projects.engineering_consultant_evaluation', $project->id) }}"  enctype="multipart/form-data">
                                @csrf                                            <!--begin::Scroll-->
                                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_modify_price_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_modify_price_header" data-kt-scroll-wrappers="#kt_modal_modify_price_scroll" data-kt-scroll-offset="300px">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">@lang('admin.Rejection Reason')</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="input-group">
                                            <textarea rows="3" class="form-control" name="decline_reasons" style="text-align: right; direction: rtl;">{{$project->decline_reasons}}</textarea>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Scroll-->
                                <!--begin::Actions-->
                                <div class="text-center pt-10">
                                    <button type="reset" class="btn btn-light me-3" data-kt-project-adoption-notes-action="cancel">@lang('admin.Discard')</button>
                                    <button type="submit" class="btn btn-primary" value="rejected"  data-kt-rejected-project-adoption-action="submit">
                                        <span class="indicator-label">@lang('admin.Send Rejection Reason')</span>
                                        <span class="indicator-progress">@lang('admin.Please wait...')
																	<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>


        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Projects.Partial.project_adoption_js")

@endsection

