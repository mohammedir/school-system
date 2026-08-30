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
                                    <div class="text fz25">الرصيد الحالي</div>
                                    <div class="text fz20 mt-2">{{getSettings()->currency_symbol}}{{number_format($investor->balance)}}</div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-home"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="d-flex justify-content-between statistics_funfact">
                                <div class="details">
                                    <div class="text fz25">الرصيد المعلق</div>
                                    <div class="text fz20 mt-2">{{getSettings()->currency_symbol}}{{number_format($pending_deposit_requests_sum)}}</div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-search-chart"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="d-flex justify-content-between statistics_funfact">
                                <div class="details">
                                    <div class="text fz25">حركات الشحن  </div>
                                    <div class="title"></div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-review"></i></div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="d-flex justify-content-between statistics_funfact">
                                <div class="details">
                                    <div class="text fz25">المرابح المتحقق  </div>
                                    <div class="title"></div>
                                </div>
                                <div class="icon text-center"><i class="flaticon-investment"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-5">
                    <div class="dashboard_title_area">
                        <h2>حركات شحن المحفظة</h2>
                    </div>
                </div>
                @if(auth()->user()->isActive())
                        <div class="col-xxl-7">
                            <div class="dashboard_search_meta d-md-flex align-items-center justify-content-xxl-end">
                                <!-- زر شحن المحفظة -->
                                <a href="javascript:void(0)"
                                   class="ud-btn btn-thm"
                                   data-bs-toggle="modal"
                                   data-bs-target="#walletModal">
                                    شحن المحفظة
                                </a>
                            </div>
                        </div>
                    @endif
            </div>
            <!-- المودال -->
            <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="walletModalLabel">شحن المحفظة</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>

                        <div class="modal-body">
                            <!-- محتوى المودال -->
                            <form id="depositForm" action="{{route('investors.dashboard.wallet.deposit_requests')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="amount" class="form-label required">@lang('investors.Payment value')</label>
                                    <input id="amount" name="amount" type="text" class="form-control number_format"  placeholder="أدخل المبلغ">
                                    <small class="text-danger error-message"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label required">@lang('investors.Payment date')</label>
                                    <input id="payment_date" name="payment_date" type="date" class="form-control" style="text-align-last:end" placeholder="أدخل التاريخ">
                                    <small class="text-danger error-message"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label required">@lang('investors.payment method')</label>
                                    <select class="form-control form-select" id="payment_method_cd" name="payment_method_cd">
                                        @foreach ($payment_method_cd as $val)
                                            <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger error-message"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label required">@lang('investors.Bank name')</label>
                                    <select class="form-control form-select" id="bank_name" name="bank_name">
                                        @foreach ($banks_cd as $val)
                                            <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger error-message"></small>

                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">ملاحظات الدفع</label>
                                    <input id="payment_notes" name="payment_notes" type="text" class="form-control" placeholder="ملاحظات الدفع">
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label required">الرقم المرجعي</label>
                                    <input id="reference_number" name="reference_number" type="number" style="text-align-last:end" class="form-control" placeholder="الرقم المرجعي">
                                    <small class="text-danger error-message"></small>

                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label required">صورة الوصل</label>
                                    <input class="form-control" type="file" name="payment_proof" style="height: auto; padding-right: 2px">
                                    <small class="text-danger error-message"></small>

                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </form>
                        </div>

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
                                    <th class="text-center" scope="col">@lang('investors.Payment value')</th>
                                    <th class="text-center" scope="col">@lang('investors.Payment date')</th>
                                    <th class="text-center"  scope="col">@lang('investors.payment method')</th>
                                    <th class="text-center" scope="col">@lang('investors.Bank name')</th>
                                    <th class="text-center" scope="col">@lang('investors.Motion condition')</th>
                                    <th class="text-center" scope="col">@lang('admin.Actions')</th>
                                </tr>
                                </thead>
                                <tbody class="t-body">

                                </tbody>
                            </table>

                        </div>
                        {{--update price--}}
                        <div class="modal fade" id="kt_modal_edit_land_price" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <form id="update_price_form" action="{{ route('investors.dashboard.update_price_lands') }}" method="POST" class="form">
                                        @csrf

                                        <!-- رأس المودال -->
                                        <div class="modal-header">
                                            <h2 class="fw-bold">@lang('admin.Review price')</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-info" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"></i>
                                            </div>
                                        </div>

                                        <!-- جسم المودال -->
                                        <div class="modal-body">
                                            <h5 class="mb-4">@lang('admin.Real estate appraiser data')</h5>

                                            <div class="row mb-4">
                                                <div class="col-md-4">
                                                    <label class="form-label">@lang('admin.Name')</label>
                                                    <input type="text" disabled class="form-control" id="land_valuation_name_modal">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">@lang('admin.Contact number')</label>
                                                    <input type="text" disabled class="form-control" id="land_valuation_mobile_number_modal">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">@lang('admin.Email')</label>
                                                    <input type="text" disabled class="form-control" id="land_valuation_email_modal">
                                                </div>
                                            </div>

                                            <input type="hidden" name="land_id" id="edit_land_id">

                                            <div class="mb-4">
                                                <label class="form-label">@lang('admin.Appraisal notes')</label>
                                                <textarea disabled class="form-control" id="land_valuation_notes_modal" rows="3"></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label">@lang('admin.Asking price')</label>
                                                    <div class="input-group">
                                                        <input type="text" disabled class="form-control text-start number_format" id="land_old_price_modal">
                                                        <span class="input-group-text">{{ getSettings()->currency_symbol }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label">@lang('admin.Valuation price')</label>
                                                    <div class="input-group">
                                                        <input type="text" disabled class="form-control text-start number_format" name="valuation_price" id="land_valuation_price_modal">
                                                        <span class="input-group-text">{{ getSettings()->currency_symbol }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- تذييل المودال -->
                                        <div class="modal-footer">
                                            <input type="hidden" name="action" id="action_input">
                                            <button type="submit" id="approve_btn" class="btn btn-success text-white">
                                                @lang('admin.Accept the current price')
                                            </button>
                                            <button type="submit" id="reject_btn" class="btn btn-danger text-white">
                                                @lang('admin.Reject Price')
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    @include('site.dashboard.wallet.Partial.my_wallet_js')
@endsection


