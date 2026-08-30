<div id="kt_app_header" class="app-header">
    <!--begin::Brand-->
    <div class="app-header-brand ps-6">
        <!--begin::Mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-color-gray-500 btn-active-color-info w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
        </div>
        <!--end::Mobile toggle-->
        <!--begin::Logo-->
        <a class="app-sidebar-secondary-collapse-d-none text-center w-100" href="{{route('dashboardController')}}">
            <img alt="Logo" src="{{asset('uploads/logo/logo_dashbord.jpg')}}" class="h-55px"/>
        </a>
        <!--end::Logo-->
        <!--begin::Sidebar toggle-->
        <button id="kt_app_sidebar_secondary_toggle" class="btn btn-sm btn-icon bg-body btn-color-gray-500 btn-active-color-info d-none d-lg-flex ms-2" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-secondary-collapse">
            <i class="ki-outline ki-menu fs-1"></i>
        </button>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Brand-->
    <!--begin::Header wrapper-->
    <div class="app-header-wrapper">
        <div class="app-container container-fluid">
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1">
            </div>
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Notifications-->
                <div class="app-navbar-item ms-1 ms-md-3">
                    <!--begin::Menu- wrapper-->
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-info w-30px h-30px w-md-40px h-md-40px position-relative"
                         data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                         data-kt-menu-attach="parent"
                         data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-notification-on fs-1"></i>
                        <!-- Badge (عدد الإشعارات) -->
                        <span id="unread-count"
                              class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger text-white fs-8"
                              style="min-width: 1.5rem; height: 1.5rem; line-height: 1.5rem; text-align: center;">
                            0
                        </span>
                    </div>

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('{{ asset("assets/media/misc/menu-header-bg.jpg") }}')">
                            <!--begin::Title-->
                            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">@lang('admin.Notifications')
                            </h3>
                            <div class="d-flex justify-content-end px-5">
                                <button id="mark-all-read" class="btn btn-sm btn-light-info">
                                    <i class="ki-outline ki-double-check"></i> @lang('admin.Mark All as Read')
                                </button>
                            </div>
                            <!--end::Title-->
                            <!--begin::Tabs-->
                            <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                <li class="nav-item">
                                    <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">@lang('admin.All')</a>
                                </li>
                            </ul>
                            <!--end::Tabs-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Tab content-->
                        <div class="tab-content">
                            <!--begin::Tab panel-->
                            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                                <!--begin::Items-->
                                <ul id="notification-list" class="scroll-y mh-325px my-5 px-8">

                                </ul>
                                <!--end::Items-->
                                <!--begin::View more-->
                                <div class="py-3 text-center border-top">
                                    <a href="{{route('notifications.pageList')}}" class="btn btn-color-gray-600 btn-active-color-info">@lang('admin.View  all ')
                                        <i class="ki-outline ki-arrow-right fs-5"></i></a>
                                </div>
                                <!--end::View more-->
                            </div>
                            <!--end::Tab panel-->
                        </div>
                        <!--end::Tab content-->
                    </div>
                    <!--end::Menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::Notifications-->
                <!--begin::Quick links-->
                <div class="app-navbar-item ms-1 ms-md-3">
                    <!--begin::Menu- wrapper-->
                    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-info w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <i class="ki-outline ki-abstract-26 fs-1"></i>
                    </div>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
                        <!--begin::Heading-->
                        <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10" style="background-image:url('{{ asset("assets/media/misc/menu-header-bg.jpg") }}')">
                            <!--begin::Title-->
                            <!--<h3 class="text-info fw-semibold mb-3">الأنظمة الأخرى</h3>-->
                            <!--end::Title-->
                            <!--begin::Status-->
                            <span class="badge bg-info text-inverse-info py-2 px-3">الأنظمة الأخرى</span>
                            <!--end::Status-->
                        </div>
                        <!--end::Heading-->
                        <!--begin:Nav-->
                        <div class="row g-0 border-top">
                            <!--begin:Item-->
                            <div class="col-6">
                                <a target="_blank" href="{{ route('teachers.login') }}" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                                    <i class="ki-duotone ki-abstract-41 fs-3x text-info mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="fs-5 fw-semibold text-gray-800 mb-0">بوابة المدرسين</span>
                                    <span class="fs-7 text-gray-500">200 مستخدم</span>
                                </a>
                            </div>
                            <!--end:Item-->
                            <!--begin:Item-->
                            <div class="col-6">
                                <a target="_blank" href="{{ route('contractors.login') }}"  class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
                                    <i class="ki-duotone ki-briefcase fs-3x text-info mb-2">
                                        <span class="path1"></span>
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="fs-5 fw-semibold text-gray-800 mb-0">بوابة المقاولين</span>
                                    <span class="fs-7 text-gray-500">50 مستخدم</span>
                                </a>
                            </div>
                            <!--end:Item-->
                        </div>

                        <div class="row g-0 border-top">
                            <!--begin:Item-->
                            <div class="col-6">
                                <a target="_blank" href="{{ url('/') }}" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                                    <i class="ki-duotone ki-abstract-41 fs-3x text-info mb-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="fs-5 fw-semibold text-gray-800 mb-0"> ليرن توبي</span>
                                    <span class="fs-7 text-gray-500">&nbsp;</span>
                                </a>
                            </div>
                            <!--end:Item-->
                            <!--begin:Item-->
                            <div class="col-6">
                            </div>
                            <!--end:Item-->
                        </div>
                    </div>

                    <!--end::Menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::Quick links-->
                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <img src="{{auth()->user()->avatar ? asset('uploads/usersImage/' . auth()->user()->avatar) : asset('assets/media/avatars/300-1.jpg')}}" alt="user" />
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <img alt="Logo" src="{{auth()->user()->avatar ? asset('uploads/usersImage/' . auth()->user()->avatar) : asset('assets/media/avatars/300-1.jpg')}}" />
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">{{auth()->user()->name}}
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{auth()->user()->getRoleNames()->join(', ')}}</span></div>
                                    <a href="#" class="fw-semibold text-muted text-hover-info fs-7">{{auth()->user()->email}}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{route('profile.view.blade.php')}}" class="menu-link px-5">@lang('admin.My Profile')</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
												<span class="menu-title position-relative">@lang('admin.Mode')
												<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
													<i class="ki-outline ki-night-day theme-light-show fs-2"></i>
													<i class="ki-outline ki-moon theme-dark-show fs-2"></i>
												</span></span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-night-day fs-2"></i>
														</span>
                                        <span class="menu-title">@lang('admin.Light')</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-moon fs-2"></i>
														</span>
                                        <span class="menu-title">@lang('admin.Dark')</span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </div>
                        <!--end::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('logout') }}" class="menu-link px-5"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ki-outline ki-logout fs-2 me-2"></i>
                                @lang('admin.Sign Out')
                            </a>
                            <!-- الفورم المخفي لتنفيذ POST -->
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                    <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->
            </div>
            <!--end::Navbar-->
        </div>
    </div>
    <!--end::Header wrapper-->
</div>
