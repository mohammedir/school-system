@extends('admin.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Add Student')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Student management')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.View Student')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Add Student')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Container-->
    <div id="kt_content_container_land" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <form method="post" action="{{ route('students.store') }}" class="form" id="kt_add_student" enctype="multipart/form-data">
                @csrf
                <!--begin::Card - Student Details-->
                <div class="card card-flush mt-5">
                    <div class="card-header pt-8">
                        <h5>@lang('admin.Student data')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 mb-15">
                            <div class="col-md-2 fv-row">
                                <label class="form-label">@lang('admin.Student Photo')</label>
                                {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                <!--begin::Image placeholder-->
                                <style>.image-input-placeholder {
                                        background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}");
                                    }

                                    [data-bs-theme="dark"] .image-input-placeholder {
                                        background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                    }</style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline image-input-placeholder"
                                     data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-400px h-300px"
                                         style="background-image: url({{asset('assets/media/logos/logo_icon.png')}});"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="@lang('admin.Change avatar')">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="student_avatar" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="student_avatar_remove"/>
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="@lang('admin.Remove avatar')">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                            </div>
                            <small class="text-muted">الحد الأدنى للأبعاد: 300 × 400 بكسل</small>
                        </div>
                        <div class="row g-4 mb-15">
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Student ID Number')</label>
                                <input class="form-control" name="student_id" id="student_id"
                                       placeholder="@lang('admin.Student ID Number')" maxlength="9">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Student Name')</label>
                                <input class="form-control" name="first_name" id="first_name"
                                       placeholder="@lang('admin.Student Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Father Name')</label>
                                <input class="form-control" name="father_name" id="father_name"
                                       placeholder="@lang('admin.Father Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Grandfather Name')</label>
                                <input class="form-control" name="grandfather_name" id="grandfather_name"
                                       placeholder="@lang('admin.Grandfather Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.last Name')</label>
                                <input class="form-control" name="last_name" id="last_name"
                                       placeholder="@lang('admin.last Name')">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">العنوان</label>
                                <input class="form-control" name="address" id="address"
                                       placeholder="ادخل العنوان">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Gender')</label>
                                <select class="form-select" name="gender" id="gender" data-control="select2"
                                        data-placeholder="@lang('admin.Select')">
                                    <option value="" disabled selected>@lang('admin.Select')</option>
                                    <option value="male">@lang('admin.male')</option>
                                    <option value="female">@lang('admin.female')</option>
                                </select>
                            </div>
                            <!-- تاريخ الميلاد -->
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Birth Date')</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date"
                                       placeholder="@lang('admin.Select birth date')">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Age Group')</label>
                                <select class="form-select" name="age_group" id="age_group" data-control="select2"
                                        data-placeholder="@lang('admin.Select')">
                                    <option value="" disabled selected>@lang('admin.Select')</option>
                                    @foreach(get_lookup_by_master_key('age_group') as $age_group)
                                        <option value="{{$age_group->id}}">{{$age_group->name_ar}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label required">@lang('admin.Class')</label>
                                <select class="form-select" name="class" id="class" data-control="select2"
                                        data-placeholder="@lang('admin.Select')">
                                    <option value="" disabled selected>@lang('admin.Select')</option>
                                    <!-- سيتم ملؤها بواسطة Ajax -->
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">

                            <!-- الحالة الصحية -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Health Status')</label>
                                <select class="form-select" name="health_status" id="health_status" data-control="select2"
                                        data-placeholder="@lang('admin.Select health status')">
                                    <option value="" disabled selected>@lang('admin.Select health status')</option>
                                    <option value="healthy">@lang('admin.Healthy')</option>
                                    <option value="special_needs">@lang('admin.Special Needs')</option>
                                    <option value="chronic_disease">@lang('admin.Chronic Disease')</option>
                                </select>
                            </div>
                            <!-- حقل وصف الحالة الصحية (يظهر فقط عند اختيار special_needs أو chronic_disease) -->
                            <div class="col-md-3" id="health_status_description_container" style="display: none;">
                                <label class="form-label required">@lang('admin.Health Status Description')</label>
                                <textarea class="form-control" name="health_status_description" id="health_status_description"
                                          rows="2" placeholder="@lang('admin.Enter health status description')"></textarea>
                            </div>
                            <!-- حالة اليتم -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.orphan status')</label>
                                <select class="form-select" name="orphan_status" id="orphan_status" data-control="select2"
                                        data-placeholder="@lang('admin.Select orphan status')">
                                    <option value="" disabled selected>@lang('admin.Select orphan status')</option>
                                    <option value="not_an_orphan">@lang('admin.Not an orphan')</option>
                                    <option value="father_is_an_orphan">@lang('admin.Father is an orphan')</option>
                                    <option value="mother_is_an_orphan">@lang('admin.Mother is an orphan')</option>
                                    <option value="both_mother_and_father_are_orphans">@lang('admin.Both mother and father are orphans')</option>
                                </select>
                            </div>
                            <!-- حالة المواطنة -->
                            <div class="col-md-3">
                                <label class="form-label required">حالة المواطنة</label>
                                <select class="form-select" name="citizenship_status" id="citizenship_status" data-control="select2"
                                        data-placeholder="اختر حالة المواطنة">
                                    <option value="" disabled selected>اختر حالة المواطنة</option>
                                    <option value="citizen">مواطن</option>
                                    <option value="refugee">لاجيء</option>
                                </select>
                            </div>


                            <!-- هوية ولي الامر -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Parent ID Number')</label>
                                <input class="form-control" id="parent_id" name="parent_id" type="text"
                                       maxlength="9" data-rule-minlength="9"
                                       placeholder="@lang('admin.Enter parent ID number')">
                            </div>

                            <!-- اسم ولي الامر -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Parent Name')</label>
                                <input class="form-control" id="parent_name" name="parent_name" type="text"
                                       placeholder="@lang('admin.Enter parent full name')">
                            </div>

                            <!-- رقم التواصل -->
                            <div class="col-md-3">
                                <label class="form-label required">@lang('admin.Contact number')</label>
                                <input class="form-control" id="mobile" name="mobile" type="text"
                                       maxlength="10" data-rule-minlength="10"
                                       placeholder="@lang('admin.Enter Mobile number')">
                            </div>

                            <!-- رقم التواصل بديل -->
                            <div class="col-md-3">
                                <label class="form-label">@lang('admin.Alternative contact number')</label>
                                <input class="form-control" id="alternate_mobile" name="alternate_mobile" type="text"
                                       maxlength="10"
                                       placeholder="@lang('admin.Enter Mobile number')">
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->
                <!--end::Card-->
                <div class="card-footer">
                    <!--begin::Actions-->
                    <div class="row mt-5">
                        <div class="col-md-9 offset-md-3 text-end">
                            <button id="submit" type="submit" class="btn btn-info btn-outline me-5"
                                    data-kt-investors-action="submit">
                                <span class="indicator-label"><i
                                        class="bi bi-floppy2-fill"></i> @lang('admin.Submit')</span>
                                <span class="indicator-progress">@lang('admin.Please wait...')<span
                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="button" class="btn btn-secondary btn-outline me-10"
                                    data-kt-lands-action="cancel"><i class="bi bi-x-circle"></i> @lang('admin.Discard')
                            </button>
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
            </form>


        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
        <style>
            #preview_images {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 15px;
            }

            .position-relative {
                position: relative;
            }

            /* تنسيق رسائل الأخطاء */
            .error-message {
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }

            .is-invalid {
                border-color: #dc3545 !important;
            }

            .is-valid {
                border-color: #198754 !important;
            }

            .alert-error-list {
                max-height: 300px;
                overflow-y: auto;
            }

            .alert-error-list .list-group-item {
                border-left: 3px solid #dc3545;
                margin-bottom: 5px;
                background-color: #f8f9fa;
            }

            .alert-error-list .list-group-item:last-child {
                margin-bottom: 0;
            }
        </style>

        <script>
            $(document).ready(function () {
                // =============================================
                // معالجة إرسال النموذج عبر AJAX
                // =============================================
                $('#kt_add_student').on('submit', function(e) {
                    e.preventDefault();

                    var form = $(this);
                    var submitBtn = form.find('#submit');
                    var formData = new FormData(this);

                    // تعطيل الزر وإظهار مؤشر التحميل
                    submitBtn.prop('disabled', true);
                    submitBtn.find('.indicator-label').hide();
                    submitBtn.find('.indicator-progress').show();

                    // إزالة الأخطاء السابقة
                    clearErrors();

                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                // عرض رسالة نجاح
                                Swal.fire({
                                    icon: 'success',
                                    title: '{{ __("admin.Success") }}',
                                    text: response.message,
                                    confirmButtonText: '{{ __("admin.OK") }}',
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                }).then(function() {
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    } else {
                                        form[0].reset();
                                        location.reload();
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                // أخطاء التحقق
                                var errors = xhr.responseJSON.errors;
                                var errorMessages = [];

                                // تجميع رسائل الأخطاء
                                $.each(errors, function(field, messages) {
                                    $.each(messages, function(index, message) {
                                        errorMessages.push(message);
                                        // عرض الخطأ بجانب الحقل
                                        showFieldError(field, message);
                                    });
                                });

                                // عرض الأخطاء في SweetAlert
                                showErrorModal(errorMessages);

                            } else if (xhr.status === 500) {
                                // خطأ في السيرفر
                                var errorMessage = xhr.responseJSON?.message || '{{ __("admin.Something went wrong") }}';
                                showErrorModal([errorMessage]);

                            } else {
                                // أخطاء أخرى
                                var errorMessage = xhr.responseJSON?.message || '{{ __("admin.An error occurred") }}';
                                showErrorModal([errorMessage]);
                            }
                        },
                        complete: function() {
                            // إعادة تفعيل الزر
                            submitBtn.prop('disabled', false);
                            submitBtn.find('.indicator-label').show();
                            submitBtn.find('.indicator-progress').hide();
                        }
                    });
                });

                // =============================================
                // دوال عرض وإخفاء الأخطاء
                // =============================================

                // عرض خطأ بجانب الحقل
                function showFieldError(field, message) {
                    var element = $('[name="' + field + '"]');

                    if (element.length) {
                        // إضافة الكلاس is-invalid
                        element.addClass('is-invalid');

                        // إزالة أي رسالة خطأ سابقة
                        element.siblings('.error-message').remove();

                        // إضافة رسالة الخطأ
                        element.after('<div class="error-message">' + message + '</div>');

                        // إذا كان الحقل من نوع Select2
                        if (element.hasClass('select2-hidden-accessible')) {
                            element.closest('.select2-container').after('<div class="error-message">' + message + '</div>');
                        }
                    }
                }

                // مسح جميع الأخطاء
                function clearErrors() {
                    $('.error-message').remove();
                    $('.is-invalid').removeClass('is-invalid');
                    $('.is-valid').removeClass('is-valid');

                    // إزالة الأخطاء من Select2
                    $('.select2-container').siblings('.error-message').remove();
                }

                // عرض مودال الأخطاء بشكل جميل
                function showErrorModal(errors) {
                    var errorList = '';

                    if (Array.isArray(errors)) {
                        $.each(errors, function(index, message) {
                            errorList += '<li class="list-group-item">' +
                                '<i class="fas fa-exclamation-circle text-danger me-2"></i> ' +
                                message +
                                '</li>';
                        });
                    } else {
                        errorList = '<li class="list-group-item">' +
                            '<i class="fas fa-exclamation-circle text-danger me-2"></i> ' +
                            errors +
                            '</li>';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: '{{ __("admin.Validation Error") }}',
                        html: '<div class="alert-error-list">' +
                            '<ul class="list-group">' + errorList + '</ul>' +
                            '</div>',
                        confirmButtonText: '{{ __("admin.OK") }}',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        },
                        width: 500
                    });
                }

                // =============================================
                // إزالة الأخطاء عند التعديل على الحقول
                // =============================================
                $(document).on('change keyup', '.form-control, .form-select', function() {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.error-message').remove();
                    $(this).closest('.select2-container').siblings('.error-message').remove();
                });

                // =============================================
                // التعليمات البرمجية الأخرى الموجودة
                // =============================================

                // ... (ضع هنا الكود السابق مع تعديل دوال البحث)
                // ... ولكن قم بتعديل دوال البحث لتكون متوافقة مع الإضافة الجديدة

                // تعديل دالة searchStudentData لتكون متوافقة
                function searchStudentData(studentId) {
                    $('#student_id_help_text').text('{{ __("admin.Searching...") }}').css('color', '#0d6efd');
                    $('#student_id').prop('disabled', true);

                    $.ajax({
                        url: "{{ url('/students/search-by-id') }}/" + studentId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#student_id').prop('disabled', false);

                            if (response.status === 'found') {
                                var data = response.data;
                                $('#student_id_help_text')
                                    .text('{{ __("admin.Student found! Auto-filling data...") }}')
                                    .css('color', '#28a745');

                                fillStudentFields(data);

                                Swal.fire({
                                    icon: 'success',
                                    text: "{{ __('admin.Student data found! Fields have been auto-filled.') }}",
                                    confirmButtonText: "{{ __('admin.OK') }}",
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    }
                                });

                            } else if (response.status === 'not_found') {
                                $('#student_id_help_text')
                                    .text('{{ __("admin.Student not found. Please fill data manually.") }}')
                                    .css('color', '#dc3545');

                                clearStudentFields();

                                Swal.fire({
                                    icon: 'warning',
                                    text: "{{ __('admin.Student not found in database. Please fill data manually.') }}",
                                    confirmButtonText: "{{ __('admin.OK') }}",
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        confirmButton: "btn btn-warning"
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#student_id').prop('disabled', false);
                            var errorMsg = "{{ __('admin.Error searching for student') }}";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }

                            $('#student_id_help_text')
                                .text(errorMsg)
                                .css('color', '#dc3545');

                            Swal.fire({
                                icon: 'error',
                                text: errorMsg,
                                confirmButtonText: "{{ __('admin.OK') }}",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                }
                            });
                        }
                    });
                }

                // دوال مساعدة
                function fillStudentFields(data) {
                    // تعبئة الحقول
                    $('#first_name').val(data.first_name || '').trigger('change');
                    $('#father_name').val(data.father_name || '').trigger('change');
                    $('#grandfather_name').val(data.grandfather_name || '').trigger('change');
                    $('#last_name').val(data.last_name || '').trigger('change');

                    if (data.gender) {
                        $('#gender').val(data.gender).trigger('change');
                    }

                    if (data.birth_date) {
                        $('#birth_date').val(data.birth_date);
                    }

                    if (data.health_status) {
                        $('#health_status').val(data.health_status).trigger('change');
                    }

                    $('#parent_id').val(data.parent_id || '').trigger('change');
                    $('#parent_name').val(data.parent_name || '').trigger('change');
                    $('#mobile').val(data.mobile || '').trigger('change');
                    $('#alternate_mobile').val(data.alternate_mobile || '').trigger('change');

                    if (data.address) {
                        $('#address').val(data.address).trigger('change');
                    }

                    if (data.notes) {
                        $('#notes').val(data.notes).trigger('change');
                    }

                    // إضافة تأثير بصري للحقول المعبأة
                    $('.form-control, .form-select').each(function() {
                        if ($(this).val()) {
                            $(this).addClass('is-valid');
                        }
                    });

                    // إزالة أي رسائل خطأ سابقة
                    clearErrors();
                }

                function clearStudentFields() {
                    $('#first_name').val('').trigger('change');
                    $('#father_name').val('').trigger('change');
                    $('#grandfather_name').val('').trigger('change');
                    $('#last_name').val('').trigger('change');

                    if ($.fn.select2) {
                        $('#gender').val(null).trigger('change');
                        $('#health_status').val(null).trigger('change');
                    }

                    $('#birth_date').val('');
                    $('#parent_id').val('').trigger('change');
                    $('#parent_name').val('').trigger('change');
                    $('#mobile').val('').trigger('change');
                    $('#alternate_mobile').val('').trigger('change');
                    $('#address').val('').trigger('change');
                    $('#notes').val('').trigger('change');

                    // إزالة التأثيرات البصرية
                    $('.form-control, .form-select').removeClass('is-valid is-invalid');
                    clearErrors();
                }

                // ... باقي الكود الموجود
            });
        </script>


    @include("admin.Students.Partial.addStudent_js")

@endsection

