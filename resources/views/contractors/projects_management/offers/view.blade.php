@extends('contractors.layouts.master')
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
                        <a href="index.html" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.My Price offers')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.Actions')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('engineering.Edit a quote')</li>
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

                <!--begin::Card -->
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
                            <div class="col-md-4 fv-row">
                                <label class="required form-label">@lang('admin.Project type')</label>
                                <select disabled name="project_type_cd" class="form-select" data-control="select2" data-placeholder="@lang('admin.Project type')">
                                    <option>{{getlookup($project->project_type_cd)->{'name_' . app()->getLocale()} }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 fv-row">
                                <label class="required form-label">@lang('admin.Project space')</label>
                                <div class="input-group">
                                    <input disabled class="form-control text-start" value="{{$project->area}}" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                                    <span class="input-group-text">م2</span>
                                </div>
                            </div>
                            <div class="col-md-4 fv-row">
                                <label class="required form-label">@lang('admin.Project cost')</label>
                                <div class="input-group">
                                    <input disabled class="form-control text-start" id="project_cost" value="{{$project->project_cost}}" name="project_cost" type="number" placeholder="@lang('admin.Enter The project cost')">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                            <div class="col-md-6 fv-row">
                                <label disabled class="form-label">@lang('admin.Project name')</label>
                                <input disabled class="form-control" name="title" value="{{$project->title}}">
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-5">@lang('admin.Engineering Description')</label>
                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5">
                                        {!! htmlspecialchars_decode($project->engineering_consultant_description) !!}
                                    </div>
                                </div>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            <form method="post" action="{{ route('contractors.projects.submit_quote',$project->id) }}" class="form" id="kt_add_project">
                @csrf
            <!--begin::Card - Land Info-->
            <div class="card card-flush mt-5">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <!--begin::Input-->
                            <h3>@lang('contractors.Edit a quote')</h3>
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

                        <div class="col-md-4 fv-row">
                            <label class="required form-label">@lang('contractors.Offered price')</label>
                            <div class="input-group">
                                <input  class="form-control number_format text-start" value="{{$my_offer->total_price??null}}" id="total_price" name="total_price" type="text" placeholder="@lang('contractors.Offered price')">
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required form-label">@lang('contractors.Implementation period')</label>
                            <div class="input-group">
                                <input class="form-control text-start" id="duration" value="{{$my_offer->duration??null}}" name="duration" type="number" placeholder="@lang('contractors.Implementation period')">
                                <span class="input-group-text">@lang('contractors.day')</span>
                            </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required form-label">@lang('admin.Download the contract for signature')</label>
                            <a href="{{ asset('uploads/settings/' . $settings->contractor_template_file) }}" download class="btn btn-light-primary btn-sm form-control" style="font-size: 15px">
                                <i class="fas fa-download me-2"></i> @lang('investors.Download Contract')
                            </a>
                        </div>
                    </div>

                    <div class="row g-4 mb-15">
                        <div class="col-md-8 fv-row">
                            <label class="form-label">@lang('contractors.notes')</label>
                            <textarea rows="12" class="form-control" name="offer_notes">{{$my_offer->offer_notes??null}}</textarea>
                        </div>
                    </div>

                    <div class="row g-4 mb-15">

                        <!-- ✅ Existing Attachments Preview  -->
                        @if (!empty($attachments) && $attachments->count())
                            <div class="mb-5">
                                <h5>@lang('admin.Existing Attachments')</h5>
                                <ul class="list-group">
                                    @foreach ($attachments as $attachment)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <div>
                                                <a href="{{ asset($attachment->file_path) }}" target="_blank">
                                                    {{ $attachment->original_name }}
                                                </a>
                                                @if($attachment->file_description)
                                                    <div class="text-muted small mt-1">
                                                        {{ $attachment->file_description }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="javascript:;" data-id="{{ $attachment->id }}"
                                                   class="delete-attachment-btn btn btn-sm btn-light-danger mt-2">
                                                    <i class="ki-duotone ki-trash fs-5">
                                                        <span class="path1"></span><span class="path2"></span>
                                                        <span class="path3"></span><span class="path4"></span><span class="path5"></span>
                                                    </i>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <!--begin::Repeater-->
                        <div id="kt_docs_repeater_basic">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="kt_docs_repeater_basic">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label class="form-label">@lang('admin.Attachment')</label>
                                                <input name="projects_contractors_offer_attachment" type="file" class="form-control mb-2 mb-md-0"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">@lang('admin.Description')</label>
                                                <input name="description" type="text" class="form-control mb-2 mb-md-0"/>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                    <i class="bi bi-trash fs-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-info">
                                    <i class="bi bi-plus-circle fs-2"></i>
                                    @lang('admin.Add')
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->

                    </div>

                    <!--end::Form-->
                    <div class="row g-4 mb-15">
                        <div class="col-md-9 offset-md-3 text-end fv-row">
                            <button id="submit" type="submit" class="btn btn-primary" data-kt-project-action="submit">
                                <span class="indicator-label"><i class="bi bi-floppy2-fill me-2"></i> @lang('admin.Submit')</span>
                                <span class="indicator-progress">@lang('admin.Please wait...')
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
{{--                            <button type="button" class="btn btn-light me-3" data-kt-project-action="cancel">@lang('admin.Discard')</button>--}}
                           <button type="button" class="btn btn-secondary btn-outline me-10 mx-2" data-kt-project-action="cancel"><i class="bi bi-x-circle"></i>@lang('admin.Discard')</button>

                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            </form>

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("contractors.projects_management.Partial.addProject_js")

@endsection

