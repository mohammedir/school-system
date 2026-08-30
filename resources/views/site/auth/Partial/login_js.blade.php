<script>
    $(function () {
        const $form = $('#sign_in_form');
        const $btn = $('#sign_in_submit');

        $form.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "{{ __('investors.email_required') }}",
                    email: "{{ __('investors.email_invalid') }}"
                },
                password: {
                    required: "{{ __('investors.password_required') }}"
                }
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form, e) {
                e.preventDefault();

                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function (xhr) {
                        let msg = "{{ __('investors.login_error') }}";
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            msg = '';
                            $.each(xhr.responseJSON.errors, function (key, val) {
                                msg += val[0] + '<br>';
                            });
                        }
                        Swal.fire({
                            html: msg,
                            icon: 'error',
                            confirmButtonText: "{{ __('investors.ok') }}"
                        });
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html("{{ __('investors.sign_in') }} <i class='fal fa-arrow-right-long'></i>");
                    }
                });
            }
        });
    });
</script>
