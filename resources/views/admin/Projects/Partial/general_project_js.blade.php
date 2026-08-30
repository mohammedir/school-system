<script>
    $(document).ready(function () {
        $(document).on('input', '#area', function () {
            const landArea = parseFloat($('#landArea').val());
            const projectArea = parseFloat($(this).val());
            const errorDiv = $('#area-error');

            if (projectArea > landArea) {
                errorDiv.removeClass('d-none');
                $(this).addClass('is-invalid');
            } else {
                errorDiv.addClass('d-none');
                $(this).removeClass('is-invalid');
            }
        });


    });
</script>

