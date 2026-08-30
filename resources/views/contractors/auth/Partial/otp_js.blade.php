<script>
    "use strict";

    var KTSigninTwoFactor = function() {
        var form;
        var submitButton;

        var handleForm = function() {
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();

                var inputs = [].slice.call(form.querySelectorAll('input[maxlength="1"]'));
                var validated = inputs.every(input => input.value.trim() !== '');

                if (!validated) {
                    Swal.fire({
                        text: "@lang('admin.Please enter the complete 6 digit security code.')",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.OK')",
                        customClass: {
                            confirmButton: "btn btn-light-primary fw-bold"
                        }
                    });
                    return;
                }

                var otpCode = inputs.map(input => input.value).join('');

                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        otp_code: otpCode
                    })
                })
                    .then(response => {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;

                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            text: data.message || "@lang('admin.You have been successfully verified!')",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-primary fw-bold"
                            }
                        }).then(() => {
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                inputs.forEach(input => input.value = '');
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            text: error.message || "@lang('admin.Verification failed, please try again.')",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-light-primary fw-bold"
                            }
                        });
                    });
            });
        };

        var handleType = function() {
            var inputs = [
                form.querySelector("[name=code_1]"),
                form.querySelector("[name=code_2]"),
                form.querySelector("[name=code_3]"),
                form.querySelector("[name=code_4]"),
                form.querySelector("[name=code_5]"),
                form.querySelector("[name=code_6]")
            ];

            if (inputs[0]) inputs[0].focus();

            // ✅ دعم لصق الكود
            inputs[0].addEventListener("paste", function(e) {
                e.preventDefault();
                var paste = (e.clipboardData || window.clipboardData).getData('text');
                var digits = paste.replace(/\D/g, '').slice(0, 6).split('');

                // تفريغ الخانات قبل التوزيع
                inputs.forEach(input => input.value = '');

                digits.forEach((digit, index) => {
                    if (inputs[index]) {
                        inputs[index].value = digit;
                    }
                });

                if (inputs[digits.length - 1]) {
                    inputs[digits.length - 1].focus();
                }
            });

            inputs.forEach((input, index) => {
                input.addEventListener("input", function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 1); // تأكد من إدخال رقم واحد فقط

                    if (this.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                input.addEventListener("keyup", function(e) {
                    if (e.key === "Backspace" && this.value === "" && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        };

        return {
            init: function() {
                form = document.querySelector('#kt_sing_in_two_factor_form');
                submitButton = document.querySelector('#kt_sing_in_two_factor_submit');

                if (!form || !submitButton) {
                    console.warn('Form or submit button not found!');
                    return;
                }

                handleForm();
                handleType();
            }
        };
    }();

    document.addEventListener('DOMContentLoaded', function() {
        KTSigninTwoFactor.init();
    });

</script>
