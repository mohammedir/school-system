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
                            <h2>@lang('investors.My profile')</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($user->isPending() || $user->isUpdated())
                        <!--begin::Notice-->
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <!--end::Icon-->
                            <!--begin::Wrapper-->

                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-semibold">
                                    <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                                    <div class="fs-6 text-gray-700">@lang('engineering.Your request is still under review. Please be patient.')</div>
                                </div>
                                <!--end::Content-->
                            </div>


                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                    @endif
                    <div class="col-xl-12">
                        <div class="card card-flush shadow-sm border-0 mb-8">
                            <div class="card-header py-4">
                                <h3 class="card-title fs-4 fw-bold text-dark">
                                    <i class="fas fa-user-check text-primary me-2"></i>
                                    التحقق من الهوية الشخصية
                                </h3>
                                <div class="text-muted fw-semibold">يرجى تعبئة البيانات بدقة لضمان أمان حسابك</div>
                            </div>

                            <!--end::Input group-->
                            @if($user->isRejected())
                                <!--begin::Notice-->
                                <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed">
                                    <!--begin::Icon-->
                                    <i class="ki-duotone ki-information fs-2tx text-danager me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <!--end::Icon-->

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <!--begin::Content-->
                                        <div class="fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">@lang('engineering.We need your attention!')</h4>
                                            <div class="fs-6 text-gray-700 mb-2">
                                                @lang('engineering.Your request has been rejected. Please check the reason below.')
                                            </div>

                                            @if($user->rejection_reason)
                                                <div class="fs-6 text-danger">
                                                    <strong>@lang('engineering.Rejection Reason'):</strong> {{ $user->rejection_reason }}
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Notice-->
                            @endif

                            <div class="card-body py-5">
                                <form id="identity-verification-form" method="post" action="{{route('investors.dashboard.sendVerifyData')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-6">
                                        <!-- البريد الإلكتروني -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-envelope text-primary me-1"></i> البريد الإلكتروني
                                                @if(isset($user->email_verified_at)) 
                                                    <i class="fas fa-check-circle fs-8 pt-2" style="color: #0f9d58;" title="تم التحقق من البريد الالكتروني"></i>
                                                @endif
                                            </label>
                                            <input type="email" @if(isset($user->email_verified_at)) disabled @endif   value="{{$user->email}}" id="investorEmailInput" class="form-control form-control-solid" placeholder="example@email.com">
                                            @if(!isset($user->email_verified_at))
                                                <!-- زر فتح المودال -->
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button style="border-radius: 10px !important;"  class="ud-btn btn-success btn-sm py-1 px-2 no-hover" id="sendOtpBtn" data-email="{{\Illuminate\Support\Facades\Auth::user()->email}}" data-bs-target="#otpModal">إرسال كود التحقق</button>
                                                    <button style="border-radius: 10px !important;"  class="ud-btn btn-danger2 btn-sm py-1 px-2 ms-2" id="editEmail"  data-mobile="{{\Illuminate\Support\Facades\Auth::user()->mobile}}">تعديل</button>

                                                </div>
                                            @endif

                                        </div>

                                        <!-- رقم الجوال -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-mobile-alt text-primary me-1"></i> رقم الجوال 
                                                @if(isset($user->mobile_verified_at)) 
                                                    <i class="fas fa-check-circle fs-8 pt-2" style="color: #0f9d58;" title="تم التحقق من الجوال"></i>
                                                @endif
                                            </label>
                                            <input type="text"  @if(isset($user->mobile_verified_at)) disabled @endif value="{{$user->mobile}}" id="investorMobileInput" class="form-control form-control-solid" placeholder="05XXXXXXXX">
                                            @if(!isset($user->mobile_verified_at))
                                                <!-- زر فتح المودال -->
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button style="border-radius: 10px !important;" class="ud-btn btn-success btn-sm py-1 px-2 no-hover" id="sendOtpSMSBtn" data-mobile="{{\Illuminate\Support\Facades\Auth::user()->mobile}}" data-bs-target="#otpSMSModal">إرسال كود التحقق</button>
                                                    <button style="border-radius: 10px !important;" class="ud-btn btn-danger2 btn-sm py-1 px-2 ms-2" id="editMobile" data-mobile="{{\Illuminate\Support\Facades\Auth::user()->mobile}}">تعديل</button>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- صورة الهوية -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-id-card text-primary me-1"></i> صورة الهوية الشخصية
                                            </label>
                                            <input type="file" class="form-control form-control-solid" name="photo_personal_id" accept="image/*" style="height: auto; padding-right: 2px">
                                            <div class="form-text">يفضل أن تكون الصورة واضحة وبصيغة JPG أو PNG.</div>
                                            @if(isset($user->photo_personal_id))
                                                <a href="{{ asset('uploads/' . $user->photo_personal_id) }}" download class="btn btn-light-primary btn-sm">
                                                    <i class="fas fa-download me-2"></i> @lang('admin.Download the')
                                                </a>
                                            @endif

                                        </div>

                                        <!-- صورة مع الهوية -->
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-user-circle text-primary me-1"></i> صورة لك مع الهوية
                                            </label>
                                            <input type="file" class="form-control form-control-solid" accept="image/*" name="photo_with_id" style="height: auto; padding-right: 2px">
                                            <div class="form-text">التقط صورة وأنت تحمل هويتك بوضوح.</div>
                                            @if(isset($user->photo_with_id))
                                            <a href="{{ asset('uploads/' . $user->photo_with_id) }}" download class="btn btn-light-primary btn-sm">
                                                <i class="fas fa-download me-2"></i> @lang('admin.Download the')
                                            </a>
                                            @endif
                                        </div>
                                    </div>

                                    @if($user->isNew() || $user->isRejected())
                                        <!-- زر الإرسال -->
                                        <div class="text-end">
                                            <button type="submit" id="submitVerificationBtn" class="ud-btn btn-thm">
                                                <i class="fas fa-paper-plane me-1"></i> إرسال بيانات التحقق
                                            </button>
                                        </div>
                                    @endif

                                </form>
                            </div>
                        </div>
                       {{-- <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p30 mb30 overflow-hidden position-relative">
                            <div class="col-xl-7">
                                <div class="profile-box position-relative d-md-flex align-items-end mb50">
                                    <div class="profile-img position-relative overflow-hidden bdrs12 mb20-sm">
                                        <img class="w-100" src="images/listings/profile-1.jpg" alt="">
                                        <a href="" class="tag-del" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete Image" aria-label="Delete Item"><span class="fas fa-trash-can"></span></a>
                                    </div>
                                    <div class="profile-content mr30 mr0-sm">
                                        <a href="" class="ud-btn btn-white2 mb30">Upload Profile Files<i class="fal fa-arrow-right-long"></i></a>
                                        <p class="text">Photos must be JPEG or PNG format and least 2048x768</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form class="form-style1">
                                    <div class="row">
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Username</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Email</label>
                                                <input type="email" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Phone</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">First Name</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Last Name</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Position</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Language</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Company Name</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-4">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Tax Number</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="mb20">
                                                <label class="heading-color ff-heading fw600 mb10">Address</label>
                                                <input type="text" class="form-control" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb10">
                                                <label class="heading-color ff-heading fw600 mb10">About me</label>
                                                <textarea cols="30" rows="4" placeholder="There are many variations of passages."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="text-end">
                                                <a class="ud-btn btn-dark" href="page-contact.html">Update Profile<i class="fal fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p30 mb30 overflow-hidden position-relative">
                            <h4 class="title fz17 mb30">Social Media</h4>
                            <form class="form-style1">
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Facebook Url</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Pinterest Url</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Instagram Url</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Twitter Url</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Linkedin Url</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Website Url (without http)</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-end">
                                            <a class="ud-btn btn-dark" href="page-contact.html">Update Social<i class="fal fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ps-widget bgc-white bdrs12 default-box-shadow2 p30 mb30 overflow-hidden position-relative">
                            <h4 class="title fz17 mb30">Change password</h4>
                            <form class="form-style1">
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Old Password</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">New Password</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xl-4">
                                        <div class="mb20">
                                            <label class="heading-color ff-heading fw600 mb10">Confirm New Password</label>
                                            <input type="text" class="form-control" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-end">
                                            <a class="ud-btn btn-dark" href="page-contact.html">Change Password<i class="fal fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
--}}

                    </div>
                </div>


            </div>

        </div>
        <!-- مودال إدخال OTP -->
        <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="otpModalLabel">إدخال كود التحقق الذي تم إرساله على ايميلك</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body text-center">
                        <p class="mb-3">أدخل كود التحقق المكون من 6 أرقام:</p>
                        <input type="text" id="otpInput" maxlength="6"
                               class="form-control text-center mx-auto"
                               style="width: 200px; font-size: 1.5rem; letter-spacing: 5px;">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="verifyOtpBtn">تحقق</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>

                </div>
            </div>
        </div>
        
        <!-- مودال إدخال SMS OTP -->
        <div class="modal fade" id="otpSMSModal" tabindex="-1" aria-labelledby="otpSMSModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="otpSMSModalLabel">إدخال كود التحقق المرسل على جوالك</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>

                    <div class="modal-body text-center">
                        <p class="mb-3">أدخل كود التحقق المكون من 6 أرقام:</p>
                        <input type="text" id="otpSMSInput" maxlength="6"
                               class="form-control text-center mx-auto"
                               style="width: 200px; font-size: 1.5rem; letter-spacing: 5px;">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="verifySMSOtpBtn">تحقق</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>

                </div>
            </div>
        </div>
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editEmailBtn = document.getElementById("editEmail");
            const editMobileBtn = document.getElementById("editMobile");
            const emailInput = document.getElementById("investorEmailInput");
            const mobileInput = document.getElementById("investorMobileInput");
            const form = document.getElementById("identity-verification-form");
            const submitBtn = document.getElementById("submitVerificationBtn");

            if (editEmailBtn && emailInput) {
                editEmailBtn.addEventListener("click", function (e) {
                    e.preventDefault(); // منع إعادة تحميل الصفحة

                    const newEmail = emailInput.value;

                    Swal.fire({
                        title: "هل أنت متأكد؟",
                        text: "سيتم تعديل البريد الإلكتروني الخاص بك",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "نعم، تعديل",
                        cancelButtonText: "إلغاء"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('investors.profile.updateEmail') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({ email: newEmail })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire("تم التعديل!", data.message, "success");
                                    } else {
                                        Swal.fire("خطأ", data.message, "error");
                                    }
                                })
                                .catch(() => {
                                    Swal.fire("خطأ", "حدث خطأ غير متوقع", "error");
                                });
                        }
                    });
                });
            }

            if (editMobileBtn && mobileInput) {
                editMobileBtn.addEventListener("click", function (e) {
                    e.preventDefault(); // منع إعادة تحميل الصفحة

                    const newMobile = mobileInput.value;

                    Swal.fire({
                        title: "هل أنت متأكد؟",
                        text: "سيتم تعديل رقم الهاتف الخاص بك",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "نعم، تعديل",
                        cancelButtonText: "إلغاء"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('investors.profile.updateMobile') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({ mobile: newMobile })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire("تم التعديل!", data.message, "success");
                                    } else {
                                        Swal.fire("خطأ", data.message, "error");
                                    }
                                })
                                .catch(() => {
                                    Swal.fire("خطأ", "حدث خطأ غير متوقع", "error");
                                });
                        }
                    });
                });
            }

            form.addEventListener("submit", function (e) {
                let errors = [];

                // التحقق من الإيميل
                let emailVerified = "{{ isset($user->email_verified_at) ? 'true' : 'false' }}" === "true";
                if (!emailVerified) {
                    errors.push("يجب التحقق من البريد الإلكتروني أولاً ✅");
                }

                // التحقق من الموبايل
                let mobileVerified = "{{ isset($user->mobile_verified_at) ? 'true' : 'false' }}" === "true";
                if (!mobileVerified) {
                    errors.push("يجب التحقق من رقم الجوال أولاً 📱");
                }

                // التحقق من الملفات
                let photoPersonal = form.querySelector("input[name='photo_personal_id']").value;
                let photoWithId = form.querySelector("input[name='photo_with_id']").value;
                if (!photoPersonal || !photoWithId) {
                    errors.push("يجب رفع صورة الهوية وصورة مع الهوية 🖼️");
                }

                // إذا في أخطاء -> منع الإرسال
                if (errors.length > 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: "error",
                        title: "لم يتم الإرسال",
                        html: errors.join("<br>"),
                        confirmButtonText: "حسناً"

                    });
                }
            });
        });

        $(document).on('click', '#sendOtpBtn', function (e) {
            e.preventDefault();
            let email = this.getAttribute('data-email');

            fetch('{{ route("investors.dashboard.emailOtp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // فتح المودال بعد إرسال الكود بنجاح
                        let otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
                        otpModal.show();
                    } else {
                        alert(data.message || 'حدث خطأ أثناء إرسال الكود');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('تعذر الاتصال بالخادم');
                });
        });
        
        document.querySelectorAll('.otp-input').forEach((input, index, inputs) => {
            // الانتقال للأمام عند الكتابة
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1); // السماح برقم واحد فقط
                }
                if (e.target.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // الانتقال للخلف عند مسح الحقل
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        $(document).on('click', '#verifyOtpBtn', function (e) {
            let otpCode = document.getElementById('otpInput').value.trim(); // اجلب القيمة من الحقل
            if (otpCode.length < 6) {  // لاحظ 6 لأن الدالة تتحقق على 6 أرقام
                alert('يرجى إدخال جميع الأرقام.');
                return;
            }

            // إرسال البيانات إلى السيرفر عبر fetch
            fetch('{{ route("investors.dashboard.verifyEmailOtp") }}', { // عدّل حسب اسم الراوت الصحيح
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // تأكد وجود توكين الحماية
                },
                body: JSON.stringify({ otp_code: otpCode })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التحقق بنجاح',
                            text: data.message,
                            confirmButtonText: 'حسناً'
                        });
                        // إخفاء المودال بعد النجاح
                        let otpModal = bootstrap.Modal.getInstance(document.getElementById('otpModal'));
                        otpModal.hide();

                        // إعادة التوجيه إذا كان هناك رابط
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        }
                    } else {
                        alert(data.message || 'فشل التحقق من الكود.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ في الاتصال بالخادم.');
                });
        });

        // mobile OTP
        $(document).on('click', '#sendOtpSMSBtn', function (e) {
            e.preventDefault();
            let mobile = this.getAttribute('data-mobile');

            fetch('{{ route("investors.dashboard.smsOtp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mobile: mobile })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // فتح المودال بعد إرسال الكود بنجاح
                        let otpModal = new bootstrap.Modal(document.getElementById('otpSMSModal'));
                        otpModal.show();
                    } else {
                        alert(data.message || 'حدث خطأ أثناء إرسال الكود');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('تعذر الاتصال بالخادم');
                });
        });
        
        $(document).on('click', '#verifySMSOtpBtn', function () {
            let otpCode = document.getElementById('otpSMSInput').value.trim(); // اجلب القيمة من الحقل
            if (otpCode.length < 6) {  // لاحظ 6 لأن الدالة تتحقق على 6 أرقام                
                        Swal.fire({
                            icon: 'warning',
                            title: 'تنبيه',
                            text: 'يرجى إدخال جميع الأرقام',
                            confirmButtonText: 'حسناً'
                        });
                return;
            }

            // إرسال البيانات إلى السيرفر عبر fetch
            fetch('{{ route("investors.dashboard.verifySmsOtp") }}', { // عدّل حسب اسم الراوت الصحيح
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // تأكد وجود توكين الحماية
                },
                body: JSON.stringify({ otp_code: otpCode })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التحقق بنجاح',
                            text: data.message,
                            confirmButtonText: 'حسناً'
                        });
                        // إخفاء المودال بعد النجاح
                        let otpModal = bootstrap.Modal.getInstance(document.getElementById('otpSMSModal'));
                        otpModal.hide();

                        // إعادة التوجيه إذا كان هناك رابط
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: data.message,
                            confirmButtonText: 'حسناً'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ في الاتصال بالخادم.');
                });
        });
    </script>
@endsection

