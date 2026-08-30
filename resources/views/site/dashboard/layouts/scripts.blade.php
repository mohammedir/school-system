<script src="{{ asset('site_assets/js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('site_assets/js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('site_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('site_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('site_assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('site_assets/js/jquery.mmenu.all.js') }}"></script>
<script src="{{ asset('site_assets/js/ace-responsive-menu.js') }}"></script>
<script src="{{ asset('site_assets/js/chart.min.js') }}"></script>
<script src="{{ asset('site_assets/js/chart-custome.js') }}"></script>
<script src="{{ asset('site_assets/js/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('site_assets/js/dashboard-script.js') }}"></script>
<!-- Custom script for all pages -->
<script src="{{ asset('site_assets/js/script.js') }}"></script>

<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Select2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>

<script>
    $(document).ready(function () {
         // تحميل المدن بناءً على المحافظة
        function loadCities(provinceId, citySelectId, areaSelectId) {
            const citySelect = $(citySelectId);
            const areaSelect = $(areaSelectId);

            citySelect.empty();
            areaSelect.empty();

            if (provinceId) {
                // blockUI على حقل المدينة
                citySelect.parent().block({
                    message: '<div class="spinner-border text-primary" role="status"></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.1,
                        cursor: 'wait'
                    }
                });

                $.ajax({
                    method: "POST",
                    url: '{{ url("/") }}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: provinceId, '_token': '{{ csrf_token() }}' },
                    success: function (data) {
                        citySelect.append(data.children);
                        citySelect.trigger('change.select2');
                    },
                    error: function () {
                        citySelect.append('<option value="">خطأ في تحميل المدن</option>');
                    },
                    complete: function () {
                        citySelect.parent().unblock();
                    }
                });
            }
        }

        // تحميل الأحياء بناءً على المدينة
        function loadAreas(cityId, areaSelectId) {
            const areaSelect = $(areaSelectId);
            areaSelect.empty();

            if (cityId) {
                // blockUI على حقل الحي
                areaSelect.parent().block({
                    message: '<div class="spinner-border text-primary" role="status"></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent'
                    },
                    overlayCSS: {
                        backgroundColor: '#000',
                        opacity: 0.1,
                        cursor: 'wait'
                    }
                });

                $.ajax({
                    method: "POST",
                    url: '{{ url("/") }}/lookups/get_children_by_parent',
                    dataType: 'json',
                    data: { id: cityId, '_token': '{{ csrf_token() }}' },
                    success: function (data) {
                        areaSelect.append(data.children);
                        areaSelect.trigger('change.select2');
                    },
                    error: function () {
                        areaSelect.append('<option value="">خطأ في تحميل الأحياء</option>');
                    },
                    complete: function () {
                        areaSelect.parent().unblock();
                    }
                });
            }
        }

        // عند تغيير المحافظة
        $(document).on("change", "select.location_province", function () {
            const province_id = $(this).val();
            const provinceId = $(this).attr('id');
            const suffix = provinceId.replace('province_', '');
            loadCities(province_id, '#location_cities_' + suffix, '#location_areas_' + suffix);
        });

        // عند تغيير المدينة
        $(document).on("change", "select.location_city", function () {
            const city_id = $(this).val();
            const cityId = $(this).attr('id');
            const suffix = cityId.replace('location_cities_', '');
            loadAreas(city_id, '#location_areas_' + suffix);
        });

    });
</script>

<script>
    // استهداف كل الحقول التي تحتوي على class "number_format"
    $('.number_format').on('input', function () {
        var value = $(this).val().replace(/[^0-9]/g, ''); // إزالة كل ما هو غير رقم
        if (value !== '') {
            $(this).val(Number(value).toLocaleString());
        } else {
            $(this).val('');
        }
    });
    document.addEventListener('DOMContentLoaded', function () {

        function formatNumberElement(el) {
            // جلب النص الداخلي بدون العلامة $
            let value = el.innerText.replace(/\$/g, '').replace(/,/g, '').replace(/\..*$/, '').replace(/\D/g, '');

            if (!value) {
                el.innerText = '';
                return;
            }

            // إضافة $ قبل الرقم المنسق
            el.innerText = '$' + new Intl.NumberFormat('en-US').format(value);
        }

        // تنسيق كل العناصر التي تحمل الكلاس number_format
        document.querySelectorAll('.number_format').forEach(el => {
            if (el.innerText) {
                formatNumberElement(el);
            }
        });

        loadNotifications();

        // عند فتح القائمة - تحميل الإشعارات داخل القائمة
        document.querySelector('[data-kt-menu-trigger]').addEventListener('click', function () {
            loadNotifications();
        });
        // Mark all as read
        $(document).on('click', '#mark-all-read', function () {
            fetch("{{ route('notifications.markAsRead') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                loadNotifications();
                fetchUnreadNotifications(); // إخفاء العدد
            });
        });
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('mark-as-read')) {
                const notificationId = e.target.dataset.id;
                fetch(`{{ url('/') }}/investors/notifications/mark-as-read/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            // Optional: remove the dot
                            e.target.remove();
                            loadNotifications();
                            fetchUnreadNotifications();
                        } else {
                            console.warn('❌ Failed to mark notification as read');
                        }
                    });
            }
        });
    });


    function fetchUnreadNotifications() {
        fetch("{{ route('notifications.unread') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById("unread-count").textContent = data.count;
            });
    }

    function loadNotifications() {
        fetch("{{ route('investors.notifications.list') }}")
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById("notification-list");
                list.innerHTML = ''; // تفريغ القائمة

                if (data.notifications.length === 0) {
                    list.insertAdjacentHTML('beforebegin', `
            <li class="dropdown-item text-center text-muted">لا توجد إشعارات جديدة</li>
        `);
                } else {
                    data.notifications.forEach(notification => {
                        const baseUrl = "{{ url('/') }}";
                        list.insertAdjacentHTML('beforebegin', `
                <li>
                <div class="dropdown-item d-flex justify-content-between align-items-center">
                  <a class="align-items-start" href="${baseUrl}${notification.data.url}">
                    <div style="font-size: 14px" class="fw-semibold ${notification.read_at != null ? 'text-muted' : ''}">
                      ${notification.data.message}
                      <p style="font-size: 10px" class="text-muted">${notification.created_at_human}</p>
                    </div>
                  </a>
                ${
                            notification.read_at === null
                                ? `<span class="mark-as-read badge bg-success rounded-circle p-25"
                                        style="cursor:pointer;
                                               margin-inline-start: 77%"
                                        data-id="${notification.id}">
                                        &nbsp;
                                   </span>`
                                : ''
                        }
                   <br>
                </div>
                </li>
                `);
                    });
                }

                // تحديث العداد بعد العرض
                fetchUnreadNotifications();
            });

    }

    function fetchUnreadNotifications() {
        fetch("{{ route('investors.notifications.unread') }}")
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById("unread-count");
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('d-none'); // ✅ التصحيح هنا
                } else {
                    badge.style.display = 'none';
                }
            });
    }

</script>
@yield('js')
