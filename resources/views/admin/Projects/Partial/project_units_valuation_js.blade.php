<script>

    $(document).ready(function () {

        function unformatNumber(str) {
            return str.replace(/[^0-9.-]/g, '');
        }

        let totalInputs = 0;
        $('.valuation_price_input').each(function () {
            let val = parseInt(unformatNumber($(this).val().trim()) || 0, 10);
            if (!isNaN(val)) totalInputs += val;
        });

        let projectCostRaw = unformatNumber($('#project_cost').text().trim());
        let projectCost = parseInt(projectCostRaw, 10);

        let remaining = projectCost - totalInputs;

        $('#remaining_project_cost').text(remaining.toLocaleString() + ' $');

        // تحديث المتبقي
        document.getElementById('remaining_project_cost').textContent = formatNumberWithCommas(remaining) + ' $';




        const submitButton = document.getElementById('valuation-price-approve');
        const form = submitButton.closest('form');
        const hiddenActionInput = document.getElementById('hidden-action');

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            const priceInputs = form.querySelectorAll('.valuation_price_input');
            let allFilled = true;

            priceInputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                e.preventDefault(); // امنع الإرسال
                Swal.fire({
                    title: 'تنبيه',
                    text: '⚠️ الرجاء إدخال سعر التثمين لجميع الوحدات قبل الاعتماد.',
                    icon: 'info',
                    confirmButtonText: 'حسنًا',
                    showCancelButton: false,
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    customClass: {
                        confirmButton: 'mx-auto'
                    }
                })
            }else {
                let rawValue = document.getElementById("remaining_project_cost").innerText;
                let numericValue = parseFloat(rawValue.replace(/[^0-9.]/g, "")); // يحذف كل شيء غير الأرقام والنقطة

                if (numericValue === 0) {
                    Swal.fire({
                        title: 'تأكيد الإرسال',
                        text: 'هل أنت متأكد أنك تريد اعتماد التثمين للوحدات؟' +
                            'علماً انه عند الارسال لن تتمكن من التعديل على الوحدات مرة اخرى',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، أرسل',
                        cancelButtonText: 'إلغاء'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hiddenActionInput.value = submitButton.value;

                            form.submit();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'القيمة المتبقية ليست صفر',
                        text: 'يجب أن تكون القيمة المتبقية للتثمين صفر قبل إرسال التثمين',
                        icon: 'warning',
                        confirmButtonText: 'حسناً'
                    });
                }


            }
        });


        const $input = $('input[name="project_id"]');

        function loadProjectDetails(project_id) {
            if (project_id) {
                $.ajax({
                    url: '{{ route("projects.getProjectsDetails") }}',
                    type: 'GET',
                    data: { id: project_id },
                    success: function (response) {
                        console.log(response);
                        $('#project_details').html(response).fadeIn();
                    },
                    error: function () {
                        $('#project_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                    }
                });
            } else {
                $('#project_details').fadeOut().html('');
            }
        }

        // Handle ENTER press
        $input.on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                loadProjectDetails($(this).val());
            }
        });

        // Also handle blur (when user leaves the field)
        $input.on('blur', function () {
            loadProjectDetails($(this).val());
        });

        // Optionally: Load initially if value is pre-filled
        if ($input.val()) {
            loadProjectDetails($input.val());
        }



        // رقم إلى نص بفواصل
        function formatNumberWithCommas(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // إزالة الفواصل
        function unformatNumber(str) {
            return str.replace(/,/g, '');
        }

        function formatNumberWithCommas(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // التحقق عند ترك الحقل
        document.querySelectorAll('.valuation_price_input').forEach(function(input) {
            // تنسيق القيمة الموجودة عند تحميل الصفحة
            const rawValue = input.value.trim().replace(/,/g, '');
            if (rawValue !== '' && !isNaN(rawValue)) {
                const formatted = formatNumberWithCommas(parseInt(rawValue, 10));
                input.value = formatted;
            }

            // عند فقدان التركيز
            input.addEventListener('blur', function() {
                let raw = unformatNumber(input.value.trim());
                if (raw === '') return;

                let value = parseInt(raw, 10);

                // التحقق من مضاعفات الألف
                if (isNaN(value) || value % 1000 !== 0) {
                    Swal.fire({
                        title: 'تنبيه',
                        text: '⚠️ يجب أن يكون المبلغ من مضاعفات الألف.',
                        icon: 'info',
                        confirmButtonText: 'حسنًا'
                    });
                    input.value = '';
                    input.focus();
                    return;
                }

                // جمع جميع القيم المدخلة
                let totalInputs = 0;
                document.querySelectorAll('.valuation_price_input').forEach(function(inp) {
                    let val = parseInt(unformatNumber(inp.value.trim()) || 0, 10);
                    if (!isNaN(val)) totalInputs += val;
                });

                // جلب قيمة المشروع الكلية
                let projectCostRaw = unformatNumber(document.getElementById('project_cost').textContent.trim());
                let projectCost = parseInt(projectCostRaw, 10);

                // حساب القيمة المتبقية
                let remaining = projectCost - totalInputs;

                if (remaining < 0) {
                    Swal.fire({
                        title: 'تنبيه',
                        text: '❌ لا يوجد مبلغ كافٍ لإتمام العملية.',
                        icon: 'warning',
                        confirmButtonText: 'حسنًا'
                    });
                    input.value = '';
                    input.focus();
                    return;
                }

                // تحديث المتبقي
                document.getElementById('remaining_project_cost').textContent = formatNumberWithCommas(remaining) + ' $';

                // إعادة تنسيق الحقل الحالي
                input.value = formatNumberWithCommas(value);
            });

            // عند التركيز على الحقل، إزالة الفواصل
            input.addEventListener('focus', function() {
                this.value = unformatNumber(this.value.trim());
            });
        });

        // التحقق عند الإرسال
        document.querySelector('form').addEventListener('submit', function(e) {
            let hasError = false;
            document.querySelectorAll('.valuation_price_input').forEach(function(input) {
                let raw = unformatNumber(input.value.trim());
                if (raw !== '') {
                    let value = parseInt(raw, 10);
                    if (isNaN(value) || value % 1000 !== 0) {
                        hasError = true;
                        alert('⚠️ تأكد أن كل المبالغ من مضاعفات الألف.');
                        input.focus();
                        e.preventDefault();
                        return false;
                    }
                }
            });
            if (hasError) e.preventDefault();
        });

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
