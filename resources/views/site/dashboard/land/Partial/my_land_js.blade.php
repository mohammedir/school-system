`<script>
    $(document).ready(function () {
        formatNumberFields();
        let table = $("#investor_table_my_land").DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            columnDefs: [
                { width: "5%", targets: 0 }, // وصف الأرض
                { width: "5%", targets: 1 }, // السعر
                { width: "33%", targets: 2 }, // المثمن
                { width: "37%", targets: 3 }, // الشريك القانوني
                { width: "18%", targets: 4 }, // تاريخ
                { width: "2%", targets: 5 }, // الأكشن
            ],
            ajax: {
                url: "{{ route('investors.dashboard.get_my_land') }}",
                data: function (d) {
                    d.province_cd = $('#province_cd').val();
                    d.location_cities = $('#location_cities').val();
                    d.location_areas = $('#location_areas').val();
                    d.address = $('#address').val();
                    d.ownership_type_cd = $('#ownership_type_cd').val();
                    d.accreditation_status = $('#accreditation_status').val();
                    d.area_from = $('#area_from').val();
                    d.area_to = $('#area_to').val();
                    d.price_from = $('#price_from').val();
                    d.price_to = $('#price_to').val();
                }
            },
            columns: [
                { data: 'land_description', name: 'land_description' },
                { data: 'price', name: 'price' },
                { data: 'valuation_status_cd', name: 'valuation_status_cd' },
                { data: 'legal_status_cd', name: 'legal_status_cd' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "{{asset('assets/Arabic.json')}}"
            },
            createdRow: function (row, data, dataIndex) {
                $('td', row).each(function (index) {
                    $(this).addClass('text-center');

                });
            },
            drawCallback: function () {
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances();
                }
            }
        });
        let searchTimeout;
        $('[data-kt-land-table-filter="search"]').on('keyup', function () {
            clearTimeout(searchTimeout);
            let input = this;

            searchTimeout = setTimeout(function () {
                table.search(input.value).draw();
            }, 300); // delay in milliseconds
        });
        $('.search_btn').on('click', function () {
            table.draw(); // redraw the table with the filter values
        });
        $('.reset_search').on('click', function () {
            $('#filters')[0].reset(); // clear form fields
            // Reset the Select2 value manually
            $('#province_cd').val(null).trigger('change'); // Reset and update UI
            $('#location_cities').val(null).trigger('change');
            $('#location_areas').val(null).trigger('change');
            $('#address').val(null).trigger('change');
            $('#ownership_type_cd').val(null).trigger('change');
            $('#accreditation_status').val(null).trigger('change');
            $('#area_from').val(null).trigger('change');
            $('#area_to').val(null).trigger('change');
            $('#price_from').val(null).trigger('change');
            $('#price_to').val(null).trigger('change');
            table.draw(); // refresh table
        });


        $(document).on('click', '.delete-land-btn', function(e) {
            e.preventDefault();
            const landId = $(this).data('land-id');

            Swal.fire({
                title: '@lang('admin.Are you sure?')',
                text: "@lang('admin.This land will be soft deleted!')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "@lang('admin.Yes, delete it!')",
                cancelButtonText: "@lang('admin.Discard')"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('/lands/softDelete') }}/${landId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                text: '@lang("admin.Deleted!")',
                                icon: 'success',
                                confirmButtonText: '@lang('admin.OK')',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            })
                            // Optionally remove or refresh the card from the DOM
                            $('#kt_table_lands').DataTable().ajax.reload();

                        },
                        error: function() {
                            Swal.fire('@lang('admin.Error!')', '@lang('admin.Something went wrong.')', 'error');
                        }
                    });
                }
            });
        });

        // فتح المودال عند الضغط على الزر
        $(document).on('click', '.edit-price-land', function () {
            const modal = new bootstrap.Modal(document.getElementById('kt_modal_edit_land_price'));
            landId = $(this).data('land-id');
            landPrice = $(this).data('land-price');
            landValuationPrice = $(this).data('land-valuation-price');
            $('#land_valuation_notes_modal').val($(this).data('land-valuation-notes'));
            $('#land_valuation_price_modal').val(landValuationPrice);
            $('#land_valuation_name_modal').val($(this).data('land-valuation-name'));
            $('#land_valuation_mobile_number_modal').val($(this).data('land-valuation-mobile-number'));
            $('#land_valuation_email_modal').val($(this).data('land-valuation-email'));
            $('#land_old_price_modal').val(landPrice);



            $('#edit_land_id').val(landId);

            // تنسيق الأرقام قبل العرض
            formatNumberFields();
            modal.show();
        });

        $('#approve_btn').on('click', function (e) {
            e.preventDefault();
            $('#action_input').val('approved');
            $('#update_price_form').submit();
        });

        $('#reject_btn').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم رفض السعر المقدم بالأضافة انه سيتم أرشفة الأرض، هل تريد المتابعة؟',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'إلغاء',
                confirmButtonText: 'نعم، ارفض',
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#action_input').val('rejected');
                    $('#update_price_form').submit();
                }
            });

        });
    });
    function formatNumberFields() {
        $('.number_format').each(function () {
            let rawValue = $(this).val().replace(/,/g, '');
            if (!isNaN(rawValue) && rawValue.trim() !== '') {
                let formatted = parseFloat(rawValue).toLocaleString();
                $(this).val(formatted);
            }
        });
    }




</script>
