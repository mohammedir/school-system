<script>
    let myMap;
    let myMarker;

    // Global function for Google Maps callback (called by the script tag)
    function initMap() {
        // Placeholder - actual map initialization will happen after AJAX
        console.log('Google Maps API loaded');
    }

    $(document).ready(function () {

        let table = $("#kt_table_history_list").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('projects.get_project_history',[$project_id]) }}",
                data: function (d) {
                    d.list_name_cd = $('#list_name_cd').val();
                }
            },
            columns: [
                { data: 'notifications_message', name: 'notifications_message' },
                { data: 'notifications_created_at', name: 'notifications_created_at' },
                { data: 'notifiable_id', name: 'notifiable_id' },
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

        let balance_log_table = $("#kt_table_balance_log").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('projects.get_project_balance_log',[$project_id]) }}",
                data: function (d) {
                    d.list_name_cd = $('#list_name_cd').val();
                }
            },
            columns: [
                { data: 'amount', name: 'amount' },
                { data: 'user_type', name: 'user_type' },
                { data: 'user_id', name: 'user_id' },
                { data: 'description', name: 'description' },
                { data: 'transaction_id', name: 'transaction_id' },
                { data: 'created_at', name: 'created_at' },
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

        const baseOfferUrl = "{{ url('/projects/get-project-offers/') }}";
        let project_id = $('#project_id').val();
        let table_offers_list = $("#kt_table_projects_offers_list").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `${baseOfferUrl}/${project_id}`, // 👈 clean and dynamic
                data: function (d) {
                    d.status_cd = $('#status_cd').val();
                }
            },
            columns: [
                { data: 'engineering_partner_name', name: 'engineering_partner_name' },
                { data: 'duration', name: 'duration' },
                { data: 'created_at', name: 'created_at' },
                { data: 'offer_notes', name: 'offer_notes' },

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

        const baseContractorOffersUrl = "{{ url('/projects/get-project-contractor-offers/') }}";
        let table_contractor_offers_list = $("#kt_table_contractor_offers_list").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `${baseContractorOffersUrl}/${project_id}`, // 👈 clean and dynamic
                data: function (d) {
                    d.status_cd = $('#status_cd').val();
                }
            },
            columns: [
                { data: 'contractor_name', name: 'contractor_name' },
                { data: 'duration', name: 'duration' },
                { data: 'created_at', name: 'created_at' },
                { data: 'offer_notes', name: 'offer_notes' },

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
                table_offers_list.search(input.value).draw();
            }, 300); // delay in milliseconds
        });
        $('.search_btn').on('click', function () {
            table_offers_list.draw(); // redraw the table with the filter values
        });
        $('.reset_search').on('click', function () {
            $('#filters')[0].reset(); // clear form fields
            // Reset the Select2 value manually
            $('#status_cd').val(null).trigger('change'); // Reset and update UI
            table_offers_list.draw(); // refresh table
        });

        let editorInstance;

        DecoupledEditor
            .create(document.querySelector('.kt_docs_ckeditor_document'), {
                removePlugins: ['Image', 'ImageUpload', 'MediaEmbed', 'EasyImage', 'CKFinder', 'Table'], // إزالة الميديا
            })
            .then(editor => {
                editorInstance = editor;

                const toolbarContainer = document.querySelector('.kt_docs_ckeditor_document_toolbar');
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
            })
            .catch(error => {
                console.error(error);
            });

        $(document).on('click', '.search_btn', function (e) {
            e.preventDefault();
            let data = {
                province_cd: $('select[name="province_cd"]').val(),
                city_cd: $('select[name="city_cd"]').val(),
                district_cd: $('select[name="district_cd"]').val(),
                address: $('input[name="address"]').val(),
                ownership_type_cd: $('select[name="ownership_type_cd"]').val(),
                area_from: $('input[name="area_from"]').val(),
                area_to: $('input[name="area_to"]').val(),
                price_from: $('input[name="price_from"]').val(),
                price_to: $('input[name="price_to"]').val(),

                // أضف أي عناصر أخرى بنفس الطريقة
            };
            $.ajax({
                url: '{{ route("projects.land_filter") }}',
                method: 'GET',
                data: data,
                beforeSend: function () {
                    $('#land_id').html('<option disabled selected>جاري التحميل...</option>');
                },
                success: function (response) {
                    // تأكد أن الـ response يحتوي على مصفوفة lands
                    let select = $('#land_id');
                    select.empty();
                    select.append('<option></option>'); // لإعادة الخيار الفارغ

                    response.lands.forEach(function (land) {
                        select.append(`
                        <option value="${land.id}" data-lat="${land.lat}" data-long="${land.long}" data-investor_id="${land.investor_id}">
                            ${land.investor_name} - ${land.area}م2 - ${land.land_description}
                        </option>
                    `);
                    });

                    // إعادة تهيئة Select2
                    select.select2();
                },
                error: function (xhr) {
                    alert('حدث خطأ أثناء جلب البيانات');
                    console.error(xhr);
                }
            });
        });
        $(document).on('click', '.reset_search', function (e) {
            e.preventDefault();
            // أولًا: إفراغ جميع الحقول
            $('select[name="province_cd"]').val(null).trigger('change');
            $('select[name="city_cd"]').val(null).trigger('change');
            $('select[name="district_cd"]').val(null).trigger('change');
            $('input[name="address"]').val('');
            $('select[name="ownership_type_cd"]').val(null).trigger('change');
            $('input[name="area_from"]').val('');
            $('input[name="area_to"]').val('');
            $('input[name="price_from"]').val('');
            $('input[name="price_to"]').val('');

            // ثانيًا: إنشاء كائن البيانات مع كل القيم فارغة
            let data = {
                province_cd: null,
                city_cd: null,
                district_cd: null,
                address: null,
                ownership_type_cd: null,
                area_from: null,
                area_to: null,
                price_from: null,
                price_to: null
            };
            $.ajax({
                url: '{{ route("projects.land_filter") }}',
                method: 'GET',
                data: data,
                beforeSend: function () {
                    $('#land_id').html('<option disabled selected>جاري التحميل...</option>');
                },
                success: function (response) {
                    // تأكد أن الـ response يحتوي على مصفوفة lands
                    let select = $('#land_id');
                    select.empty();
                    select.append('<option></option>'); // لإعادة الخيار الفارغ

                    response.lands.forEach(function (land) {
                        select.append(`
                        <option value="${land.id}" data-lat="${land.lat}" data-long="${land.long}" data-investor_id="${land.investor_id}">
                            ${land.investor_name} - ${land.area}م2 - ${land.land_description}
                        </option>
                    `);
                    });

                    // إعادة تهيئة Select2
                    select.select2();
                },
                error: function (xhr) {
                    alert('حدث خطأ أثناء جلب البيانات');
                    console.error(xhr);
                }
            });
        });

        $(".kt_datepicker").flatpickr();
        // Initialize select2
        $('select[name="land_id"]').select2();

        // On change of land selection
        $('select[name="land_id"]').on('change', function () {
            const landId = $(this).val();
            const selectedOption = $(this).find('option:selected');
            const investorId = selectedOption.data('investor_id');
            const lat = parseFloat(selectedOption.data('lat'));
            const lng = parseFloat(selectedOption.data('long'));
            const land_area = selectedOption.data('land_area');

            $('#land_area_note').html(land_area);

            // Load Land Details
            if (landId) {
                $.ajax({
                    url: '{{ route("land.getLandDetails") }}',
                    type: 'GET',
                    data: { id: landId },
                    success: function (response) {
                        $('#land_details').html(response).fadeIn();

                        // Show map if coordinates are available
                        if (!isNaN(lat) && !isNaN(lng)) {
                            $('#map_card').fadeIn();

                            const location = { lat: lat, lng: lng };

                            // Initialize or update map
                            if (!myMap) {
                                myMap = new google.maps.Map(document.getElementById("map"), {
                                    zoom: 13,
                                    center: location,
                                });

                                myMarker = new google.maps.Marker({
                                    position: location,
                                    map: myMap,
                                    draggable: false,
                                });

                                myMarker.addListener('dragend', function (event) {
                                    $('#lat').val(event.latLng.lat().toFixed(6));
                                    $('#long').val(event.latLng.lng().toFixed(6));
                                });
                            } else {
                                myMap.setCenter(location);
                                myMarker.setPosition(location);
                            }

                            // Set initial coordinates if needed
                            $('#lat').val(lat.toFixed(6));
                            $('#long').val(lng.toFixed(6));
                        } else {
                            $('#map_card').hide();
                        }
                    },
                    error: function () {
                        const errorMessage = "{{ __('admin.Error loading data.') }}";
                        $('#land_details').html('<div class="alert alert-danger">' + errorMessage + '</div>').fadeIn();
                    }
                });
            } else {
                $('#land_details').fadeOut().html('');
                $('#map_card').fadeOut();
            }

            // Load Student Details
            if (investorId) {
                $.ajax({
                    url: '{{ route("admin.getInvestorDetails") }}',
                    type: 'GET',
                    data: { id: investorId },
                    success: function (response) {
                        $('#investor_details').html(response).fadeIn();
                    },
                    error: function () {
                        $('#investor_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                    }
                });
            } else {
                $('#investor_details').fadeOut().html('');
            }
        });

        // Trigger change on page load
        $('select[name="land_id"]').trigger('change');

        $(document).on('click', '.toggle-collapse', function() {
            const $collapse = $(this).closest('.floor-wrapper').find('.card-collapse');
            $collapse.collapse('toggle');

            // تبديل الأيقونة
            $collapse.on('shown.bs.collapse', () => {
                $(this).text('⯅');
            });
            $collapse.on('hidden.bs.collapse', () => {
                $(this).text('⯆');
            });
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('projectLogModal');
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const notes = button.getAttribute('data-notes');
            const modalBody = modal.querySelector('#projectLogNotesContent');
            modalBody.textContent = notes || 'لا توجد ملاحظات.';
        });
    });
</script>


<!-- Google Maps API -->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA&callback=initMap">
</script>
