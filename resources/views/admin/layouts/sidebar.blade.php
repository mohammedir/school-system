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
                    <span class="menu-link {{ request()->routeIs('dashboardController') ? 'active' : '' }}">
											<span class="menu-icon">
												<i class="ki-outline ki-home-2 fs-2"></i>
											</span>
                        <a href="{{route('dashboardController')}}"> <span class="menu-title">@lang('admin.Dashboards')</span></a>
										</span>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->
                @can('Students Section View')
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('student*') ? 'show menu-accordion' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-burger-menu-3 fs-2"></i>
											</span>
											<span class="menu-title">@lang('admin.Student management')</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('student*') ? 'show menu-accordion' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('student.index') ? 'active' : '' }}" href="{{route('student.index')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										    			<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">@lang('admin.View Students')</span>
                            </a>
                            <!--end:Menu link-->

                            @can('Student create')
                            <a class="menu-link {{ request()->routeIs('students.add') ? 'active' : '' }}" href="{{route('students.add')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">@lang('admin.Add Student')</span>
                            </a>
                            @endcan
                            <a class="menu-link {{ request()->routeIs('students.registered_by_website') ? 'active' : '' }}" href="{{route('students.registered_by_website')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">مسجلين من قبل الموقع</span>
                            </a>
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @endcan

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('student*') ? 'show menu-accordion' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-burger-menu-3 fs-2"></i>
											</span>
											<span class="menu-title">إدارة المدرسين</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('admin.teachers*') ? 'show menu-accordion' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('admin.teachers.list') ? 'active' : '' }}" href="{{route('admin.teachers.list')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										    			<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">عرض المدرسين</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('sits*') ? 'show menu-accordion' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-burger-menu-3 fs-2"></i>
											</span>
											<span class="menu-title">إدارة الموقع</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('sits*') ? 'show menu-accordion' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('sits.complaints') ? 'active' : '' }}" href="{{route('sits.complaints')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										    			<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">الشكاوي</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('sits.registrations_students') ? 'active' : '' }}" href="{{route('sits.registrations_students')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
										    			<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">الطلاب المسجلين</span>
                            </a>
                            <!--end:Menu link-->

                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @php
                    $isUserOrRoleActive = request()->routeIs('users*', 'roles*');
                @endphp
                @can('User and Permission Management Section View')
                <div data-kt-menu-trigger="click" class="menu-item {{ $isUserOrRoleActive ? 'show menu-accordion' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
        <span class="menu-icon">
            <i class="ki-outline ki-user fs-2"></i>
        </span>
        <span class="menu-title">@lang('admin.User and Permission Management')</span>
        <span class="menu-arrow"></span>
    </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item - Users-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('users*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}"
                               data-bs-toggle="tooltip"
                               data-bs-trigger="hover"
                               data-bs-dismiss="click"
                               data-bs-placement="right">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                <span class="menu-title">@lang('admin.View Users')</span>
                            </a>
                        </div>
                        <!--end:Menu item - Users-->

                        <!--begin:Menu item - Roles-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('roles*') ? 'active' : '' }}"
                               href="{{ route('roles.index') }}"
                               data-bs-toggle="tooltip"
                               data-bs-trigger="hover"
                               data-bs-dismiss="click"
                               data-bs-placement="right">
                <span class="menu-bullet">
                    <span class="bullet bullet-dot"></span>
                </span>
                                <span class="menu-title">@lang('admin.View Roles')</span>
                            </a>
                        </div>
                        <!--end:Menu item - Roles-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                @can('Settings Section View')
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('settings*') ? 'show menu-accordion' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-setting-2 fs-2"></i>
											</span>
											<span class="menu-title">@lang('admin.System settings')</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('settings*') ? 'show menu-accordion' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('settings.general') ? 'active' : '' }}" href="{{route('settings.general')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">@lang('admin.General settings')</span>
                            </a>
                            <a class="menu-link {{ request()->routeIs('settings.manage_lists') ? 'active' : '' }}" href="{{route('settings.manage_lists')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">@lang('admin.Manage Lists')</span>
                            </a>
                            <a class="menu-link {{ request()->routeIs('notifications.pageList') ? 'active' : '' }}" href="{{route('notifications.pageList')}}"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">@lang('admin.Notifications')</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                @endcan
                @can('Reports Section View')
                <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('reports*') ? 'show menu-accordion' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
											<span class="menu-icon">
												<i class="ki-outline ki-cheque fs-2"></i>
											</span>
											<span class="menu-title">@lang('admin.Reports')</span>
											<span class="menu-arrow"></span>
										</span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item {{ request()->routeIs('reports*') ? 'show menu-accordion' : '' }}">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ request()->routeIs('reports*') ? 'active' : '' }}" href=""  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
													<span class="menu-bullet">
														<span class="bullet bullet-dot"></span>
													</span>
                                <span class="menu-title">@lang('admin.Reports View')</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
                @endcan

                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
        </div>
        <!--end::Sidebar menu-->
    </div>
    <!--end::Sidebar secondary-->
</div>
