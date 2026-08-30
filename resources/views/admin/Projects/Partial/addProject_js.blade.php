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

    $(document).ready(function () {

        let editorInstance;

        DecoupledEditor
            .create(document.querySelector('.kt_docs_ckeditor_document'), {
                removePlugins: ['Image', 'ImageUpload', 'MediaEmbed', 'EasyImage', 'CKFinder', 'Table'], // إزالة الميديا
                language: 'ar',
            })
            .then(editor => {
                editorInstance = editor;

                const toolbarContainer = document.querySelector('.kt_docs_ckeditor_document_toolbar');
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            })
            .catch(error => {
                console.error(error);
            });

        $(document).on('click', '.search_btn', function (e) {
            e.preventDefault();
            let data = {
                province_cd: $('select[name="province_cd"]').val(),
                city_cd: $('select[name="city_cd"]').val(),
                district_cd: $('select[name="district_cd"]').val(),
                address: $('input[name="address"]').val(),
                ownership_type_cd: $('select[name="ownership_type_cd"]').val(),
                area_from: $('input[name="area_from"]').val(),
                area_to: $('input[name="area_to"]').val(),
                price_from: $('input[name="price_from"]').val(),
                price_to: $('input[name="price_to"]').val(),

                // أضف أي عناصر أخرى بنفس الطريقة
            };
            $.ajax({
                url: '{{ route("projects.land_filter") }}',
                method: 'GET',
                data: data,
                beforeSend: function () {
                    $('#land_id').html('<option disabled selected>جاري التحميل...</option>');
                },
                success: function (response) {
                    // تأكد أن الـ response يحتوي على مصفوفة lands
                    let select = $('#land_id');
                    select.empty();
                    select.append('<option></option>'); // لإعادة الخيار الفارغ

                    response.lands.forEach(function (land) {
                        select.append(`
                        <option value="${land.id}" data-lat="${land.lat}" data-long="${land.long}" data-investor_id="${land.investor_id}">
                            ${land.investor_name} - ${land.area}م2 - ${land.land_description}
                        </option>
                    `);
                    });

                    // إعادة تهيئة Select2
                    select.select2();
                },
                error: function (xhr) {
                    alert('حدث خطأ أثناء جلب البيانات');
                    console.error(xhr);
                }
            });
        });
        $(document).on('click', '.reset_search', function (e) {
            e.preventDefault();
            // أولًا: إفراغ جميع الحقول
            $('select[name="province_cd"]').val(null).trigger('change');
            $('select[name="city_cd"]').val(null).trigger('change');
            $('select[name="district_cd"]').val(null).trigger('change');
            $('input[name="address"]').val('');
            $('select[name="ownership_type_cd"]').val(null).trigger('change');
            $('input[name="area_from"]').val('');
            $('input[name="area_to"]').val('');
            $('input[name="price_from"]').val('');
            $('input[name="price_to"]').val('');

            // ثانيًا: إنشاء كائن البيانات مع كل القيم فارغة
            let data = {
                province_cd: null,
                city_cd: null,
                district_cd: null,
                address: null,
                ownership_type_cd: null,
                area_from: null,
                area_to: null,
                price_from: null,
                price_to: null
            };
            $.ajax({
                url: '{{ route("projects.land_filter") }}',
                method: 'GET',
                data: data,
                beforeSend: function () {
                    $('#land_id').html('<option disabled selected>جاري التحميل...</option>');
                },
                success: function (response) {
                    // تأكد أن الـ response يحتوي على مصفوفة lands
                    let select = $('#land_id');
                    select.empty();
                    select.append('<option></option>'); // لإعادة الخيار الفارغ

                    response.lands.forEach(function (land) {
                        select.append(`
                        <option value="${land.id}" data-lat="${land.lat}" data-long="${land.long}" data-investor_id="${land.investor_id}">
                            ${land.investor_name} - ${land.area}م2 - ${land.land_description}
                        </option>
                    `);
                    });

                    // إعادة تهيئة Select2
                    select.select2();
                },
                error: function (xhr) {
                    alert('حدث خطأ أثناء جلب البيانات');
                    console.error(xhr);
                }
            });
        });

        $(".kt_datepicker").flatpickr();
        // Initialize select2
        $('select[name="land_id"]').select2();

        // On change of land selection
        $('select[name="land_id"]').on('change', function () {
            const landId = $(this).val();
            const selectedOption = $(this).find('option:selected');
            const investorId = selectedOption.data('investor_id');
            const lat = parseFloat(selectedOption.data('lat'));
            const lng = parseFloat(selectedOption.data('long'));
            const land_area = selectedOption.data('land_area');

            $('#land_area_note').html(land_area);

            // Load Land Details
            if (landId) {
                $.ajax({
                    url: '{{ route("land.getLandDetails") }}',
                    type: 'GET',
                    data: { id: landId },
                    success: function (response) {
                        $('#land_details').html(response).fadeIn();

                        // Show map if coordinates are available
                        if (!isNaN(lat) && !isNaN(lng)) {
                            $('#map_card').fadeIn();

                            const location = { lat: lat, lng: lng };

                            // Initialize or update map
                            if (!myMap) {
                                myMap = new google.maps.Map(document.getElementById("map"), {
                                    zoom: 13,
                                    center: location,
                                });

                                myMarker = new google.maps.Marker({
                                    position: location,
                                    map: myMap,
                                    draggable: false,
                                });

                                myMarker.addListener('dragend', function (event) {
                                    $('#lat').val(event.latLng.lat().toFixed(6));
                                    $('#long').val(event.latLng.lng().toFixed(6));
                                });
                            } else {
                                myMap.setCenter(location);
                                myMarker.setPosition(location);
                            }

                            // Set initial coordinates if needed
                            $('#lat').val(lat.toFixed(6));
                            $('#long').val(lng.toFixed(6));
                        } else {
                            $('#map_card').hide();
                        }
                    },
                    error: function () {
                        const errorMessage = "{{ __('admin.Error loading data.') }}";
                        $('#land_details').html('<div class="alert alert-danger">' + errorMessage + '</div>').fadeIn();
                    }
                });
            } else {
                $('#land_details').fadeOut().html('');
                $('#map_card').fadeOut();
            }

            // Load Student Details
            if (investorId) {
                $.ajax({
                    url: '{{ route("admin.getInvestorDetails") }}',
                    type: 'GET',
                    data: { id: investorId },
                    success: function (response) {
                        $('#investor_details').html(response).fadeIn();
                    },
                    error: function () {
                        $('#investor_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                    }
                });
            } else {
                $('#investor_details').fadeOut().html('');
            }
        });

        // Trigger change on page load
        $('select[name="land_id"]').trigger('change');
        const investorBalance = 0;


        let balance = 0; // متغير عام
        $('#investor_id').on('change', function () {
            balance = $(this).find(':selected').data('investor-balance') ?? 0;
            // تحديث قيمة الـ hidden input
            $('#investor_balance').val(balance);
        });

        var KTProjectsAddproject = function () {
            var form = document.querySelector('#kt_add_project');
            const projectCostInput = document.getElementById('project_cost');
            const investorBalanceInput = document.getElementById('investor_balance');

            const element = document.getElementById('kt_content_container_project');
            var validator = null;
            var initAddproject = function () {

                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            land_id: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            title: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            investor_id: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            project_type_cd: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            area: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },
                            project_cost: { validators: { notEmpty: { message: '{{ __("admin.This field is required") }}' } } },

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap5: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: 'is-invalid',
                                eleValidClass: 'is-valid',
                            }),
                            submitButton: new FormValidation.plugins.SubmitButton(),
                            // Removed DefaultSubmit
                        }
                    }
                );

                validator.on('core.form.invalid', function () {
                    var invalidElements = form.querySelectorAll('.is-invalid');
                    if (invalidElements.length > 0) {
                        invalidElements[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        invalidElements[0].focus();
                    }
                });

                const submitButton = element.querySelector('[data-kt-project-action="submit"]');
                submitButton.addEventListener('click', e => {
                    e.preventDefault();
                    if (validator) {
                        const landArea = parseFloat($('#landArea').val());
                        const projectArea = parseFloat($('#area').val());

                        const projectCostValue = projectCostInput.value.replace(/,/g, '');
                        const projectCost = parseFloat(projectCostValue) ?? 0;

                        const investorBalanceValue = investorBalanceInput.value.replace(/,/g, '');
                        const investorBalance = parseFloat(investorBalanceValue) ?? 0;

                        // حساب 10% من تكلفة المشروع
                        const requiredBalance = projectCost * 0.1 ?? 0;



                        validator.validate().then(function (status) {
                            if (status == 'Valid' && (projectArea <= landArea)) {
                                // التحقق إذا كان الرصيد كافي
                                if (investorBalance < requiredBalance) {
                                    submitButton.setAttribute('data-kt-indicator', 'on');
                                    submitButton.disabled = true;
                                    const currencySymbol = '{{ getSettings()->currency_symbol }}';
                                    const shortage = requiredBalance - investorBalance;

                                    // عرض رسالة SweetAlert
                                    Swal.fire({
                                        icon: 'error',
                                        title: '@lang("admin.Insufficient balance")',
                                        html: `@lang("admin.Your balance is insufficient for this project")!<br><br>
                                      <table style="margin: 0 auto;">
                                        <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Project cost"):</td><td style="text-align: left;">${projectCost.toLocaleString()} ${currencySymbol}</td></tr>
                                        <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Required 10%"):</td><td style="text-align: left;">${requiredBalance.toLocaleString()} ${currencySymbol}</td></tr>
                                        <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Current balance"):</td><td style="text-align: left;">${investorBalance.toLocaleString()} ${currencySymbol}</td></tr>
                                        <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Shortage amount"):</td><td style="text-align: left;">${shortage.toLocaleString()} ${currencySymbol}</td></tr>
                                        <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Please charge the wallet with an amount"):</td><td style="text-align: left;">${shortage.toLocaleString()} ${currencySymbol}</td></tr>
                                      </table>`,
                                        confirmButtonText: '@lang("admin.OK")',
                                        confirmButtonColor: '#3085d6',
                                    });
                                    // إعادة تمكين الزر وإخفاء السبينر
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                    return; // إيقاف التنفيذ

                                }
                                submitButton.setAttribute('data-kt-indicator', 'on');
                                submitButton.disabled = true;

                                setTimeout(function () {
                                    submitButton.removeAttribute('data-kt-indicator');
                                    submitButton.disabled = false;
                                    if (editorInstance) {
                                        // تحديث textarea المخفية
                                        document.querySelector('textarea[name="description"]').value = editorInstance.getData();
                                    }

                                    const formData = new FormData(form);
                                    const url = `{{ route('projects.store') }}`;

                                    fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                        .then(async response => {
                                            const data = await response.json();

                                            if (response.ok) {
                                                Swal.fire({
                                                    text: "@lang('admin.Form has been successfully submitted!')",
                                                    icon: "success",
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: { confirmButton: "btn btn-primary" }
                                                }).then(() => {
                                                    form.reset();
                                                    window.location.href = data.redirect; // Safe redirect from JS
                                                });
                                            } else if (response.status === 422) {
                                                let errorMessages = Object.values(data.errors).flat().join('<br>');
                                                Swal.fire({
                                                    html: `<div class="text-start">${errorMessages}</div>`,
                                                    icon: "error",
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: { confirmButton: "btn btn-danger" }
                                                });
                                            } else {
                                                Swal.fire({
                                                    text: data.message || "@lang('admin.Something went wrong.')",
                                                    icon: "error",
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: { confirmButton: "btn btn-danger" }
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            Swal.fire({
                                                text: "@lang('admin.Unexpected error: ')",
                                                icon: "error",
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: { confirmButton: "btn btn-danger" }
                                            });
                                        });
                                }, 1000);
                            } else {
                                Swal.fire({
                                    text: "@lang('admin.Sorry, looks like there are some errors detected, please try again.')",
                                    icon: "error",
                                    confirmButtonText: "@lang('admin.OK')",
                                    customClass: { confirmButton: "btn btn-primary" }
                                });
                            }
                        });
                    }
                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-project-action="cancel"]');
                cancelButton.addEventListener('click', e => {
                    e.preventDefault();

                    Swal.fire({
                        text: "@lang('admin.Are you sure you would like to cancel?')",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.Yes, cancel it!')",
                        cancelButtonText: "@lang('admin.No, return')",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            window.location.href = "{{ route('projects.index') }}"; // Redirect to land.index route

                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "@lang('admin.Your form has not been cancelled!.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('OK')",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                });

            }

            return {
                init: function () {
                    initAddproject();
                }
            };
        }();

// On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTProjectsAddproject.init();

        });
    });
    document.getElementById('projectLogoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const img = new Image();
        img.onload = function() {
            if (img.width < 160 || img.height < 160) {
                alert('⚠️ يجب أن تكون أبعاد الصورة على الأقل 160 × 160 بكسل.');
                event.target.value = ''; // امسح الاختيار
            }
        };
        img.onerror = function() {
            alert('⚠️ الملف الذي اخترته ليس صورة صالحة.');
            event.target.value = '';
        };
        img.src = URL.createObjectURL(file);
    });
</script>


<!-- Google Maps API -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap">
</script>
