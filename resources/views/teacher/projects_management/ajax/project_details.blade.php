<div class="d-flex align-items-center mb-6 ml-10">
    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $projects->title }}</a>
    <a href="#">
        <i class="ki-outline ki-verify fs-1 text-primary"></i>
    </a>
</div>
<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Engineering Description')</label>
        <div class="text-muted">
            {!! htmlspecialchars_decode($projects->engineering_consultant_description) !!}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Project type')</label>
        <div class="text-muted">
            {{getlookup($projects->project_type_cd)->name_ar ?? '-'}}
        </div>
    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Project space')</label>
        <div class="text-muted">
            {{$projects->area}}
            <span>م2</span>
        </div>

    </div>
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Project cost')</label>
        <div class="text-muted number_format">
            {{ number_format($projects->project_cost, 2) }}
            <span>{{getSettings()->currency_symbol}}</span>
        </div>
    </div>

</div>

{{--<div class="fv-row row mb-15">
    <div class="col-md-3 mb-5">
        <label class="form-label d-block">@lang('admin.Province')</label>
        <div class="text-muted">{{ getlookup($projects->project_type_cd)->{"name_".app()->getLocale()} ?? '-' }}</div>
    </div>

</div>--}}
