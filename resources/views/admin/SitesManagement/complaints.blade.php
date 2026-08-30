@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">إدارة الموقع</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Home')</li>
                    <li class="breadcrumb-item text-gray-600">إدارة الموقع</li>
                    <li class="breadcrumb-item text-gray-600">الشكوي</li>
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
                            <input type="text" data-kt-complaint-table-filter="search"
                                   class="form-control form-control-solid w-250px ps-13"
                                   placeholder="البحث عن شكوى"/>
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
                                    <a class="dropdown-item export-complaints-btn" href="#" data-export-type="excel">
                                        <i class="bi bi-file-earmark-excel text-success"></i> @lang('admin.Export to Excel')
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item export-complaints-btn" href="#" data-export-type="pdf">
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
                                    href="#kt_complaint_view_details">
                                <i class="bi bi-funnel-fill fs-2"></i>
                            </button>
                            <!--end::Filter-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Card toolbar-->
                </div>

                <!--end::Card header-->
                <div id="kt_complaint_view_details" class="collapse mb-5">
                    <div class="py-5 px-10">
                        <form class="kt-form kt-form--label-right form-control" id="filters" method="GET"
                              autocomplete="off">
                            <div class="form-group row">
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Complainant Name')</label>
                                    <input type="text" class="form-control" name="complainant_name" id="filter_complainant_name" placeholder="@lang('admin.Search by name')">
                                </div>
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Phone Number')</label>
                                    <input type="text" class="form-control" name="phone_number" id="filter_phone_number" placeholder="@lang('admin.Search by phone')">
                                </div>
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Type')</label>
                                    <select class="form-select" name="type" id="filter_type" data-control="select2"
                                            data-placeholder="@lang('admin.Select')">
                                        <option value="">@lang('admin.All')</option>
                                        <option value="complaint">@lang('admin.Complaint')</option>
                                        <option value="suggestion">@lang('admin.Suggestion')</option>
                                        <option value="inquiry">@lang('admin.Inquiry')</option>
                                    </select>
                                </div>
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Status')</label>
                                    <select class="form-select" name="status" id="filter_status"
                                            data-control="select2">
                                        <option value="">@lang('admin.All')</option>
                                        <option value="pending">@lang('admin.Pending')</option>
                                        <option value="in_progress">@lang('admin.In Progress')</option>
                                        <option value="resolved">@lang('admin.Resolved')</option>
                                        <option value="rejected">@lang('admin.Rejected')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Date From')</label>
                                    <input type="date" class="form-control" name="date_from" id="filter_date_from">
                                </div>
                                <div class="col-form-label col-lg-3 col-sm-6">
                                    <label class="form-label">@lang('admin.Date To')</label>
                                    <input type="date" class="form-control" name="date_to" id="filter_date_to">
                                </div>
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%" class="btn btn-info search_btn">
                                        <i class="bi bi-search"></i> البحث
                                    </a>
                                </div>
                                <div class="col-form-label col-lg-2 col-sm-6">
                                    <a href="javascript:void(0)" style="width: 100%"
                                       class="btn btn-secondary reset_search">
                                        <i class="bi bi-recycle"></i> @lang('admin.Reset')
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_complaints">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="text-center min-w-50px">#</th>
                            <th class="text-center min-w-150px">الأسم</th>
                            <th class="text-center min-w-150px">رقم الجوال</th>
                            <th class="text-center min-w-100px">النوع</th>
                            <th class="text-center min-w-100px">الحالة</th>
                            <th class="text-center min-w-150px">التفاصيل</th>
                            <th class="text-center min-w-150px">الوقت</th>
                            <th class="text-end min-w-100px">الإجرائات</th>
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

    <!-- Modal لعرض تفاصيل الشكوى -->
    <div class="modal fade" id="complaintDetailsModal" tabindex="-1" aria-labelledby="complaintDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complaintDetailsModalLabel">تفاصيل الشكوي</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="complaintDetailsBody">
                    <!-- سيتم ملؤها بواسطة AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include("admin.SitesManagement.Partial.complaints_js")
@endsection
