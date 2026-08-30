<script>
    $(document).ready(function () {

            $('#age_group').on('change', function() {
                var ageGroupId = $(this).val();
                var classSelect = $('#class');

                // تعطيل الـ select أثناء التحميل
                classSelect.prop('disabled', true);
                classSelect.html('<option value="" disabled selected>@lang("admin.Loading")...</option>');

                if (ageGroupId) {
                    $.ajax({
                        url: '{{ route("get.classes.by.age.group") }}', // أنشئ هذا الـ route
                        type: 'GET',
                        data: {
                            age_group_id: ageGroupId
                        },
                        success: function(response) {
                            classSelect.prop('disabled', false);
                            classSelect.html('<option value="" disabled selected>@lang("admin.Select")</option>');

                            if (response.data && response.data.length > 0) {
                                $.each(response.data, function(key, value) {
                                    classSelect.append('<option value="' + value.id + '">' + value.name_ar + '</option>');
                                });
                            } else {
                                classSelect.append('<option value="" disabled>@lang("admin.No classes found")</option>');
                            }

                            // تحديث Select2
                            classSelect.trigger('change');
                        },
                        error: function(xhr) {
                            classSelect.prop('disabled', false);
                            classSelect.html('<option value="" disabled selected>@lang("admin.Error loading data")</option>');
                            classSelect.trigger('change');
                        }
                    });
                } else {
                    classSelect.prop('disabled', false);
                    classSelect.html('<option value="" disabled selected>@lang("admin.Select")</option>');
                    classSelect.trigger('change');
                }
            });

        // التحكم في إظهار/إخفاء حقل وصف الحالة الصحية
        function toggleHealthStatusDescription() {
            var healthStatus = $('#health_status').val();
            if (healthStatus === 'special_needs' || healthStatus === 'chronic_disease') {
                $('#health_status_description_container').show('slow');
                $('#health_status_description').prop('required', true);
            } else {
                $('#health_status_description_container').hide('slow');
                $('#health_status_description').prop('required', false);
                $('#health_status_description').val(''); // مسح القيمة عند الإخفاء
            }
        }

        // استدعاء الدالة عند تغيير قيمة الحقل
        $('#health_status').on('change', function() {
            toggleHealthStatusDescription();
        });

        // استدعاء الدالة عند تحميل الصفحة للتأكد من الحالة الابتدائية
        toggleHealthStatusDescription();

        // =============================================
        // 1. دوال تغيير المحافظات والمدن (إن وجدت)
        // =============================================
        $(document).on("change", "select.location_province", function () {
            var province_id = $(this).val();
            var this_city = $("#location_cities");
            var this_area = $("#location_areas");
            var cities_block = document.querySelector("#cities_block");

            if (!cities_block) {
                console.error("#cities_block not found");
                return;
            }

            var blockUI = KTBlockUI.getInstance(cities_block) ?? new KTBlockUI(cities_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-info"></span> @lang("engineering.Please wait")...</div>',
            });

            if (province_id !== '') {
                blockUI.block();
                this_city.empty();
                this_area.empty();

                $.ajax({
                    method: "POST",
                    url: '{{url("/")}}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: province_id, '_token': '{{csrf_token()}}' },
                    success: function (data) {
                        this_city.append(data.children);
                    },
                    complete: function () {
                        blockUI.release();
                    },
                    error: function () {
                        blockUI.release();
                    }
                });
            } else {
                blockUI.release();
            }
        });

        $(document).on("change", "select.location_city", function () {
            var city_id = $(this).val();
            var this_area = $("#location_areas");
            var areas_block = document.querySelector("#areas_block");

            if (!areas_block) {
                console.error("#areas_block not found");
                return;
            }

            var blockUI = KTBlockUI.getInstance(areas_block) ?? new KTBlockUI(areas_block, {
                message: '<div class="blockui-message"><span class="spinner-border text-info"></span> @lang("engineering.Please wait")...</div>',
            });

            if (city_id !== '') {
                blockUI.block();
                this_area.empty();

                $.ajax({
                    method: "POST",
                    url: '{{url("/")}}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: city_id, '_token': '{{csrf_token()}}' },
                    success: function (data) {
                        this_area.append(data.children);
                    },
                    complete: function () {
                        blockUI.release();
                    },
                    error: function () {
                        blockUI.release();
                    }
                });
            } else {
                blockUI.release();
            }
        });

        // =============================================
        // 2. تهيئة Select2
        // =============================================
        if ($.fn.select2) {
            $('select[data-control="select2"]').select2({
                placeholder: "{{ __('admin.Select') }}",
                allowClear: true,
                language: "{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}"
            });
        }

        // =============================================
        // 3. وظيفة البحث التلقائي عن رقم الهوية
        // =============================================
        var searchTimeout = null;

        $('#student_id').on('input', function() {
            var studentId = $(this).val().trim();

            // مسح الـ timeout السابق
            clearTimeout(searchTimeout);

            // التحقق من أن رقم الهوية مكون من 9 أرقام
            if (studentId.length === 9 && /^[0-9]+$/.test(studentId)) {
                // تأخير البحث لمدة 500 مللي ثانية لتجنب الطلبات المتكررة
                searchTimeout = setTimeout(function() {
                    searchStudentData(studentId);
                }, 500);
            } else {
                // إذا كان الرقم غير مكتمل أو غير صحيح، إعادة تعيين الحقول
                if (studentId.length > 0 && studentId.length < 9) {
                    // عرض رسالة للمستخدم
                    $('#student_id_help_text').text('{{ __("admin.Please enter complete 9-digit ID") }}').css('color', '#ffc107');
                } else {
                    $('#student_id_help_text').text('');
                }
            }
        });

        // دالة البحث عن بيانات الطالب
        function searchStudentData(studentId) {
            // إظهار مؤشر التحميل
            $('#student_id_help_text').text('{{ __("admin.Searching...") }}').css('color', '#0d6efd');

            // تعطيل حقل رقم الهوية أثناء البحث
            $('#student_id').prop('disabled', true);

            $.ajax({
                url: "{{ url('/students/search-by-id') }}/" + studentId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // إعادة تفعيل حقل رقم الهوية
                    $('#student_id').prop('disabled', false);

                    if (response.status === 'found') {
                        var data = response.data;

                        // عرض رسالة نجاح
                        $('#student_id_help_text')
                            .text('{{ __("admin.Student found! Auto-filling data...") }}')
                            .css('color', '#28a745')
                            .fadeIn();

                        // ملء الحقول تلقائياً
                        fillStudentFields(data);

                        // عرض رسالة نجاح إضافية
                        Swal.fire({
                            text: "{{ __('admin.Student data found! Fields have been auto-filled.') }}",
                            icon: "success",
                            confirmButtonText: "{{ __('admin.OK') }}",
                            timer: 3000,
                            timerProgressBar: true,
                            customClass: {
                                confirmButton: "btn btn-success"
                            }
                        });

                    } else if (response.status === 'not_found') {
                        // الطالب غير موجود
                        $('#student_id_help_text')
                            .text('{{ __("admin.Student not found. Please fill data manually.") }}')
                            .css('color', '#dc3545');

                        // إعادة تعيين الحقول إذا كانت ممتلئة سابقاً
                        clearStudentFields();

                        // عرض رسالة تحذيرية
                        Swal.fire({
                            text: "{{ __('admin.Student not found in database. Please fill data manually.') }}",
                            icon: "warning",
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
                    // إعادة تفعيل حقل رقم الهوية
                    $('#student_id').prop('disabled', false);

                    var errorMsg = "{{ __('admin.Error searching for student') }}";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    $('#student_id_help_text')
                        .text(errorMsg)
                        .css('color', '#dc3545');

                    Swal.fire({
                        text: errorMsg,
                        icon: "error",
                        confirmButtonText: "{{ __('admin.OK') }}",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }
            });
        }

        // دالة ملء الحقول بالبيانات
        function fillStudentFields(data) {
            // تعيين القيم في الحقول
            $('#first_name').val(data.first_name || '').trigger('change');
            $('#father_name').val(data.father_name || '').trigger('change');
            $('#grandfather_name').val(data.grandfather_name || '').trigger('change');
            $('#last_name').val(data.last_name || '').trigger('change');

            // تعيين الجنس (Select2)
            if (data.gender) {
                $('#gender').val(data.gender).trigger('change');
            }

            // تعيين تاريخ الميلاد
            if (data.birth_date) {
                $('#birth_date').val(data.birth_date);
            }

            // تعيين الحالة الصحية (Select2)
            if (data.health_status) {
                $('#health_status').val(data.health_status).trigger('change');
            }

            // تعيين بيانات ولي الامر
            $('#parent_id').val(data.parent_id || '').trigger('change');
            $('#parent_name').val(data.parent_name || '').trigger('change');

            // تعيين أرقام الهواتف
            $('#mobile').val(data.mobile || '').trigger('change');
            $('#alternate_mobile').val(data.alternate_mobile || '').trigger('change');

            // تعيين العنوان (إذا وجد)
            if (data.address) {
                $('#address').val(data.address).trigger('change');
            }

            // تعيين الملاحظات (إذا وجدت)
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
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
        }

        // دالة إعادة تعيين الحقول
        function clearStudentFields() {
            // إعادة تعيين الحقول التي تم تعبئتها تلقائياً
            $('#first_name').val('').trigger('change');
            $('#father_name').val('').trigger('change');
            $('#grandfather_name').val('').trigger('change');
            $('#last_name').val('').trigger('change');

            // إعادة تعيين Select2
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
            $('.invalid-feedback').remove();
        }


        // زر البحث
        $('.search_btn').on('click', function() {
            if (typeof table !== 'undefined') {
                table.ajax.reload();
            }
        });

        // زر إعادة تعيين الفلاتر
        $('.reset_search').on('click', function() {
            $('#filter_student_id').val('');
            $('#filter_first_name').val('');
            $('#filter_last_name').val('');
            $('#filter_mobile').val('');
            $('#filter_full_name').val('');
            if (typeof table !== 'undefined') {
                table.ajax.reload();
            }
        });

        // =============================================
        // 8. معالجة حذف الطالب
        // =============================================
        $(document).on('click', '.delete-student-btn', function(e) {
            e.preventDefault();
            var studentId = $(this).data('student-id');

            Swal.fire({
                text: "{{ __('admin.Are you sure you want to delete this student?') }}",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "{{ __('admin.Yes, delete it!') }}",
                cancelButtonText: "{{ __('admin.No, cancel') }}",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/students/delete') }}/" + studentId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    text: response.message || "{{ __('admin.Student deleted successfully!') }}",
                                    icon: "success",
                                    confirmButtonText: "{{ __('admin.OK') }}",
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    }
                                }).then(function() {
                                    if (typeof table !== 'undefined') {
                                        table.ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    text: response.message || "{{ __('admin.Something went wrong.') }}",
                                    icon: "error",
                                    confirmButtonText: "{{ __('admin.OK') }}",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            var errorMsg = "{{ __('admin.Unexpected error occurred') }}";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                text: errorMsg,
                                icon: "error",
                                confirmButtonText: "{{ __('admin.OK') }}",
                                customClass: {
                                    confirmButton: "btn btn-danger"
                                }
                            });
                        }
                    });
                }
            });
        });

        console.log("Student Management Script Loaded Successfully");
    });
</script>
