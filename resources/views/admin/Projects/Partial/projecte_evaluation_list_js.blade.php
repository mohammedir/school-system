<script>
    $(document).ready(function () {
        let table = $("#kt_table_projects").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('projects.getTableProjects') }}",
                data: function (d) {
                    d.project_type_cd = $('#project_type_cd').val();
                }
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'project_type_cd', name: 'project_type_cd' },
                { data: 'project_status_cd', name: 'project_status_cd' },
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
        // عند الضغط على زر البحث
        $('.search_btn').on('click', function (e) {
            e.preventDefault();
        });

        // عند الضغط على زر إعادة التصفية
        $('.reset_search').on('click', function (e) {
            e.preventDefault();
            $('#filters')[0].reset(); // إعادة تعيين النموذج
            $('#project_type_cd').val('').trigger('change');
            $('#project_status_cd').val('').trigger('change');
            $('#province_cd').val('').trigger('change');
            $('#location_cities').val('').trigger('change');
            $('#district_cd').val('').trigger('change');
            $('#investor_id').val('').trigger('change');
        });

    });
</script>
