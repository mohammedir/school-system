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
                        <h2>@lang('investors.view_project')</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 pt30 mb30 overflow-hidden position-relative">
                        <div class="navtab-style1">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab2" role="tablist">
                                    <button class="nav-link active fw600 ms-3" id="nav-item1-tab" data-bs-toggle="tab" data-bs-target="#nav-item1" type="button" role="tab" aria-controls="nav-item1" aria-selected="true">نظرة عامة</button>
                                    <button class="nav-link fw600" id="nav-item2-tab" data-bs-toggle="tab" data-bs-target="#nav-item2" type="button" role="tab" aria-controls="nav-item2" aria-selected="false">سجل المشروع</button>
                                    <button class="nav-link fw600" id="nav-item3-tab" data-bs-toggle="tab" data-bs-target="#nav-item3" type="button" role="tab" aria-controls="nav-item3" aria-selected="false">عروض الاسعار الاستشارية </button>
                                    <button class="nav-link fw600" id="nav-item4-tab" data-bs-toggle="tab" data-bs-target="#nav-item4" type="button" role="tab" aria-controls="nav-item4" aria-selected="false">عروض أسعار المقاولات </button>
                                    <button class="nav-link fw600" id="nav-item5-tab" data-bs-toggle="tab" data-bs-target="#nav-item5" type="button" role="tab" aria-controls="nav-item5" aria-selected="false">سجل المساهمين</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-item1" role="tabpanel" aria-labelledby="nav-item1-tab">
                                    <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
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
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="ps-widget bgc-white bdrs12 default-box-shadow2 pt30 mb30 overflow-hidden position-relative" >
                                                    <div id="formErrorMsg" class="alert alert-danger d-none"></div>
                                                    <form id="investors_add_project_form" action="{{ route('investors.dashboard.add_project',['land_id',$land_id]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="land_id" value="{{$land_id}}">
                                                        <div class="card-body">
                                                            <!--begin::Form-->
                                                            {{--<div class="row g-4 mb-15">
                                                                <label class="required form-label">وصف الأرض</label>
                                                                <p><b>{{$land->land_description}}</b></p>
                                                            </div>
                                                            <hr>--}}
                                                            <div class="row g-4 mb-15">
                                                                <div class="col-md-2 fv-row">
                                                                    <label class="required form-label">@lang('admin.Project logo')</label>
                                                                    <!-- عنصر المعاينة -->
                                                                    <div style="margin-top: 10px;">
                                                                        <img id="preview_project_logo" src="{{asset('uploads/projects/'.$project->project_logo)}}" alt="معاينة الصورة" style="max-width: 100%; max-height: 300px; " />
                                                                    </div>
                                                                </div>
                                                                {{--<small class="text-muted">الحد الأدنى للأبعاد: 160 × 160 بكسل</small>--}}

                                                            </div>
                                                            <div class="row g-4 mb-15 mt-5">
                                                                <div class="col-md-8 fv-row">
                                                                    <label class="required form-label">@lang('admin.Project name')</label>
                                                                    <input readonly class="form-control" name="title" required value="{{$project->title}}">
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>

                                                            <div class="row g-4 mb-15 mt-10">
                                                                <div class="col-md-4 fv-row">
                                                                    <label class="required form-label">@lang('admin.Project type')</label>
                                                                    <select disabled name="project_type_cd" class="form-control text-start" data-control="select2" data-placeholder="@lang('admin.Project type')" required>
                                                                        <option></option>
                                                                        @foreach(get_lookup_by_master_key('project_type_cd') as $val)
                                                                            <option value="{{$val->id}}" @if($project->project_type_cd == $val->id) selected @endif>{{$val->{'name_' . app()->getLocale()} }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4 fv-row">
                                                                    <label class="required form-label">@lang('admin.Project space')</label>
                                                                    <div class="input-group">
                                                                        <input disabled class="form-control text-start" value="{{$project->area}}" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')" required>
                                                                        <span class="input-group-text">م2</span>
                                                                    </div>
                                                                    <!--begin::Hint-->
                                                                    <div class="form-text text-info">@lang('admin.The building percentage is subject to regulatory requirements.')</div>
                                                                    <!--end::Hint-->
                                                                    <br>
                                                                    <div id="area-error" class="text-danger mt-2 d-none">@lang('admin.Project area cannot exceed land area') <span id="land_area_note"></span>م2</div>

                                                                </div>
                                                                <div class="col-md-4 fv-row">
                                                                    <label class="required form-label">@lang('admin.Project cost')</label>
                                                                    <div class="input-group">
                                                                        <input disabled class="form-control text-start number_format" id="project_cost" name="project_cost" type="text" value="{{$project->project_cost}}" placeholder="@lang('admin.Enter The project cost')" required>
                                                                        <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row g-4 mb-15 mt-5" style="padding-bottom: 30px">
                                                                <div class="col-md-12 fv-row">
                                                                    <label class="form-label">@lang('admin.Project description')</label>
                                                                    {{--<textarea  rows="3" class="form-control kt_docs_ckeditor_document" name="description"></textarea>--}}

                                                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5" style="background-color: #f5f4f4">
                                                                        {!! htmlspecialchars_decode($project->description) !!}
                                                                    </div>
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

                                                            <!--end::Form-->
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-item2" role="tabpanel" aria-labelledby="nav-item2-tab">
                                    <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_history_list">
                                            <thead>
                                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                <th class="text-center min-w-125px">@lang('admin.Notifications')</th>
                                                <th class="text-center min-w-125px">@lang('admin.Time')</th>
                                                <th class="text-center min-w-125px">@lang('admin.From')</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-semibold">
                                            @foreach($projectLogs as $projectLog) {{-- ⚠️ use plural for the collection --}}
                                            <tr class="text-center">
                                                <td class="min-w-125px">{{ $projectLog->description }}</td>
                                                <td class="min-w-125px">{{ $projectLog->created_at->diffForHumans() }}</td>
                                                <td class="min-w-125px">
                                                    @if($projectLog->user_id != '' && $projectLog->user_type == 'investor')
                                                        {{getInvestorData($projectLog->user_id)->full_name}}
                                                    @elseif($projectLog->user_id != '' && $projectLog->user_type == 'user')
                                                        {{getUserData($projectLog->user_id)->name}}
                                                    @else
                                                        {{getEngineeringPartnerData($projectLog->engineering_partner_id)->company_name}}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-item3" role="tabpanel" aria-labelledby="nav-item3-tab">
                                    <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                        <h4 class="title fz17 mb30">Listing Location</h4>
                                        <form class="form-style1">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Address</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Country / State</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>Belgiul</option>
                                                                <option>France</option>
                                                                <option>Kewait</option>
                                                                <option>Qatar</option>
                                                                <option>Netherland</option>
                                                                <option>Germany</option>
                                                                <option>Turkey</option>
                                                                <option>UK</option>
                                                                <option>USA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">City</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>California</option>
                                                                <option>Chicago</option>
                                                                <option>Los Angeles</option>
                                                                <option>Manhattan</option>
                                                                <option>New Jersey</option>
                                                                <option>New York</option>
                                                                <option>San Diego</option>
                                                                <option>San Francisco</option>
                                                                <option>Texas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Neighborhood</label>
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Zip</label>
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Country</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>Belgiul</option>
                                                                <option>France</option>
                                                                <option>Kewait</option>
                                                                <option>Qatar</option>
                                                                <option>Netherland</option>
                                                                <option>Germany</option>
                                                                <option>Turkey</option>
                                                                <option>UK</option>
                                                                <option>USA</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb20 mt30">
                                                        <label class="heading-color ff-heading fw600 mb30">Place the listing pin on the map</label>
                                                        <iframe class="h550" loading="lazy" src="https://maps.google.com/maps?q=London%20Eye%2C%20London%2C%20United%20Kingdom&amp;t=m&amp;z=14&amp;output=embed&amp;iwloc=near" title="London Eye, London, United Kingdom" aria-label="London Eye, London, United Kingdom"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb30">
                                                        <label class="heading-color ff-heading fw600 mb10">Latitude</label>
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb30">
                                                        <label class="heading-color ff-heading fw600 mb10">Longitude</label>
                                                        <input type="text" class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-sm-flex justify-content-between">
                                                        <a class="ud-btn btn-white" href="">Prev Step<i class="fal fa-arrow-right-long"></i></a>
                                                        <a class="ud-btn btn-dark" href="">Next Step<i class="fal fa-arrow-right-long"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-item4" role="tabpanel" aria-labelledby="nav-item4-tab">
                                    <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                        <h4 class="title fz17 mb30">Listing Detail</h4>
                                        <form class="form-style1">
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Size in ft (only numbers)</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Lot size in ft (only numbers)</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Rooms</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Bedrooms</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Bathrooms</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Custom ID (text)</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Garages</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Garage size</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Year built (numeric)</label>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Available from (date)</label>
                                                        <input type="text" class="form-control" placeholder="99.aa.yyyy">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Basement</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Extra details</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Roofing</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Exterior Material</label>
                                                        <input type="text" class="form-control" placeholder="Your Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Structure type</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>Apartments</option>
                                                                <option>Bungalow</option>
                                                                <option>Houses</option>
                                                                <option>Loft</option>
                                                                <option>Office</option>
                                                                <option>Townhome</option>
                                                                <option>Villa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Floors no</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>1st</option>
                                                                <option>2nd</option>
                                                                <option>3rd</option>
                                                                <option>4th</option>
                                                                <option>5th</option>
                                                                <option>6th</option>
                                                                <option>7th</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="mb20">
                                                        <label class="heading-color ff-heading fw600 mb10">Owner/ Agent nots (not visible on front end)</label>
                                                        <textarea cols="30" rows="5" placeholder="There are many variations of passages."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb30">
                                                        <label class="heading-color ff-heading fw600 mb10">Energy Class</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>All Listing</option>
                                                                <option>Active</option>
                                                                <option>Sold</option>
                                                                <option>Processing</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xl-4">
                                                    <div class="mb30">
                                                        <label class="heading-color ff-heading fw600 mb10">Energy index in kWh/m2a</label>
                                                        <div class="location-area">
                                                            <select class="selectpicker" multiple>
                                                                <option>All Cities</option>
                                                                <option>Pending</option>
                                                                <option>Processing</option>
                                                                <option>Published</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-sm-flex justify-content-between">
                                                        <a class="ud-btn btn-white" href="">Prev Step<i class="fal fa-arrow-right-long"></i></a>
                                                        <a class="ud-btn btn-dark" href="">Next Step<i class="fal fa-arrow-right-long"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-item5" role="tabpanel" aria-labelledby="nav-item5-tab">
                                    <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                        <h4 class="title fz17 mb30">Select Amenities</h4>
                                        <div class="row">
                                            <div class="col-sm-6 col-lg-3 col-xxl-2">
                                                <div class="checkbox-style1">
                                                    <label class="custom_checkbox">Attic
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Basketball court
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Air Conditioning
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Lawn
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Swimming Pool
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Barbeque
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Microwave
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3 col-xxl-2">
                                                <div class="checkbox-style1">
                                                    <label class="custom_checkbox">TV Cable
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Dryer
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Outdoor Shower
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Washer
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Gym
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Ocean view
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Private space
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3 col-xxl-2">
                                                <div class="checkbox-style1">
                                                    <label class="custom_checkbox">Lake view
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Wine cellar
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Front yard
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Refrigerator
                                                        <input type="checkbox" checked="checked">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">WiFi
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Laundry
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="custom_checkbox">Sauna
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt30">
                                                <div class="d-sm-flex justify-content-between">
                                                    <a class="ud-btn btn-white" href="">Prev Step<i class="fal fa-arrow-right-long"></i></a>
                                                    <a class="ud-btn btn-thm" href="">Submit Property<i class="fal fa-arrow-right-long"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.number_format').forEach(function (input) {
                if (input.value) {
                    let value = input.value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    input.value = value;
                }
            });
        });
    </script>

    @include('site.dashboard.projects.Partial.add_project_js')
@endsection


