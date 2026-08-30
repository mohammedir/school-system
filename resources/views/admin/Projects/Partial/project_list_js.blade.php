<script>
    $(document).ready(function () {
        /*let table = $("#kt_table_projects").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('projects.getProjects') }}",
                data: function (d) {
                    d.project_type_cd = $('#project_type_cd').val();
                }
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'project_type_cd', name: 'project_type_cd' },
                { data: 'project_status_cd', name: 'project_status_cd' },
                { data: 'engineering_consultant_evaluation_status_cd', name: 'engineering_consultant_evaluation_status_cd' },
                { data: 'approval_status_cd', name: 'approval_status_cd' },
                { data: 'awarded_engineering_creator_approval_cd', name: 'awarded_engineering_creator_approval_cd' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                "url": "{{asset('assets/Arabic.json')}}"
            },
            createdRow: function (row, data, dataIndex) {
                $('td', row).each(function (index) {
                    $(this).addClass('text-center');

                });
            },
            drawCallback: function () {
                if (typeof KTMenu !== 'undefined') {
                    KTMenu.createInstances();
                }
            }
        });
        let searchTimeout;
        $('[data-kt-project-table-filter="search"]').on('keyup', function () {
            clearTimeout(searchTimeout);
            let input = this;

            searchTimeout = setTimeout(function () {
                table.search(input.value).draw();
            }, 300); // delay in milliseconds
        });
        $('.search_btn').on('click', function () {
            table.draw(); // redraw the table with the filter values
        });
        $('.reset_search').on('click', function () {
            $('#filters')[0].reset(); // clear form fields
            // Reset the Select2 value manually
            $('#project_type_cd').val(null).trigger('change'); // Reset and update UI
            table.draw(); // refresh table
        });*/
        loadProjects();
        // عند الضغط على زر البحث
        $('.search_btn').on('click', function (e) {
            e.preventDefault();
            loadProjects();
        });

        // عند الضغط على زر إعادة التصفية
        $('.reset_search').on('click', function (e) {
            e.preventDefault();
            $('#filters')[0].reset(); // إعادة تعيين النموذج
            $('#project_type_cd').val('').trigger('change');
            $('#project_status_cd').val('').trigger('change');
            $('#province_cd').val('').trigger('change');
            $('#location_cities').val('').trigger('change');
            $('#district_cd').val('').trigger('change');
            $('#investor_id').val('').trigger('change');
            loadProjects(); // إعادة التحميل
        });


        // Class definition
        var KTProjectList = function () {
            var initChart = function () {
                // init chart
                var element = document.getElementById("kt_project_list_chart");

                if (!element) {
                    return;
                }

                var config = {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: [30, 45, 25],
                            backgroundColor: ['#00A3FF', '#50CD89', '#E4E6EF']
                        }],
                        labels: ['Active', 'Completed', 'Yet to start']
                    },
                    options: {
                        chart: {
                            fontFamily: 'inherit'
                        },
                        borderWidth: 0,
                        cutout: '75%',
                        cutoutPercentage: 65,
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: false
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        },
                        stroke: {
                            width: 0
                        },
                        tooltips: {
                            enabled: true,
                            intersect: false,
                            mode: 'nearest',
                            bodySpacing: 5,
                            yPadding: 10,
                            xPadding: 10,
                            caretPadding: 0,
                            displayColors: false,
                            backgroundColor: '#20D489',
                            titleFontColor: '#ffffff',
                            cornerRadius: 4,
                            footerSpacing: 0,
                            titleSpacing: 0
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                };

                var ctx = element.getContext('2d');
                var myDoughnut = new Chart(ctx, config);
            }

            // Public methods
            return {
                init: function () {
                    initChart();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTProjectList.init();
        });

        $(document).on('click', '.acepting_offers', function () {
            let projectId = $(this).data('project-id');

            $.ajax({
                url: `{{ url("/") }}/projects/project-data/${projectId}`,
                method: 'GET',
                success: function (response) {
                    // Fill in the role name
                    $('input[name="offers_start_date"]').val(response.project.offers_start_date);
                    $('input[name="offers_end_date"]').val(response.project.offers_end_date);
                    $('input[name="project_jd"]').val(response.project.id);

                },
                error: function () {
                    alert('Failed to fetch role data.');
                }
            });
        });

        $(document).on('click', '.acepting_contractor_offers', function () {
            let projectId = $(this).data('project-id');

            $.ajax({
                url: `{{ url("/") }}/projects/project-data/${projectId}`,
                method: 'GET',
                success: function (response) {
                    // Fill in the role name
                    $('input[name="contractor_offers_start_date"]').val(response.project.contractor_offers_start_date);
                    $('input[name="contractor_offers_end_date"]').val(response.project.contractor_offers_end_date);
                    $('input[name="project_jd"]').val(response.project.id);

                },
                error: function () {
                    alert('Failed to fetch role data.');
                }
            });
        });
    });
    function loadProjects(url = null) {
        if (!url) {
            const params = new URLSearchParams();

            const project_type_cd = $('#project_type_cd').val();
            if(project_type_cd) params.append('project_type_cd', project_type_cd);

            const project_status_cd = $('#project_status_cd').val();
            if(project_status_cd) params.append('project_status_cd', project_status_cd);

            const province_cd = $('#province_cd').val();
            if(province_cd) params.append('province_cd', province_cd);

            const location_cities = $('#location_cities').val();
            if(location_cities) params.append('location_cities', location_cities);

            const location_areas = $('#location_areas').val();
            if(location_areas) params.append('location_areas', location_areas);

            const investor_id = $('#investor_id').val();
            if(investor_id) params.append('investor_id', investor_id);

            const area_from = $('#area_from').val();
            if(area_from) params.append('area_from', area_from);

            const area_to = $('#area_to').val();
            if(area_to) params.append('area_to', area_to);

            const project_cost_from = $('#project_cost_from').val();
            if(project_cost_from) params.append('project_cost_from', project_cost_from);

            const project_cost_to = $('#project_cost_to').val();
            if(project_cost_to) params.append('project_cost_to', project_cost_to);

            $('.project_status_list').removeClass('blinking-bg');
            $('#project_status_list_' + project_status_cd).addClass('blinking-bg');

            // تأكد من وضع رابط الـ route بشكل صحيح داخل blade مع js
            url = `{{ route('projects.getProjects') }}`;
            if(params.toString()) {
                url += '?' + params.toString();
            }
        }
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                let container = $('#projects-cards-container');
                container.empty();

                response.data.forEach(project => {
                    let baseUrl = "{{ url('/projects/view.blade.php-project') }}";

                    function stripHtml(html) {
                        let div = document.createElement("div");
                        div.innerHTML = html;
                        return div.textContent || div.innerText || "";
                    }
                    let plainDescription = stripHtml(project.description ?? '');
                    let shortDescription = plainDescription.length > 30 ? plainDescription.substring(0, 30) + '...' : plainDescription;

                    let plainTitle = stripHtml(project.title ?? '');
                    let shortTitle = plainTitle.length > 30 ? plainTitle.substring(0, 30) + '...' : plainTitle;

                    let adoptionMenuItem = '';
                    let menu_html = '';

                    /*if (project.engineering_consultant_status_recommendAccept) {
                        adoptionMenuItem = `
                                <div class="menu-item px-3">
                                    <a href="{{url('/projects/project-adoption')}}/${project.id}" class="menu-link px-3">
                                        @lang('admin.Project adoption')
                                                </a>
                                            </div>
                        `;
                    }*/
                    if (project.project_status_approved || project.is_accepting_offers_status) {
                        menu_html += `
                                  @can('Change bid history')
                                    <div class="menu-item px-3">
                                            <a  class="menu-link px-3 acepting_offers" data-project-id="${project.id}"  data-bs-toggle="modal" data-bs-target="#kt_modal_acepting_offers">
                                                <i class="ki-outline ki-calendar fs-4 me-1"></i> @lang('admin.Change Offers Date')
                                            </a>
                                    </div>
                                  @endcan
                        `;
                        if (project.offers_start_date != null && !project.boolen_is_accepting_offers){
                        menu_html += `
                                  @can('Closing the bids')
                                        <div class="menu-item px-3">
                                            <a  class="menu-link px-3 close_acepting_offers" data-project-id="${project.id}">
                                                  <i class="ki-outline ki-calendar fs-4 me-1"></i> @lang('admin.Close accepting offers')
                                            </a>
                                        </div>
                                  @endcan
                        `;
                        }

                    }else if(project.project_status_canceled ){
                        menu_html += `
                                  @can('Projects view.blade.php')
                                    <div class="menu-item px-3">
                                            <a href="{{url('/projects/view.blade.php-project')}}/${project.id}"  class="menu-link px-3" data-project-id="${project.id}">
                                                                        <i class="ki-outline ki-calendar fs-4 me-1"></i> @lang('admin.Project View')
                                            </a>
                                    </div>
                                  @endcan
                        `;
                    }else if(project.isEngineeringConsultantPending) {
                        menu_html = `
                                    @can('Projects edit')
                                    <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{url('/projects/edit-project')}}/${project.id}" class="menu-link px-3">@lang('admin.Edit')</a>
                                                                    </div>
                                                                <!--end::Menu item-->
                                    @endcan
                                    @can('Engineering Consultant Evaluation')
                                    <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{url('/projects/engineering-consultant-evaluation')}}/${project.id}" class="menu-link px-3">@lang('admin.Engineering Consultant Evaluation')</a>
                                                                    </div>
                                                                <!--end::Menu item-->
									@endcan
                                `;
                    }else if(project.is_waiting_awarded){
                        menu_html = `<div class="menu-item px-3">
                                       <a href="#" class="menu-link px-3 text-start text-info">
                                        بانتظار الترسية على شريك هندسي
                                        </a>
                                       </div>
                                    `;
                    }
                    else if(project.is_awarded){
                        menu_html = `
                                    <div class="menu-item px-3">
                                       <a href="javascript:;"
                       class="menu-link px-3 text-start show-award-modal"
                       data-project-id="${project.id}"
                       data-offer-id="${project.offer_id}">
                       @lang('engineering.Award approval')
                        </a>
                    </div>`;
                    }else if(project.is_awarding_approved){
                        menu_html = `<div class="menu-item px-3">
                                       <a href="#" class="menu-link px-3 text-start text-info">
                                        بانتظار إدخال الوحدات من الشريك الهندسي
                                        </a>
                                       </div>
                                    `;
                    }

                    else if (project.is_units_added || project.is_accepting_contractor_offers_status) {
                        menu_html = `
                                  @can('Change bid history')
                                    <div class="menu-item px-3">
                                            <a  class="menu-link px-3 acepting_contractor_offers" data-project-id="${project.id}"  data-bs-toggle="modal" data-bs-target="#kt_modal_acepting_contractor_offers">
                                                <i class="ki-outline ki-calendar fs-4 me-1"></i> تغيير تاريخ استقبال عروض أسعار المقاولات
                                            </a>
                                    </div>
                                  @endcan
                        `;
                        if (project.contractor_offers_start_date != null && !project.boolen_is_accepting_contractor_offers){
                        menu_html += `
                                  @can('Closing the bids')
                                        <div class="menu-item px-3">
                                            <a  class="menu-link px-3 close_acepting_contractor_offers" data-project-id="${project.id}">
                                                  <i class="ki-outline ki-calendar fs-4 me-1"></i> @lang('admin.Close accepting contractor offers')
                                            </a>
                                        </div>
                                  @endcan
                        `;
                        }

                    }
                    else if(project.is_waiting_contractor_awarded){
                            menu_html = `<div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3 text-start text-primary">
                                            بانتظار الترسية على مقاول
                                            </a>
                                        </div>
                                        `;
                    }
                    else if(project.is_contractor_awarded){
                            menu_html = `
                                        <div class="menu-item px-3">
                                        <a href="javascript:;"
                        class="menu-link px-3 text-start show-contractor-award-modal"
                        data-project-id="${project.id}"
                        data-contractor-offer-id="${project.contractor_offer_id}"
                        >
                        @lang('engineering.Award approval')
                            </a>
                        </div>`;

                    }else if(project.is_contractor_awarding_approved){
                        menu_html = `<div class="menu-item px-3">
                                       <a href="{{url('/projects/project-valuation-units/')}}/${project.id}"}}"
                                            class="menu-link px-3 text-start"
                                       >
                                        @lang('admin.Project units valuation')
                                        </a>
                                       </div>
                                    `;
                    }else if(project.is_units_priced){
                        menu_html = `@can('Starting the investment phase')
                                        <div class="menu-item px-3">
                                           <a href="{{url('/projects/project-start-investing')}}/${project.id}"}}"
                                                class="menu-link px-3 text-start"
                                           >
                                            @lang('admin.Starting the investment phase')
                                            </a>
                                        </div>
                                        @endcan
                        `;
                    }else if(project.isInvesting){
                            menu_html = `<div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3 text-start text-primary">
                                            المشروع مدرج على المنصة للاستثمار
                                            </a>
                                        </div>
                                        `;
                    }else {
                        menu_html = `
                                    @can('Projects edit')
                        <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{url('/projects/edit-project')}}/${project.id}" class="menu-link px-3">@lang('admin.Edit')</a>
                                                                    </div>
                                                                <!--end::Menu item-->
                                    @endcan
                        @can('Engineering Consultant Evaluation')
                        <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{url('/projects/engineering-consultant-evaluation')}}/${project.id}" class="menu-link px-3">@lang('admin.Engineering Consultant Evaluation')</a>
                                                                    </div>
                                                                <!--end::Menu item-->
						@endcan
                        @can('Project Adoption')
                        <div class="menu-item px-3">
                           <a href="{{url('/projects/project-adoption')}}/${project.id}" class="menu-link px-3">
                                                            @lang('admin.Project adoption')
                            </a>
                        </div>
                        @endcan
                        `;
                    }
                    let project_logo = project.project_logo
                        ? "{{ asset('uploads/projects') }}" + "/"+project.project_logo
                        : "{{ asset('assets/media/logos/logo_icon.png') }}";
                    let card = `
                        <div class="col-md-6 col-xl-4">
                            <div class="card border-hover-primary">
                                <div  class="card-header border-0 pt-9">
                                    <div class="card-title m-0">
                                            <!--begin::Avatar-->
                                                <div class="symbol symbol-50px w-50px bg-light">
                                                    <img src="${project_logo}" alt="image" class="p-3" />
                                                </div>
                                            <!--end::Avatar-->
                                    </div>
                                    <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                    ${project.status}
                                                    <div class="d-flex flex-wrap my-1 text-start"><div>
												<button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
													<i class="ki-outline ki-element-plus fs-2"></i>
												</button>
												<!--begin::Menu 3-->
												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                                  ${menu_html}

												</div>
                                            </div>
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <a href="${baseUrl}/${project.id}">
                                <div class="card-body p-6">
                                      <!--begin::Name-->
                                          <div class="fs-3 fw-bold text-gray-900">${shortTitle}</div>
                                      <!--end::Name-->
                                      <!--begin::Description-->
									     <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">${shortDescription}</p>


									  <!--end::Description-->
									  <!--begin::Info-->
									  <div class="d-flex flex-wrap mb-5">`;

                                            if( project.is_engineering_offers_section_shown){
                                                card += `<div class="border border-gray-400 border-dashed rounded py-3 px-2 me-7 mb-3" style="min-height: 70px;">
                                                    <div class="fw-semibold text-gray-500">@lang('admin.Date of receiving Engineering offers') ${project.is_accepting_offers} </div>
                                                    <div class="fs-6 text-gray-800 fw-bold">${project.offers_start_date != null ? 'من: '+project.offers_start_date +'<br> إلى: '+ project.offers_end_date : 'لم يحدد بعد'}</div>
                                                </div>`;
                                            }

                                            if( project.is_contractor_offers_section_shown){
                                                card += `<div class="border border-gray-400 border-dashed rounded py-3 px-2 me-7 mb-3" style="min-height: 70px;">
                                                    <div class="fw-semibold text-gray-500">@lang('admin.Date of receiving Contractor offers') ${project.is_accepting_contractor_offers} </div>
                                                    <div class="fs-6 text-gray-800 fw-bold">${project.contractor_offers_start_date != null ? 'من: '+project.contractor_offers_start_date +'<br> إلى: '+ project.contractor_offers_end_date : 'لم يحدد بعد'}</div>
                                                </div>`;
                                            }

                                            if(!project.is_engineering_offers_section_shown && !project.is_contractor_offers_section_shown && !project.isInvesting){
                                                card += `<div class="border border-gray-400 border-dashed rounded py-3 px-2 me-7 mb-3" style="min-height: 70px;">
                                                    <div class="fw-semibold text-gray-500 mb-4">@lang('admin.Project type')</div>
                                                    <div class="fs-6 text-gray-800 fw-bold">${project.project_type}</div>
                                                </div>`;
                                                card += `<div class="border border-gray-400 border-dashed rounded py-3 px-2 me-7 mb-3" style="min-height: 70px;">
                                                    <div class="fw-semibold text-gray-500 mb-4">@lang('admin.Project space')  </div>
                                                    <div class="fs-6 text-gray-800 fw-bold">${project.project_area} م2</div>
                                                </div>`;
                                            }

                                            if(project.isInvesting){
                                                card += `<div class="border border-gray-400 border-dashed rounded py-3 px-3 me-7 mb-3" style="min-height: 70px;">
                                                    <div class="fw-semibold text-gray-500 mb-4">@lang('admin.Total Shares')</div>
                                                    <div class="fs-6 text-gray-800 fw-bold">${project.total_shares} سهم</div>
                                                </div>`;
                                                card += `<div class="border border-gray-400 border-dashed rounded py-3 px-3 me-7 mb-3" style="min-height: 70px;">
                                                    <div class="fw-semibold text-gray-500 mb-4">@lang('admin.Remaning Shares')  </div>
                                                    <div class="fs-6 text-gray-800 fw-bold">${project.total_shares} سهم</div>
                                                </div>`;
                                            }

											card += `<div class="border border-gray-400 border-dashed rounded py-3 px-2 mb-3">
											   <div class="fw-semibold text-gray-500 mb-4">@lang('admin.Budget')</div>
											   <div class="fs-6 text-gray-800 fw-bold">${project.project_cost}$</div>
											</div>
									  </div>
							          <!--end::Info-->
							          <!--begin::Progress-->
										 <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 100% completed">
											<div class="bg-success rounded h-4px" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
										 </div>
									  <!--end::Progress-->

                                </div>
                              </a>
                               <div class="card-footer p-5 w-100">
                                    <div class="d-flex flex-stack">
																<!--begin::Name-->
																<span class="text-gray-500 fw-bold">
																<a href="#" class="text-gray-800 text-hover-primary fw-bold">@lang('admin.Engineering consultant evaluation status')</a></span>
																<!--end::Name-->
																<!--begin::Label-->
                                                                ${project.engineering_consultant_status_html}
																<!--end::Label-->
									</div>
									<div class="d-flex flex-stack mt-7">
																<!--begin::Name-->
																<span class="text-gray-500 fw-bold">
																<a href="#" class="text-gray-800 text-hover-primary fw-bold">@lang('admin.Accreditation status')</a></span>
																<!--end::Name-->
																<!--begin::Label-->
                                                                ${project.project_status_html}
																<!--end::Label-->
									</div>`;

                                if(project.awarded_engineering_partner_info != '' && project.is_engineering_awrded_shown){
									card += `<div class="d-flex flex-stack mt-7">
																<!--begin::Name-->
																<span class="text-gray-500 fw-bold">
																<a href="#" class="text-gray-800 text-hover-primary fw-bold">الشريك الهندسي </a></span>
																<!--end::Name-->
                                                                <span class="badge badge-light-info"> ${project.awarded_engineering_partner_info.company_name} </span>
									</div>`;
                                }

                                if(project.awarded_contractor_info != '' && project.is_contractor_awrded_shown){
									card += `<div class="d-flex flex-stack mt-7">
																<!--begin::Name-->
																<span class="text-gray-500 fw-bold">
																<a href="#" class="text-gray-800 text-hover-primary fw-bold"> المقاول </a></span>
																<!--end::Name-->
                                                                <span class="badge badge-light-info"> ${project.awarded_contractor_info.company_name} </span>
									</div>`;
                                }

                               card += `</div>
                            </div>
                        </div>`;
                    container.append(card);
                    KTMenu.createInstances(); // يعيد تهيئة جميع القوائم الجديدة

                })

                renderPagination(response.pagination);
                $('#entries-info').text(`عرض من  ${response.pagination.from} الى ${response.pagination.to} من ${response.pagination.total} السجلات`);

            },
            error: function () {
                alert('حدث خطأ أثناء جلب البيانات');
            }
        });
    }
    function renderPagination(pagination) {
        let paginationContainer = $('#pagination-links');
        paginationContainer.empty();

        if (pagination.prev_page_url) {
            paginationContainer.append(`<li class="page-item"><a class="page-link" href="#" data-url="${pagination.prev_page_url}">&laquo;</a></li>`);
        }

        for (let i = 1; i <= pagination.last_page; i++) {
            paginationContainer.append(`<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
            <a class="page-link" href="#" data-url="{{ route('projects.getProjects') }}?page=${i}">${i}</a>
        </li>`);
        }

        if (pagination.next_page_url) {
            paginationContainer.append(`<li class="page-item"><a class="page-link" href="#" data-url="${pagination.next_page_url}">&raquo;</a></li>`);
        }
    }
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        if (url) {
            loadProjects(url);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const engineering_offers_form = document.querySelector('#kt_form_acepting_offers');
        const contractor_offers_form = document.querySelector('#kt_form_acepting_contractor_offers');

        engineering_offers_form.addEventListener('submit', function (e) {
            e.preventDefault(); // prevent real engineering_offers_form submission

            const startDate = engineering_offers_form.querySelector('[name="offers_start_date"]').value.trim();
            const endDate = engineering_offers_form.querySelector('[name="offers_end_date"]').value.trim();

            // ✅ التحقق من أن كلا الحقلين مملوءين
            if (!startDate || !endDate) {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ تنبيه',
                    text: 'يرجى تعبئة كل من تاريخ البداية وتاريخ الانتهاء قبل الإرسال.',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
                return; // إيقاف الإرسال
            }
            // ✅ التحقق من أن تاريخ البداية أقل من تاريخ الانتهاء
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (isNaN(start.getTime()) || isNaN(end.getTime())) {
                Swal.fire({
                    icon: 'error',
                    title: '⚠️ خطأ في التاريخ',
                    text: 'التاريخ المدخل غير صالح.',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
                return;
            }
            if (start >= end) {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ تنبيه',
                    text: 'يجب أن يكون تاريخ البداية أقل من تاريخ الانتهاء.',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
                return;
            }
            const submitButton = engineering_offers_form.querySelector('[data-kt-accepting-offers-action="submit"]');

            // Show loading
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            // Collect form data
            const formData = new FormData(engineering_offers_form);
            const data = Object.fromEntries(formData.entries());

            const projectId = document.getElementById('acepting_offers_project_jd').value
            const url = `{{url("/")}}/projects/accepting-offers/${projectId}`; // Build the correct URL
            // Example: AJAX POST to Laravel route
            fetch(url, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    // Hide loading
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;

                    if (result.success) {
                        Swal.fire({
                            text: "@lang('admin.Form has been successfully submitted!')",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-info"
                            }
                        });
                        loadProjects()
                        // Close the modal
                        $('#kt_modal_acepting_offers').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '@lang("admin.Error")',
                            text: result.message || 'Something went wrong!',
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: '@lang("admin.Error")',
                        text: 'An unexpected error occurred.',
                    });
                });
        });


        contractor_offers_form.addEventListener('submit', function (e) {
            e.preventDefault(); // prevent real engineering_offers_form submission

            const startDate = contractor_offers_form.querySelector('[name="contractor_offers_start_date"]').value.trim();
            const endDate = contractor_offers_form.querySelector('[name="contractor_offers_end_date"]').value.trim();

            // ✅ التحقق من أن كلا الحقلين مملوءين
            if (!startDate || !endDate) {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ تنبيه',
                    text: 'يرجى تعبئة كل من تاريخ البداية وتاريخ الانتهاء قبل الإرسال.',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
                return; // إيقاف الإرسال
            }
            // ✅ التحقق من أن تاريخ البداية أقل من تاريخ الانتهاء
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (isNaN(start.getTime()) || isNaN(end.getTime())) {
                Swal.fire({
                    icon: 'error',
                    title: '⚠️ خطأ في التاريخ',
                    text: 'التاريخ المدخل غير صالح.',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        confirmButton: "btn btn-danger"
                    }
                });
                return;
            }
            if (start >= end) {
                Swal.fire({
                    icon: 'warning',
                    title: '⚠️ تنبيه',
                    text: 'يجب أن يكون تاريخ البداية أقل من تاريخ الانتهاء.',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        confirmButton: "btn btn-warning"
                    }
                });
                return;
            }
            const submitButton = contractor_offers_form.querySelector('[data-kt-accepting-contractor-offers-action="submit"]');

            // Show loading
            submitButton.setAttribute("data-kt-indicator", "on");
            submitButton.disabled = true;

            // Collect form data
            const formData = new FormData(contractor_offers_form);
            const data = Object.fromEntries(formData.entries());

            const projectId = document.getElementById('acepting_contractor_offers_project_jd').value
            const url = `{{url("/")}}/projects/accepting-contractor-offers/${projectId}`; // Build the correct URL
            // Example: AJAX POST to Laravel route
            fetch(url, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    // Hide loading
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;

                    if (result.success) {
                        Swal.fire({
                            text: "@lang('admin.Form has been successfully submitted!')",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "@lang('admin.OK')",
                            customClass: {
                                confirmButton: "btn btn-info"
                            }
                        });
                        loadProjects()
                        // Close the modal
                        $('#kt_modal_acepting_contractor_offers').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '@lang("admin.Error")',
                            text: result.message || 'Something went wrong!',
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    submitButton.removeAttribute("data-kt-indicator");
                    submitButton.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: '@lang("admin.Error")',
                        text: 'An unexpected error occurred.',
                    });
                });
        });
    });

    $(document).on("change", "select.location_province", function () {
        var province_id = $(this).val();
        var this_city = $("#location_cities");
        var this_area = $("#location_areas");
        var cities_block = document.querySelector("#cities_block");

        if (!cities_block) {
            console.error("#cities_block not found");
            return;
        }

        // استخدم getInstance أو أنشئ جديد عند الحاجة فقط
        var blockUI = KTBlockUI.getInstance(cities_block) ?? new KTBlockUI(cities_block, {
            message: '<div class="blockui-message"><span class="spinner-border text-info"></span> @lang("engineering.Please wait")...</div>',
        });

        if (province_id !== '') {
            blockUI.block();
            this_city.empty();
            this_area.empty();

            $.ajax({
                method: "POST",
                url: '{{url("/")}}/lookups/get_children_by_parent',
                dataType: 'json',
                data: { id: province_id, '_token': '{{csrf_token()}}' },
                success: function (data) {
                    this_city.append(data.children);
                },
                complete: function () {
                    blockUI.release();
                },
                error: function () {
                    blockUI.release();
                }
            });
        } else {
            blockUI.release();
        }
    });
    $(document).on("change", "select.location_city", function () {
        var city_id = $(this).val();
        var this_area = $("#location_areas");
        var areas_block = document.querySelector("#areas_block");

        if (!areas_block) {
            console.error("#areas_block not found");
            return;
        }

        var blockUI = KTBlockUI.getInstance(areas_block) ?? new KTBlockUI(areas_block, {
            message: '<div class="blockui-message"><span class="spinner-border text-info"></span> @lang("engineering.Please wait")...</div>',
        });

        if (city_id !== '') {
            blockUI.block();
            this_area.empty();

            $.ajax({
                method: "POST",
                url: '{{url("/")}}/lookups/get_children_by_parent',
                dataType: 'json',
                data: { id: city_id, '_token': '{{csrf_token()}}' },
                success: function (data) {
                    this_area.append(data.children);
                },
                complete: function () {
                    blockUI.release();
                },
                error: function () {
                    blockUI.release();
                }
            });
        } else {
            blockUI.release();
        }
    });

    $(document).on('click', '.close_acepting_offers', function(e) {
        e.preventDefault();

        let projectId = $(this).data('project-id');

        Swal.fire({
            title: 'تأكيد',
            text: 'هل أنت متأكد أنك تريد إغلاق استقبال العروض لهذا المشروع؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، تأكيد',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // إرسال طلب AJAX لتغيير الحالة
                $.ajax({
                    url: '{{url("/")}}/projects/close-acepting-offers',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        project_id: projectId
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'تم بنجاح',
                            text: 'تم تغيير حالة المشروع بنجاح.',
                            icon: 'success',
                            confirmButtonText: "@lang('admin.OK')",
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'خطأ',
                            'حدث خطأ أثناء محاولة تغيير حالة المشروع.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $(document).on('click', '.close_acepting_contractor_offers', function(e) {
        e.preventDefault();

        let projectId = $(this).data('project-id');

        Swal.fire({
            title: 'تأكيد',
            text: 'هل أنت متأكد أنك تريد إغلاق استقبال عروض المقاولات لهذا المشروع؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، تأكيد',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // إرسال طلب AJAX لتغيير الحالة
                $.ajax({
                    url: '{{url("/")}}/projects/close-acepting-contractor-offers',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        project_id: projectId
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'تم بنجاح',
                            text: 'تم تغيير إغلاق استقبال عروض المقاولات للمشروع بنجاح.',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'خطأ',
                            'حدث خطأ أثناء محاولة تغيير حالة المشروع.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).on('click', '.show-award-modal', function () {
        var offerId = $(this).data('offer-id');
        var projectId = $(this).data('project-id');

        $.ajax({
            url: '{{ route('project.award_modal', '') }}/' + projectId,
            method: 'GET',
            beforeSend: function () {
                $('#awardModalWrapper').html('<div class="text-center p-5">جارٍ التحميل...</div>');
            },
            success: function (response) {
                $('#awardModalWrapper').html(response);

                // خزّن الـ IDs في المودال بعد ما تحمل
                const modal = $('#kt_modal_award_offer');
                modal.attr('data-project-id', projectId);
                modal.attr('data-offer-id', offerId);

                modal.modal('show');
            },
            error: function () {
                $('#awardModalWrapper').html('<div class="text-danger p-5">فشل تحميل المودال</div>');
            }
        });
    });

    $(document).on('click', '.show-contractor-award-modal', function () {
        var offerId = $(this).data('contractor-offer-id');
        var projectId = $(this).data('project-id');

        $.ajax({
            url: '{{ route('project.contractor_award_modal', '') }}/' + projectId,
            method: 'GET',
            beforeSend: function () {
                $('#awardModalWrapper').html('<div class="text-center p-5">جارٍ التحميل...</div>');
            },
            success: function (response) {
                $('#awardModalWrapper').html(response);

                // خزّن الـ IDs في المودال بعد ما تحمل
                const modal = $('#kt_modal_contractor_award_offer');
                modal.attr('data-project-id', projectId);
                modal.attr('data-contractor-offer-id', offerId);

                modal.modal('show');
            },
            error: function () {
                $('#awardModalWrapper').html('<div class="text-danger p-5">فشل تحميل المودال</div>');
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $(document).on('shown.bs.modal', '#kt_modal_award_offer', function () {
            const form = document.getElementById('kt_form_award_offer');
            const submitBtn = document.getElementById('award_submit_btn');
            const indicatorLabel = submitBtn.querySelector('.indicator-label');
            const indicatorProgress = submitBtn.querySelector('.indicator-progress');
            const modal = $('#kt_modal_award_offer');

            if (!form.hasAttribute('data-validated')) {
                const validation = FormValidation.formValidation(form, {
                    fields: {
                        award_reason: {
                            validators: {
                                notEmpty: {
                                    message: 'سبب الترسية مطلوب'
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: 'is-invalid',
                            eleValidClass: 'is-valid'
                        }),
                    },
                });

                form.setAttribute('data-validated', 'true');

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    validation.validate().then(function (status) {
                        if (status === 'Valid') {
                            submitBtn.disabled = true;
                            indicatorLabel.style.display = 'none';
                            indicatorProgress.style.display = 'inline-block';

                            const formData = new FormData(form);

                            // ✅ استخرج الـ ID بعد عرض المودال
                            const offerId = modal.attr('data-offer-id');

                            const url = `{{ url('/projects/award-approval-offer') }}/${offerId}`;

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
                                    loadProjects()
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
                        }
                    });
                });
            }
        });

        $(document).on('shown.bs.modal', '#kt_modal_contractor_award_offer', function () {
            const form = document.getElementById('kt_form_award_offer');
            const submitBtn = document.getElementById('award_submit_btn');
            const indicatorLabel = submitBtn.querySelector('.indicator-label');
            const indicatorProgress = submitBtn.querySelector('.indicator-progress');
            const modal = $('#kt_modal_contractor_award_offer');

            if (!form.hasAttribute('data-validated')) {
                const validation = FormValidation.formValidation(form, {
                    fields: {
                        award_reason: {
                            validators: {
                                notEmpty: {
                                    message: 'سبب الترسية مطلوب'
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: 'is-invalid',
                            eleValidClass: 'is-valid'
                        }),
                    },
                });

                form.setAttribute('data-validated', 'true');

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    validation.validate().then(function (status) {
                        if (status === 'Valid') {
                            submitBtn.disabled = true;
                            indicatorLabel.style.display = 'none';
                            indicatorProgress.style.display = 'inline-block';

                            const formData = new FormData(form);

                            // ✅ استخرج الـ ID بعد عرض المودال
                            const offerId = modal.attr('data-contractor-offer-id');

                            const url = `{{ url('/projects/contractor-award-approval-offer') }}/${offerId}`;

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
                                    loadProjects()
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
                        }
                    });
                });
            }
        });
    });


    $(document).on('click', '.filter_by_project_status', function () {

        simpleBlockPage();

        var projectStatus = $(this).attr('project-status');
        $('#project_status_cd').val(projectStatus).trigger('change');
        $('#kt_land_view_details').collapse();
        loadProjects();

        $('html, body').animate({
            scrollTop: $('#projects-cards-container').offset().top - 20 // 20px offset
        }, 1200);

        setTimeout(function(){ simpleUnblockPage(); }, 2000);
    });

    function simpleBlockPage() {
        $('<div class="page-blocker"></div>').css({
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            background: 'rgba(0,0,0,0.2)',
            zIndex: 9999
        }).appendTo('#projects-cards-container');
    }

    function simpleUnblockPage() {
        $('.page-blocker').remove();
    }
</script>

