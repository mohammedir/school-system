<script>
    $(document).ready(function () {
        let table = $("#kt_table_projects").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('contractors.get_projects') }}",
                data: function (d) {
                    d.project_type_cd = $('#project_type_cd').val();
                }
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'engineering_consultant_description', name: 'engineering_consultant_description' },
                { data: 'contractor_offers_start_date', name: 'contractor_offers_start_date' },
                { data: 'contractor_offers_end_date', name: 'contractor_offers_end_date' },
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
            $('#project_type_cd').val(null).trigger('change'); // Reset and update UI
            table.draw(); // refresh table
        });
    });


</script>
