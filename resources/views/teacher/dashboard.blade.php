@extends('teacher.layouts.master')
@section('content')
    <!--begin::Row-->


    @if($teacher->status == 'pending')
        <!--begin::Notice-->
        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
            <!--begin::Icon-->
            <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <!--end::Icon-->
            <!--begin::Wrapper-->
                <div class="d-flex flex-stack flex-grow-1">
                    <!--begin::Content-->
                    <div class="fw-semibold">
                        <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                        <div class="fs-6 text-gray-700">@lang('engineering.Your request is still under review. Please be patient.')</div>
                    </div>
                    <!--end::Content-->
                </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Notice-->
    @endif
    @if($teacher->status != "active")
        <!--begin::Notice-->
       <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed p-6">
            <!--begin::Icon-->
            <i class="ki-duotone ki-information fs-2tx text-danager me-4">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <!--end::Icon-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-grow-1">
                <!--begin::Content-->
                <div class="fw-semibold">
                    <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                    <div class="fs-6 text-gray-700 mb-2">
                        @if($teacher->status == 'inactive')
                            تم إلغاء تفعيل حسابك. يرجى مراجعة سبب إلغاء تفعيل الحساب من قبل الإدارة.
                        @else
                            تم توقيف حسابك. يرجى مراجعة سبب توقيف الحساب من قبل الإدارة.
                        @endif
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Notice-->
    @endif
    @if($teacher->status == 'active')
    <div class="row gx-5 gx-xl-10">
        <!--begin::Col-->
        <div class="col-xl-6 mb-5 mb-xl-10">
            <!--begin::Table widget 9-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-800">أحدث عروض الأسعار المقدمة</span>
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
                                <th class="min-w-150px text-end pe-0" colspan="2">عرض السعر</th>
                                <th class="text-end min-w-150px" colspan="2"> حالة عرض السعر</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Google</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">1,256</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-935</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">23.63%</span>
                                        <span class="text-danger min-w-60px d-block text-end fw-bold fs-6">-9.35%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Facebook</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">446</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-576</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">12.45%</span>
                                        <span class="text-danger min-w-60px d-block text-end fw-bold fs-6">-57.02%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Bol.com</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">67</span>
                                        <span class="text-success min-w-50px d-block text-end fw-bold fs-6">+24</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">73.63%</span>
                                        <span class="text-success min-w-60px d-block text-end fw-bold fs-6">+28.73%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#"
                                       class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Dutchnews.nl</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">2,136</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-1,229</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">3.67%</span>
                                        <span class="text-danger min-w-60px d-block text-end fw-bold fs-6">-12.29%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#"
                                       class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Stackoverflow</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">945</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-634</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">25.03%</span>
                                        <span class="text-danger min-w-60px d-block text-end fw-bold fs-6">-9.35%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#"
                                       class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Themeforest</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6 me-1">237</span>
                                        <span class="text-success min-w-50px d-block text-end fw-bold fs-6">106</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6 me-3">36.52%</span>
                                        <span class="text-success min-w-60px d-block text-end fw-bold fs-6">+3.06%</span>
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
                        <span class="card-label fw-bold text-gray-800">آخر المشاريع </span>
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
                                <th class="min-w-200px" colspan="2"> المشروع</th>
                                <th class="min-w-100px text-end pe-0" colspan="2">القيمة</th>
                                <th class="text-end min-w-100px" colspan="2">حالة المشروع</th>
                            </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Index</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6">1,256</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-935</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6">2.63</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-1.35</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Products</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6">446</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-576</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6">1.45</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">0.32</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">devs.keenthemes.com</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6">67</span>
                                        <span class="text-success min-w-50px d-block text-end fw-bold fs-6">+24</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6">7.63</span>
                                        <span class="text-success min-w-50px d-block text-end fw-bold fs-6">+8.73</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">studio.keenthemes.com</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6">2,136</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-1,229</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6">3.67</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-2.29</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">graphics.keenthemes.com</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6">945</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-634</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6">5.03</span>
                                        <span class="text-danger min-w-50px d-block text-end fw-bold fs-6">-0.35</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="" colspan="2">
                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">Licenses</a>
                                </td>
                                <td class="pe-0" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-800 fw-bold fs-6">237</span>
                                        <span class="text-success min-w-50px d-block text-end fw-bold fs-6">106</span>
                                    </div>
                                </td>
                                <td class="" colspan="2">
                                    <div class="d-flex justify-content-end">
                                        <span class="text-gray-900 fw-bold fs-6">3.52</span>
                                        <span class="text-success min-w-50px d-block text-end fw-bold fs-6">+3.06</span>
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
    @endif
    <!--end::Row-->
@endsection
