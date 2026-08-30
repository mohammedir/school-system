<script>
    $(document).ready(function () {
        let table = $("#investor_table_my_wallet").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('investors.dashboard.wallet.deposit_requests') }}",
                data: function (d) {
                    d.province_cd = $('#amount').val();
                }
            },
            columns: [
                { data: 'amount', name: 'amount' },
                { data: 'payment_date', name: 'payment_date' },
                { data: 'payment_method_cd', name: 'payment_method_cd' },
                { data: 'bank_name', name: 'bank_name' },
                { data: 'deposit_request_status_cd', name: 'deposit_request_status_cd' },
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

            document.getElementById('depositForm').addEventListener('submit', function (e) {
            e.preventDefault(); // أولاً منع الإرسال بشكل افتراضي
            let isValid = true;

            // مسح رسائل الأخطاء القديمة
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

            // التحقق من الحقول المطلوبة
            const requiredFields = [
        {id: 'amount', message: 'هذا الحقل مطلوب'},
        {id: 'payment_date', message: 'هذا الحقل مطلوب'},
        {id: 'payment_method_cd', message: 'يرجى اختيار طريقة الدفع'},
        {id: 'bank_name', message: 'اسم البنك مطلوب'},
        {id: 'reference_number', message: 'الرقم المرجعي مطلوب'},
        {id: 'payment_proof', message: 'صورة الوصل مطلوبة'},
            ];

            requiredFields.forEach(field => {
            const input = document.getElementById(field.id);

            // التعامل مع input من نوع file
            if (input && input.type === 'file') {
            if (input.files.length === 0) {
            isValid = false;
            input.nextElementSibling.textContent = field.message;
        }
        } else if (input && !input.value.trim()) {
            isValid = false;
            input.nextElementSibling.textContent = field.message;
        }
        });

            if (isValid) {
            // تعطيل الزر حتى لا يتم الضغط مرتين
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = "جاري الإرسال...";

            // إرسال الفورم بعد التأكد
            this.submit();
        }
        });

    });


</script>
