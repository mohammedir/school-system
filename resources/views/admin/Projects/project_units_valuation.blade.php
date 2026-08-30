@extends('admin.layouts.master')
@section('content')
    <style>
        .sticky-cost-box {
            position: fixed;
            top: 80px; /* المسافة من أعلى الصفحة - عدلها حسب ارتفاع الـ header */
            right: 85%; /* المسافة من اليمين */
            background: #fff;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1050; /* فوق كل شيء */
            min-width: 160px;
        }

        .sticky-cost-box label {
            display: block;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .sticky-cost-box .form-label {
            font-size: 20px;
            font-weight: bold;
            color: #28a745; /* لون أخضر للقيمة */
        }
    </style>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif
    <!--begin::Toolbar-->
    <div class="toolbar py-3 py-lg-6" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold m-0 fs-3">@lang('admin.Project units valuation')</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        @lang('admin.Home')
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Projects')</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">@lang('admin.Project units valuation')</li>
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
            <!--begin::Card - Project Info-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-8">
                    <!--begin::Col-->
                    <div class="col-md-4">
                        <h3>@lang('engineering.Project Data')</h3>
                        <div class="d-flex align-items-center gap-2">
                            <!--begin::Input-->
                            <input class="form-control" type="text" name="project_title" id="project_title" disabled
                                   value="{{$project->title}}">
                            <input class="form-control" type="hidden" name="project_id" id="project_id" disabled
                                   value="{{$project->id}}">
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Form-->
                    <!-- Student details will be loaded here -->
                    <div id="project_details" style="display: none;">
                        <!-- content will be injected here by AJAX -->
                    </div>

                    <!--end::Form-->
                </div>
                <!--end::Card body-->

                <?php
                $total_project_cost = $project->lands->price + $project->awardedEngineeringOffer->total_price + $project->awardedContractorOffer->total_price;
                $sahmi_fee = ceil($total_project_cost * 0.1);
                $net_project_cost = $total_project_cost + $sahmi_fee;

                $extra_fees = 1000 - ($net_project_cost % 1000); // $net_project_cost mod 1000;
                $sahmi_fee += $extra_fees;
                $net_project_cost += $extra_fees;
                ?>
                <div class="card-body">
                    <div class="fv-row row mb-15">
                        <div class="col-md-2 mb-5">
                            <b>القيمة الإجمالية للمشروع = </b>
                        </div>

                        @if(auth()->user()->hasRole('admin'))
                            <div class="col-md-1 mb-5">
                                <label class="text-muted"> قيمة الأرض</label>
                                <div class="form-label d-block">
                                    {{number_format($project->lands->price)}} $
                                </div>
                            </div>
                            <div class="col-md-1 mb-1">
                                <label class="form-label d-block"> + </label>
                            </div>

                            <div class="col-md-1 mb-5">
                                <label class="text-muted">تكلفة الشريك الهندسي </label>
                                <div class="form-label d-block">
                                    {{number_format($project->awardedEngineeringOffer->total_price)}} $
                                </div>
                            </div>
                            <div class="col-md-1 mb-1">
                                <label class="form-label d-block"> + </label>
                            </div>

                            <div class="col-md-1 mb-5">
                                <label class="text-muted">تكلفة المقاولات </label>
                                <div class="form-label d-block">
                                    {{number_format($project->awardedContractorOffer->total_price)}} $
                                </div>
                            </div>
                            <div class="col-md-1 mb-1">
                                <label class="form-label d-block"> + </label>
                            </div>

                            <div class="col-md-1 mb-5">
                                <label class="text-muted">رسوم One Thousand 10% </label>
                                <div class="form-label d-block">
                                    {{number_format($sahmi_fee)}} $
                                </div>
                            </div>
                            <div class="col-md-1 mb-1">
                                <label class="form-label d-block"> = </label>
                            </div>
                        @endif

                        <div class="col-md-1 mb-5">
                            <label class="text-muted"> قيمة المشروع النهائية </label>
                            <div class="form-label d-block">
                                {{number_format($net_project_cost)}} $
                            </div>
                        </div>
                        <div class="col-md-1 mb-5 sticky-cost-box">
                            <label class="text-muted"> قيمة المشروع النهائية </label>
                            <div class="form-label d-block" id="project_cost">
                                {{number_format($net_project_cost)}} $
                            </div>
                            <hr>
                            <label class="text-muted">القيمية المتبقية </label>
                            <div class="form-label d-block" id="remaining_project_cost">
                                {{number_format($net_project_cost)}} $
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!--end::Card-->

            <!--begin::Card - Map-->
            <div class="card card-flush mt-5">
                <div class="card-header pt-8 pb-4 border-bottom">
                    <h3 class="fw-bold mb-0">@lang('admin.Land details')</h3>
                </div>
                <div class="card-body">
                    <div class="row g-5">
                        <!-- العنوان -->
                        <div class="col-md-4">
                            <div class="p-4 border rounded bg-light h-100">
                                <h5 class="fw-bold mb-3">@lang('admin.Address in detail')</h5>
                                <p class="text-muted mb-0">
                                    {{ $land->address ?? __('admin.No address available') }}
                                </p>
                            </div>
                        </div>

                        <!-- الخريطة + الإحداثيات -->
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-3">@lang('admin.Address on map')</h5>
                            <div id="map" class="mb-4"
                                 style="height: 350px; width: 100%; border-radius: 8px; border: 1px solid #ddd;"></div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('admin.Latitude')</label>
                                    <input disabled type="text" id="lat" name="lat" class="form-control"
                                           placeholder="@lang('admin.Latitude')" value="{{ $land->lat }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">@lang('admin.Longitude')</label>
                                    <input disabled type="text" id="long" name="long" class="form-control"
                                           placeholder="@lang('admin.Longitude')" value="{{ $land->long }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end::Card-->

            <!--begin::Card -  Units Details-->
            <div class="card card-flush mt-5">
                <div class="card-header pt-8">
                    <h5>📑 عرض الوحدات </h5>
                </div>
                <div class="card-body">
                    <div class="wrapper">
                        <div class="content-wrapper">
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card card-primary mt-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">@lang('engineering.Manage Floors and Units')</h3>
                                                </div>
                                                <form action="{{ route('projects.project_valuation_units',[$project->id]) }}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="form_project_id"
                                                           value="{{$project->id}}">
                                                    <input type="hidden" name="project_management_fees"
                                                           value="{{$sahmi_fee}}">
                                                    <input type="hidden" name="project_total_evaluation"
                                                           value="{{$net_project_cost}}">
                                                    <div class="container py-5">
                                                        <div id="floors-repeater">
                                                            @foreach($floors as $floorIndex => $floor)
                                                                <div class="card mb-5 shadow-sm floor-wrapper">
                                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                                        <h5 class="mb-0 floor-number">🗂️ بيانات
                                                                            الطابق </h5>
                                                                        <div>
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-secondary toggle-collapse">
                                                                                ⯆
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="collapse show card-collapse">
                                                                        <div class="card-body">
                                                                            <div class="col-md-2 fv-row mb-3">
                                                                                <label class="required form-label">صورة
                                                                                    الطابق</label>
                                                                                {{-- <input class="form-control" name="project_logo" type="file" id="projectLogoInput">--}}
                                                                                <!--begin::Image placeholder-->
                                                                                <style>.image-input-placeholder {
                                                                                        background-image: url("{{asset('assets/media/svg/files/blank-image.svg')}}");
                                                                                    }

                                                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                                                        background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                                                                    }</style>
                                                                                <!--end::Image placeholder-->
                                                                                <!--begin::Image input-->
                                                                                <div class="image-input image-input-outline image-input-placeholder"
                                                                                     data-kt-image-input="true">
                                                                                    <div class="image-input-wrapper w-700px h-350px"
                                                                                         style="background-image: url({{asset('/uploads/projects/' . $floor->image)}});"></div>
                                                                                    <!--end::Preview existing avatar-->
                                                                                    <!--begin::Label-->
                                                                                    @if(!$project->isContractorAwardingApproved())
                                                                                        <label class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                                                                               data-kt-image-input-action="change"
                                                                                               data-bs-toggle="tooltip"
                                                                                               title="@lang('admin.Change avatar')">
                                                                                            <i class="ki-duotone ki-pencil fs-7">
                                                                                                <span class="path1"></span>
                                                                                                <span class="path2"></span>
                                                                                            </i>
                                                                                            <!--begin::Inputs-->
                                                                                            <input type="hidden"
                                                                                                   name="floors[{{ $floorIndex }}][hidden_image]"
                                                                                                   value="{{$floor->image}}">
                                                                                            <input type="file"
                                                                                                   name="floors[{{ $floorIndex }}][image]"
                                                                                                   accept=".png, .jpg, .jpeg"/>
                                                                                            <input type="hidden"
                                                                                                   name="floors[{{$floorIndex}}][avatar_remove]"/>

                                                                                            <!--end::Inputs-->
                                                                                        </label>
                                                                                    @endif
                                                                                    <!--end::Label-->
                                                                                    <!--begin::Cancel-->
                                                                                    <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                                                                          data-kt-image-input-action="cancel"
                                                                                          data-bs-toggle="tooltip"
                                                                                          title="Cancel avatar">
																			<i class="ki-duotone ki-cross fs-2">
																				<span class="path1"></span>
																				<span class="path2"></span>
																			</i>
																		</span>
                                                                                    <!--end::Cancel-->
                                                                                    <!--begin::Remove-->
                                                                                    @if(!$project->isContractorAwardingApproved())
                                                                                        <span class="btn btn-icon btn-circle btn-active-color-info w-25px h-25px bg-body shadow"
                                                                                              data-kt-image-input-action="remove"
                                                                                              data-bs-toggle="tooltip"
                                                                                              title="@lang('admin.Remove avatar')">
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
                                                                            <small class="text-muted">الحد الأدنى
                                                                                للأبعاد: 350 × 700 بكسل</small>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">رقم/وصف
                                                                                    الطابق</label>
                                                                                <input readonly type="text"
                                                                                       name="floors[{{ $floorIndex }}][description]"
                                                                                       class="form-control"
                                                                                       placeholder="مثلاً الطابق الأرضي، الأول، الثاني ..."
                                                                                       value="{{$floor->description}}">
                                                                            </div>

                                                                            <hr class="my-4">

                                                                            <h6 class="mb-3">🛏️ الوحدات في هذا
                                                                                الطابق</h6>

                                                                            <!-- nested repeater للـ units داخل هذا الطابق -->
                                                                            <div class="units-repeater">
                                                                                @foreach($floor->children as $unitIndex => $unit)
                                                                                    <div class="unit-wrapper">
                                                                                        <div class="row align-items-end mb-3">
                                                                                            <div class="col-md-2">
                                                                                                <label class="form-label required">رقم
                                                                                                    / رمز الوحدة</label>
                                                                                                <input disabled
                                                                                                       type="text"
                                                                                                       name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][description]"
                                                                                                       class="form-control"
                                                                                                       required
                                                                                                       value="{{$unit->description}}">
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label class="form-label required">نوع
                                                                                                    الوحدة</label>
                                                                                                <select disabled
                                                                                                        class="form-control"
                                                                                                        name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][unit_type_cd]"
                                                                                                        required>
                                                                                                    @foreach(get_lookup_by_master_key('unit_type') as $unit_type)
                                                                                                        <option value="{{ $unit_type->id }}" {{ $unit_type->id == $unit->unit_type_cd ? 'selected' : '' }}>
                                                                                                            {{ $unit_type->name_ar }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label class="form-label required">المساحة</label>
                                                                                                <input disabled
                                                                                                       type="number"
                                                                                                       name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][area]"
                                                                                                       class="form-control"
                                                                                                       required
                                                                                                       value="{{$unit->area}}">
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label class="form-label">عدد
                                                                                                    الغرف</label>
                                                                                                <input disabled
                                                                                                       type="number"
                                                                                                       name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][rooms]"
                                                                                                       class="form-control"
                                                                                                       value="{{$unit->rooms}}">
                                                                                            </div>
                                                                                            <div class="col-md-1">
                                                                                                <label class="form-label">عدد
                                                                                                    الحمامات</label>
                                                                                                <input disabled
                                                                                                       type="number"
                                                                                                       name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][bathrooms]"
                                                                                                       class="form-control"
                                                                                                       value="{{$unit->bathrooms}}">
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label class="form-label">تفاصيل
                                                                                                    التشطبيات</label>
                                                                                                <textarea disabled
                                                                                                          name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][finishing_details]"
                                                                                                          class="form-control">{{$unit->finishing_details}}</textarea>
                                                                                            </div>
                                                                                            <div class="col-md-2">
                                                                                                <label class="form-label">سعر
                                                                                                    التثمين</label>
                                                                                                <div class="input-group">
                                                                                                    <input type="hidden"
                                                                                                           name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][unit_id]"
                                                                                                           value="{{$unit->id}}">
                                                                                                    <input @if(!$project->isContractorAwardingApproved()) disabled
                                                                                                           @endif  type="text"
                                                                                                           value="{{$unit->valuation_price}}"
                                                                                                           class="form-control valuation_price_input number_format"
                                                                                                           name="floors[{{ $floorIndex }}][units][{{ $unitIndex }}][valuation_price]"
                                                                                                           placeholder="@lang('admin.Enter the price')"
                                                                                                           style="text-align: right; direction: rtl;">
                                                                                                    <span class="input-group-text">{{getSettings()->currency_symbol}}</span>
                                                                                                </div>
                                                                                                <small class="form-text text-muted"
                                                                                                       style="font-size: 8px">
                                                                                                    ⚠️ يجب إدخال المبلغ
                                                                                                    من مضاعفات الألف
                                                                                                </small>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                    @if(!$project->isContractorAwardingApproved())

                                                    @else
                                                        <div class="card-footer">
                                                            <input type="hidden" name="action" id="hidden-action">
                                                            <button type="submit" name="action"
                                                                    value="valuation-price-submit"
                                                                    id="valuation-price-submit" class="btn btn-success">
                                                                حفظ التثمين
                                                            </button>
                                                            <button type="submit" name="action"
                                                                    value="valuation-price-approve"
                                                                    id="valuation-price-approve"
                                                                    class="btn btn-primary">اعتماد التثمين
                                                            </button>
                                                        </div>
                                                    @endif

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Card-->

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@section('js')
    @include("admin.Projects.Partial.project_units_valuation_js")

@endsection

