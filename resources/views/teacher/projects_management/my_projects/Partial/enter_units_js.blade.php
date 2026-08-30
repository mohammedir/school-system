<script>
    $(document).ready(function () {

        // Initialize select2
    $('select[name="project_id"]').select2();

    // Handle change
    $('select[name="project_id"]').on('change', function () {
        var project_id = $(this).val();
        if (project_id) {
            $.ajax({
                url: '{{ route("engineering.my_projects.getProjectsDetails") }}', // Use a named route
                type: 'GET',
                data: { id: project_id },
                success: function (response) {
                    console.log(response)
                    $('#project_details').html(response).fadeIn();
                },
                error: function () {
                    $('#project_details').html('<div class="alert alert-danger">Error loading data.</div>').fadeIn();
                }
            });
        } else {
            $('#investor_details').fadeOut().html('');
        }
    });

    $('select[name="project_id"]').trigger('change');

        const submitButton = document.getElementById('valuation-submit');
        const normalSubmit = document.getElementById('normal-submit');
        const form = submitButton.closest('form');
        const hiddenActionInput = document.getElementById('hidden-action');


        submitButton.addEventListener('click', function (e) {
            let isValid = true;
            const floorWrappers = document.querySelectorAll('.floor-wrapper');
            var floorCount = $('#floors-repeater .floor-wrapper').length;

            floorWrappers.forEach((floor, index) => {
                if (!floor.offsetParent) {
                    return;
                }
                const units = floor.querySelectorAll('.unit-wrapper');
                if (units.length === 0) {
                    isValid = false;
                    // إضافة تحذير بصري للمستخدم
                    floor.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    floor.classList.add('border', 'border-danger');

                    // يمكن عرض رسالة toastr أو SweetAlert:
                    toastr.error(`الطابق رقم ${index + 1} لا يحتوي على وحدات. الرجاء إضافة وحدة واحدة على الأقل.`);
                } else {
                    // إزالة أي تنبيه سابق
                    floor.classList.remove('border', 'border-danger');
                }
            });

            if (!isValid) {
                e.preventDefault(); // إلغاء الإرسال
            }else{
                e.preventDefault();
                if (floorCount === 0) {
                    e.preventDefault(); // منع الإرسال
                    Swal.fire({
                        title: 'تنبيه',
                        text: 'يجب إضافة طابق واحد على الأقل قبل حفظ البيانات.',
                        icon: 'info', // أو استخدم 'warning' إذا أردت
                        confirmButtonText: 'حسنًا',
                        showCancelButton: false,
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        customClass: {
                            confirmButton: 'mx-auto' // لجعل الزر في المنتصف
                        }
                    }).then(() => {
                        // تنفيذ الكود بعد الضغط على زر "حسنًا"
                        submitButton.removeAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = false;
                    });

                }else {
                    Swal.fire({
                        title: 'تأكيد الإرسال',
                        text: 'هل أنت متأكد أنك تريد إرسال البيانات للتثمين؟' +
                            'علماً انه عند الارسال لن تتمكن من التعديل على الوحدات مرة اخرى',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، أرسل',
                        cancelButtonText: 'إلغاء'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hiddenActionInput.value = submitButton.value;
                            // إظهار مؤشّر التحميل
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // تعطيل الزر لتفادي الضغط المتكرر
                            submitButton.disabled = true;

                            form.requestSubmit();

                            submitButton.removeAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = false;
                        }
                    });
                }
            }

        });
        normalSubmit.addEventListener('click', function (e) {
            e.preventDefault();

            var floorCount = $('#floors-repeater .floor-wrapper').length;


            // إظهار مؤشّر التحميل
            normalSubmit.setAttribute('data-kt-indicator', 'on');
            // تعطيل الزر لتفادي الضغط المتكرر
            normalSubmit.disabled = true;
            if (floorCount === 0) {
                e.preventDefault(); // منع الإرسال
                Swal.fire({
                    title: 'تنبيه',
                    text: 'يجب إضافة طابق واحد على الأقل قبل حفظ البيانات.',
                    icon: 'info', // أو استخدم 'warning' إذا أردت
                    confirmButtonText: 'حسنًا',
                    showCancelButton: false,
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    customClass: {
                        confirmButton: 'mx-auto' // لجعل الزر في المنتصف
                    }
                }).then(() => {
                    // تنفيذ الكود بعد الضغط على زر "حسنًا"
                    normalSubmit.removeAttribute('data-kt-indicator', 'on');
                    normalSubmit.disabled = false;
                });

            }else {
                // إرسال الفورم يدويًا
                form.requestSubmit();
                // تنفيذ الكود بعد الضغط على زر "حسنًا"
                normalSubmit.removeAttribute('data-kt-indicator', 'on');
                normalSubmit.disabled = false;

            }
        });

            // استخدم الـ name أو attribute selector للوصول إلى جميع مكونات الصور
            document.querySelectorAll('input[type="file"][name^="floors"]').forEach(function (input) {
                input.addEventListener('change', function (event) {
                    const file = event.target.files[0];

                    if (file) {
                        const maxSize = 2 * 1024 * 1024; // 3MB in bytes

                        if (file.size > maxSize) {
                            alert('حجم الصورة يجب أن لا يتجاوز 2 ميغابايت (2MB)');
                            event.target.value = ''; // مسح الملف المختار
                        }
                    }
                });
            });

    });

    $('#floors_repeater').repeater({
        initEmpty: true,
        show: function () {
            $(this).slideDown();
            // تهيئة الـ nested داخل كل floor
            $(this).find('.units-repeater').each(function () {
                $(this).repeater({
                    initEmpty: true,
                    show: function () {
                        $(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
            });
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });






</script>
