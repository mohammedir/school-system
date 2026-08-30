@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Projects for evaluation')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Projects management')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Projects for evaluation')</li>
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



    <!--begin::Toolbar-->
    <div class="d-flex flex-wrap flex-stack my-5">
        <!--begin::Heading-->
        <h2 class="fs-2 fw-semibold my-2">@lang('engineering.offers')</h2>
        <!--end::Heading-->
        <!--begin::Controls-->

        <!--end::Controls-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
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
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_projects">
                    <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="text-center min-w-125px">@lang('admin.Project name')</th>
                        <th class="text-center min-w-125px">@lang('admin.Project type')</th>
                        <th class="text-center min-w-125px">@lang('admin.Project status')</th>
                        <th class="text-end min-w-100px">@lang('admin.Actions')</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold">
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Post-->
    <div id="awardModalWrapper"></div>

    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Projects.Partial.projecte_evaluation_list_js")

@endsection

