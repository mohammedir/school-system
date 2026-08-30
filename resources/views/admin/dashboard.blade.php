@extends('admin.layouts.master')
@section('content')
    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xxl-4 mb-5 mb-xl-10">
            <!--begin::Chart widget 27-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header py-7">
                    <!--begin::Statistics-->
                    <div class="m-0">
                        <!--begin::Heading-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Title-->
                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">احصائيات عامة</span>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 pb-1">
                    <div id="general_stats" class="min-h-auto"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 27-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-4 mb-5 mb-xl-10">
            <!--begin::Chart widget 28-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header py-7">
                    <!--begin::Statistics-->
                    <div class="m-0">
                        <!--begin::Heading-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Title-->
                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">2,579</span>
                            <!--end::Title-->
                            <!--begin::Label-->
                            <span class="badge badge-light-success fs-base"><i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.2%</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Description-->
                        <span class="fs-6 fw-semibold text-gray-500">مشتريات الأسهم خلال الأسبوع</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body d-flex align-items-end ps-4 pe-0 pb-4">
                    <!--begin::Chart-->
                    <div id="shares_buying_stats" class="h-300px w-100 min-h-auto"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart widget 28-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-4 mb-5 mb-xl-10">
            <!--begin::List widget 9-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header py-7">
                    <!--begin::Statistics-->
                    <div class="m-0">
                        <!--begin::Heading-->
                        <div class="d-flex align-items-center mb-2">
                            <!--begin::Title-->
                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">5,037</span>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Description-->
                        <span class="fs-6 fw-semibold text-gray-500">إجمالي الأسهم حسب المشاريع</span>
                        <!--end::Description-->
                    </div>
                    <!--end::Statistics-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body card-body d-flex justify-content-between flex-column pt-3">
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('assets/media/avatars/300-1.jpg') }}" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6"> مشروع سكني</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">محمد علي</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">1,579</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('assets/media/avatars/300-5.jpg') }}" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6"> برج سكني</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">أحمد محمد</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">1,288</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('assets/media/avatars/300-7.jpg') }}" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">مشروع تجاري سكني في حي الرمال </a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">إياد</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">994</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('assets/media/avatars/300-13.jpg') }}" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6"> عمارة سكنية 4 طوابق </a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">سامي</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">778</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Separator-->
                    <div class="separator separator-dashed my-3"></div>
                    <!--end::Separator-->
                    <!--begin::Item-->
                    <div class="d-flex flex-stack">
                        <!--begin::Flag-->
                        <img src="{{ asset('assets/media/avatars/300-21.jpg') }}" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                        <!--end::Flag-->
                        <!--begin::Section-->
                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                            <!--begin::Content-->
                            <div class="me-5">
                                <!--begin::Title-->
                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6"> مشروع تجاري في حي النصر</a>
                                <!--end::Title-->
                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">عمر</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Content-->
                            <!--begin::Wrapper-->
                            <div class="d-flex align-items-center">
                                <!--begin::Number-->
                                <span class="text-gray-800 fw-bold fs-4 me-3">658</span>
                                <!--end::Number-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::List widget 9-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-6 mb-5 mb-xl-10">
            <!--begin::Table widget 9-->
            <div class="card card-flush h-xl-90">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">أكبر 5 مشاريع</span>
                        <span class="text-gray-500 pt-1 fw-semibold fs-6"> حسب قيمة المشاريع </span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light">PDF تقرير</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fs-7 fw-bold border-0 text-gray-500">
                                <th class="min-w-150px" colspan="2">المشروع</th>
                                <th class="min-w-150px text-end pe-0" colspan="2">القيمة الإجمالية ($)</th>
                                <th class="text-end min-w-150px" colspan="2">الهدف ($) </th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">مشروع سكني في حي النصر</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">1,358,000</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">1,850,000</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">برج سكني</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">850,000</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">1,150,000</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">مشروع تجاري سكني حي الرمال</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">660,000</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">978,000</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">عمارة سكنية 5 طوابق</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">350,000</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">875,000</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">مشروع تجاري </a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">50,256</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">70,000</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Table Widget 9-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-6 mb-5 mb-xl-10">
            <!--begin::Table widget 10-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">أكبر 5 مستثمرين</span>
                        <span class="text-gray-500 pt-1 fw-semibold fs-6">حسب عدد الأسهم المملوكة</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light">PDF تقرير</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fs-7 fw-bold border-0 text-gray-500">
                                <th class="min-w-200px" colspan="2">اسم المستثمر</th>
                                <th class="min-w-100px pe-0" colspan="2">أجمالي الأسهم</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">محمد علي</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex">
                                        <span class="text-gray-800 fw-bold fs-6">2,256</span>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">محمود أحمد </a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex">
                                        <span class="text-gray-800 fw-bold fs-6">1,800</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6"> إياد</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex">
                                        <span class="text-gray-800 fw-bold fs-6">1,556</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6"> عمر محمد</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex">
                                        <span class="text-gray-800 fw-bold fs-6">1,256</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6"> السيد علي</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex">
                                        <span class="text-gray-800 fw-bold fs-6">850</span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Table Widget 10-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-6 mb-5 mb-xl-10">
            <!--begin::Table widget 11-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">الأسهم المتاحة للاستثمار</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-sm btn-light">PDF تقرير</a>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between flex-column py-3">
                    <!--begin::Block-->
                    <div class="m-0"></div>
                    <!--end::Block-->
                    <!--begin::Table container-->
                    <div class="table-responsive mb-n2">
                        <!--begin::Table-->
                        <table class="table table-row-dashed gs-0 gy-4">
                            <!--begin::Table head-->
                            <thead>
                            <tr class="fs-7 fw-bold border-0 text-gray-500">
                                <th class="min-w-300px">المشروع</th>
                                <th class="min-w-100px">عدد الأسهم الشاغرة</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            <tr>
                                <td>
                                    <a href="#" class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6">مشروع تجاري في حي النصر</a>
                                </td>
                                <td class="d-flex align-items-center border-0">
                                    <span class="fw-bold text-gray-800 fs-6 me-3">720</span>
                                    <div class="progress rounded-start-0">
                                        <div class="progress-bar bg-success m-0" role="progressbar" style="height: 12px;width: 166px" aria-valuenow="166" aria-valuemin="0" aria-valuemax="166px"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6">مشروع تجاري في حي الرمال </a>
                                </td>
                                <td class="d-flex align-items-center border-0">
                                    <span class="fw-bold text-gray-800 fs-6 me-3">687</span>
                                    <div class="progress rounded-start-0">
                                        <div class="progress-bar bg-success m-0" role="progressbar" style="height: 12px;width: 158px" aria-valuenow="158" aria-valuemin="0" aria-valuemax="158px"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6">برج سكني </a>
                                </td>
                                <td class="d-flex align-items-center border-0">
                                    <span class="fw-bold text-gray-800 fs-6 me-3">455</span>
                                    <div class="progress rounded-start-0">
                                        <div class="progress-bar bg-success m-0" role="progressbar" style="height: 12px;width: 129px" aria-valuenow="129" aria-valuemin="0" aria-valuemax="129px"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6">عمارة تجارية سكنية في تل الهوا</a>
                                </td>
                                <td class="d-flex align-items-center border-0">
                                    <span class="fw-bold text-gray-800 fs-6 me-3">340</span>
                                    <div class="progress rounded-start-0">
                                        <div class="progress-bar bg-success m-0" role="progressbar" style="height: 12px;width: 112px" aria-valuenow="112" aria-valuemin="0" aria-valuemax="112px"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6"> عمارة سكنية</a>
                                </td>
                                <td class="d-flex align-items-center border-0">
                                    <span class="fw-bold text-gray-800 fs-6 me-3">230</span>
                                    <div class="progress rounded-start-0">
                                        <div class="progress-bar bg-success m-0" role="progressbar" style="height: 12px;width: 107px" aria-valuenow="107" aria-valuemin="0" aria-valuemax="107px"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" class="text-gray-600 fw-bold text-hover-primary mb-1 fs-6">مشروع سكني في شارع الجلاء</a>
                                </td>
                                <td class="d-flex align-items-center border-0">
                                    <span class="fw-bold text-gray-800 fs-6 me-3">115</span>
                                    <div class="progress rounded-start-0">
                                        <div class="progress-bar bg-success m-0" role="progressbar" style="height: 12px;width: 74px" aria-valuenow="74" aria-valuemin="0" aria-valuemax="74px"></div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Table Widget 11-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
@endsection

@section('js')
    @include("admin.dashboard_js")
@endsection
