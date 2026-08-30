@extends('site.dashboard.layouts.master')
@section('content')
    <style>
        .tab-pane {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .tab-pane.show.active {
            display: block;
            opacity: 1;
        }


    </style>
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
                        <h2>@lang('investors.add_land')</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="ps-widget bgc-white bdrs12 default-box-shadow2 pt30 mb30 overflow-hidden position-relative" >
                        <div class="navtab-style1">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab2" role="tablist">
                                    <button class="nav-link active fw600 ms-3" id="nav-item1-tab" data-bs-toggle="tab" data-bs-target="#nav-item1" type="button" role="tab" aria-controls="nav-item1" aria-selected="true">@lang('admin.Land details')</button>
                                    <button class="nav-link fw600" id="nav-item2-tab" data-bs-toggle="tab" data-bs-target="#nav-item2" type="button" role="tab" aria-controls="nav-item2" aria-selected="false"> وسائط
                                    </button>
                                    <button class="nav-link fw600" id="nav-item3-tab" data-bs-toggle="tab" data-bs-target="#nav-item3" type="button" role="tab" aria-controls="nav-item3" aria-selected="false">موقع</button>
{{--
                                    <button class="nav-link fw600" id="nav-item4-tab" data-bs-toggle="tab" data-bs-target="#nav-item4" type="button" role="tab" aria-controls="nav-item4" aria-selected="false">4. Detail</button>
--}}
                                    <button class="nav-link fw600" id="nav-item5-tab" data-bs-toggle="tab" data-bs-target="#nav-item5" type="button" role="tab" aria-controls="nav-item5" aria-selected="false">المرفقات</button>
                                </div>
                            </nav>
                            <div id="formErrorMsg" class="alert alert-danger d-none"></div>
                            <div class="tab-content" id="nav-tabContent">
                                <form id="investors_add_land_form" action="{{ route('investors.dashboard.add_land') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="tab-pane fade show active" id="nav-item1" role="tabpanel" aria-labelledby="nav-item1-tab">
                                        <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                            <h4 class="title fz17 mb30">@lang('admin.Land details')</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb20">
                                                            <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Description of the land')</label>
                                                            <input required id="land_description" name="land_description" type="text" class="form-control" placeholder="@lang('admin.Enter land description here')">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-4">
                                                        <label for="province_contractor" class="heading-color ff-heading fw600 mb10 required">المحافظة</label>
                                                        <select required class="form-select form-control location_province" name="province_cd" id="province_contractor" data-control="select2">
                                                            <option value="" selected>-- اختر المحافظة --</option>
                                                            @foreach ($provinces as $val)
                                                                <option value="{{ $val->id }}">{{ $val->{'name_' . app()->getLocale()} }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="location_cities_contractor" class="heading-color ff-heading fw600 mb10 required">المدينة</label>
                                                        <select required class="form-select form-control location_city" id="location_cities_contractor" name="city_cd" data-control="select2">
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="location_areas_contractor" class="heading-color ff-heading fw600 mb10 required">الحي</label>
                                                        <select required class="form-select form-control" id="location_areas_contractor" name="district_cd" data-control="select2">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="mb20">
                                                            <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Address in detail')</label>
                                                            <textarea  name="address" cols="30" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb20">
                                                            <label class="heading-color ff-heading fw600 mb10">@lang('admin.Border')</label>
                                                            <textarea  name="borders"  rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mb20">
                                                            <label class="heading-color ff-heading fw600 mb10">@lang('admin.Available services')</label>
                                                            <textarea  name="services"  rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-4">
                                                        <div class="mb30">

                                                            <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Land area')</label>
                                                            <div class="input-group">
                                                                <input class="form-control" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')" required style="text-align: end">
                                                                <span class="input-group-text">م2</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xl-4">
                                                        <div class="mb30">
                                                            <label class="heading-color ff-heading fw600 mb10">@lang('admin.Plot Number')</label>
                                                            <input name="plot_number" type="text" class="form-control" placeholder="@lang('admin.Plot Number')">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xl-4">
                                                        <div class="mb30">
                                                            <label class="heading-color ff-heading fw600 mb10">@lang('admin.Parcel Number')</label>
                                                            <input  name="parcel_number" type="text" class="form-control" placeholder="@lang('admin.Parcel Number')">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 col-xl-4">
                                                        <div class="mb30">
                                                            <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Type of land ownership')</label>
                                                            <select required class="form-select form-control" name="ownership_type_cd"  data-control="select2">
                                                                <option value="" disabled selected>@lang('admin.Choose the land ownership type')</option>
                                                                @foreach($ownership_type as $ownership_types)
                                                                    <option value="{{$ownership_types->id}}">{{$ownership_types->{'name_'.app()->getLocale()} }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Asking price')</label>
                                                        <div class="input-group">
                                                            <input required type="text" class="form-control number_format"  name="price" placeholder="@lang('admin.Enter the price')" style="text-align: right; direction: rtl;">
                                                            <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            <div class="row mb-0 pb-0">
                                                <div class="col-md-12 text-end">
                                                    <a class="ud-btn btn-dark next-tab mt-3" data-next-tab="#nav-item2" href="javascript:void(0)">
                                                        التالي <i class="fal fa-arrow-right-long"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-item2" role="tabpanel" aria-labelledby="nav-item2-tab">
                                        <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                                <div class="col-12" style="padding-bottom: 20px">
                                                    <label class="heading-color ff-heading fw600 mb10 required">صورة الأرض الرئيسية</label>
                                                    <input type="file" id="main_land_images" class="form-control" name="land_logo"  accept="image/*" required style="height: auto; padding-right: 2px">
                                                    <!-- عنصر المعاينة -->
                                                    <div style="margin-top: 10px;">
                                                        <img id="preview_main_land_image" src="#" alt="معاينة الصورة" style="max-width: 100%; max-height: 300px; display: none;" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-5" style="margin-bottom: 17px">
                                                    <label class="heading-color ff-heading fw600 mb10">@lang('admin.Land Photos')</label>
                                                    <input type="file" id="land_images" class="form-control" name="land_images[]" multiple accept="image/*" style="height: auto; padding-right: 2px">
                                                    <input type="hidden" name="deleted_images" id="deleted_images" value="[]">

                                                    <div class="row mt-4" id="preview_images" style="gap: 15px;"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-sm-flex justify-content-between">
                                                        <a class="ud-btn btn-dark next-tab" data-next-tab="#nav-item1" href="javascript:void(0)">
                                                            السابق<i class="fal fa-arrow-left-long"></i></a>
                                                        <a class="ud-btn btn-dark next-tab" data-next-tab="#nav-item3" href="javascript:void(0)">
                                                             التالي <i class="fal fa-arrow-right-long"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-item3" role="tabpanel" aria-labelledby="nav-item3-tab">
                                        <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                            <h4 class="title fz17 mb30">موقع الارض</h4>
                                                <div class="row">
                                                    <div class="col-md-8 mb-5">
                                                        <div id="map" style="height: 550px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>
                                                    </div>
                                                    <div class="col-md-4 d-flex flex-column justify-content-center gap-3">
                                                        <div>
                                                            <label class="form-label fw-bold required">@lang('admin.Latitude')</label>
                                                            <input type="text" id="lat" name="lat" class="form-control" placeholder="@lang('admin.Latitude')" value="{{ $lat ?? '31.5012' }}">
                                                        </div>
                                                        <div>
                                                            <label class="form-label fw-bold required">@lang('admin.Longitude')</label>
                                                            <input type="text" id="long" name="long" class="form-control" placeholder="@lang('admin.Longitude')" value="{{ $lng ?? '34.4663' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-5" style="padding-top: 25px">
                                                        <div class="d-sm-flex justify-content-between">
                                                            <a class="ud-btn btn-dark next-tab" data-next-tab="#nav-item2" href="javascript:void(0)">
                                                                السابق<i class="fal fa-arrow-left-long"></i></a>
                                                            <a class="ud-btn btn-dark next-tab" data-next-tab="#nav-item5" href="javascript:void(0)">
                                                                التالي<i class="fal fa-arrow-right-long"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-item5" role="tabpanel" aria-labelledby="nav-item5-tab">
                                        <div class="ps-widget bgc-white bdrs12 p30 overflow-hidden position-relative">
                                            <div class="card card-flush mt-5">
                                                <div class="card-header pt-8">
                                                    <h5>@lang('admin.Ownership Documents')</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div id="ownership-documents-container">
                                                        <!-- العنصر الأساسي للنسخ -->
                                                        <div class="document-item row mb-3" data-clone-item>
                                                            <div class="col-md-3">
                                                                <label class="heading-color ff-heading fw600 mb10">@lang('admin.Attachment')</label>
                                                                <input name="land_attachment[]" type="file" class="form-control mb-2 mb-md-0" style="height: auto; padding-right: 2px" />
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="heading-color ff-heading fw600 mb10">@lang('admin.Description')</label>
                                                                <input name="description[]" type="text" class="form-control mb-2 mb-md-0" style="height: auto; padding-right: 2px" />
                                                            </div>
                                                            <div class="col-md-4 d-flex align-items-end">
                                                                <button type="button" class="btn btn-sm btn-light-danger remove-document">
                                                                    <span class="flaticon-bin"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="attachments-error" class="text-danger mt-2" style="font-size: 13px;"></div>

                                                    <!-- زر الإضافة -->
                                                    <div class="mt-5">
                                                        <button type="button" id="add-document" class="btn btn-light-info">
                                                            <i class="bi bi-plus-circle fs-2"></i>
                                                            @lang('investors.add')
                                                        </button>
                                                    </div>

                                                    <!-- 🆕 قسم توقيع العقد -->
                                                    <div class="mt-10 pt-5 border-top">
                                                        <h4 class="fw-bold text-primary mb-4">@lang('admin.Contract Signing')</h4>

                                                        <div class="row mb-4">
                                                            <div class="col-md-6">
                                                                <label class="heading-color ff-heading fw600 mb10 fw-semibold text-gray-700 d-block mb-2">@lang('investors.Download Contract')</label>
                                                                <a href="{{ asset('uploads/settings/' . $settings->land_template_file) }}" download class="btn btn-light-primary btn-sm">
                                                                    <i class="fas fa-download me-2"></i> @lang('investors.Download Contract')
                                                                </a>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="heading-color ff-heading fw600 mb10 required">@lang('admin.Upload Signed Contract')</label>
                                                                <input type="file" name="signed_contract_file" class="form-control form-control-solid" style="height: auto; padding-right: 2px" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- أزرار التنقل -->
                                            <div class="col-md-12 mt30">
                                                <div class="d-sm-flex justify-content-between">
                                                    <a class="ud-btn btn-dark next-tab" data-next-tab="#nav-item3" href="javascript:void(0)">
                                                        السابق<i class="fal fa-arrow-left-long"></i>
                                                    </a>
                                                    <button type="submit" class="ud-btn btn-thm" id="submitBtn">
                                                        <span class="btn-text">إضافة أرض</span>
                                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true" id="btnSpinner"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </form>
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
        let selectedImages = [];

        document.getElementById('land_images').addEventListener('change', function (event) {
            const newFiles = Array.from(event.target.files);
            const file = event.target.files[0];

            if (file) {
                const maxSize = 3 * 1024 * 1024; // ✅ 3MB

                if (file.size > maxSize) {
                    alert('حجم الصورة يجب أن لا يتجاوز 3 ميغابايت (3MB)');
                    event.target.value = ''; // مسح الملف المختار
                }else {
                    // أضف الملفات الجديدة إلى المصفوفة الأصلية
                    selectedImages = selectedImages.concat(newFiles);

                    updatePreview();
                }
            }

        });
        function updatePreview() {
            const preview = document.getElementById('preview_images');
            preview.innerHTML = '';

            selectedImages.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.className = 'position-relative'; // إزالة col من bootstrap

                    col.innerHTML = `
                <div class="card shadow-sm h-100">
                    <div class="card-body p-2 d-flex align-items-center justify-content-center">
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;" />
                    </div>
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-image" data-index="${index}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
                    preview.appendChild(col);
                };

                reader.readAsDataURL(file);
            });

            // تحديث ملفات input
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => dataTransfer.items.add(file));
            document.getElementById('land_images').files = dataTransfer.files;
        }

        // حذف صورة عند الضغط على زر X
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-image')) {
                const btn = e.target.closest('.remove-image');
                const index = parseInt(btn.getAttribute('data-index'));

                selectedImages.splice(index, 1); // حذف من المصفوفة
                updatePreview(); // إعادة عرض الصور
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById('ownership-documents-container');
            const addButton = document.getElementById('add-document');

            addButton.addEventListener('click', function () {
                // نسخ أول عنصر
                const original = container.querySelector('[data-clone-item]');
                const clone = original.cloneNode(true);

                // إعادة تعيين القيم
                const inputs = clone.querySelectorAll('input');
                inputs.forEach(input => {
                    input.value = '';
                });

                container.appendChild(clone);

                // إعادة تفعيل زر الحذف في النسخة الجديدة
                activateRemoveButtons();
            });

            function activateRemoveButtons() {
                const removeButtons = container.querySelectorAll('.remove-document');
                removeButtons.forEach(button => {
                    button.onclick = function () {
                        // لا تحذف إذا بقي عنصر واحد فقط
                        if (container.querySelectorAll('[data-clone-item]').length > 1) {
                            button.closest('[data-clone-item]').remove();
                        }
                    };
                });
            }

            // تفعيل أول مرة
            activateRemoveButtons();
        });
    </script>
    <script>
        let myMap;
        let myMarker;

        function initMap() {
            const initialLat = parseFloat(document.getElementById('lat').value) || 31.5012;
            const initialLng = parseFloat(document.getElementById('long').value) || 34.4663;
            const initialLocation = { lat: initialLat, lng: initialLng };

            myMap = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: initialLocation,
            });

            myMarker = new google.maps.Marker({
                position: initialLocation,
                map: myMap,  // ✅ هذا التصحيح
                draggable: true
            });

            // When marker is dragged update input fields
            myMarker.addListener('dragend', function (event) {
                document.getElementById('lat').value = event.latLng.lat().toFixed(6);
                document.getElementById('long').value = event.latLng.lng().toFixed(6);
            });
        }

        // When input fields change update the map
        document.getElementById('lat').addEventListener('input', updateMap);
        document.getElementById('long').addEventListener('input', updateMap);

        function updateMap() {
            const lat = parseFloat(document.getElementById('lat').value);
            const lng = parseFloat(document.getElementById('long').value);

            if (!isNaN(lat) && !isNaN(lng)) {
                const newPosition = { lat: lat, lng: lng };
                myMarker.setPosition(newPosition);
                myMap.setCenter(newPosition);
            }
        }

        $(document).on('click', '.openImagePreview', function () {
            let imageUrl = $(this).data('image');
            $('#previewImage').attr('src', imageUrl);
            $('#imagePreviewModal').modal('show');
        });

    </script>


    <!-- Google Maps API -->
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const errorMsgDiv = document.getElementById('formErrorMsg');

            function validateTab(tabPane) {
                errorMsgDiv.classList.add('d-none');
                errorMsgDiv.innerText = '';

                const requiredFields = tabPane.querySelectorAll('[required], .required input, .required select, .required textarea');
                let firstInvalidField = null;

                for (let field of requiredFields) {
                    if (field.type === 'file') {
                        if (field.files.length === 0) {
                            firstInvalidField = field;
                            break;
                        }
                    } else if (field.value.trim() === '') {
                        firstInvalidField = field;
                        break;
                    }
                }

                if (firstInvalidField) {
                    errorMsgDiv.classList.remove('d-none');
                    errorMsgDiv.innerText = 'يرجى تعبئة جميع الحقول المطلوبة في هذه الخطوة.';
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }
                return true;
            }

            // استهداف أزرار التالي فقط
            const nextButtons = document.querySelectorAll('.next-tab');

            nextButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    let currentTab = btn.closest('.tab-pane');
                    if (!currentTab) return;

                    // تحقق الحقول المطلوبة
                    if (!validateTab(currentTab)) {
                        return; // اذا لم ينجح التحقق لا ننتقل للتبويب التالي
                    }

                    // التبويب التالي من data-next-tab
                    const nextTabSelector = btn.getAttribute('data-next-tab');
                    if (!nextTabSelector) return;

                    // اخفاء التبويب الحالي
                    currentTab.classList.remove('show', 'active');

                    // اظهار التبويب التالي
                    const nextTab = document.querySelector(nextTabSelector);
                    if (nextTab) {
                        nextTab.classList.add('show', 'active');
                    }

                    // تحديث الـ nav-link (اختياري)
                    const targetNav = document.querySelector(`[aria-controls="${nextTabSelector.replace('#', '')}"]`);
                    if (targetNav) {
                        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                        targetNav.classList.add('active');
                    }

                    // إخفاء رسالة الخطأ إذا كانت معروضة
                    errorMsgDiv.classList.add('d-none');
                    errorMsgDiv.innerText = '';
                });
            });

            // استهداف أزرار السابق فقط
            const prevButtons = document.querySelectorAll('.prev-tab');

            prevButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetTabId = btn.getAttribute('data-next-tab');
                    if (!targetTabId) return;

                    // إلغاء تفعيل جميع التبويبات
                    document.querySelectorAll('.tab-pane').forEach(tab => {
                        tab.classList.remove('show', 'active');
                    });

                    // تفعيل التبويب المطلوب
                    const targetTab = document.querySelector(targetTabId);
                    if (targetTab) {
                        targetTab.classList.add('show', 'active');
                    }

                    // تحديث الـ nav-link (اختياري)
                    const targetNav = document.querySelector(`[aria-controls="${targetTabId.replace('#', '')}"]`);
                    if (targetNav) {
                        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                        targetNav.classList.add('active');
                    }

                    // إخفاء رسالة الخطأ إذا كانت معروضة
                    errorMsgDiv.classList.add('d-none');
                    errorMsgDiv.innerText = '';
                });
            });
        });
    </script>


    <script>
        document.getElementById('main_land_images').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview_main_land_image');

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('#investors_add_land_form'); // ID النموذج
            const submitBtn = document.querySelector('#submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnSpinner = document.querySelector('#btnSpinner');
            const errorDiv = document.getElementById('attachments-error');

            form.addEventListener('submit', function (e) {
                errorDiv.textContent = ''; // مسح الأخطاء السابقة

                // جلب جميع الحقول الخاصة بالمرفقات
                const attachments = document.querySelectorAll('input[name="land_attachment[]"]');

                let hasFile = false;
                attachments.forEach(input => {
                    if (input.files.length > 0) {
                        hasFile = true;
                    }
                });

                // التحقق
                if (!hasFile) {
                    e.preventDefault(); // منع إرسال الفورم
                    errorDiv.textContent = 'يجب رفع مرفق واحد على الأقل';
                    return false;
                }

                // تعطيل الزر وإظهار السبينر عند الإرسال
                submitBtn.disabled = true;
                btnSpinner.classList.remove('d-none');
            });

            // إعادة تفعيل الزر في حالة وجود أخطاء Laravel
            @if ($errors->any() || session('error'))
            window.addEventListener('DOMContentLoaded', () => {
                submitBtn.disabled = false;
                btnSpinner.classList.add('d-none');
            });
            @endif
        });
    </script>


@endsection


