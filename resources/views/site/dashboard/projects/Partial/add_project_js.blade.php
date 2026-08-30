<script>
    document.getElementById('project_logo').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview_project_logo');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.number_format').forEach(function (input) {
            let value = input.value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            input.value = value;
        });
            let editorInstance;

            DecoupledEditor
            .create(document.querySelector('.kt_docs_ckeditor_document'), {
            removePlugins: ['Image', 'ImageUpload', 'MediaEmbed', 'EasyImage', 'CKFinder', 'Table'], // إزالة الميديا
            height: '120px', // تقريبًا 3 أسطر
            language: 'ar',
        })
            .then(editor => {
            editorInstance = editor;

            const toolbarContainer = document.querySelector('.kt_docs_ckeditor_document_toolbar');
            toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        })
            .catch(error => {
            console.error(error);
        });


        const form = document.querySelector('#investors_add_project_form');
        const submitBtn = document.querySelector('#submitBtn');
        const btnSpinner = document.querySelector('#btnSpinner');
        const areaInput = document.querySelector('#area');
        const landArea = {{ @$land->area }}; // مساحة الأرض من السيرفر
        const errorDiv = document.getElementById('area-error');
        const landAreaNote = document.getElementById('land_area_note');
        const investorBalance = {{ $investor_balance }}; // قيمة الرصيد من PHP
        const projectCostInput = document.getElementById('project_cost');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            let areaVal = parseFloat(areaInput.value);
            // تنظيف قيمة التكلفة من أي فواصل
            const projectCostValue = projectCostInput.value.replace(/,/g, '');
            const projectCost = parseFloat(projectCostValue);

            // حساب 10% من تكلفة المشروع
            const requiredBalance = projectCost * 0.1;
            // التحقق إذا كان الرصيد كافي
            if (investorBalance < requiredBalance) {
                const currencySymbol = '{{ getSettings()->currency_symbol }}';
                const shortage = requiredBalance - investorBalance;

                // عرض رسالة SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: '@lang("admin.Insufficient balance")',
                    html: `@lang("admin.Your balance is insufficient for this project")!<br><br>
                  <table style="margin: 0 auto;">
                    <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Project cost"):</td><td style="text-align: left;">${projectCost.toLocaleString()} ${currencySymbol}</td></tr>
                    <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Required 10%"):</td><td style="text-align: left;">${requiredBalance.toLocaleString()} ${currencySymbol}</td></tr>
                    <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Current balance"):</td><td style="text-align: left;">${investorBalance.toLocaleString()} ${currencySymbol}</td></tr>
                    <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Shortage amount"):</td><td style="text-align: left;">${shortage.toLocaleString()} ${currencySymbol}</td></tr>
                    <tr><td style="text-align: right; padding-right: 10px;">@lang("admin.Please charge the wallet with an amount"):</td><td style="text-align: left;">${shortage.toLocaleString()} ${currencySymbol}</td></tr>
                  </table>`,
                    confirmButtonText: '@lang("admin.OK")',
                    confirmButtonColor: '#3085d6',
                });

                // إعادة تمكين الزر وإخفاء السبينر
                submitBtn.disabled = false;
                btnSpinner.classList.add('d-none');
                return; // إيقاف التنفيذ

            }
            if (editorInstance) {
                // تحديث textarea المخفية
                document.querySelector('textarea[name="description"]').value = editorInstance.getData();
            }
            // تحقق من أن مساحة المشروع <= مساحة الأرض
            if (isNaN(areaVal) || areaVal > landArea) {
                e.preventDefault(); // منع الإرسال
                errorDiv.classList.remove('d-none');
                landAreaNote.innerText = landArea;
                submitBtn.disabled = false;
                btnSpinner.classList.add('d-none');
                return;
            } else {
                errorDiv.classList.add('d-none');
            }
            // عند اجتياز التحقق، يتم تعطيل الزر وتشغيل السبينر
            submitBtn.disabled = true;
            btnSpinner.classList.remove('d-none');
            // إذا اجتاز جميع التحققات، يتم إرسال النموذج
            this.submit();
        });


    });
</script>
