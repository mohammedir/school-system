<div class="modal fade" id="kt_modal_contractor_award_offer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">

            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
            </div>

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">

                <form id="kt_form_award_offer" method="POST" action="javascript:;">
                    @csrf
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    <input type="hidden" name="project_id" value="{{ $offer->project_id }}">
                    <!--begin::Heading-->
                    <div class="text-center mb-13">
                        <h1 class="mb-3">ترسية العرض</h1>
                    </div>
                    <!--end::Heading-->

                    <!--begin::Details-->
                    <div class="mb-10">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold"> المقاول:</label>
                                <div class="form-control bg-light">{{ $offer->contractor->company_name }}</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">السعر:</label>
                                <div class="form-control bg-light">{{ number_format($offer->total_price) }} $</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">مدة التنفيذ:</label>
                                <div class="form-control bg-light">{{ $offer->duration }} يوم</div>
                            </div>
                        </div>


                        <div class="mb-4">
                            <div class="fv-row mb-8">
                                <label class=" fw-semibold fs-6 mb-2">سبب الترسية</label>
                                <!--begin::Email-->
                                <div class="form-control bg-light" rows="4">{{ $project->awarded_contractor_reasons }} </div>


                                <!--end::Email-->
                            </div>
                        </div>
                    </div>
                    <!--end::Details-->

                    <!--begin::Buttons-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info btn-outline me-5" id="award_submit_btn">
                            <span class="indicator-label"><i class="fa fa-award me-2"></i> اعتماد الترسية</span>
                            <span class="indicator-progress" style="display:none;">الرجاء الانتظار...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
                        </button>
                        <button type="button" class="btn btn-secondary btn-outline me-2" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> @lang('admin.Discard')</button>
                    </div>
                    <!--end::Buttons-->

                </form>
            </div>

        </div>
    </div>
</div>

