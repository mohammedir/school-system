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
                <div class="col-xxl-5">
                    <div class="dashboard_title_area">
                        <h2>الأراضي المتاحة للاستثمار</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p30 mb30 overflow-hidden position-relative">
                        <div class="packages_table table-responsive">
                            <table id="investor_table_my_land" class="table-style3 table at-savesearch">
                                <thead class="t-head">
                                <tr>
                                    <th scope="col" width="20%">@lang('admin.Description of the land')</th>
                                    <th scope="col">عنوان الأرض</th>
                                    <th scope="col">سعر الارض</th>
                                    <th scope="col">تاريخ الأضافة</th>
                                    <th scope="col">@lang('admin.Actions')</th>
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
                                    <form id="update_price_form" action="{{route('investors.dashboard.update_price_lands')}}" method="POST"  class="form">
                                        @csrf
                                        <div class="modal-header">
                                            <h2 class="fw-bold">@lang('admin.Edit Land Price')</h2>
                                            <div class="btn btn-icon btn-sm btn-active-icon-info" data-bs-dismiss="modal">
                                                <i class="ki-duotone ki-cross fs-1"></i>
                                            </div>
                                        </div>

                                        <div class="modal-body">
                                            <h5>@lang('admin.Real estate appraiser data')</h5>
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="form-label">@lang('admin.Name')</label>
                                                    <input type="text" disabled class="form-control" id="land_valuation_name_modal">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">@lang('admin.Contact number')</label>
                                                    <input type="text" disabled class="form-control" id="land_valuation_mobile_number_modal">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">@lang('admin.Email')</label>
                                                    <input type="text" disabled class="form-control" id="land_valuation_email_modal">
                                                </div>
                                            </div>
                                            <input type="hidden" name="land_id" id="edit_land_id">
                                            <div class="mb-3 mt-5">
                                                <label class="form-label">@lang('admin.Appraisal notes')</label>
                                                <textarea type="text" disabled class="form-control" id="land_valuation_notes_modal"></textarea>
                                            </div>
                                            <div class="mb-3 col-5">
                                                <label class="form-label">@lang('admin.Asking price')</label>
                                                <div class="input-group">
                                                    <input type="text" disabled  class="form-control text-start number_format" id="land_old_price_modal">
                                                    <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-5">
                                                <label class="form-label">@lang('admin.Valuation price')</label>
                                                <div class="input-group">
                                                    <input  type="text" disabled class="form-control text-start number_format" id="land_valuation_price_modal">
                                                    <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" name="action" id="action_input">
                                            <button type="submit" id="approve_btn" class="btn btn-success text-white">قبول السعر</button>
                                            <button type="submit" id="reject_btn" class="btn btn-danger text-white">رفض السعر</button>
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
    @include('site.dashboard.land.Partial.all_land_js')
@endsection


