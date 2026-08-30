@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.View Students')</h1>
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
                    <li class="breadcrumb-item text-gray-600">@lang('admin.View Students')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                            <input type="text" data-kt-land-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-13"
                                   placeholder="@lang('admin.Search for Student')"/>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Export buttons-->
                        <div class="btn-group me-3">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-download"></i> @lang('admin.Export')
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item export-students-btn" href="#" data-export-type="excel">
                                        <i class="bi bi-file-earmark-excel text-success"></i> @lang('admin.Export to Excel')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item export-students-btn" href="#" data-export-type="pdf">
                                        <i class="bi bi-file-earmark-pdf text-danger"></i> @lang('admin.Export to PDF')
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Export buttons-->
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-info me-3" data-bs-toggle="collapse"
                                    href="#kt_land_view_details">
                                <i class="bi bi-funnel-fill fs-2"></i>
                            </button>
                            <!--end::Filter-->
                            @can('Student create')
                                <!--begin::Add land-->
                                <a href="{{url('/students/add-student')}}" class="btn btn-info">
                                    <i class="bi bi-plus-circle fs-2"></i>@lang('admin.Add Student')
                                </a>
                                <!--end::Add land-->
                            @endcan
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                             data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                                Delete Selected
                            </button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>

                <!--end::Card header-->
                <div id="kt_land_view_details" class="collapse mb-5">
                    <div class="py-5 px-10">
                        <form class="kt-form kt-form--label-right form-control" id="filters" method="GET"
                              autocomplete="off">
                            <div class="form-group row">
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Gender')</label>
                                    <select class="form-select" name="gender" id="gender" data-control="select2"
                                            data-placeholder="@lang('admin.Select')">
                                        <option value="" disabled selected>@lang('admin.Select')</option>
                                        <option value="male">@lang('admin.male')</option>
                                        <option value="female">@lang('admin.female')</option>
                                    </select>
                                </div>
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label required">@lang('admin.Age Group')</label>
                                    <select class="form-select" name="age_group" id="age_group" data-control="select2"
                                            data-placeholder="@lang('admin.Select')">
                                        <option value="" disabled selected>@lang('admin.Select')</option>
                                        @foreach(get_lookup_by_master_key('age_group') as $age_group)
                                            <option value="{{$age_group->id}}">{{$age_group->name_ar}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mt-3">
                                    <label class="form-label required">@lang('admin.Class')</label>
                                    <select class="form-select" name="class" id="class" data-control="select2"
                                            data-placeholder="@lang('admin.Select')">
                                        <option value="" disabled selected>@lang('admin.Select')</option>
                                        <!-- سيتم ملؤها بواسطة Ajax -->
                                    </select>
                                </div>
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Accreditation status')</label>
                                    <select class="form-select" id="accreditation_status" name="accreditation_status"
                                            data-control="select2">
                                        <option value="">@lang('admin.All')</option>
                                        <option value="approved">@lang('admin.ِApproved')</option>
                                        <option value="pending">@lang('admin.Pending')</option>
                                        <option value="rejected">@lang('admin.Rejected')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%" class="btn btn-info search_btn"><i
                                            class="bi bi-search"></i> @lang('admin.Search')</a>
                                </div>
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%"
                                       class="btn btn-secondary reset_search"><i
                                            class="bi bi-recycle"></i> @lang('admin.Reset')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_student">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-125px">@lang('admin.Student ID Number')</th>
                            <th class="text-center min-w-125px">@lang('admin.Student name')</th>
                            <th class="text-center min-w-125px">@lang('admin.Birth Date')</th>
                            <th class="text-center min-w-125px">@lang('admin.Mobile number')</th>
                            <th class="text-end min-w-100px">@lang('admin.Actions')</th>
                        </tr>
                        </thead>
                        <tbody class="text-600 fw-semibold">
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->

    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Students.Partial.student_list_registered_by_website_js")
@endsection

