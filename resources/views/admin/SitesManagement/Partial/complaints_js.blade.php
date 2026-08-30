<script>
    $(document).ready(function () {
        // =============================================
        // 1. تعريف DataTable للشكاوى مع الفلاتر
        // =============================================
        var table = $("#kt_table_complaints").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.complaints.getData') }}",
                type: "GET",
                data: function (d) {
                    // الفلاتر الأساسية
                    d.complainant_name = $('#filter_complainant_name').val();
                    d.phone_number = $('#filter_phone_number').val();
                    d.type = $('#filter_type').val();
                    d.status = $('#filter_status').val();
                    d.date_from = $('#filter_date_from').val();
                    d.date_to = $('#filter_date_to').val();
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
                    data: 'id',
                    name: 'id',
                    className: 'text-center'
                },
                {
                    data: 'complainant_name',
                    name: 'complainant_name',
                    className: 'text-center'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number',
                    className: 'text-center'
                },
                {
                    data: 'type_html',
                    name: 'type',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'status_html',
                    name: 'status',
                    className: 'text-center',
                    orderable: false
                },
                {
                    data: 'details_short',
                    name: 'details',
                    className: 'text-center'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
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
        // 2. البحث السريع
        // =============================================
        var searchTimeout;
        $('[data-kt-complaint-table-filter="search"]').on('keyup', function () {
            clearTimeout(searchTimeout);
            var input = this;
            searchTimeout = setTimeout(function () {
                table.search(input.value).draw();
            }, 300);
        });

        // =============================================
        // 3. زر البحث المتقدم
        // =============================================
        $('.search_btn').on('click', function() {
            table.draw();
        });

        // =============================================
        // 4. زر إعادة تعيين الفلاتر
        // =============================================
        $('.reset_search').on('click', function() {
            // إعادة تعيين جميع حقول الفلتر في النموذج
            $('#filters')[0].reset();

            // إعادة تعيين الـ Select2
            if ($.fn.select2) {
                $('#filter_type').val(null).trigger('change');
                $('#filter_status').val(null).trigger('change');
            }

            // إعادة تحميل الجدول
            table.draw();
        });

        // =============================================
        // 5. تحديث الجدول عند تغيير الفلاتر
        // =============================================
        $('#filter_type, #filter_status').on('change', function() {
            table.draw();
        });

        // =============================================
        // 6. عرض تفاصيل الشكوى
        // =============================================
        $(document).on('click', '.view.blade.php-complaint-btn', function(e) {
            e.preventDefault();
            var complaintId = $(this).data('id');

            $.ajax({
                url: "{{ route('admin.complaints.details', ['id' => ':id']) }}".replace(':id', complaintId),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        var html = `
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>أسم مقدم الشكوي:</strong> ${data.complainant_name}</p>
                                    <p><strong>الرقم:</strong> ${data.phone_number}</p>
                                    <p><strong>النوع:</strong> ${data.type_name}</p>
                                    <p><strong>الحالة:</strong> ${data.status_name}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>التاريخ:</strong> ${data.created_at}</p>
                                    <p><strong>التفاصيل:</strong></p>
                                    <div class="border p-3 bg-light">${data.details}</div>
                                    ${data.admin_reply ? `<p><strong>الرد:</strong></p><div class="border p-3 bg-info text-white">${data.admin_reply}</div>` : ''}
                                </div>
                            </div>
                        `;
                        $('#complaintDetailsBody').html(html);
                        $('#complaintDetailsModal').modal('show');
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        text: 'حدث خطأ في تحميل التفاصيل',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // =============================================
        // 7. حذف الشكوى
        // =============================================
        $(document).on('click', '.delete-complaint-btn', function(e) {
            e.preventDefault();
            var complaintId = $(this).data('id');
            var complainantName = $(this).data('name') || '';

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف شكوى " + complainantName + " بشكل نهائي!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/complaints/' + complaintId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                text: response.message || 'تم حذف الشكوى بنجاح',
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
        // 8. تغيير حالة الشكوى
        // =============================================
        $(document).on('change', '.complaint-status-select', function() {
            var complaintId = $(this).data('id');
            var status = $(this).val();

            Swal.fire({
                title: 'تغيير الحالة',
                text: 'هل أنت متأكد من تغيير حالة الشكوى؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، تغيير',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.complaints.update-status', ['id' => ':id']) }}".replace(':id', complaintId),
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function(response) {
                            Swal.fire({
                                text: response.message || 'تم تغيير الحالة بنجاح',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                text: 'حدث خطأ في تغيير الحالة',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    // إعادة القيمة القديمة
                    table.ajax.reload();
                }
            });
        });
    });
</script>
