<!DOCTYPE html>
<html dir="rtl" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- css file -->
    <link rel="stylesheet" href="{{ asset('site_assets/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/ace-responsive-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/ud-custom-spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('site_assets/css/dashbord_navitaion.css') }}">
    <!-- Responsive stylesheet -->
    <link rel="stylesheet" href="{{ asset('site_assets/css/responsive.css') }}">

    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Title -->
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
    <title>ONE-THOUSAND</title>
    <!-- Favicon -->
    <!-- Apple Touch Icon -->
    <link href="images/apple-touch-icon-60x60.png" sizes="60x60" rel="apple-touch-icon">
    <link href="images/apple-touch-icon-72x72.png" sizes="72x72" rel="apple-touch-icon">
    <link href="images/apple-touch-icon-114x114.png" sizes="114x114" rel="apple-touch-icon">
    <link href="images/apple-touch-icon-180x180.png" sizes="180x180" rel="apple-touch-icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view.blade.php the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        /* تعطيل تأثير :before إذا كان موجود */
        .no-hover::before {
            background-color: transparent !important;
            content: none !important;
        }
        #preview_images {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
        }
        .position-relative {
            position: relative;
        }
         label.required::after {
             content: " *";
             color: red;
         }

        .ck-editor__editable_inline {
            min-height: 120px !important; /* تقريبًا 3 صفوف */
        }
        .disabled{
            background-color: #e9ecef !important;
        }
        .table-style3 .t-head th{
            font-size:13px
        }
        .table-style3 .icon{
            width: 20px;
        }

    </style>
</head>
<body>
<div class="wrapper">
    <div class="preloader"></div>

    <!-- Main Header Nav -->
        @include('site.dashboard.layouts.header')
    <!-- Menu In Hiddn SideBar -->
    @include('site.dashboard.layouts.sidebar')

    <!--End Menu In Hiddn SideBar -->
    <!-- Mobile Nav  -->
    <div id="page" class="mobilie_header_nav stylehome1">
        <div class="mobile-menu">
            <div class="header innerpage-style">
                <div class="menu_and_widgets">
                    <div class="mobile_menu_bar d-flex justify-content-between align-items-center">
                        <a class="menubar" href="#menu"><img src="{{asset('site_assets/images/mobile-dark-nav-icon.svg')}}" alt=""></a>
                        <a class="mobile_logo" href="#"><img src="{{asset('site_assets/images/header-logo2.svg')}}" alt=""></a>
                        <a href="page-login.html"><span class="icon fz18 far fa-user-circle"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.mobile-menu -->
        <nav id="menu" class="">
            <ul>
                <li><span>Home</span>
                    <ul>
                        <li><a href="index.html">Home V1</a></li>
                        <li><a href="index2.html">Home V2</a></li>
                        <li><a href="index3.html">Home V3</a></li>
                        <li><a href="index4.html">Home V4</a></li>
                        <li><a href="index5.html">Home V5</a></li>
                        <li><a href="index6.html">Home V6</a></li>
                        <li><a href="index7.html">Home V7</a></li>
                        <li><a href="index8.html">Home V8</a></li>
                        <li><a href="index9.html">Home V9</a></li>
                        <li><a href="index10.html">Home V10</a></li>
                    </ul>
                </li>
                <li><span>Property Listign</span>
                    <ul>
                        <li><span>Listing Grid</span>
                            <ul>
                                <li><a href="page-grid-default-v1.html">Grid Default v1</a></li>
                                <li><a href="page-grid-default-v2.html">Grid Default v2</a></li>
                                <li><a href="page-property-3-col.html">Grid Full Width 3 Cols</a></li>
                                <li><a href="page-property-4-col.html">Grid Full Width 4 Cols</a></li>
                                <li><a href="page-property-2-col.html">Grid Full Width 2 Cols</a></li>
                                <li><a href="page-property-1-col-v1.html">Grid Full Width 1 Cols v1</a></li>
                                <li><a href="page-property-1-col-v2.html">Grid Full Width 1 Cols v2</a></li>
                                <li><a href="page-property-banner-v1.html">Banner Search v1</a></li>
                                <li><a href="page-property-banner-v2.html">Banner Search v2</a></li>
                            </ul>
                        </li>
                        <li><span>List Style</span>
                            <ul>
                                <li><a href="page-property-list.html">Style V1</a></li>
                                <li><a href="page-property-list-all.html">All List</a></li>
                            </ul>
                        </li>
                        <li><span>Listing Single</span>
                            <ul>
                                <li><a href="page-property-single-v1.html">Single V1</a></li>
                                <li><a href="page-property-single-v2.html">Single V2</a></li>
                                <li><a href="page-property-single-v3.html">Single V3</a></li>
                                <li><a href="page-property-single-v4.html">Single V4</a></li>
                                <li><a href="page-property-single-v5.html">Single V5</a></li>
                                <li><a href="page-property-single-v6.html">Single V6</a></li>
                                <li><a href="page-property-single-v7.html">Single V7</a></li>
                                <li><a href="page-property-single-v8.html">Single V8</a></li>
                                <li><a href="page-property-single-v9.html">Single V9</a></li>
                                <li><a href="page-property-single-v10.html">Single V10</a></li>
                            </ul>
                        </li>
                        <li><span>Map Style</span>
                            <ul>
                                <li><a href="page-property-header-map-style.html">Map Header</a></li>
                                <li><a href="page-property-half-map-v1.html">Map V1</a></li>
                                <li><a href="page-property-half-map-v2.html">Map V2</a></li>
                                <li><a href="page-property-half-map-v3.html">Map V3</a></li>
                                <li><a href="page-property-half-map-v4.html">Map V4</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><span>User Dashboard</span>
                    <ul>
                        <li><a href="{{route('investors.dashboard.index')}}">Dashboard</a></li>
                        <li><a href="page-dashboard-message.html">Message</a></li>
                        <li><a href="page-dashboard-add-property.html">New Property</a></li>
                        <li><a href="page-dashboard-properties.html">My Properties</a></li>
                        <li><a href="page-dashboard-favorites.html">My Favorites</a></li>
                        <li><a href="page-dashboard-savesearch.html">Saved Search</a></li>
                        <li><a href="page-dashboard-review.html">Reviews</a></li>
                        <li><a href="page-dashboard-package.html">My Package</a></li>
                        <li><a href="page-dashboard-profile.html">My Profile</a></li>
                    </ul>
                </li>
                <li><span>Blog</span>
                    <ul>
                        <li><a href="page-blog-v1.html">List V1</a></li>
                        <li><a href="page-blog-v2.html">List V2</a></li>
                        <li><a href="page-blog-v3.html">List V3</a></li>
                        <li><a href="page-blog-single.html">Single</a></li>
                    </ul>
                </li>
                <li><span>Pages</span>
                    <ul>
                        <li><a href="page-about.html">About</a></li>
                        <li><a href="page-contact.html">Contact</a></li>
                        <li><a href="page-compare.html">Compare</a></li>
                        <li><a href="page-pricing.html">Pricing</a></li>
                        <li><a href="page-faq.html">Faq</a></li>
                        <li><a href="page-login.html">Login</a></li>
                        <li><a href="page-register.html">Register</a></li>
                        <li><a href="page-error.html">404</a></li>
                        <li><a href="page-invoice.html">Invoices</a></li>
                        <li><a href="page-ui-element.html">UI Elements</a></li>
                    </ul>
                </li>
                <li class="px-3 mobile-menu-btn">
                    <a href="page-dashboard-add-property.html" class="ud-btn btn-thm text-white">Submit Property<i class="fal fa-arrow-right-long"></i></a>
                </li>
                <!-- Only for Mobile View -->
            </ul>
        </nav>
    </div>
    <div class="dashboard_content_wrapper">
        <div class="dashboard dashboard_wrapper pr30 pr0-xl">
            <div class="dashboard__sidebar d-none d-lg-block">
                <div class="dashboard_sidebar_list">
                    <div class="sidebar_list_item">
                        <a href="{{route('investors.dashboard.index')}}" class="items-center {{ request()->routeIs('investors.dashboard.index') ? '-is-active' : '' }}"><i class="flaticon-discovery ml15"></i> الرئيسية</a>
                    </div>
                    <p class="fz15 fw400 ff-heading mt30">الاستثمارات </p>

                    <div class="sidebar_list_item ">
                        <div class="sidebar_list_item">
                            @if(!auth()->user()->isActive())
                                <a href="javascript:void(0);"
                                   class="items-center disabled-link"
                                   title="يجب اعتماد الملف الشخصي قبل إضافة أرض جديدة"
                                   style=" opacity: 0.6;">
                                    <i class="flaticon-new-tab ml15"></i>
                                    إضافة أرض جديدة
                                </a>
                            @else
                                <a href="{{route('investors.dashboard.add_land')}}" class="items-center {{ request()->routeIs('investors.dashboard.add_land') ? '-is-active' : '' }}"><i class="flaticon-new-tab ml15"></i>إضافة أرض جديدة</a>
                            @endif
                        </div>

                    </div>
                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.my_land')}}" class="items-center {{ request()->routeIs('investors.dashboard.my_land') ? '-is-active' : '' }}"><i class="flaticon-home ml15"></i>الأراضي الخاصة بي</a>
                    </div>
                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.all_land')}}" class="items-center {{ request()->routeIs('investors.dashboard.all_land') ? '-is-active' : '' }}"><i class="flaticon-like ml15"></i>الأراضي المتاحة للاستثمار</a>
                    </div>
                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.my_projects')}}" class="items-center {{ request()->routeIs('investors.dashboard.my_projects') ? '-is-active' : '' }}"><i class="flaticon-search-2 ml15"></i>مشاريعي</a>
                    </div>
                    <p class="fz15 fw400 ff-heading mt30">محفظتى </p>
                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.wallet')}}" class="items-center"><i class="flaticon-protection ml15"></i>شحن المحفظة </a>
                    </div>
                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.wallet.transactions')}}" class="items-center"><i class="flaticon-protection ml15"></i>@lang('investors.Financial movements')</a>
                    </div>
                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.wallet.my_stock_portfolio')}}" class="items-center"><i class="flaticon-protection ml15"></i>@lang('investors.Stock portfolio')</a>
                    </div>
                    <p class="fz15 fw400 ff-heading mt30">إعدادات </p>

                    <div class="sidebar_list_item ">
                        <a href="{{route('investors.dashboard.profile')}}" class="items-center"><i class="flaticon-user ml15"></i>ملفي الشخصي </a>
                    </div>
                    <div class="sidebar_list_item ">
                        <a href="page-dashboard-profile.html" class="items-center"><i class="flaticon-security ml15"></i>الخصوصية والأمان  </a>
                    </div>
                    <div class="sidebar_list_item ">
                        <a href="{{ route('investors.logout') }}" class="menu-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="flaticon-logout ml15"></i>
                            @lang('admin.Sign Out')
                        </a>
                        <!-- الفورم المخفي لتنفيذ POST -->
                        <form id="logout-form" action="{{ route('investors.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            @yield('content')

        </div>
        @include('site.dashboard.layouts.footer')
    </div>
    <a class="scrollToHome" href="#"><i class="fas fa-angle-up"></i></a>

</div>
<!-- Wrapper End -->
@include('site.dashboard.layouts.scripts')

</body>
</html>
