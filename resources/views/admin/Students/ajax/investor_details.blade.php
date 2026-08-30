<div class="d-flex align-items-center mb-6 ml-10">
    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $investor->full_name }}</a>
    <a href="#">
        <i class="ki-outline ki-verify fs-1 text-primary"></i>
    </a>
</div>
<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Mobile number')</label>
        <div class="text-muted">{{ $investor->mobile }}</div>
    </div>

    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Email')</label>
        <div class="text-muted">{{ $investor->email }}</div>
    </div>

    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.The condition')</label>
        <div class="text-muted">{{ getlookup($investor->status_cd)->{"name_".app()->getLocale()} ?? '-' }}</div>
    </div>

    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Registration Date')</label>
        <div class="text-muted">{{ $investor->created_at ? $investor->created_at->format('Y-m-d') : '' }}</div>
    </div>
</div>

<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Province')</label>
        <div class="text-muted">{{ getlookup($investor->province_cd)->{"name_".app()->getLocale()} ?? '-' }}</div>
    </div>

    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.City')</label>
        <div class="text-muted">{{ getlookup($investor->city_cd)->{"name_".app()->getLocale()} ?? '-' }}</div>
    </div>

    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.District')</label>
        <div class="text-muted">{{ getlookup($investor->district_cd)->{"name_".app()->getLocale()} ?? '-' }}</div>
    </div>

    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Address in detail')</label>
        <div class="text-muted">{{ $investor->address }}</div>
    </div>
</div>
