@extends('site.dashboard.layouts.master')
@section('content')

    <div class="dashboard__main pl0-md">
        <div class="dashboard__content property-page bgc-f7">
            <div class="row pb40 d-block d-lg-none">
                <div class="col-lg-12">
                    <div class="dashboard_navigationbar">
                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars pl10"></i> Dashboard Navigation</button>
                            <ul id="myDropdown" class="dropdown-content">
                                <li><a href="page-dashboard.html"><i class="flaticon-discovery mr10"></i>Dashboard</a></li>
                                <li><a href="page-dashboard-message.html"><i class="flaticon-chat-1 mr10"></i>Message</a></li>
                                <li><p class="fz15 fw400 ff-heading mt30 pr30">MANAGE LISTINGS</p></li>
                                <li><a href="page-dashboard-add-property.html"><i class="flaticon-new-tab mr10"></i>Add New Property</a></li>
                                <li class="active"><a href="page-dashboard-properties.html"><i class="flaticon-home mr10"></i>My Properties</a></li>
                                <li><a href="page-dashboard-favorites.html"><i class="flaticon-like mr10"></i>My Favorites</a></li>
                                <li><a href="page-dashboard-savesearch.html"><i class="flaticon-search-2 mr10"></i>Saved Search</a></li>
                                <li><a href="page-dashboard-review.html"><i class="flaticon-review mr10"></i>Reviews</a></li>
                                <li><p class="fz15 fw400 ff-heading mt30 pr30">MANAGE ACCOUNT</p></li>
                                <li><a href="page-dashboard-package.html"><i class="flaticon-protection mr10"></i>My Package</a></li>
                                <li><a href="page-dashboard-profile.html"><i class="flaticon-user mr10"></i>My Profile</a></li>
                                <li><a class="" href="page-login.html"><i class="flaticon-exit mr10"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center pb40">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                    <div class="row">
                        <div class="col-sm-6 col-xxl-3">
                            <div class="d-flex justify-content-between statistics_funfact">
                                <div class="details">
                                    <div class="text fz25">إجمالي الإيداعات</div>
                                    <div class="text fz20 mt-2 text-success fw-bold">{{getSettings()->currency_symbol}}{{number_format($investor->total_deposits)}}</div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-search-chart"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="d-flex justify-content-between statistics_funfact">
                                <div class="details">
                                    <div class="text fz25">إجمالي المصروفات</div>
                                    <div class="text fz20 mt-2 text-danger fw-bold">{{getSettings()->currency_symbol}}{{number_format($investor->total_expenses)}}</div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-search-chart"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="d-flex justify-content-between statistics_funfact">
                                <div class="details">
                                    <div class="text fz25">الرصيد الحالي</div>
                                    <div class="text fz20 mt-2 text-success fw-bold">{{getSettings()->currency_symbol}}{{number_format($investor->balance)}}</div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-home"></i></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xxl-3">
                    <div class="dashboard_title_area">
                        <h2>@lang('investors.Financial movements')</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p30 mb30 overflow-hidden position-relative">
                        <div class="packages_table table-responsive">
                            <table id="investor_table_my_wallet" class="table-style3 table at-savesearch">
                                <thead class="t-head">
                                <tr>
                                    <th class="text-center" scope="col">@lang('investors.Movement value')</th>
                                    <th class="text-center" scope="col">@lang('investors.History of the movement')</th>
                                    <th class="text-center"  scope="col">@lang('investors.balance_before')</th>
                                    <th class="text-center" scope="col">@lang('investors.balance_after')</th>
                                    <th class="text-center" scope="col">@lang('investors.Type condition')</th>
                                </tr>
                                </thead>
                                <tbody class="t-body">

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    @include('site.dashboard.wallet.Partial.my_transactions_js')
@endsection


