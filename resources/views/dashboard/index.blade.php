@extends('layouts.main')

@section('main')
    <!-- Tambahkan CDN di bagian head atau sebelum script -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <x-title-page title="DASHBOARD" />
            </div>

            <div class="row">
                <!-- Bagian statistik tetap sama -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary d-flex align-items-center justify-content-center">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Active Users</h4>
                            </div>
                            <div class="card-body">
                                {{ $conUser }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger d-flex align-items-center justify-content-center">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>All Documents</h4>
                            </div>
                            <div class="card-body">
                                {{ $conDocs }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning d-flex align-items-center justify-content-center">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Risk</h4>
                            </div>
                            <div class="card-body">
                                1,201
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon d-flex align-items-center justify-content-center"
                            style="background-color: #2E7D32">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Distribution</h4>
                            </div>
                            <div class="card-body">
                                47
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Chart by Department -->
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Documents (by Department)</h4>
                        </div>
                        <div class="card-body" id="chart-cust">
                            <div class="chart-container" style="position: relative; height:500px;">
                                <canvas id="departmentChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart by Document Type -->
                <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Documents (by Document Type)</h4>
                        </div>
                        <div class="card-body" id="chart-cust">
                            <div class="chart-container" style="position: relative; height:500px;">
                                <canvas id="documentChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body" id="chart-cust">
                            <ul class="list-unstyled list-unstyled-border recent-activities">
                                @foreach ($logs as $log)
                                    <li class="media">
                                        <img class="mr-3 rounded-circle" width="50"
                                            src="{{ asset('assets/img/avatar/' . $log->avatar) }}" alt="avatar">
                                        <div class="media-body">
                                            <div class="float-right text-primary">{{ $log->time_ago }}</div>
                                            <div class="media-title">{{ $log->user_name }}</div>
                                            <span class="text-small text-muted">{{ $log->description }}.</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-center pt-1 pb-1">
                                <a href="{{ route('dashboard.index') }}" class="btn btn-primary btn-lg btn-round">
                                    View Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documents Review -->
                <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Documents Review as Soon</h4>
                        </div>
                        <div class="card-body" id="chart-cust">
                            <div class="chart-container" style="position: relative; height:300px;">
                                <canvas id="reviewChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .recent-activities {
            max-height: 200px;
            overflow-y: auto;
        }

        .chart-container {
            max-height: 250px;
            width: 100% !important;
        }

        #card-body {
            height: 300px;
        }

        /* CSS khusus untuk Firefox */
        @-moz-document url-prefix() {
            .chart-container canvas {
                max-height: 250px;
                width: 100% !important;
            }

            .card {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    <script>
        // Fungsi untuk inisialisasi chart
        function initializeCharts() {
            try {
                var docs = @json($documentData);
                var dept = @json($departmentData);

                // Fallback jika data tidak ada
                function showChartError(elementId, message) {
                    const container = document.getElementById(elementId).parentNode;
                    container.innerHTML = `<div class="alert alert-warning">${message}</div>`;
                }

                // Pastikan library Chart.js terload
                if (typeof Chart === 'undefined' || typeof ChartDataLabels === 'undefined') {
                    showChartError('documentChart', 'Chart library tidak terload. Silakan refresh halaman.');
                    showChartError('departmentChart', 'Chart library tidak terload. Silakan refresh halaman.');
                    showChartError('reviewChart', 'Chart library tidak terload. Silakan refresh halaman.');
                    return;
                }

                // Inisialisasi chart dokumen
                if (docs && docs.length > 0) {
                    const docCtx = document.getElementById('documentChart').getContext('2d');
                    new Chart(docCtx, {
                        type: "bar",
                        data: {
                            labels: docs.map(item => item.jenis),
                            datasets: [{
                                label: "",
                                data: docs.map(item => item.total),
                                backgroundColor: ["#FF6384", "#FF9F40", "#FFCD56", "#4BC0C0", "#36A2EB"],
                                borderRadius: 10,
                                barPercentage: 1,
                                categoryPercentage: 0.5
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 1000,
                                easing: 'easeOutQuart'
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: true
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else {
                    showChartError('documentChart', 'Data dokumen tidak tersedia');
                }

                // Inisialisasi chart departemen
                if (dept && dept.length > 0) {
                    const deptCtx = document.getElementById('departmentChart').getContext('2d');
                    new Chart(deptCtx, {
                        type: "doughnut",
                        data: {
                            labels: dept.map(item => item.department),
                            datasets: [{
                                data: dept.map(item => item.total),
                                backgroundColor: ["#FF6384", "#FF9F40", "#36A2EB", "#FFCD56", "#4BC0C0"],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                animateScale: true,
                                animateRotate: true,
                                duration: 1000
                            },
                            plugins: {
                                legend: {
                                    position: "bottom"
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.raw + "%";
                                        }
                                    }
                                },
                                datalabels: {
                                    color: "#fff",
                                    font: {
                                        weight: "bold",
                                        size: 14
                                    },
                                    formatter: (value, ctx) => {
                                        const total = ctx.dataset.data.reduce((sum, val) => sum + val, 0);
                                        return ((value / total) * 100).toFixed(0) + "%";
                                    }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                } else {
                    showChartError('departmentChart', 'Data departemen tidak tersedia');
                }

                // Handle resize untuk Firefox
                window.addEventListener('resize', function() {
                    if (window.docChart) window.docChart.resize();
                    if (window.deptChart) window.deptChart.resize();
                });

            } catch (error) {
                console.error("Error in chart initialization:", error);
            }
        }

        // Tunggu sampai DOM dan semua resource selesai dimuat
        if (document.readyState === 'complete') {
            initializeCharts();
        } else {
            document.addEventListener('DOMContentLoaded', initializeCharts);
            window.addEventListener('load', initializeCharts);
        }
    </script>
@endsection
