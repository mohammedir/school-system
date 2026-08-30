<script>
    $(document).ready(function () {
        var general_stats = function () {
            var chart = {
                self: null,
                rendered: false
            };

            var initChart = function(chart) {
            var element = document.getElementById("general_stats");

            if (!element) {
                return;
            }

            var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');

            var options = {
                series: [{
                    name: 'الإجمالي',
                    data: [{{ $engineeringPartner_cnt }}, {{ $student_cnt }}, {{ $contractors_cnt }}],
                    show: false
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        distributed: true,
                        barHeight: 23
                    }
                },
                dataLabels: {
                    enabled: true
                },
                legend: {
                    show: false
                },
                colors: ['#3E97FF', '#F1416C', '#50CD89', '#FFC700', '#7239EA', '#50CDCD', '#3F4254'],
                xaxis: {
                    categories: ["الأراضي", "الطلاب", 'الشركاء الهندسيين', 'المستثمرين', 'المقاولين'],
                    labels: {
                        formatter: function (val) {
                        return val
                        },
                        style: {
                            colors: KTUtil.getCssVariableValue('--bs-gray-400'),
                            fontSize: '14px',
                            fontWeight: '600',
                            align: 'left'
                        }
                    },
                    axisBorder: {
                        show: true
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: KTUtil.getCssVariableValue('--bs-gray-800'),
                            fontSize: '14px',
                            fontWeight: '600'
                        },
                        offsetY: 2,
                        align: 'left'
                    }
                },
                grid: {
                    borderColor: borderColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    strokeDashArray: 4
                }
            };

            chart.self = new ApexCharts(element, options);

            // Set timeout to properly get the parent elements width
            setTimeout(function() {
                chart.self.render();
                chart.rendered = true;
            }, 200);
        }
            // Public methods
            return {
                init: function () {
                    initChart(chart);

                    // Update chart on theme mode change
                    KTThemeMode.on("kt.thememode.change", function() {
                        if (chart.rendered) {
                            chart.self.destroy();
                        }

                        initChart(chart);
                    });
                }
            }
        }();

        // Webpack support
        if (typeof module !== 'undefined') {
            module.exports = general_stats;
        }

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            general_stats.init();
        });



        var shares_buying_stats = function () {
        var chart = {
            self: null,
            rendered: false
        };

        // Private methods
        var initChart = function(chart) {
            var element = document.getElementById("shares_buying_stats");

            if (!element) {
                return;
            }

            var height = parseInt(KTUtil.css(element, 'height'));
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');
            var baseColor = KTUtil.getCssVariableValue('--bs-info');

            var options = {
                series: [{
                    name: 'القيمة ($)',
                    data: [190, 230, 230, 200, 200, 190, 190, 200, 200, 220, 220, 200, 200, 210, 210]
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0,
                        stops: [0, 80, 100]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [baseColor]
                },
                xaxis: {
                    categories: ['May 04', 'May 05', 'May 06', 'May 09', 'May 10', 'May 12', 'May 14', 'May 17', 'May 18', 'May 20', 'May 22', 'May 24', 'May 26', 'May 28', 'May 30'],
                    axisBorder: {
                        show: false,
                    },
                    offsetX: 20,
                    axisTicks: {
                        show: false
                    },
                    tickAmount: 3,
                    labels: {
                        rotate: 0,
                        rotateAlways: false,
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        position: 'front',
                        stroke: {
                            color: baseColor,
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    tickAmount: 4,
                    max: 250,
                    min: 100,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '12px'
                        },
                        formatter: function (val) {
                            return val
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                },
                colors: [baseColor],
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                markers: {
                    strokeColor: baseColor,
                    strokeWidth: 3
                }
            };

            chart.self = new ApexCharts(element, options);

            // Set timeout to properly get the parent elements width
            setTimeout(function() {
                chart.self.render();
                chart.rendered = true;
            }, 200);
        }

        // Public methods
        return {
            init: function () {
                initChart(chart);

                // Update chart on theme mode change
                KTThemeMode.on("kt.thememode.change", function() {
                    if (chart.rendered) {
                        chart.self.destroy();
                    }

                    initChart(chart);
                });
            }
        }
    }();

    // Webpack support
    if (typeof module !== 'undefined') {
        module.exports = shares_buying_stats;
    }

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        shares_buying_stats.init();
    });

    });
</script>
