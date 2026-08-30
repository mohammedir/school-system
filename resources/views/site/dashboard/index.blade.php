@php use Illuminate\Support\Facades\Auth; @endphp
@extends('site.dashboard.layouts.master')
@section('content')
    <div class="dashboard__main pl0-md">
        <div class="dashboard__content bgc-f7">
            <div class="dashboard_title_area d-flex align-items-center justify-content-between flex-wrap">
                @php
                    $investor = Auth::guard('investors')->user();
                @endphp

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h2 class="mb-0">مرحباً {{ $investor->full_name }}</h2>

                    {{-- رابط التنبيه بالبروفايل --}}
                    @if($investor->isNew())
                        <a href="{{route('investors.dashboard.profile')}}"
                           class="btn btn-sm btn-warning ms-3 d-flex align-items-center gap-1"
                           style="font-size: 14px;">
                            <i class="fa fa-exclamation-circle"></i>الرجاء إكمال متطلبات التحقق من الهوية الشخصية
                        </a>
                    @elseif($investor->isPending() || $investor->isUpdated())
                        <a href="{{route('investors.dashboard.profile')}}"
                           class="btn btn-sm btn-warning ms-3 d-flex align-items-center gap-1"
                           style="font-size: 14px;">
                            <i class="fa fa-exclamation-circle"></i>طلبك قيد المراجعة الرجاء الانتظار
                        </a>
                    @elseif($investor->isRejected())
                        <a href="{{route('investors.dashboard.profile')}}"
                           class="btn btn-sm btn-danger ms-3 d-flex align-items-center gap-1"
                           style="font-size: 14px;">
                            <i class="fa fa-exclamation-square"></i>لقد تم رفض الحساب الخاص بك اضغط لمعرفة السبب
                        </a>
                    @else
                        <div class="icon">
                            <i class="fas fa-check-circle fs-5 pt-2" style="color: #0f9d58;" title="تم التحقق من الهوية الشخصية"></i>
                        </div>
                    @endif
                </div>

                <div class="w-100 mt-2">
                    <p class="text">يسعدنا رؤيتك مرة أخرى!</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-xxl-3">
                    <div class="d-flex justify-content-between statistics_funfact">
                        <div class="details">
                            <div class="text fz25">الأراضي المتاحة </div>
                            <div class="title"></div>
                        </div>
                        <div class="icon text-center"><i class="flaticon-home"></i></div>
                    </div>
                </div>
                <div class="col-sm-6 col-xxl-3">
                    <div class="d-flex justify-content-between statistics_funfact">
                        <div class="details">
                            <div class="text fz25">الأراضي الخاصة بي </div>
                            <div class="title"></div>
                        </div>
                        <div class="icon text-center"><i class="flaticon-search-chart"></i></div>
                    </div>
                </div>
                <div class="col-sm-6 col-xxl-3">
                    <div class="d-flex justify-content-between statistics_funfact">
                        <div class="details">
                            <div class="text fz25">مشاريعي  </div>
                            <div class="title"></div>
                        </div>
                        <div class="icon text-center"><i class="flaticon-review"></i></div>
                    </div>
                </div>
                <div class="col-sm-6 col-xxl-3">
                    <div class="d-flex justify-content-between statistics_funfact">
                        <div class="details">
                            <div class="text fz25">أسهمي  </div>
                            <div class="title"></div>
                        </div>
                        <div class="icon text-center"><i class="flaticon-investment"></i></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p30 mb30 overflow-hidden position-relative">
                        <div class="navtab-style1">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <h4 class="title fz17 mb20">احصائيات أسهمي </h4>
                                <ul class="nav nav-tabs border-bottom-0 mb30" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link fw600 active" id="hourly-tab" data-bs-toggle="tab" href="#hourly" role="tab" aria-controls="hourly" aria-selected="true">أسبوعي</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link fw600" id="weekly-tab" data-bs-toggle="tab" href="#weekly" role="tab" aria-controls="weekly" aria-selected="false">شهري</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link fw600" id="monthly-tab" data-bs-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">سنوي</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="hourly" role="tabpanel" aria-labelledby="hourly-tab">
                                    <canvas class="chart-container" id="doublebar-chart"></canvas>
                                </div>
                                <div class="tab-pane fade w-100" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                                    <canvas class="canvas w-100" id="myChartweave"></canvas>
                                </div>
                                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                    <div class="chart pt20">
                                        <canvas class="w-100" id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--begin footer--}}
        @include('site.dashboard.layouts.footer')

    </div>

@endsection

