<script>
    "use strict";

    // Class definition
    var KTStudentsList = function () {
        var datatable;
        var table = document.getElementById('kt_table_students');

        // Private functions
        var initDatatable = function () {
            datatable = $(table).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.registrations_students.getData") }}',
                    type: 'GET',
                    data: function (d) {
                        d.student_full_name = $('#filter_student_name').val();
                        d.student_id_number = $('#filter_student_id').val();
                        d.phone_number = $('#filter_phone_number').val();
                        d.age_group_id = $('#filter_age_group').val();
                        d.class_id = $('#filter_class').val();
                        d.status = $('#filter_status').val();
                        d.date_from = $('#filter_date_from').val();
                        d.date_to = $('#filter_date_to').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'student_id_number', name: 'student_id_number'},
                    {data: 'student_full_name', name: 'student_full_name'},
                    {data: 'guardian_name', name: 'guardian_name'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'age_group_name', name: 'age_group_id'},
                    {data: 'class_name', name: 'class_id'},
                    {data: 'status_badge', name: 'status', orderable: false, searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                order: [[8, 'desc']],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                },
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-sm btn-success',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        className: 'btn btn-sm btn-danger',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });
        };

        // Search
        var handleSearchDatatable = function () {
            const filterSearch = document.querySelector('[data-kt-student-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
        };

        // Filter
        var handleFilter = function () {
            $('.search_btn').on('click', function (e) {
                e.preventDefault();
                datatable.ajax.reload();
            });

            $('.reset_search').on('click', function (e) {
                e.preventDefault();
                $('#filters')[0].reset();
                // Reset select2
                $('#filter_age_group').val('').trigger('change');
                $('#filter_class').val('').trigger('change');
                $('#filter_status').val('').trigger('change');
                datatable.ajax.reload();
            });
        };

        // View Details
        var handleViewDetails = function () {
            $(document).on('click', '.view.blade.php-student-btn', function (e) {
                e.preventDefault();
                var studentId = $(this).data('id');

                $.ajax({
                    url: '{{ route("admin.registrations_students.details", ":id") }}'.replace(':id', studentId),
                    type: 'GET',
                    success: function (response) {
                        if (response.success) {
                            var data = response.data;
                            var html = `
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="fw-bold">رقم الهوية:</label>
                                            <p>${data.student_id_number}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">اسم الطالب:</label>
                                            <p>${data.student_full_name}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">تاريخ الميلاد:</label>
                                            <p>${data.birth_date}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">العنوان:</label>
                                            <p>${data.address}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">المرحلة الدراسية:</label>
                                            <p>${data.age_group_name}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">الفصل:</label>
                                            <p>${data.class_name}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="fw-bold">اسم ولي الأمر:</label>
                                            <p>${data.guardian_name}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">رقم هوية ولي الأمر:</label>
                                            <p>${data.guardian_id_number}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">رقم الهاتف:</label>
                                            <p>${data.phone_number}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">الحالة:</label>
                                            <p>${data.status_badge}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">إشعار التحويل:</label>
                                            ${data.transfer_notice ? `<a href="${data.transfer_notice}" target="_blank" class="btn btn-sm btn-primary">عرض الملف</a>` : '<p>لا يوجد</p>'}
                                        </div>
                                        <div class="mb-3">
                                            <label class="fw-bold">ملاحظات إضافية:</label>
                                            <p>${data.additional_notes || 'لا يوجد'}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#studentDetailsBody').html(html);
                            $('#studentDetailsModal').modal('show');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('حدث خطأ في عرض التفاصيل');
                    }
                });
            });
        };

        // Public methods
        return {
            init: function () {
                if (!table) {
                    return;
                }

                initDatatable();
                handleSearchDatatable();
                handleFilter();
                handleViewDetails();
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function () {
        KTStudentsList.init();
    });
</script>
