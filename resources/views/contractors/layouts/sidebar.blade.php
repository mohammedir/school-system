<div id="kt_app_sidebar" class="app-sidebar" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    @php
        $isDisabled = !getContractorData(Auth::user()->id)->isApproved();
    @endphp
    <!--begin::Sidebar secondary-->
    <div class="app-sidebar-secondary">
        <!--begin::Sidebar menu-->
        <div id="kt_app_sidebar_secondary_wrapper" class="hover-scroll-y" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_sidebar_secondary_menu, #kt_app_sidebar_secondary_tags" data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div class="app-sidebar-menu menu menu-sub-indention menu-rounded menu-column" id="kt_app_sidebar_secondary_menu" data-kt-menu="true">
                <!--begin:Menu item-->
                <div class="menu-item here" >
                    <!--begin:Menu link-->
                    <span class="menu-link {{ request()->routeIs('contractors.dashboardController') ? 'active' : '' }}">
											<span class="menu-icon">
												<i class="ki-outline ki-home-2 fs-2"></i>
											</span>
                        <a href="{{route('contractors.dashboardController')}}"> <span class="menu-title">@lang('admin.Dashboards')</span></a>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu link-->
                    <span class="menu-link {{ request()->routeIs('contractors.projects.index') ? 'active' : '' }} {{ $isDisabled ? 'disabled' : ''}}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-calendar-edit fs-2"></i>
                        </span>
                        @if($isDisabled)
                            <span class="menu-title text-muted">@lang('contractors.Projects')</span>
                        @else
                            <a href="{{ route('contractors.projects.index') }}" class="text-decoration-none">
                                <span class="menu-title">@lang('contractors.Projects')</span>
                            </a>
                        @endif
                    </span>
                    <!--end:Menu link-->
                    
                    <!-- Price Offers Link -->
                    <span class="menu-link {{ request()->routeIs('contractors.contractors_offers.index') ? 'active' : '' }} {{ $isDisabled ? 'disabled' : ''}}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-price-tag fs-2"></i>
                        </span>
                        @if($isDisabled)
                            <span class="menu-title text-muted">@lang('contractors.Price offers')</span>
                        @else
                            <a href="{{ route('contractors.contractors_offers.index') }}" class="text-decoration-none">
                                <span class="menu-title">@lang('contractors.My Price offers')</span>
                            </a>
                        @endif
                    </span>
                    
                    <!-- My Projects Link -->
                    <span class="menu-link {{ request()->routeIs('contractors.my_projects.index') ? 'active' : '' }} {{ $isDisabled ? 'disabled' : ''}}">
                        <span class="menu-icon">
                            <i class="ki-outline ki-briefcase fs-2"></i>
                        </span>
                        @if($isDisabled)
                            <span class="menu-title text-muted">@lang('contractors.My projects')</span>
                        @else
                            <a href="{{ route('contractors.my_projects.index') }}" class="text-decoration-none">
                                <span class="menu-title">@lang('contractors.My projects')</span>
                            </a>
                        @endif
                    </span>
                    
                </div>
                <!--end:Menu item-->

                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
        </div>
        <!--end::Sidebar menu-->
    </div>
    <!--end::Sidebar secondary-->
</div>
