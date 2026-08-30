<script>
    $(document).ready(function () {
        let table = $("#kt_table_projects").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('contractors.contractors_offers.get_offers') }}",
                data: function (d) {
                    d.status_cd = $('#status_cd').val();
                }
            },
            columns: [
                { data: 'id', name: 'id', visible: false }, // ✅ اضف هذا العمود
                { data: 'project_title', name: 'project.title' },
                { data: 'total_price', name: 'total_price' },
                { data: 'duration', name: 'duration' },
                { data: 'created_at', name: 'created_at' },
                { data: 'status_cd', name: 'status_cd' },
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
        $('[data-kt-project-table-filter="search"]').on('keyup', function () {
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
            $('#status_cd').val(null).trigger('change'); // Reset and update UI
            table.draw(); // refresh table
        });
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let item_id = $(this).data('item-id');


            Swal.fire({
                title: '@lang("admin.Are you sure?")',
                text: '@lang("admin.This action cannot be undone!")',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang("admin.Yes, delete it!")',
                cancelButtonText: '@lang("admin.Discard")',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send delete request
                    fetch(`{{ route('contractors.contractors_offers.delete','') }}/${item_id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(async response => {
                            const data = await response.json();

                            if (response.ok) {
                                Swal.fire({
                                    title: '@lang("admin.Deleted!")',
                                    text: '@lang("admin.Quote has been deleted")',
                                    icon: 'success',
                                    confirmButtonText: '@lang("admin.OK")',
                                    customClass: {
                                        confirmButton: 'btn btn-info'
                                    },
                                    buttonsStyling: false
                                });

                                // Optionally reload the table
                                table.ajax.reload();
                            } else {
                                throw new Error(data.message || 'Error occurred');
                            }
                        })
                        .catch((error) => {
                            Swal.fire({
                                title: '@lang("admin.Error")',
                                text: error.message,
                                icon: 'error',
                                confirmButtonText: '@lang("admin.OK")',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                },
                                buttonsStyling: false
                            });
                        });
                }
            });
        });
    });


</script>
