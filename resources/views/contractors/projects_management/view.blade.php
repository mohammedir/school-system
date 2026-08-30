@extends('contractors.layouts.master')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('contractors.Submit a quote')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="index.html" class="text-gray-600 text-hover-primary">@lang('admin.Home')</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Projects')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Project View')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('contractors.Submit a quote')</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Container-->
    <div id="kt_content_container_project" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">

                <!--begin::Card - Land Info-->
                <div class="card card-flush mt-5">
                    <!--begin::Card header-->
                    <div class="card-header pt-8">
                        <!--begin::Col-->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center gap-2">
                                <!--begin::Input-->
                                <h3>@lang('admin.Project data')</h3>
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Form-->
                        <div class="row g-4 mb-15">
                            <div class="col-md-4 fv-row">
                                <label class="form-label">@lang('admin.Project type')</label>
                                <select disabled name="project_type_cd" class="form-select" data-control="select2" data-placeholder="@lang('admin.Project type')">
                                    <option>{{getlookup($project->project_type_cd)->{'name_' . app()->getLocale()} }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 fv-row">
                                <label class="form-label">@lang('admin.Project space')</label>
                                <div class="input-group">
                                    <input disabled class="form-control text-start" value="{{$project->area}}" id="area" name="area" type="number" placeholder="@lang('admin.Enter the area')">
                                    <span class="input-group-text">م2</span>
                                </div>
                            </div>
                            <div class="col-md-4 fv-row">
                                <label class="form-label">@lang('admin.Project cost')</label>
                                <div class="input-group">
                                    <input disabled class="form-control text-start number_format" id="project_cost" value="{{$project->project_cost}}" name="project_cost" type="text" placeholder="@lang('admin.Enter The project cost')">
                                    <span class="input-group-text">$</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-15">
                            <div class="col-md-6 fv-row">
                                <label disabled class="form-label">@lang('admin.Project name')</label>
                                <input disabled class="form-control" name="title" value="{{$project->title}}">
                            </div>
                        </div>

                            <div class="row g-4 mb-15">
                                <div class="col-md-12 fv-row">
                                    <label class="form-label mb-5">@lang('admin.Engineering Description')</label>
                                    <div class="border border-dashed border-gray-600 rounded min-w-700px p-5">
                                        {!! htmlspecialchars_decode($project->engineering_consultant_description) !!}
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <!--begin::Card-->
                            <div class="card card-flush mt-5">
                                <div class="card-header pt-8">
                                    <h5>📑 عرض الوحدات </h5>
                                </div>
                                <div class="card-body">
                                    <div class="wrapper">
                                        <div class="content-wrapper">
                                            <div id="floors-repeater">
                                                @foreach($floors as $floorIndex => $floor)
                                                    <div class="card mb-5 shadow-sm floor-wrapper">
                                                        <div class="card-header d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-0 floor-number">🗂️ {{$floor->description}} </h5>
                                                            <div>
                                                                <button type="button" class="btn btn-sm btn-secondary toggle-collapse">⯆</button>
                                                            </div>
                                                        </div>
                                                        <div class="collapse show card-collapse">
                                                            <div class="card-body">
                                                                <div class="col-md-2 fv-row mb-3">
                                                                    {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                                                    <!--begin::Image placeholder-->
                                                                    <style>.image-input-placeholder { background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}"); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                                                    <!--end::Image placeholder-->
                                                                    <!--begin::Image input-->
                                                                    <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                                        <div class="image-input-wrapper w-700px h-350px" style="background-image: url({{asset('/uploads/projects/' . $floor->image)}});"></div>
                                                                        <!--end::Preview existing avatar-->
                                                                        <!--begin::Label-->
                                                                        @if(!$project->isUnitsAdded())
                                                                            <label class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="@lang('admin.Change avatar')">
                                                                                <i class="ki-duotone ki-pencil fs-7">
                                                                                    <span class="path1"></span>
                                                                                    <span class="path2"></span>
                                                                                </i>
                                                                                <!--begin::Inputs-->
                                                                                <input type="hidden" name="floors[{{ $floorIndex }}][hidden_image]" value="{{$floor->image}}">
                                                                                <input type="file" name="floors[{{ $floorIndex }}][image]" accept=".png, .jpg, .jpeg" />
                                                                                <input type="hidden" name="floors[{{$floorIndex}}][avatar_remove]" />

                                                                                <!--end::Inputs-->
                                                                            </label>
                                                                        @endif
                                                                        <!--end::Label-->
                                                                        <!--begin::Cancel-->
                                                                        <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                                                        <!--end::Cancel-->
                                                                        <!--begin::Remove-->
                                                                        @if(!$project->isUnitsAdded())
                                                                            <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="@lang('admin.Remove avatar')">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                                                        @endif
                                                                        <!--end::Remove-->
                                                                    </div>
                                                                    <!--end::Image input-->


                                                                </div>
                                                                <small class="text-muted">الحد الأدنى للأبعاد: 350 × 700 بكسل</small>

                                                                <hr class="my-4">

                                                                <h6 class="mb-3">🛏️ الوحدات في هذا الطابق</h6>

                                                                <table class="table align-middle table-row-dashed fs-5 gy-3">
                                                                    <thead>
                                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                                        <th>رقم / رمز الوحدة</th>
                                                                        <th>نوع الوحدة</th>
                                                                        <th>مساحة الوحدة</th>
                                                                        <th>عدد الغرف</th>
                                                                        <th>عدد الحمامات</th>
                                                                        <th>تفاصيل التشطيبات</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="text-gray-600 fw-semibold">
                                                                    @foreach($floor->children as $unitIndex => $unit)
                                                                        <tr>
                                                                            <td><span class="badge badge-light-info badge-lg fw-bold">{{$unit->description}}</span></td>
                                                                            <td>{{getlookup($unit->unit_type_cd)->{'name_' . app()->getLocale()} }}</td>
                                                                            <td>{{$unit->area}} م2</td>
                                                                            <td>{{$unit->rooms}} غرفة</td>
                                                                            <td>{{$unit->bathrooms}} حمام</td>
                                                                            <td>{{$unit->finishing_details}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            <form method="post" action="{{ route('contractors.projects.submit_quote',$project->id) }}" class="form" id="kt_add_project">
                @csrf
            <!--begin::Card - Land Info-->
            <div class="card card-flush mt-5">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <!--begin::Input-->
                            <h3>@lang('contractors.Submit a quote')</h3>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Form-->
                    <div class="row g-4 mb-15">

                        <div class="col-md-4 fv-row">
                            <label class="required form-label">@lang('contractors.Offered price')</label>
                            <div class="input-group">
                                <input class="form-control number_format text-start" value="{{$my_offer->total_price??null}}" id="total_price" name="total_price" type="text" placeholder="@lang('contractors.Offered price')">
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required form-label">@lang('contractors.Implementation period')</label>
                            <div class="input-group">
                                <input class="form-control text-start" id="duration" value="{{$my_offer->duration??null}}" name="duration" type="number" placeholder="@lang('contractors.Implementation period')">
                                <span class="input-group-text">@lang('contractors.day')</span>
                            </div>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="required form-label">@lang('admin.Download the contract for signature')</label>
                            <a href="{{ asset('uploads/settings/' . $settings->contractor_template_file) }}" download class="btn btn-light-primary btn-sm form-control" style="font-size: 15px">
                                <i class="fas fa-download me-2"></i> @lang('investors.Download Contract')
                            </a>
                        </div>
                    </div>

                    <div class="row g-4 mb-15">

                        <div class="col-md-8 fv-row">
                            <label class="form-label">@lang('contractors.notes')</label>
                            <textarea rows="12" class="form-control" name="offer_notes">{{$my_offer->offer_notes??null}}</textarea>
                        </div>
                    </div>

                    <div class="row g-4 mb-15">
                        <!--begin::Repeater-->
                        <div id="kt_docs_repeater_basic">
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div data-repeater-list="kt_docs_repeater_basic">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label class="form-label">@lang('admin.Attachment')</label>
                                                <input name="projects_contractors_offer_attachment" type="file" class="form-control mb-2 mb-md-0"/>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">@lang('admin.Description')</label>
                                                <input name="description" type="text" class="form-control mb-2 mb-md-0"/>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                    <i class="bi bi-trash fs-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Form group-->

                            <!--begin::Form group-->
                            <div class="form-group mt-5">
                                <a href="javascript:;" data-repeater-create class="btn btn-light-info">
                                    <i class="bi bi-plus-circle fs-2"></i>
                                    @lang('admin.Add')
                                </a>
                            </div>
                            <!--end::Form group-->
                        </div>
                        <!--end::Repeater-->

                    </div>

                    <!--end::Form-->
                    <div class="row g-4 mb-15">
                        <div class="col-md-9 offset-md-3 text-end fv-row">
                            <button id="submit" type="submit" class="btn btn-primary" data-kt-project-action="submit">
                                <span class="indicator-label">
                                    <i class="bi bi-floppy2-fill"></i>
                                    @lang('admin.Submit')
                                </span>
                                <span class="indicator-progress">@lang('admin.Please wait...')
                                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                           <button type="button" class="btn btn-secondary btn-outline me-10 mx-2" data-kt-project-action="cancel"><i class="bi bi-x-circle"></i>@lang('admin.Discard')</button>


                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            </form>

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("contractors.projects_management.Partial.addProject_js")

@endsection

