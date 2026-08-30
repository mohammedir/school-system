<script>
    $(document).ready(function () {
        const cityRegionWrapper = document.getElementById('city_region_wrapper');
        const area_region_wrapper = document.getElementById('area_region_wrapper');
        const age_group_wrapper = document.getElementById('age_group_wrapper');

        $(document).on("change", "select.list_type", function () {
                const selectedOption = this.options[this.selectedIndex];
                const masterKey = selectedOption.getAttribute('data-master_key');

                if (masterKey === 'city') {
                    cityRegionWrapper.classList.remove('d-none');
                    age_group_wrapper.classList.add('d-none');
                }else if(masterKey == 'area'){
                    cityRegionWrapper.classList.remove('d-none');
                    area_region_wrapper.classList.remove('d-none');
                    age_group_wrapper.classList.add('d-none');

                }else if(masterKey == 'age_group'){
                    age_group_wrapper.classList.remove('d-none');
                    cityRegionWrapper.classList.add('d-none');
                    area_region_wrapper.classList.add('d-none');

                } else {
                    cityRegionWrapper.classList.add('d-none');
                    area_region_wrapper.classList.add('d-none');

                }
            });
        $(document).on("change", "select.location_province", function () {
            var province_id = $(this).val();
            var this_city = $("#location_cities");
            var this_area = $("#location_areas");
            var cities_block = document.querySelector("#cities_block");

            if (!cities_block) {
                console.error("#cities_block not found");
                return;
            }

            // استخدم getInstance أو أنشئ جديد عند الحاجة فقط
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
        let table = $("#kt_table_manage_list").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('settings.get_manage_lists_data') }}",
                data: function (d) {
                    d.list_name_cd = $('#list_name_cd').val();
                }
            },
            columns: [
                { data: 'list_name', name: 'list_name' },
                { data: 'item_name', name: 'item_name' },
                { data: 'status', name: 'status' },
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
        $('[data-kt-list-table-filter="search"]').on('keyup', function () {
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
            table.draw(); // refresh table
        });


        $(document).on('click', '.view_items', function () {
            let listId = $(this).data('settings-list-id');
            $.ajax({
                url: `{{ url("/") }}/settings/settings-list/${listId}`,
                method: 'GET',
                success: function (response) {
                    // Fill in the role name
                    $('input[name="edit_name_ar"]').val(response.lookups.name_ar);
                    $('input[name="edit_item_id"]').val(response.lookups.id);
                    $('select[name="status"]').val(response.lookups.status).trigger('change');

                },
                error: function () {
                    alert('Failed to fetch role data.');
                }
            });
        });

        $(document).on('click', '.delete-land-btn', function (e) {
            e.preventDefault();
            let landId = $(this).data('land-id');

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
                    fetch(`{{ url("/") }}/settings/delete-item/${landId}`, {
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
                                    text: '@lang("admin.Item has been deleted.")',
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


        var KTAddItem = function () {
            // Shared variables
            const element = document.getElementById('kt_modal_add_items');
            const form = element.querySelector('#kt_modal_add_item_form');
            const modal = new bootstrap.Modal(element);

            // Init add schedule modal
            var initAddItem = () => {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                var validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'name_ar': {
                                validators: {
                                    notEmpty: {
                                        message: '@lang('admin.This field is required')'
                                    }
                                }
                            },
                        },

                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',
                                eleValidClass: ''
                            })
                        }
                    }
                );

                // Submit button handler
                const submitButton = element.querySelector('[data-kt-add-item-modal-action="submit"]');
                submitButton.addEventListener('click', e => {
                    e.preventDefault();

                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function (status) {
                            if (status == 'Valid') {
                                // Show loading indication
                                submitButton.setAttribute('data-kt-indicator', 'on');

                                // Disable button to avoid multiple click
                                submitButton.disabled = true;


                                // Enable button
                                submitButton.disabled = false;
                                const formData = new FormData(form); // Handles file uploads too

                                // Show popup confirmation

                                fetch('{{ route('settings.add_item') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: formData
                                })
                                    .then(async response => {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        const data = await response.json();

                                        if (response.ok) {
                                            Swal.fire({
                                                text: "@lang('admin.Form has been successfully submitted!')",
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-info"
                                                }
                                            }).then(function (result) {
                                                if (result.isConfirmed) {
                                                    form.reset();
                                                    modal.hide(); // Hide the modal if needed
                                                    table.ajax.reload(); //  Reload the DataTable
                                                }
                                            });
                                        } else if (response.status === 422) {
                                            // Laravel validation errors
                                            let errorMessages = Object.values(data.errors).flat().join('<br>');
                                            Swal.fire({
                                                html: `<div class="text-center">${errorMessages}</div>`,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                text: data.message || "@lang('admin.Something went wrong.')",
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "@lang('admin.OK')",
                                                customClass: {
                                                    confirmButton: "btn btn-danger"
                                                }
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        submitButton.removeAttribute('data-kt-indicator');
                                        submitButton.disabled = false;

                                        Swal.fire({
                                            text: "@lang('admin.Unexpected error: ')",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "@lang('admin.OK')",
                                            customClass: {
                                                confirmButton: "btn btn-danger"
                                            }
                                        });
                                    });
                            } else {
                                // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "@lang('admin.Sorry, looks like there are some errors detected, please try again.')",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "@lang('admin.OK')",
                                    customClass: {
                                        confirmButton: "btn btn-info"
                                    }
                                });
                            }
                        });
                    }
                });

                // Cancel button handler
                const cancelButton = element.querySelector('[data-kt-users-modal-action="cancel"]');
                cancelButton.addEventListener('click', e => {
                    e.preventDefault();

                    Swal.fire({
                        text: "@lang('admin.Are you sure you would like to cancel?')",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "@lang('admin.Yes, cancel it!')",
                        cancelButtonText: "@lang('admin.No, return')",
                        customClass: {
                            confirmButton: "btn btn-info",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            form.reset(); // Reset form
                            modal.hide();
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "@lang('admin.Your form has not been cancelled!.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('OK')",
                                customClass: {
                                    confirmButton: "btn btn-info",
                                }
                            });
                        }
                    });
                });

            }
            return {
                // Public functions
                init: function () {
                    initAddItem();
                }
            };
        }();
        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTAddItem.init();

        });
    });



</script>

<script>
    $(document).ready(function () {
        let table = $("#kt_table_manage_list").DataTable();
        var KTEditItem = function () {
        // Shared variables
        const editelement = document.getElementById('kt_modal_view_items');
        const editform = editelement.querySelector('#kt_modal_edit_item_form');
        const editmodal = new bootstrap.Modal(editelement);

        // Init add schedule modal
        var initEditItem = () => {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validator = FormValidation.formValidation(
                editform,
                {
                    fields: {
                        'settings_name': {
                            validators: {
                                notEmpty: {
                                    message: '@lang('admin.This field is required')'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Submit button handler
            const editsubmitButton = editelement.querySelector('[data-kt-edit-modal-action="submit"]');
            editsubmitButton.addEventListener('click', e => {
                e.preventDefault();

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            // Show loading indication
                            editsubmitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            editsubmitButton.disabled = true;


                            // Enable button
                            editsubmitButton.disabled = false;
                            const formData = new FormData(editform); // Handles file uploads too
                            const list_Id = document.getElementById('edit_item_id').value;
                            const url = `{{url("/")}}/settings/edit-item/${list_Id}`; // Build the correct URL

                            // Show popup confirmation
                            fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: formData
                            })
                                .then(async response => {
                                    editsubmitButton.removeAttribute('data-kt-indicator');
                                    editsubmitButton.disabled = false;

                                    const data = await response.json();
                                    if (response.ok) {
                                        Swal.fire({
                                            text: "@lang('admin.Form has been successfully submitted!')",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "@lang('admin.OK')",
                                            customClass: {
                                                confirmButton: "btn btn-info"
                                            }
                                        }).then(function (result) {
                                            if (result.isConfirmed) {
                                                editform.reset();
                                                editmodal.hide(); // Hide the modal if needed
                                                table.ajax.reload(); //  Reload the DataTable
                                            }
                                        });
                                    } else if (response.status === 422) {
                                        // Laravel validation errors
                                        let errorMessages = Object.values(data.errors).flat().join('<br>');
                                        Swal.fire({
                                            html: `<div class="text-center">${errorMessages}</div>`,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "@lang('admin.OK')",
                                            customClass: {
                                                confirmButton: "btn btn-danger"
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            text: data.message || "@lang('admin.Something went wrong.')",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "@lang('admin.OK')",
                                            customClass: {
                                                confirmButton: "btn btn-danger"
                                            }
                                        });
                                    }
                                })
                                .catch(error => {
                                    editsubmitButton.removeAttribute('data-kt-indicator');
                                    editsubmitButton.disabled = false;

                                    Swal.fire({
                                        text: "@lang('admin.Unexpected error: ')",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "@lang('admin.OK')",
                                        customClass: {
                                            confirmButton: "btn btn-danger"
                                        }
                                    });
                                });
                        } else {
                            // Show popup warning. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "@lang('admin.Sorry, looks like there are some errors detected, please try again.')",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "@lang('admin.OK')",
                                customClass: {
                                    confirmButton: "btn btn-info"
                                }
                            });
                        }
                    });
                }
            });




        }
        return {
            // Public functions
            init: function () {
                initEditItem();
            }
        };
    }();
        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTEditItem.init();

        });
    });

</script>
