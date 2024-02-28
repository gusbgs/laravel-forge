@extends('layouts.layoutDashboard')

@section('title', 'Welcome')

@section('link')

@endsection

@section('style')

    <style media="screen">

    </style>

@endsection

@section('navigation')

@endsection

@section('content')

    <!--begin::Card-->
    <div class="card card-custom gutter-b mt-5">
        <div class="card-header py-6">
            <div class="card-title mt-5">
                <span class="card-icon mr-5">
                    <span class="svg-icon svg-icon-md svg-icon-primary">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
                        <i class="fa fa-home" style="color:#3699ff; font-size:28px"></i>
                        <!--end::Svg Icon-->
                    </span>
                </span>
                <h3 class="card-label">
                    Welcome to E-Penda
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item text-muted active">
                            <a href="#" class="text-muted">Welcome</a>
                        </li>
                    </ul>
                </h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="{{ $about->file }}" class="btn btn-primary font-weight-bolder mr-2"
                    download="{{ $about->file_name }}">
                    <i class="fa fa-download"></i>Download
                </a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <div class="container px-10">
                {{--                <div class="row"> --}}
                {{--                    <div class="col"> --}}
                {{--                        {!! $about->description !!} --}}
                {{--                    </div> --}}
                {{--                </div> --}}
                <div class="row">
                    <div class="col">
                        <div class="card card-custom card-stretch">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Penerimaan
                                        <small>Hari Ini</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2> Rp. {{ number_format($penerimaan['today'], 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-custom card-stretch">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Penerimaan
                                        <small>Bulan ini</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2> Rp. {{ number_format($penerimaan['this_month'], 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-custom card-stretch">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Penerimaan
                                        <small>Tahun ini</small>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2> Rp. {{ number_format($penerimaan['this_year'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <div class="card card-custom">
                            <div class="card-header card-header-tabs-line">
                                <div class="card-title">
                                    <h3 class="card-label">Pendapatan Daerah Tabalong</h3>
                                </div>
                                <div class="card-toolbar">
                                    <ul class="nav nav-tabs nav-bold nav-tabs-line">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1_2">Seminggu
                                                Terakhir</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_2">Bulan Ini</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_2">Tahun Ini</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="kt_tab_pane_1_2" role="tabpanel">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-label">Grafik Pendapatan Daerah Dalam Seminggu</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div id="chart_1"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="kt_tab_pane_2_2" role="tabpanel">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-label">Grafik Pendapatan Daerah Dalam Sebulan</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div id="chart_2"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="kt_tab_pane_3_2" role="tabpanel">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-label">Grafik Pendapatan Daerah Dalam Setahun</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div id="chart_3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">

                    <div class="col-12">
                        <div class="card card-custom card-stretch">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Penerimaan Tahunan
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach ($penerimaan_tahunan as $key => $value)
                                    <div class="card card-custom ">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="p-3">
                                                    Tahun {{ $value['year'] }}
                                                </div>
                                                <div class="p-3">
                                                    Rp. {{ number_format($value['sum'], 2) }}
                                                </div>
                                            </div>
                                            @if ($value['is_down'] == true && $key != 0)
                                                <div class="d-flex justify-content-end">
                                                    <div class="p-3">
                                                        <p class="text-danger">↓
                                                            {{ number_format($value['percentage' ?? 0]) }}%</p>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($value['is_down'] == false && $key != 0)
                                                <div class="d-flex justify-content-end">
                                                    <div class="p-3">
                                                        <p class="text-success">↑
                                                            {{ number_format($value['percentage' ?? 0]) }}%
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card card-custom card-stretch">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">
                                        Penerimaan Berdasarkan SKPD
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row-reverse">
                                    <div class="p-2">
                                        <select class="form-select" aria-label="Default select example" id="select-year">
                                            <option selected value="none">Pilih tahun...</option>
                                            @foreach ($penerimaan_tahunan as $value)
                                                <option value="{{ $value['year'] }}">{{ $value['year'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="chart_12" class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Card-->
    {{-- <script src="/metronic/assets/js/pages/features/charts/apexcharts.js"></script> --}}
@endsection

@section('script')

    <script type="text/javascript">
        var menu_link_1 = document.getElementById("kt_header_menu_1");
        menu_link_1.classList.add("active");

        var menu_link_2 = document.getElementById("kt_header_menu_mobile_1");
        menu_link_2.classList.add("active");

        var menu_link_3 = document.getElementById("kt_header_tab_1");
        menu_link_3.classList.add("active");
        menu_link_3.classList.add("show");

        var menu_link_4 = document.getElementById("menu_welcome");
        menu_link_4.classList.add("menu-item-active");


        "use strict";

        // Shared Colors Definition
        const primary = '#6993FF';
        const success = '#1BC5BD';
        const info = '#8950FC';
        const warning = '#FFA800';
        const danger = '#F64E60';

        let y_1 = [];
        let x_1 = [];

        let y_2 = [];
        let x_2 = [];

        let y_3 = [];
        let x_3 = [];

        let pie_label_x = [];
        let pie_series_y = [];

        function chartAjax(type, year) {
            let url = null;
            if (type == 'pie') {
                url = "{{ route('dashboard.chart.week') }}?type=pie&year=" + year;
            } else {
                url = "{{ route('dashboard.chart.week') }}?type=" + type;
            }
            $.ajax({
                method: "GET",
                url: url
            }).done(function(response) {
                console.log(response);
                $("#chart_12").empty();
                if (type == 'week') {
                    $.each(response.x_data, function(key, value) {
                        x_1.push(value);
                    });
                    $.each(response.y_data, function(key, value) {
                        y_1.push(value);
                    });
                    KTApexChartsDemo.init();

                } else if (type == 'month') {
                    $.each(response.x_data, function(key, value) {
                        x_2.push(value);
                    });
                    $.each(response.y_data, function(key, value) {
                        y_2.push(value);
                    });
                    KTApexChartsDemo.init();
                } else if (type == 'year') {
                    $.each(response.x_data, function(key, value) {
                        x_3.push(value);
                    });
                    $.each(response.y_data, function(key, value) {
                        y_3.push(value);
                    });
                    KTApexChartsDemo.init();
                }
                if (type == 'pie') {
                    $.each(response.x_data, function(key, value) {
                        console.log(value);
                        pie_label_x.push(value);
                    });
                    $.each(response.y_data, function(key, value) {
                        console.log(value);
                        pie_series_y.push(value);
                    });
                    KTApexChartsDemoPie.init();
                }
                // KTApexChartsDemo.init();
            });
        }
        $(document).ready(function() {
            chartAjax('week', null);
            chartAjax('month', null);
            chartAjax('year', null);
            const d = new Date();
            let year = d.getFullYear();
            chartAjax('pie', year);
        });

        $('#select-year').on('change', function() {
            if (this.value != 'none') {
                $("#chart_12").empty();
                chartAjax('pie', this.value);
            }
        });

        let KTApexChartsDemo = function() {
            // Private functions
            var _chart1 = function() {

                const apexChart = "#chart_1";
                var options = {
                    series: [{
                        name: "Nilai",
                        data: y_1

                    }, ],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        formatter: function(val) {
                            return val.toFixed(2);
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        },
                        // x: {
                        //     formatter: function(val) {
                        //         return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        //     }
                        // }
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3',
                                'transparent'
                            ], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: x_1,
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return 'Rp. ' + value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    '.');
                            }
                        },
                    },
                    colors: [primary]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _chart2 = function() {
                const apexChart = "#chart_2";
                var options = {
                    series: [{
                        name: "Nilai",
                        data: y_2

                    }, ],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        formatter: function(val) {
                            return val.toFixed(2);
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        },
                        // x: {
                        //     formatter: function(val) {
                        //         return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        //     }
                        // }
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3',
                                'transparent'
                            ], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: x_2,
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return 'Rp. ' + value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    '.');
                            }
                        },
                    },
                    colors: [primary]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            var _chart3 = function() {
                const apexChart = "#chart_3";
                var options = {
                    series: [{
                        name: "Nilai",
                        data: y_3

                    }, ],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        formatter: function(val) {
                            return val.toFixed(2);
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            }
                        },
                        // x: {
                        //     formatter: function(val) {
                        //         return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        //     }
                        // }
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3',
                                'transparent'
                            ], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: x_3,
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return 'Rp. ' + value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,
                                    '.');
                            }
                        },
                    },
                    colors: [primary]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }

            return {
                init: function() {
                    _chart1();
                    _chart2();
                    _chart3();
                }
            };
        }();

        function formatNumber(number, decimalsLength, decimalSeparator, thousandSeparator) {
            var n = number,
                decimalsLength = isNaN(decimalsLength = Math.abs(decimalsLength)) ? 2 : decimalsLength,
                decimalSeparator = decimalSeparator == undefined ? "," : decimalSeparator,
                thousandSeparator = thousandSeparator == undefined ? "." : thousandSeparator,
                sign = n < 0 ? "-" : "",
                i = parseInt(n = Math.abs(+n || 0).toFixed(decimalsLength)) + "",
                j = (j = i.length) > 3 ? j % 3 : 0;

            return sign +
                (j ? i.substr(0, j) + thousandSeparator : "") +
                i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousandSeparator) +
                (decimalsLength ? decimalSeparator + Math.abs(n - i).toFixed(decimalsLength).slice(2) : "");
        }

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        let KTApexChartsDemoPie = function() {
            var _demo12 = function() {
                const apexChart = "#chart_12";
                var options = {
                    series: pie_label_x,
                    chart: {
                        width: 1000,
                        type: 'pie',
                    },
                    labels: pie_series_y,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 5000
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return formatNumber(value, 2, ',', '.');
                            }
                        }
                    },
                    // tooltipTemplate : function(valueObj) {
                    //     return formatNumber(valueObj.value, 2, ',',  '.');
                    // }
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            }
            return {
                // public functions
                init: function() {
                    _demo12();
                }
            };
        }();
    </script>


@endsection
