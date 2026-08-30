<script>
    $(document).ready(function () {
        // متغير لتخزين بيانات المدرس المختار
        let selectedTeacher = {
            id: null,
            name: null,
            currentStatus: null
        };
    // تعريف المسارات كمتغيرات JavaScript
        const routes = {
            changeStatus: "{{ route('admin.teachers.change-status', ':id') }}",
            activateTeacher: "{{ route('admin.teachers.activate', ':id') }}"
        };
        // 1. تفعيل المدرس مباشرة (للحالة pending)
        $(document).on('click', '.activate-teacher-btn', function(e) {
            e.preventDefault();

            const teacherId = $(this).data('teacher-id');
            const teacherName = $(this).data('teacher-name');

            if (confirm(`هل أنت متأكد من تفعيل حساب المدرس "${teacherName}"؟`)) {
                $.ajax({
                    url: routes.activateTeacher.replace(':id', teacherId),
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // إعادة تحميل الـ DataTable
                            $('#teachers-table').DataTable().ajax.reload();

                            // عرض رسالة نجاح
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message);
                            } else {
                                alert(response.message);
                            }
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'حدث خطأ أثناء تفعيل الحساب';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        if (typeof toastr !== 'undefined') {
                            toastr.error(errorMessage);
                        } else {
                            alert(errorMessage);
                        }
                    }
                });
            }
        });

        // 2. فتح مودال تغيير الحالة
        $(document).on('click', '.change-status-btn', function(e) {
            e.preventDefault();

            // تخزين بيانات المدرس
            selectedTeacher.id = $(this).data('teacher-id');
            selectedTeacher.name = $(this).data('teacher-name');
            selectedTeacher.currentStatus = $(this).data('current-status');

            // عرض اسم المدرس
            $('#teacherNameDisplay').text(selectedTeacher.name);

            // عرض الحالة الحالية
            const statusNames = {
                'active': 'مفعل',
                'inactive': 'غير مفعل',
                'suspended': 'موقوف'
            };

            const statusColors = {
                'active': 'badge-success',
                'inactive': 'badge-secondary',
                'suspended': 'badge-danger'
            };

            const currentStatusText = statusNames[selectedTeacher.currentStatus] || selectedTeacher.currentStatus;
            const currentStatusColor = statusColors[selectedTeacher.currentStatus] || 'badge-light';

            $('#currentStatusBadge')
                .text(currentStatusText)
                .removeClass('badge-success badge-secondary badge-danger badge-light')
                .addClass(currentStatusColor);

            // إعادة تعيين الخيارات المحددة
            $('input[name="new_status"]').prop('checked', false);
            $('#statusError').hide();

            // إخفاء الخيارات غير المتاحة
            if (selectedTeacher.currentStatus === 'active') {
                // إخفاء خيار active لأنه نفس الحالة الحالية
                $('#status_active').closest('.form-check').hide();
                $('#status_inactive').closest('.form-check').show();
                $('#status_suspended').closest('.form-check').show();
            } else if (selectedTeacher.currentStatus === 'inactive') {
                $('#status_active').closest('.form-check').show();
                $('#status_inactive').closest('.form-check').hide();
                $('#status_suspended').closest('.form-check').show();
            } else if (selectedTeacher.currentStatus === 'suspended') {
                $('#status_active').closest('.form-check').show();
                $('#status_inactive').closest('.form-check').show();
                $('#status_suspended').closest('.form-check').hide();
            }
        });

        // 3. تأكيد تغيير الحالة من المودال
        $('#confirmChangeStatus').on('click', function() {
            const selectedStatus = $('input[name="new_status"]:checked').val();

            if (!selectedStatus) {
                $('#statusError').show();
                return;
            }

            $('#statusError').hide();

            // تعطيل الزر لمنع النقر المتكرر
            $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i>جاري التغيير...');
            $.ajax({
                url: routes.changeStatus.replace(':id', selectedTeacher.id),
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: selectedStatus
                },
                success: function(response) {
                    if (response.success) {
                        // إعادة تحميل الـ DataTable
                        $('#teachers-table').DataTable().ajax.reload();

                        // إغلاق المودال
                        $('#changeStatusModal').modal('hide');

                        // عرض رسالة نجاح
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message);
                        } else {
                            alert(response.message);
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message);
                        } else {
                            alert(response.message);
                        }
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'حدث خطأ أثناء تغيير حالة الحساب';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMessage);
                    } else {
                        alert(errorMessage);
                    }
                },
                complete: function() {
                    // إعادة تفعيل الزر
                    $('#confirmChangeStatus')
                        .prop('disabled', false)
                        .html('<i class="fa fa-save me-2"></i>تغيير الحالة');
                }
            });
        });

        // 4. إظهار رسالة الخطأ عند عدم اختيار حالة
        $('input[name="new_status"]').on('change', function() {
            $('#statusError').hide();
        });

        // 5. إعادة تعيين المودال عند الإغلاق
        $('#changeStatusModal').on('hidden.bs.modal', function() {
            $('input[name="new_status"]').prop('checked', false);
            $('#statusError').hide();
            $('#confirmChangeStatus')
                .prop('disabled', false)
                .html('<i class="fa fa-save me-2"></i>تغيير الحالة');
        });
        // =============================================
        // 2. تعريف DataTable للطلاب مع الفلاتر
        // =============================================
        var table = $("#kt_table_teacher").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.teachers.getTeachers') }}",
                type: "GET",
                data: function (d) {
                    // الفلاتر الأساسية
                    d.student_id = $('#filter_student_id').val();
                    d.first_name = $('#filter_first_name').val();
                    d.last_name = $('#filter_last_name').val();
                    d.mobile = $('#filter_mobile').val();
                    d.birth_date_from = $('#filter_birth_date_from').val();
                    d.birth_date_to = $('#filter_birth_date_to').val();
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
                    data: 'national_id',
                    name: 'national_id',
                    className: 'text-center'
                },
                {
                    data: 'teacher_name',
                    name: 'teacher_name',
                    className: 'text-center'
                },
                {
                    data: 'birth_date',
                    name: 'birth_date',
                    className: 'text-center'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number',
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
