<script>
    $(function () {
        const $form = $('#register_form');
        const $btn = $('#register_submit');

        $form.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                full_name: {
                    required: true,
                 },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: '[name="password"]'
                }
            },
            messages: {
                email: {
                    required: "{{ __('investors.email_required') }}",
                    email: "{{ __('investors.email_invalid') }}"
                },
                full_name: {
                    required: "{{ __('investors.email_full_name') }}",
                 },
                password: {
                    required: "{{ __('investors.password_required') }}",
                    minlength: "{{ __('investors.password_minlength') }}"
                },
                password_confirmation: {
                    required: "{{ __('investors.password_confirmation_required') }}",
                    equalTo: "{{ __('investors.password_confirmation_match') }}"
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
                        let msg = "{{ __('investors.register_error') }}";
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
                        $btn.prop('disabled', false).html('{{ __("investors.register") }} <i class="fal fa-arrow-right-long"></i>');
                    }
                });
            }
        });
    });
</script>
