<script>
    $(document).ready(function () {
        // =============================================
        // 1. إدارة حقل Class بناءً على Age Group
        // =============================================
        $('#age_group').on('change', function() {
            var ageGroupId = $(this).val();
            var classSelect = $('#class');

            // تعطيل الـ select أثناء التحميل
            classSelect.prop('disabled', true);
            classSelect.html('<option value="" disabled selected>@lang("admin.Loading")...</option>');

            if (ageGroupId) {
                $.ajax({
                    url: '{{ route("get.classes.by.age.group") }}',
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

        // =============================================
        // 2. تعريف DataTable للطلاب مع الفلاتر
        // =============================================
        var table = $("#kt_table_student").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('students.getStudents') }}",
                type: "GET",
                data: function (d) {
                    // الفلاتر الأساسية
                    d.student_id = $('#filter_student_id').val();
                    d.first_name = $('#filter_first_name').val();
                    d.last_name = $('#filter_last_name').val();
                    d.mobile = $('#filter_mobile').val();
                    d.birth_date_from = $('#filter_birth_date_from').val();
                    d.birth_date_to = $('#filter_birth_date_to').val();

                    // ✅ الفلاتر الجديدة من نموذج البحث
                    d.gender = $('#gender').val();
                    d.age_group = $('#age_group').val();
                    d.class_id = $('#class').val();
                    d.accreditation_status = $('#accreditation_status').val();

                    // فلاتر إضافية إذا وجدت
                    d.province_cd = $('#province_cd').val();
                    d.location_cities = $('#location_cities').val();
                    d.location_areas = $('#location_areas').val();
                },
                error: function (xhr, error, thrown) {
                    console.log("Error in DataTable AJAX:", error);
                    console.log("Response:", xhr.responseText);
                    Swal.fire({
                        text: 'حدث خطأ في تحميل البيانات',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            columns: [
                {
                    data: 'student_id',
                    name: 'student_id',
                    className: 'text-center'
                },
                {
                    data: 'full_name',
                    name: 'full_name',
                    className: 'text-center'
                },
                {
                    data: 'birth_date',
                    name: 'birth_date',
                    className: 'text-center'
                },
                {
                    data: 'mobile',
                    name: 'mobile',
                    className: 'text-center'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'text-end'
                }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "الكل"]],
            language: {
                "url": "{{asset('assets/Arabic.json')}}"
            },
            createdRow: function (row, data, dataIndex) {
                $(row).addClass('border-bottom');
                $('td', row).each(function (index) {
                    if (index < 4) {
                        $(this).addClass('text-center');
                    }
                });
            },
            drawCallback: function () {
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances();
                }
                if (typeof bootstrap !== 'undefined') {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                }
            },
            initComplete: function () {
                console.log("DataTable initialized successfully");
            }
        });

        // =============================================
        // 3. البحث والفلترة
        // =============================================

        // بحث سريع
        var searchTimeout;
        $('[data-kt-student-table-filter="search"]').on('keyup', function () {
            clearTimeout(searchTimeout);
            var input = this;
            searchTimeout = setTimeout(function () {
                table.search(input.value).draw();
            }, 300);
        });

        // ✅ زر البحث المتقدم - مع تطبيق جميع الفلاتر
        $('.search_btn').on('click', function() {
            // التحقق من صحة الفلاتر إذا لزم الأمر
            table.draw();
        });

        // ✅ زر إعادة تعيين الفلاتر
        $('.reset_search').on('click', function() {
            // إعادة تعيين جميع حقول الفلتر في النموذج
            $('#filters')[0].reset();

            // إعادة تعيين الـ Select2
            if ($.fn.select2) {
                $('#gender').val(null).trigger('change');
                $('#age_group').val(null).trigger('change');
                $('#class').val(null).trigger('change');
                $('#accreditation_status').val(null).trigger('change');
                $('#province_cd').val(null).trigger('change');
                $('#location_cities').val(null).trigger('change');
                $('#location_areas').val(null).trigger('change');
            }

            // ✅ إعادة تعيين حقل class و age_group
            $('#class').html('<option value="" disabled selected>@lang("admin.Select")</option>');
            $('#class').prop('disabled', true);

            // إعادة تحميل الجدول
            table.draw();
        });

        // ✅ عند تغيير أي فلتر، يتم تحديث الجدول تلقائياً (اختياري)
        $('#gender, #age_group, #class, #accreditation_status').on('change', function() {
            table.draw();
        });

        // =============================================
        // 4. وظيفة تصدير البيانات مع الفلاتر الحالية
        // =============================================
        $(document).on('click', '.export-students-btn', function() {
            var exportType = $(this).data('export-type') || 'excel';

            // ✅ جمع الفلاتر الحالية
            var filters = {
                student_id: $('#filter_student_id').val(),
                first_name: $('#filter_first_name').val(),
                last_name: $('#filter_last_name').val(),
                mobile: $('#filter_mobile').val(),
                birth_date_from: $('#filter_birth_date_from').val(),
                birth_date_to: $('#filter_birth_date_to').val(),
                gender: $('#gender').val(),
                age_group: $('#age_group').val(),
                class_id: $('#class').val(),
                accreditation_status: $('#accreditation_status').val(),
                province_cd: $('#province_cd').val(),
                location_cities: $('#location_cities').val(),
                location_areas: $('#location_areas').val()
            };

            Swal.fire({
                title: 'جاري التصدير...',
                text: 'يرجى الانتظار',
                allowOutsideClick: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("students.export") }}',
                type: 'GET',
                data: {
                    type: exportType,
                    filters: filters
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data, status, xhr) {
                    Swal.close();

                    var filename = xhr.getResponseHeader('Content-Disposition')
                        ? xhr.getResponseHeader('Content-Disposition').split('filename=')[1]
                        : 'students.' + (exportType === 'excel' ? 'xlsx' : 'pdf');

                    // إزالة علامات الاقتباس من اسم الملف
                    filename = filename.replace(/["']/g, '');

                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(link.href);
                },
                error: function(xhr) {
                    Swal.close();
                    var errorMsg = 'حدث خطأ في عملية التصدير';
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMsg = response.message;
                        }
                    } catch(e) {}

                    Swal.fire({
                        text: errorMsg,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // =============================================
        // 5. باقي الوظائف (عرض، تعديل، حذف)
        // =============================================
        $(document).on('click', '.view.blade.php-student-btn', function(e) {
            e.preventDefault();
            var studentId = $(this).data('student-id');
            // ... كود العرض
        });

        $(document).on('click', '.delete-student-btn', function(e) {
            e.preventDefault();
            var studentId = $(this).data('student-id');
            var studentName = $(this).data('student-name') || '';

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف الطالب " + studentName + " بشكل نهائي!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/students/delete/' + studentId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                text: response.message || 'تم حذف الطالب بنجاح',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            var errorMsg = 'حدث خطأ في عملية الحذف';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                text: errorMsg,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        // =============================================
        // 6. تحديث الجدول تلقائياً (اختياري)
        // =============================================
        // تحديث الجدول كل 5 دقائق
        setInterval(function() {
            table.ajax.reload(null, false);
        }, 300000);

        console.log("Student DataTable script loaded successfully");
    });
</script>
