@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Manage List')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.System settings')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Manage List')</li>
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
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
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
                            <input type="text" data-kt-list-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="@lang('admin.Search')" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-info me-3" data-bs-toggle="collapse" href="#kt_investors_view_details">
                                <i class="bi bi-funnel-fill fs-2"></i>
                            </button>
                            <!--end::Filter-->
                                <!--begin::Add land-->
                                <a data-bs-toggle="modal" data-bs-target="#kt_modal_add_items" class="btn btn-info">
                                    <i class="bi bi-plus-circle fs-2"></i>@lang('admin.Add Settings List')
                                </a>
                                <!--end::Add land-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>

                <!--end::Card header-->
                <div id="kt_investors_view_details" class="collapse mb-5">
                    <div class="py-5 px-10">
                        <form class="kt-form kt-form--label-right form-control" id="filters" method="GET" autocomplete="off">
                            <div class="form-group row">
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.List Type')</label>
                                    <select id="list_name_cd" class="form-select location_province" data-control="select2" name="list_name_cd">
                                        <option value="" selected>@lang('admin.Select')..</option>
                                        @foreach($lookups as $item)
                                            <option value="{{$item->master_key}}">{{$item->{'name_' . app()->getLocale()} ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%" class="btn btn-info search_btn"><i class="bi bi-search"></i> @lang('admin.Search')</a>
                                </div>
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%" class="btn btn-secondary reset_search"><i class="bi bi-recycle"></i> @lang('admin.Reset')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_manage_list">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-125px">@lang('admin.Settings Name')</th>
                            <th class="text-center min-w-125px">@lang('admin.Item Name')</th>
                            <th class="text-center min-w-125px">@lang('admin.The condition')</th>
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
        {{--add item--}}
        <div class="modal fade" id="kt_modal_view_items" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">@lang('admin.View Items')</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-info" data-kt-roles-modal-action="close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_edit_item_form" class="form" action="#">
                            <input type="hidden" id="edit_item_id" name="edit_item_id">
                            <!--begin::Scroll-->
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_item_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_item_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">@lang('admin.Settings Name')</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-solid" id="view_settings_name" name="edit_name_ar" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Permissions-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-bold form-label mb-2">
                                        <span class="required">@lang('admin.The condition')</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select" data-control="select2" name="status">
                                        <option value="1">@lang('admin.Active')</option>
                                        <option value="0">@lang('admin.Inactive')</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-kt-edit-modal-action="cancel">@lang('admin.Discard')</button>
                                <button type="submit" class="btn btn-info" data-kt-edit-modal-action="submit">
                                    <span class="indicator-label">@lang('admin.Submit')</span>
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
        <div class="modal fade" id="kt_modal_add_items" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">@lang('admin.Add Settings List')</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-info" data-kt-roles-modal-action="close">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 my-7">
                        <!--begin::Form-->
                        <form id="kt_modal_add_item_form" class="form" action="#">
                            <!--begin::Scroll-->
                            <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_item_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_item_header" data-kt-scroll-wrappers="#kt_modal_update_role_scroll" data-kt-scroll-offset="300px">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <div class="col-form-label col-lg-6 col-sm-6">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">@lang('admin.Settings Name')</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select list_type" data-control="select2" name="settings_name_id">
                                            @foreach($lookups as $item)
                                                <option value="{{$item->id}}" data-master_key="{{$item->master_key}}" >{{$item->{'name_' . app()->getLocale()} ?? '-' }}</option>
                                            @endforeach
                                        </select>
                                        <!--end::Input-->
                                    </div>

                                    <!-- begin::City Region Field (Hidden by default) -->
                                    <div id="city_region_wrapper" class="fv-row mt-5 d-none">
                                        <div class="col-form-label col-lg-6 col-sm-6">
                                            <label class="fs-5 fw-bold form-label mb-2">
                                                <span class="required">@lang('admin.Province')</span>
                                            </label>
                                            <select id="province_cd" class="form-select location_province" data-control="select2" name="province_cd" data-placeholder="@lang('engineering.select_province')">
                                                <option value="" selected>@lang('lang.Select')..</option>
                                                @foreach ($provinces as $val)
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->{'name_' . app()->getLocale()} }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end::City Region Field -->

                                    <!-- begin::Area Region Field (Hidden by default) -->
                                    <div id="area_region_wrapper" class="fv-row mt-5 d-none">
                                        <div class="col-form-label col-lg-6 col-sm-6">
                                            <label class="fs-5 fw-bold form-label mb-2">
                                                <span class="required">@lang('admin.City')</span>
                                            </label>
                                            <select id="city_cd" class="form-select" data-control="select2" name="city_cd">
                                                @foreach ($city as $val)
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->{'name_' . app()->getLocale()} }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end::Area Region Field -->

                                    <!-- begin::age_group Region Field (Hidden by default) -->
                                    <div id="age_group_wrapper" class="fv-row mt-5 d-none">
                                        <div class="col-form-label col-lg-6 col-sm-6">
                                            <label class="fs-5 fw-bold form-label mb-2">
                                                <span class="required">@lang('admin.Class')</span>
                                            </label>
                                            <select id="age_group" class="form-select" data-control="select2" name="age_group">
                                                @foreach ($age_group as $val)
                                                    <option value="{{ $val->id }}">
                                                        {{ $val->{'name_' . app()->getLocale()} }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end::Area Region Field -->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Permissions-->
                                <div class="fv-row">
                                    <div class="col-form-label col-lg-6 col-sm-6">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold form-label mb-2">
                                            <span class="required">@lang('admin.Name ar')</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input name="name_ar" class="form-control" >
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Permissions-->
                            </div>
                            <!--end::Scroll-->
                            <!--begin::Actions-->
                            <div class="text-center pt-15">
                                <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">@lang('admin.Discard')</button>
                                <button type="submit" class="btn btn-info" data-kt-add-item-modal-action="submit">
                                    <span class="indicator-label">@lang('admin.Submit')</span>
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
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.SystemSettings.Partial.manageList_js")
@endsection

