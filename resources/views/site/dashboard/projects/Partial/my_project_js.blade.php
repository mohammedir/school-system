<script>
    $(document).on('click', '.show-award-modal', function () {
        var offerId = $(this).data('offer-id');
        var projectId = $(this).data('project-id');


        $.ajax({
            url: '{{ route('investors.project.award_modal', '') }}/' + offerId,
            method: 'GET',
            beforeSend: function () {
                $('#awardModalWrapper').html('<div class="text-center p-5">جارٍ التحميل...</div>');
            },
            success: function (response) {
                $('#awardModalWrapper').html(response);

                const modal = $('#kt_modal_award_offer');

                modal.attr('data-project-id', projectId);
                modal.attr('data-offer-id', offerId);

                setTimeout(() => {
                    modal.modal('show');
                }, 100);
            },
            error: function () {
                $('#awardModalWrapper').html('<div class="text-danger p-5">فشل تحميل المودال</div>');
            }
        });
    });
    $(document).on('click', '.show-contractor-award-modal', function () {
        var contractorOfferId = $(this).data('contractor-offer-id');
        var projectId = $(this).data('project-id');


        $.ajax({
            url: '{{ route('investors.project.contractor_award_modal', '') }}/' + contractorOfferId,
            method: 'GET',
            beforeSend: function () {
                $('#awardModalWrapper').html('<div class="text-center p-5">جارٍ التحميل...</div>');
            },
            success: function (response) {
                $('#awardModalWrapper').html(response);

                const modal = $('#kt_modal_contractor_award_offer');

                modal.attr('data-project-id', projectId);
                modal.attr('data-offer-id', contractorOfferId);

                setTimeout(() => {
                    modal.modal('show');
                }, 100);
            },
            error: function () {
                $('#awardModalWrapper').html('<div class="text-danger p-5">فشل تحميل المودال</div>');
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        $(document).on('shown.bs.modal', '#kt_modal_award_offer', function () {
            const form = document.getElementById('kt_form_award_offer');
            const submitBtn = document.getElementById('award_submit_btn');
            const indicatorLabel = submitBtn.querySelector('.indicator-label');
            const indicatorProgress = submitBtn.querySelector('.indicator-progress');
            const modal = $('#kt_modal_award_offer');


                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                            submitBtn.disabled = true;
                            indicatorLabel.style.display = 'none';
                            indicatorProgress.style.display = 'inline-block';

                            const formData = new FormData(form);

                            // ✅ استخرج الـ ID بعد عرض المودال
                    const offerId = form.querySelector('input[name="offer_id"]').value;
                            const url = `{{ url('/investors/projects/award-approval-offer') }}/${offerId}`;

                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function (res) {
                                    toastr.success(res.message || 'تم تنفيذ الترسية بنجاح');
                                    modal.modal('hide');
                                    window.location.href = '{{ route('investors.dashboard.my_projects') }}';

                                },
                                error: function (xhr) {
                                    toastr.error('حدث خطأ أثناء تنفيذ الترسية');
                                    console.error(xhr);
                                },
                                complete: function () {
                                    submitBtn.disabled = false;
                                    indicatorLabel.style.display = 'inline-block';
                                    indicatorProgress.style.display = 'none';
                                }
                            });
                });

        });
        // للمودال الثاني (المقاول)
        $(document).on('shown.bs.modal', '#kt_modal_contractor_award_offer', function () {
            const contractor_form = document.getElementById('kt_form_contractor_award_offer');
            const contractorSubmitBtn = document.getElementById('contractor_award_submit_btn');
            const contractorIndicatorLabel = contractorSubmitBtn.querySelector('.indicator-label');
            const contractorIndicatorProgress = contractorSubmitBtn.querySelector('.indicator-progress');
            const contractorModal = $('#kt_modal_contractor_award_offer');

            contractor_form.addEventListener('submit', function (e) {
                e.preventDefault();
                contractorSubmitBtn.disabled = true;
                contractorIndicatorLabel.style.display = 'none';
                contractorIndicatorProgress.style.display = 'inline-block';

                const formData = new FormData(contractor_form);
                const offerId = contractor_form.querySelector('input[name="offer_id"]').value;
                const url = `{{ url('/investors/projects/contractor-award-approval-offer') }}/${offerId}`;

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        toastr.success(res.message || 'تم تنفيذ الترسية بنجاح');
                        contractorModal.modal('hide');
                        window.location.href = '{{ route('investors.dashboard.my_projects') }}';
                    },
                    error: function (xhr) {
                        toastr.error('حدث خطأ أثناء تنفيذ الترسية');
                        console.error(xhr);
                    },
                    complete: function () {
                        contractorSubmitBtn.disabled = false;
                        contractorIndicatorLabel.style.display = 'inline-block';
                        contractorIndicatorProgress.style.display = 'none';
                    }
                });
            });
        });
    });

</script>
