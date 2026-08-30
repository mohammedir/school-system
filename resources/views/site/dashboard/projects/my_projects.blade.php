@extends('site.dashboard.layouts.master')
@section('content')

    <div class="dashboard__main pl0-md">
        <div class="dashboard__content bgc-f7">
            <div class="row pb40">
                <div class="col-lg-12">
                    <div class="dashboard_navigationbar d-block d-lg-none">
                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars pl10"></i> Dashboard Navigation</button>
                            <ul id="myDropdown" class="dropdown-content">
                                <li><a href="page-dashboard.html"><i class="flaticon-discovery mr10"></i>Dashboard</a></li>
                                <li><a href="page-dashboard-message.html"><i class="flaticon-chat-1 mr10"></i>Message</a></li>
                                <li><p class="fz15 fw400 ff-heading mt30 pr30">MANAGE LISTINGS</p></li>
                                <li><a href="page-dashboard-add-property.html"><i class="flaticon-new-tab mr10"></i>Add New Property</a></li>
                                <li><a href="page-dashboard-properties.html"><i class="flaticon-home mr10"></i>My Properties</a></li>
                                <li class="active"><a href="page-dashboard-favorites.html"><i class="flaticon-like mr10"></i>My Favorites</a></li>
                                <li><a href="page-dashboard-savesearch.html"><i class="flaticon-search-2 mr10"></i>Saved Search</a></li>
                                <li><a href="page-dashboard-review.html"><i class="flaticon-review mr10"></i>Reviews</a></li>
                                <li><p class="fz15 fw400 ff-heading mt30 pr30">MANAGE ACCOUNT</p></li>
                                <li><a href="page-dashboard-package.html"><i class="flaticon-protection mr10"></i>My Package</a></li>
                                <li><a href="page-dashboard-profile.html"><i class="flaticon-user mr10"></i>My Profile</a></li>
                                <li><a href="page-login.html"><i class="flaticon-exit mr10"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="dashboard_title_area">
                        <h2>مشاريعي</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p-4 mb-4 overflow-hidden position-relative">
                        <div class="row g-4">
                            @forelse($projects as $project)
                                <div class="col-sm-6 col-lg-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                                        <!-- صورة المشروع -->
                                        <a href="{{ route('investors.dashboard.view_project', [$project->id]) }}">
                                            <img src="{{ asset('uploads/projects/' . $project->project_logo) }}"
                                                 class="card-img-top img-fluid"
                                                 alt="{{ $project->title }}"
                                                 style="height: 220px; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 m-2 px-3 py-1 bg-success text-white rounded-pill fw-bold">
                                                ${{ number_format($project->project_cost, 2) }}
                                            </div>
                                        </a>

                                        <!-- محتوى الكارد -->
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-truncate" title="{{ $project->title }}">
                                                {{ $project->title }}
                                            </h5>

                                            <!-- بيانات إضافية -->
                                            <div class="d-flex justify-content-between text-muted small mb-2">
                                                <span><i class="flaticon-bed me-1"></i> 3 bed</span>
                                                <span><i class="flaticon-shower me-1"></i> 4 bath</span>
                                                <span><i class="flaticon-expand me-1"></i> 1200 sqft</span>
                                            </div>
                                            <hr>
                                            <!-- حالة المشروع -->
                                            <div class="mt-auto">
                                                {{--<span class="d-block mb-1 text-muted">حالة المشروع</span>--}}
                                                <div class="d-flex justify-content-center">
                                                    @if($project->isAwarded())
                                                        <a  href="javascript:;"
                                                            class="show-award-modal text-decoration-none"
                                                            data-project-id="{{ $project->id }}"
                                                            data-offer-id="{{ $project->awarded_engineering_offer_id }}">
            <span class="badge rounded-pill bg-primary px-3 py-2 cursor-pointer">
                {{ getlookup($project->project_status_cd)->name_ar }}
            </span>
                                                        </a>
                                                    @elseif($project->isContractorAwarded())
                                                        <a  href="javascript:;"
                                                            class="show-contractor-award-modal text-decoration-none"
                                                            data-project-id="{{ $project->id }}"
                                                            data-contractor-offer-id="{{ $project->awarded_contractor_offer_id }}">
            <span class="badge rounded-pill bg-primary px-3 py-2 cursor-pointer">
                {{ getlookup($project->project_status_cd)->name_ar }}
            </span>
                                                        </a>
                                                    @else
                                                        {{-- حالة غير قابلة للنقر --}}
                                                        <span class="badge rounded-pill bg-secondary px-3 py-2 opacity-75">
            {{ getlookup($project->project_status_cd)->name_ar }}
        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center mt-4">
                                    <div class="alert alert-warning">لا يوجد أي مشاريع حالياً</div>
                                </div>
                            @endforelse
                        </div>

                        <!-- الباجينيشن -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $projects->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
            <div id="awardModalWrapper"></div>



        </div>
    </div>


@endsection

@section('js')
    @include('site.dashboard.projects.Partial.my_project_js')
@endsection


