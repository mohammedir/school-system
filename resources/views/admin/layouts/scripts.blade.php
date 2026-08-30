<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-document.bundle.js') }}"></script>

<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
{{--<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>--}}
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
<!--end::Custom Javascript-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function formatNumberInput(input) {
            let value = input.value.replace(/,/g, '').replace(/\..*$/, '').replace(/\D/g, '');
            if (!value) {
                input.value = '';
                return;
            }
            input.value = new Intl.NumberFormat('en-US').format(value);
        }

        function applyNumberFormatting() {
            document.querySelectorAll('.number_format').forEach(input => {
                formatNumberInput(input);
                input.addEventListener('input', function () {
                    formatNumberInput(this);
                });
            });
        }

        applyNumberFormatting();

        const modals = document.getElementsByClassName('modal');

        Array.from(modals).forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                applyNumberFormatting();
            });
        });

    });
</script>

<script>
    document.getElementById('kt_app_sidebar_secondary_toggle').addEventListener('click', function () {
        const sidebar = document.querySelector('.app-sidebar');
        sidebar.classList.toggle('collapsed');
    });
</script>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<audio id="notification-sound" src="{{ asset('assets/sounds/ringtone-you-would-be-glad-to-know.ogg') }}" preload="auto"></audio>
<script>

    document.addEventListener('DOMContentLoaded', function () {

        // ✅ إعداد Pusher
        Pusher.logToConsole = true;

        var pusher = new Pusher('4f720a87f83e58f6d217', {
            cluster: 'ap2',
            authEndpoint: '{{ url('/') }}/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
        console.log('Auth endpoint:', '{{ url('/') }}/broadcasting/auth');

        var channel = pusher.subscribe('private-App.Models.User.{{ auth()->id() }}');

        channel.bind('my-event', function (data) {
            toastr.success(data.message, '🔔 إشعار جديد');
            const sound = document.getElementById('notification-sound');
            fetchUnreadNotifications();
            loadNotifications();
            if (sound) {
                try {
                    sound.pause();
                    sound.currentTime = 0;
                    sound.play().then(() => {
                        console.log('✅ تم تشغيل الصوت بنجاح');
                    }).catch((err) => {
                        console.warn('🔇 المتصفح منع تشغيل الصوت:', err);
                    });
                } catch (error) {
                    console.error('❌ خطأ أثناء تشغيل الصوت:', error);
                }
            }

        });

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
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

                fetch(`{{ url('/') }}/notifications/mark-as-read/${notificationId}`, {
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
        fetch("{{ route('notifications.list') }}")
            .then(response => response.json())
            .then(data => {
                const list = document.getElementById("notification-list");
                list.innerHTML = ''; // تفريغ القائمة

                if (data.notifications.length === 0) {
                    list.innerHTML = '<li class="text-center text-muted">لا توجد إشعارات جديدة</li>';
                }

                data.notifications.forEach(notification => {
                    const li = document.createElement("li");
                    li.className = "d-flex flex-stack py-4 border-bottom";
                    li.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-35px me-4">
                            <span class="symbol-label bg-light-info">
                                <i class="ki-outline ki-message-text fs-2 text-info"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="${notification.data.url}"><span class="fw-semibold ${notification.read_at != null
                                                ?`text-gray-600` : ''}">${notification.data.message}</span></a>
                            <span class="text-muted fs-8">${notification.created_at_human}</span>
                        </div>
                    </div>
                    ${
                        notification.read_at === null
                            ? `<span class="badge bg-info rounded-circle ms-3 mark-as-read" data-id="${notification.id}"
                                style="width: 10px; height: 10px; cursor: pointer;"> </span>`
                            : ''
                    }

                `;
                    list.appendChild(li);
                });

                // بعد العرض، نحدث العداد
                fetchUnreadNotifications();
            });
    }
    function fetchUnreadNotifications() {
        fetch("{{ route('notifications.unread') }}")
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById("unread-count");
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-flex';
                } else {
                    badge.style.display = 'none';
                }
            });
    }

   /* document.querySelector('[data-kt-menu-trigger]').addEventListener('click', function () {
        // إرسال طلب لتحديث كل الإشعارات كمقروء
        fetch("{{ route('notifications.markAsRead') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => {
            fetchUnreadNotifications(); // إخفاء العدد
        });
    });*/

    document.querySelectorAll('.my-datepicker').forEach(function(element) {
        new tempusDominus.TempusDominus(element, {
            display: {
                components: {
                    clock: false
                }
            },
            localization: {
                locale: 'ar',
                format: 'yyyy-MM-dd'
            }
        });
    });

    $(document).on('click', '.view.blade.php-notes', function() {
        const content = $(this).data('notes');
        $('#notesModal .modal-body').html(content);
        $('#notesModal').modal('show');
    });
</script>

@yield('js')
