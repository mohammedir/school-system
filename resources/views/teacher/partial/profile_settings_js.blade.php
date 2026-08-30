<script>
    $(document).ready(function () {

        // عند تحميل الصفحة نعين القيم إذا كانت موجودة
        let selectedProvince = '{{ $user->province_cd ?? '' }}';
        let selectedCity = '{{ $user->city_cd ?? '' }}';
        let selectedDistrict = '{{ $user->district_cd ?? '' }}';

        if (selectedProvince !== '') {
            $('#location_province').val(selectedProvince).trigger('change');

            // ننتظر تحميل المدن
            setTimeout(function () {
                $('#location_cities').val(selectedCity).trigger('change');
            }, 5000);

            // ننتظر تحميل المناطق
            setTimeout(function () {
                $('#location_areas').val(selectedDistrict).trigger('change');
            }, 7000);
        }
    });

</script>

<script>
    $(document).on("change", "select.location_province", function () {
        var province_id = $(this).val();
        var this_city = $("#location_cities");
        var this_area = $("#location_areas");
        var cities_block = document.querySelector("#cities_block");

        var blockUI = KTBlockUI.getInstance(cities_block);

        if (!blockUI) {
            blockUI = new KTBlockUI(cities_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });
        }

        if (province_id !== '') {
            blockUI.block();
            this_city.empty();
            this_area.empty();


            $.ajax({
                method: "POST",
                url: '{{url("/")}}/lookups/get_children_by_parent',
                dataType: 'json',
                data: {id: province_id, '_token': '{{csrf_token()}}'},
                success: function (data, textStatus, jqXHR) {
                    this_city.append(data.children);


                },
                complete:function (){
                    blockUI.release(); // Release blockUI when the request is successful
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    blockUI.release(); // Release blockUI when the request fails
                }
            });
        } else {
            blockUI.release(); // Release blockUI immediately if province_id is empty
        }
    });

    $(document).on("change", "select.location_city", function () {
        var city_id = $(this).val();
        var this_area = $("#location_areas");
        var areas_block = document.querySelector("#areas_block");

        var blockUI = KTBlockUI.getInstance(areas_block);

        if (!blockUI) {
            blockUI = new KTBlockUI(areas_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> @lang("engineering.Please wait")...</div>',
            });
        }

        if (city_id !== '') {
            blockUI.block();
            this_area.empty();

            $.ajax({
                method: "POST",
                url: '{{url("/")}}/lookups/get_children_by_parent',
                dataType: 'json',
                data: {id: city_id, '_token': '{{csrf_token()}}'},
                success: function (data, textStatus, jqXHR) {
                    this_area.append(data.children);

                },
                complete:function (){
                    blockUI.release(); // Release blockUI when the request is successful
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    blockUI.release(); // Release blockUI when the request fails
                }
            });
        } else {
            blockUI.release(); // Release blockUI immediately if province_id is empty
        }
    });

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('kt_account_profile_details_form');
        const saveButton = document.getElementById('add_form');
        const data_url = '{{ route('engineering.profile.update') }}';

        // إعداد التحقق
        const formValidation = FormValidation.formValidation(form, {
            fields: {
                'logo': {
                    validators: {
                        file: {
                            extension: 'jpeg,png,jpg',
                            type: 'image/jpeg,image/png',
                            message: '{{ __("engineering.allowed_file_types") }}' // تأكد تضيف هذا النص للغة
                        }
                    }
                },
                'company_name': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.company_name_required") }}'
                        }
                    }
                },
                'mobile': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.mobile_required") }}'
                        }
                    }
                },
                'province_cd': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.province_required") }}'
                        }
                    }
                },
                'city_cd': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.city_required") }}'
                        }
                    }
                },
                'district_cd': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.district_required") }}'
                        }
                    }
                },
                'address': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.address_required") }}'
                        }
                    }
                },
                'experience_years': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.experience_years_required") }}'
                        }
                    }
                },
                'tax_number': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.tax_number_required") }}'
                        }
                    }
                },
                'commercial_registration_number': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.commercial_registration_required") }}'
                        }
                    }
                },
                'specializations': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.specializations_required") }}'
                        }
                    }
                },
                'tax_number': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.tax_number_required") }}'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',  // ✅ Border أحمر
                    eleValidClass: 'is-valid',       // ✅ Border أخضر
                    // ✅ لإظهار الأيقونات
                    formClass: 'fv-plugins-bootstrap5',
                    messageClass: 'fv-help-block',
                    invalidFormClass: 'fv-plugins-bootstrap5-invalid',
                    validFormClass: 'fv-plugins-bootstrap5-valid'
                }),

            }
        });
        // تفعيل Select2 وربطها بالفاليديشن
        ['province_cd', 'city_cd', 'district_cd'].forEach(function (field) {
            const $element = $('[name="' + field + '"]');

            $element.select2({
                placeholder: $element.data('placeholder'),
                width: '100%'
            });

            // ربط الـ select2 بالتغيير للفاليديشن
            $element.on('change', function () {
                formValidation.revalidateField(field);
            });
        });


        // حدث عند الضغط على زر الحفظ
        saveButton.addEventListener('click', function (e) {
            e.preventDefault();

            formValidation.validate().then(function (status) {
                if (status === 'Valid') {
                    const formData = new FormData(form);

                    saveButton.disabled = true;
                    saveButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("engineering.saving") }}`;

                    $.ajax({
                        url: data_url,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            saveButton.disabled = false;
                            saveButton.textContent = '{{ __("engineering.save_changes") }}';
                            if (data.success) {
                                toastr.success(data.message || '{{ __("engineering.profile_updated_successfully") }}');
                                // إعادة التوجيه بعد ثوانٍ قليلة لإعطاء وقت لعرض الرسالة
                                setTimeout(function () {
                                    window.location.href = "{{ route('engineering.profile') }}";
                                }, 1000); // 1 ثانية تأخير
                            } else {
                                toastr.error(data.message || '{{ __("engineering.error_occurred") }}');
                            }
                        },
                        error: function (xhr, status, error) {
                            saveButton.disabled = false;
                            saveButton.textContent = '{{ __("engineering.save_changes") }}';
                            toastr.error('{{ __("engineering.unexpected_error_occurred") }}');
                            console.error(error);
                        }
                    });
                }
                else {
                    // تمرير الصفحة لأول خطأ
                    const firstErrorElement = form.querySelector('.fv-plugins-bootstrap5-row-invalid');
                    if (firstErrorElement) {
                        firstErrorElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstErrorElement.focus();
                    }
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form_password = document.getElementById('kt_signin_change_password');
        const saveButton_password = document.getElementById('kt_password_submit');
        const data_url_password = '{{ route('engineering.profile.update-password') }}';

        const formValidation = FormValidation.formValidation(form_password, {
            fields: {
                'currentpassword': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.current_password_required") }}'
                        }
                    }
                },
                'newpassword': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.new_password_required") }}'
                        },
                        stringLength: {
                            min: 8,
                            message: '{{ __("engineering.password_min_length") }}'
                        }
                    }
                },
                'confirmpassword': {
                    validators: {
                        notEmpty: {
                            message: '{{ __("engineering.confirm_password_required") }}'
                        },
                        identical: {
                            compare: function () {
                                return form_password.querySelector('[name="newpassword"]').value;
                            },
                            message: '{{ __("engineering.passwords_do_not_match") }}'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',
                    eleValidClass: 'is-valid'
                }),
            }
        });

        saveButton_password.addEventListener('click', function (e) {
            e.preventDefault();

            formValidation.validate().then(function (status) {
                if (status === 'Valid') {
                    const formData = new FormData(form_password);

                    saveButton_password.disabled = true;
                    saveButton_password.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("engineering.saving") }}`;

                    $.ajax({
                        url: data_url_password,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            saveButton_password.disabled = false;
                            saveButton_password.textContent = '{{ __("engineering.Update Password") }}';

                            // ✅ إزالة الأخطاء السابقة
                            form_password.querySelectorAll('.is-invalid').forEach(function (el) {
                                el.classList.remove('is-invalid');
                            });
                            form_password.querySelectorAll('.invalid-feedback').forEach(function (el) {
                                el.remove();
                            });

                            toastr.success(data.message || '{{ __("engineering.password_updated_successfully") }}');
                            form_password.reset();
                            formValidation.resetForm();
                        },

                        error: function (xhr) {
                            saveButton_password.disabled = false;
                            saveButton_password.textContent = '{{ __("engineering.Update Password") }}';

                            const errors = xhr.responseJSON?.errors || {};
                            if (xhr.status === 422 && Object.keys(errors).length > 0) {
                                Object.keys(errors).forEach(function (field) {
                                    let input = form_password.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');
                                        let feedback = input.nextElementSibling;
                                        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                                            feedback = document.createElement('div');
                                            feedback.classList.add('invalid-feedback');
                                            input.parentNode.insertBefore(feedback, input.nextSibling);
                                        }
                                        feedback.textContent = errors[field][0];
                                    }
                                });

                                toastr.error(Object.values(errors)[0][0]);
                            } else if (xhr.responseJSON?.message) {
                                toastr.error(xhr.responseJSON.message);

                                const inputCurrent = form_password.querySelector('[name="currentpassword"]');
                                if (inputCurrent) {
                                    inputCurrent.classList.add('is-invalid');
                                    let feedback = inputCurrent.nextElementSibling;
                                    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                                        feedback = document.createElement('div');
                                        feedback.classList.add('invalid-feedback');
                                        inputCurrent.parentNode.insertBefore(feedback, inputCurrent.nextSibling);
                                    }
                                    feedback.textContent = xhr.responseJSON.message;
                                }
                            } else {
                                toastr.error('{{ __("engineering.unexpected_error_occurred") }}');
                            }
                        }
                    });
                }
            });
        });
    });
</script>


<script !src="">
    "use strict";

    var KTChangePassword = function () {
        var passwordForm;
        var passwordMainEl;
        var passwordEditEl;
        var passwordChange;
        var passwordCancel;

        var toggleChangePassword = function () {
            passwordMainEl.classList.toggle('d-none');
            passwordChange.classList.toggle('d-none');
            passwordEditEl.classList.toggle('d-none');
        }


        return {
            init: function () {
                passwordForm = document.getElementById('kt_signin_change_password');
                passwordMainEl = document.getElementById('kt_signin_password');
                passwordEditEl = document.getElementById('kt_signin_password_edit');
                passwordChange = document.getElementById('kt_signin_password_button');
                passwordCancel = document.getElementById('kt_password_cancel');

                if (!passwordForm || !passwordChange || !passwordCancel) return;

                passwordChange.querySelector('button').addEventListener('click', toggleChangePassword);
                passwordCancel.addEventListener('click', toggleChangePassword);

            }
        }
    }();


    
    var KTUsersAddAuthApp = function () {
        // Shared variables
        const element = document.getElementById('enable_auth_app_modal');
        const form = element.querySelector('#enable_auth_app_modal_form');
        const modal = new bootstrap.Modal(element);
        // Init add schedule modal
        var initAddAuthApp = () => {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'otp_code': {
                            validators: {
                                notEmpty: {
                                    message: '@lang('admin.OTP Code is required')'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );
            // Submit button handler
            const submitButton = element.querySelector('[data-kt-add-auth-app-modal-action="submit"]');
            submitButton.addEventListener('click', e => {
                e.preventDefault();

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function() {
                                // Remove loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                                const formData = new FormData(form); // Handles file uploads too
                                const url =
                                    `{{ route('engineering.2fa.enableAuthapp') }}`; // Build the correct URL
                                // Show popup confirmation

                                fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: formData
                                    })
                                    .then(async response => {
                                        submitButton.removeAttribute(
                                            'data-kt-indicator');
                                        submitButton.disabled = false;

                                        const data = await response.json();

                                        if (response.ok) {
                                            if(data.success){
                                                Swal.fire({
                                                    text: data.message,
                                                    icon: "success",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: {
                                                        confirmButton: "btn btn-info"
                                                    }
                                                }).then(function(result) {
                                                    if (result
                                                        .isConfirmed) {
                                                        form.reset();
                                                        modal.hide();
                                                        window.location.reload();
                                                    }
                                                });
                                            }else{
                                                Swal.fire({
                                                    text: data.message,
                                                    icon: "error",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "@lang('admin.OK')",
                                                    customClass: {
                                                        confirmButton: "btn btn-info"
                                                    }
                                                });
                                            }
                                        } else if (response.status === 422) {
                                            // Laravel validation errors
                                            let errorMessages = Object.values(
                                                data.errors).flat().join(
                                                '<br>');
                                            Swal.fire({
                                                html: `<div class="text-start">${errorMessages}</div>`,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                text: data.message ||
                                                    "@lang('admin.Something went wrong.')",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        submitButton.removeAttribute(
                                            'data-kt-indicator');
                                        submitButton.disabled = false;

                                        Swal.fire({
                                            text: "@lang('admin.Unexpected error: ')" +
                                                error.message,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "@lang('admin.OK')",
                                            customClass: {
                                                confirmButton: "btn btn-danger"
                                            }
                                        });
                                    });

                                //form.submit(); // Submit form
                            }, 2000);
                        } else {
                            // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "@lang('admin.Sorry, looks like there are some errors detected, please try again.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('admin.OK')",
                                customClass: {
                                    confirmButton: "btn btn-info"
                                }
                            });
                        }
                    });
                }
            });
        }

        // QR code to text code swapper
        var initCodeSwap = () => {
            const qrCode = element.querySelector('[ data-kt-add-auth-action="qr-code"]');
            const textCode = element.querySelector('[ data-kt-add-auth-action="text-code"]');
            const qrCodeButton = element.querySelector('[ data-kt-add-auth-action="qr-code-button"]');
            const textCodeButton = element.querySelector('[ data-kt-add-auth-action="text-code-button"]');
            const qrCodeLabel = element.querySelector('[ data-kt-add-auth-action="qr-code-label"]');
            const textCodeLabel = element.querySelector('[ data-kt-add-auth-action="text-code-label"]');

            const toggleClass = () =>{
                qrCode.classList.toggle('d-none');
                qrCodeButton.classList.toggle('d-none');
                qrCodeLabel.classList.toggle('d-none');
                textCode.classList.toggle('d-none');
                textCodeButton.classList.toggle('d-none');
                textCodeLabel.classList.toggle('d-none');
            }

            // Swap to text code handler
            textCodeButton.addEventListener('click', e =>{
                e.preventDefault();

                toggleClass();
            });

            qrCodeButton.addEventListener('click', e =>{
                e.preventDefault();

                toggleClass();
            });
        }

        return {
            // Public functions
            init: function () {                
                initAddAuthApp();
                initCodeSwap();
            }
        };
    }();
    // On document ready

    KTUtil.onDOMContentLoaded(function () {
        KTChangePassword.init();
        KTUsersAddAuthApp.init();
    });

    
    function confirmDisable() {
        Swal.fire({
            title: '@lang("admin.Are you sure?")',
            text: "@lang('admin.You are about to disable Auth App Two-Factor Authentication!')",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '@lang("admin.Yes, disable it!")',
            cancelButtonText: '@lang("admin.Cancel")'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('disable2faForm').submit();
            }
        });
    }

</script>


