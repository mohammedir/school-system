<!DOCTYPE html>
<html dir="rtl" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="advanced search, agency, agent, classified, directory, house, listing, property, real estate, real estate agency, real estate agent, realestate, realtor, rental">
    <meta name="description" content="{{ __('investors.meta_description') }}">
    <meta name="CreativeLayers" content="ATFN">
    <!-- css file -->
    <link rel="stylesheet" href="{{asset('site_assets/css/bootstrap.rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/ace-responsive-menu.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/menu.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/ud-custom-spacing.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('site_assets/css/jquery-ui.min.css')}}">
    <style>
        label.error {
            color: #dc3545 !important; /* أحمر مثل Bootstrap */
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        input.error, select.error, textarea.error {
            border-color: #dc3545 !important;
        }
        .is-invalid {
            border-color: #dc3545 !important; /* اللون الأحمر Bootstrap */
        }
    </style>


    <!-- Title -->
    <title>{{ __('investors.page_title') }}</title>
    <!-- Favicon -->
    <link href="{{asset('site_assets/images/favicon.ico')}}" sizes="128x128" rel="shortcut icon" type="image/x-icon" />
    <link href="{{asset('site_assets/images/favicon.ico')}}" sizes="128x128" rel="shortcut icon" />
    <!-- Apple Touch Icon -->
    <link href="{{asset('site_assets/images/apple-touch-icon-60x60.png')}}" sizes="60x60" rel="apple-touch-icon">
    <link href="{{asset('site_assets/images/apple-touch-icon-72x72.png')}}" sizes="72x72" rel="apple-touch-icon">
    <link href="{{asset('site_assets/images/apple-touch-icon-114x114.png')}}" sizes="114x114" rel="apple-touch-icon">
    <link href="{{asset('site_assets/images/apple-touch-icon-180x180.png')}}" sizes="180x180" rel="apple-touch-icon">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bgc-f7">
<div class="wrapper ovh">
    <div class="preloader"></div>
    <div class="body_content">
        <!-- Our Compare Area -->
        <section class="our-compare pt60 pb60">
            <img src="{{asset('site_assets/images/icon/login-page-icon.svg')}}" alt="" class="login-bg-icon wow fadeInLeft" data-wow-delay="300ms">
            <div class="container">
                <div class="row wow fadeInRight" data-wow-delay="300ms">
                    <div class="col-lg-6">
                        <div class="log-reg-form signup-modal form-style1 bgc-white p50 p30-sm default-box-shadow2 bdrs12">
                            <div class="text-center mb40">
                                <img class="mb25" src="{{asset('site_assets/images/header-logo2.svg')}}" alt="">
                                <h2>{{ __('investors.sign_in') }}</h2>
                                <p class="text">{{ __('investors.sign_in_description') }}</p>
                            </div>
                            <form id="sign_in_form" action="{{ route('investors.login') }}" method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework"  >
                                @csrf
                                <div class="mb25 fv-row">
                                    <label class="form-label fw600 dark-color">{{ __('investors.email') }}</label>
                                    <input type="email" name="email" class="form-control" placeholder="{{ __('investors.enter_email') }}">
                                </div>
                                <div class="mb15 fv-row">
                                    <label class="form-label fw600 dark-color">{{ __('investors.password') }}</label>
                                    <input type="password" name="password" class="form-control" placeholder="{{ __('investors.enter_password') }}">
                                </div>
                                <div class="checkbox-style1 d-block d-sm-flex align-items-center justify-content-between mb10">
                                    <label class="custom_checkbox fz14 ff-heading">{{ __('investors.remember_me') }}
                                        <input type="checkbox" name="remember" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                    <a class="fz14 ff-heading" href="#">{{ __('investors.lost_password') }}</a>
                                </div>
                                <div class="d-grid mb20">
                                    <button id="sign_in_submit" class="ud-btn btn-thm" type="submit">{{ __('investors.sign_in') }} <i class="fal fa-arrow-right-long"></i></button>
                                </div>
                            </form>

                            <div class="hr_content mb20"><hr><span class="hr_top_text">{{ __('investors.or') }}</span></div>
                            <div class="d-grid mb10">
                                <button class="ud-btn btn-white fw400" type="button"><i class="fab fa-google"></i> {{ __('investors.continue_google') }}</button>
                            </div>

                            <p class="dark-color text-center mb0 mt10">{{ __('investors.not_signed_up') }} <a class="dark-color fw600" href="{{route('investors.register')}}">{{ __('investors.create_account') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a class="scrollToHome" href="#"><i class="fas fa-angle-up"></i></a>
    </div>
</div>
<!-- Wrapper End -->
<script src="{{asset('site_assets/js/jquery-3.6.4.min.js')}}"></script>
<script src="{{asset('site_assets/js/ace-responsive-menu.js')}}"></script>
<script src="{{asset('site_assets/js/jquery.mmenu.all.js')}}"></script>
 <script src="{{asset('site_assets/js/popper.min.js')}}"></script>
<script src="{{asset('site_assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('site_assets/js/jquery-scrolltofixed-min.js')}}"></script>
<script src="{{asset('site_assets/js/wow.min.js')}}"></script>
<!-- Custom script for all pages -->
<script src="{{asset('site_assets/js/script.js')}}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap 5 (أو أي إصدار متوافق مع القالب) -->
<!-- jQuery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

@include('site.auth.Partial.login_js')

</body>
</html>
