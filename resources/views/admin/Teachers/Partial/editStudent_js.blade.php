<script>
    $(document).ready(function () {
        // دالة لتحميل الفصول بناءً على age_group
        function loadClasses(ageGroupId, selectedClassId = null) {
            var classSelect = $('#class');

            // تعطيل الـ select أثناء التحميل
            classSelect.prop('disabled', true);
            classSelect.html('<option value="" disabled selected>@lang("admin.Loading")...</option>');

            if (ageGroupId) {
                $.ajax({
                    url: '{{ route("students.get.classes.by.age.group") }}',
                    type: 'GET',
                    data: {
                        age_group_id: ageGroupId
                    },
                    success: function(response) {
                        classSelect.prop('disabled', false);
                        classSelect.html('<option value="" disabled>@lang("admin.Select")</option>');

                        if (response.data && response.data.length > 0) {
                            $.each(response.data, function(key, value) {
                                var option = '<option value="' + value.id + '"';
                                // تحديد القيمة المحفوظة إذا تطابقت
                                if (selectedClassId && value.id == selectedClassId) {
                                    option += ' selected';
                                }
                                option += '>' + value.name_ar + '</option>';
                                classSelect.append(option);
                            });
                        } else {
                            classSelect.append('<option value="" disabled>@lang("admin.No classes found")</option>');
                        }

                        // تحديث Select2
                        classSelect.trigger('change');
                    },
                    error: function(xhr) {
                        classSelect.prop('disabled', false);
                        classSelect.html('<option value="" disabled selected>@lang("admin.Error loading data")</option>');
                        classSelect.trigger('change');
                    }
                });
            } else {
                classSelect.prop('disabled', false);
                classSelect.html('<option value="" disabled selected>@lang("admin.Select")</option>');
                classSelect.trigger('change');
            }
        }

        // عند تغيير age_group
        $('#age_group').on('change', function() {
            var ageGroupId = $(this).val();
            loadClasses(ageGroupId);
        });

        // عند تحميل الصفحة: تحميل الفصول وتحديد القيمة المحفوظة للطالب
        var initialAgeGroup = $('#age_group').val();
        var initialClass = '{{ $student->class ?? '' }}'; // القيمة المحفوظة

        if (initialAgeGroup) {
            loadClasses(initialAgeGroup, initialClass);
        }


        // التحكم في إظهار/إخفاء حقل وصف الحالة الصحية
        function toggleHealthStatusDescription() {
            var healthStatus = $('#health_status').val();
            if (healthStatus === 'special_needs' || healthStatus === 'chronic_disease') {
                $('#health_status_description_container').show('slow');
                $('#health_status_description').prop('required', true);
            } else {
                $('#health_status_description_container').hide('slow');
                $('#health_status_description').prop('required', false);
                $('#health_status_description').val(''); // مسح القيمة عند الإخفاء
            }
        }

        // استدعاء الدالة عند تغيير قيمة الحقل
        $('#health_status').on('change', function() {
            toggleHealthStatusDescription();
        });

        // استدعاء الدالة عند تحميل الصفحة للتأكد من الحالة الابتدائية
        toggleHealthStatusDescription();

    });
</script>


