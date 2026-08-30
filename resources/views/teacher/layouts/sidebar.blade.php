<div id="kt_app_sidebar" class="app-sidebar" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <!--begin::Sidebar secondary-->
    <div class="app-sidebar-secondary">
        <!--begin::Sidebar menu-->
        <div id="kt_app_sidebar_secondary_wrapper" class="hover-scroll-y" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_app_sidebar_secondary_menu, #kt_app_sidebar_secondary_tags" data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div class="app-sidebar-menu menu menu-sub-indention menu-rounded menu-column" id="kt_app_sidebar_secondary_menu" data-kt-menu="true">
                <!--begin:Menu item-->
                <div class="menu-item here" >
                    <!--begin:Menu link-->
                    <span class="menu-link {{ request()->routeIs('teachers.dashboard') ? 'active' : '' }}">
											<span class="menu-icon">
												<i class="ki-outline ki-home-2 fs-2"></i>
											</span>
                        <a href="{{route('teachers.dashboard')}}"> <span class="menu-title">@lang('admin.Dashboards')</span></a>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu link-->
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
