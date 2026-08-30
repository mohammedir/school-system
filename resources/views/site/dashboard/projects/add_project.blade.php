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
                                <li class="active"><a href="page-dashboard-add-property.html"><i class="flaticon-new-tab mr10"></i>@lang('admin.Add land')</a></li>
                                <li><a href="page-dashboard-properties.html"><i class="flaticon-home mr10"></i>My Properties</a></li>
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
                <div class="col-lg-12">
                    <div class="dashboard_title_area">
                        <h2>@lang('investors.Create a project')</h2>
                    </div>
                </div>
            </div>
            <!--begin::Card - Land Info-->
            <div class="card card-flush mt-8">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <div class="col-md-4">
                        <h3 class="text-danger">@lang('admin.Land details')</h3>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body">
                    <!-- Description -->
                    <input type="hidden" value="{{$land->id}}" id="land_id" name="land_id">
                    <div class="mb-7">
                        <label class="form-label fw-bold">@lang('admin.Main Image'):</label>
                        <img id="preview_main_land_image" src="{{asset('uploads/lands/'.$land->land_logo)}}" alt="معاينة الصورة" style="max-width: 100%; max-height: 300px;" />
                    </div>
                    <div class="mb-7" style="padding-bottom: 12px">
                        <label class="form-label fw-bold">@lang('admin.Description of the land'):</label>
                        <div class="form-control form-control-solid bg-light">{{ $land->land_description }}</div>
                    </div>

                    <!-- Additional Info -->
                    <div class="row g-4 mb-7">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">@lang('admin.Border'):</label>
                            <div class="form-control form-control-solid bg-light d-flex  align-items-center">{{ $land->borders ?? '---' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">@lang('admin.Available services'):</label>
                            <div class="form-control form-control-solid bg-light d-flex  align-items-center">{{ $land->services ?? '---' }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">@lang('admin.Asking price'):</label>
                            <div class="input-group">
                                <input disabled class="form-control form-control-solid bg-light number_format d-flex  align-items-center" value="{{$land->price}}" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
                                <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Area and Numbers -->
                    <div class="row g-4 mb-7 mt-5" style="padding-bottom: 12px">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">@lang('admin.Land area'):</label>
                            <div class="input-group">
                                <div class="form-control form-control-solid bg-light d-flex  align-items-center">{{ $land->area }}</div>
                                <span class="input-group-text">م2</span>
                            </div>
                        </div>
                        {{--<div class="col-md-3">
                            <label class="form-label fw-bold">@lang('admin.Plot Number'):</label>
                            <div class="form-control form-control-solid bg-light d-flex align-items-center">{{ $land->parcel_number }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">@lang('admin.Parcel Number'):</label>
                            <div class="form-control form-control-solid bg-light d-flex  align-items-center">{{ $land->plot_number ?? '---' }}</div>
                        </div>--}}
                        <div class="col-md-3">
                            <label class="form-label fw-bold">@lang('admin.Type of land ownership'):</label>
                            <div class="form-control form-control-solid bg-light d-flex  align-items-center">
                                {{ getlookup($land->ownership_type_cd)->{'name_'.app()->getLocale()} ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">@lang('admin.City'):</label>
                            <div class="form-control form-control-solid bg-light d-flex  align-items-center">
                                {{ getlookup($land->city_cd)->{"name_".app()->getLocale()} ?? '---' }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">@lang('admin.District'):</label>
                            <div class="form-control form-control-solid bg-light d-flex  align-items-center">
                                {{ getlookup($land->district_cd)->{"name_".app()->getLocale()} ?? '---' }}
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <div class="row" style="margin-top: 25px">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 pt30 mb30 overflow-hidden position-relative" >
                            <div id="formErrorMsg" class="alert alert-danger d-none"></div>
                        <form id="investors_add_project_form" action="{{ route('investors.dashboard.add_project',['land_id',$land_id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="land_id" value="{{$land_id}}">
                            <div class="card-body">
                                <!--begin::Form-->
                                <div class="row g-4 mb-15">
                                    <div class="col-md-6 fv-row">
                                        <label class="heading-color ff-heading fw600 mb10 required form-label">@lang('admin.Project logo')</label>
                                        <input type="file" id="project_logo" class="form-control" name="project_logo"  accept="image/*" required style="height: auto; padding-right: 2px">
                                        <!-- عنصر المعاينة -->
                                        <div style="margin-top: 10px;">
                                            <img id="preview_project_logo" src="#" alt="معاينة الصورة" style="max-width: 100%; max-height: 300px; display: none;" />
                                        </div>
                                    </div>
                                    {{--<small class="text-muted">الحد الأدنى للأبعاد: 160 × 160 بكسل</small>--}}

                                </div>
                                <div class="row g-4 mb-15" style="padding-bottom: 12px">
                                    <div class="col-md-8 fv-row">
                                        <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Project name')</label>
                                        <input class="form-control" name="title" required>
                                    </div>
                                    <!--end::Col-->
                                </div>

                                <div class="row g-4 mb-15" style="padding-bottom: 12px">
                                    <div class="col-md-4 fv-row">
                                        <label class="required heading-color ff-heading fw600 mb10">@lang('admin.Project type')</label>
                                        <select name="project_type_cd" class="form-select form-control" data-control="select2" data-placeholder="@lang('admin.Project type')" required>
                                            <option disabled>@lang('admin.Project type')</option>
                                            @foreach(get_lookup_by_master_key('project_type_cd') as $val)
                                                <option value="{{$val->id}}">{{$val->{'name_' . app()->getLocale()} }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 fv-row">
                                        <label class="required heading-color ff-heading fw600 mb10">@lang('admin.Project space')</label>
                                        <div class="input-group">
                                            <input class="form-control text-start" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')" required>
                                            <span class="input-group-text">م2</span>
                                        </div>
                                        <!--begin::Hint-->
                                        <div class="form-text text-info">@lang('admin.The building percentage is subject to regulatory requirements.')</div>
                                        <!--end::Hint-->
                                        <div id="area-error" class="text-danger d-none">@lang('admin.Project area cannot exceed land area') <span id="land_area_note"></span>م2</div>

                                    </div>
                                    <input type="hidden" name="investor_balance" value="{{ $investor_balance ?? '' }}">
                                    <div class="col-md-4 fv-row">
                                        <label class="required heading-color ff-heading fw600 mb10">@lang('admin.Project cost')</label>
                                        <div class="input-group">
                                            <input class="form-control text-start number_format" id="project_cost" name="project_cost" type="text" placeholder="@lang('admin.Enter The project cost')" required>
                                            <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                        </div>
                                        <!--begin::Hint-->
                                        <div class="form-text text-info" style="font-size: 10px">@lang('admin.Your balance must be at least 10% of the estimated cost.')</div>
                                        <!--end::Hint-->
                                    </div>
                                </div>

                                <div class="row g-4 mb-15">
                                    <div class="col-md-12 fv-row">
                                        <label class="heading-color ff-heading fw600 mb10">@lang('admin.Project description')</label>
                                        {{--<textarea  rows="3" class="form-control kt_docs_ckeditor_document" name="description"></textarea>--}}
                                        <textarea name="description" rows="3" style="display: none;"></textarea>

                                        <div class="kt_docs_ckeditor_document_toolbar"></div>
                                        <div class="kt_docs_ckeditor_document border-secondary" style="border-color: #6c757d !important;"></div>
                                    </div>
                                </div>
                                <!--<div class="row g-4 mb-15">
                                <div class="col-md-6 fv-row">
                                    <label class="required form-label">@lang('admin.Engineering bid opening date')</label>
                                    <input type="date" name="offers_start_date" class="form-control text-start kt_datepicker">
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="required form-label">@lang('admin.Closing date for engineering bids')</label>
                                    <input type="date" name="offers_end_date" class="form-control text-start kt_datepicker">
                                </div>
                            </div>-->
                                <div class="row g-4 mb-15" style="padding-top: 15px; padding-bottom: 15px">
                                    <div class="col-md-9 offset-md-3 text-end">
                                        <button type="submit" class="ud-btn btn-thm" id="submitBtn">
                                            <span class="btn-text">@lang('admin.Submit')</span>
                                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true" id="btnSpinner"></span>
                                        </button>
                                        <button type="button" class="ud-btn btn-thm3"><i class="bi bi-x-circle"></i> @lang('admin.Discard')</button>

                                    </div>
                                </div>

                                <!--end::Form-->
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

    @include('site.dashboard.projects.Partial.add_project_js')
@endsection


