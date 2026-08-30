<script>
    var KTUsersEditUser = function() {
        // Shared variables
        const element = document.getElementById('kt_modal_update_details');
        const form = element.querySelector('#kt_modal_update_user_form');
        const user_id = element.querySelector('#edit_user_id')
        const modal = new bootstrap.Modal(element);

        // Init add schedule modal
        var initAddUser = () => {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'user_name': {
                            validators: {
                                notEmpty: {
                                    message: '@lang('admin.Full Name Filed is required')'
                                }
                            }
                        },
                        'user_email': {
                            validators: {
                                notEmpty: {
                                    message: '@lang('admin.Email address is required')'
                                },
                                regexp: {
                                    regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                    message: '@lang('admin.Invalid email address')',
                                }
                            }
                        },
                        'mobile_number': {
                            validators: {
                                notEmpty: {
                                    message: '@lang('admin.Mobile number  is required')'
                                },
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
            const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
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
                                const formData = new FormData(
                                form); // Handles file uploads too
                                const user_Id = user_id
                                .value; // Get role_id from the hidden input
                                const url =
                                    `{{ url('/') }}/users/update/${user_Id}`; // Build the correct URL
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
                                            Swal.fire({
                                                text: "@lang('admin.Form has been successfully submitted!')",
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

                                                }
                                            });
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

            // Cancel button handler
            const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
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
                        confirmButton: "btn btn-info",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.value) {
                        form.reset(); // Reset form
                        modal.hide();
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "@lang('admin.Your form has not been cancelled!.')",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('OK')",
                            customClass: {
                                confirmButton: "btn btn-info",
                            }
                        });
                    }
                });
            });

            // Close button handler
            const closeButton = element.querySelector('[data-kt-users-modal-action="close"]');
            closeButton.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "@lang('admin.Are you sure you would like to cancel?')",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "@lang('admin.Yes, cancel it!')",
                    cancelButtonText: "@lang('admin.No, return')",
                    customClass: {
                        confirmButton: "btn btn-info",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.value) {
                        form.reset(); // Reset form
                        modal.hide();
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "@lang('admin.Your form has not been cancelled!.')",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-info",
                            }
                        });
                    }
                });
            });
        }

        return {
            // Public functions
            init: function() {
                initAddUser();
            }
        };
    }();

    var KTUsersAddAuthApp = function () {
        // Shared variables
        const element = document.getElementById('enable_auth_app_modal');
        const form = element.querySelector('#enable_auth_app_modal_form');
        const user_id = element.querySelector('#user_id')
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
                                const formData = new FormData(
                                form); // Handles file uploads too
                                const user_Id = user_id
                                .value; // Get role_id from the hidden input
                                const url =
                                    `{{ url('/') }}/users/enableAuthapp/${user_Id}`; // Build the correct URL
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

            // Close button handler
            const cancelButton = element.querySelector('[data-kt-add-auth-app-modal-action="cancel"]');
            cancelButton.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "Are you sure you would like to close?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, close it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.value) {
                        modal.hide(); // Hide modal				
                    } 
                });
            });

            // Close button handler
            const closeButton = element.querySelector('[data-kt-add-auth-app-modal-action="close"]');
            closeButton.addEventListener('click', e => {
                e.preventDefault();

                Swal.fire({
                    text: "@lang('admin.Are you sure you would like to cancel?')",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "@lang('admin.Yes, cancel it!')",
                    cancelButtonText: "@lang('admin.No, return')",
                    customClass: {
                        confirmButton: "btn btn-info",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.value) {
                        form.reset(); // Reset form
                        modal.hide();
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "@lang('admin.Your form has not been cancelled!.')",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-info",
                            }
                        });
                    }
                });
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
    KTUtil.onDOMContentLoaded(function() {
        KTUsersEditUser.init();
        KTUsersAddAuthApp.init();
    });
</script>
