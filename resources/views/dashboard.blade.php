@extends('layout.app')

@section('content')
    <h3>Dashboard</h3>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informasi Utama</h5>
                        </div>
                        <div class="card-body pt-0 mb-0">
                            <div id="splashCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item">
                                        <img src="{{ asset('src/img/mbg-1.jpg') }}" class="d-block mx-auto" style="width: 600px; height: 250px; object-fit: cover;" alt="Splash 1">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('src/img/mbg-2.jpeg') }}" class="d-block mx-auto" style="width: 600px; height: 250px; object-fit: cover;" alt="Splash 2">
                                    </div>
                                    <div class="carousel-item active">
                                        <img src="{{ asset('src/img/mbg-3.jpeg') }}" class="d-block mx-auto" style="width: 600px; height: 250px; object-fit: cover;" alt="Splash 3">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#splashCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#splashCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                            <p class="mb-0">Selamat datang di Sistem Informasi Rekomendasi Penentuan SDN Penerima Makan Bergizi Gratis. Sistem ini dirancang untuk membantu dalam mengelola data dan merekomendasikan penerima program makan bergizi gratis menggunakan metode ELECTRE. Anda dapat memantau data, serta mengakses berbagai fitur lainnya sesuai dengan hak akses Anda.</p>
                        </div>
                        <div class="card-footer">
                            <p>Download Panduan Penggunaan Aplikasi (<a href="{{ asset('src/buku-panduan.pdf')}} " target="_blank" rel="noopener noreferrer">PDF</a>)</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="d-flex flex-column h-100">
                        <div class="card flex-grow-1">
                            <div class="card-body">
                                <div class="row mt-4">
                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('src/img/wilayah.png') }}" alt="Logo" style="width: 100px; height: 100px;">
                                    </div>
                                    <div class="col-6">
                                        <h5 class="card-title mb-0 mt-3">Jumlah Wilayah</h5>
                                        <p class="fw-bold text-secondary" style="font-size: 4rem;">{{ $totalWilayah }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card flex-grow-1 mb-0">
                            <div class="card-body">
                                <div class="row mt-4">
                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('src/img/sekolah.png') }}" alt="Logo" style="width: 100px; height: 100px;">
                                    </div>
                                    <div class="col-6">
                                        <h5 class="card-title mb-0 mt-3">Jumlah Sekolah</h5>
                                        <p class="fw-bold text-secondary" style="font-size: 4rem;">{{ $totalSekolah }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                @foreach ($dataTertinggi as $item)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">{{ $item['kriteria'] }}</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="{{ $item['name'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('script')
        <script>
            var colors = {
                primary: "#6571ff",
                secondary: "#7987a1",
                success: "#05a34a",
                info: "#66d1d1",
                warning: "#fbbc06",
                danger: "#ff3366",
                light: "#e9ecef",
                dark: "#060c17",
                muted: "#7987a1",
                gridBorder: "rgba(77, 138, 240, .15)",
                bodyColor: "#000",
                cardBg: "#fff"
            }

            var fontFamily = "'Roboto', Helvetica, sans-serif"

            const dataChart = @json($dataTertinggi);

            dataChart.forEach((item, index) => {
                const ctx = document.getElementById(item.name).getContext('2d');
                const labels = item.topData.map(d => d.nama);
                const values = item.topData.map(d => d.nilai);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: item.kriteria,
                            data: values,
                            backgroundColor: 'rgba(5, 163, 74, 0.5)',
                        }]
                    },
                    options: {
                        plugins: {
                            datalabels: {
                                align: 'end',
                                anchor: 'end',
                                color: colors.dark,
                                borderRadius: 5,
                                font: {
                                    size: '9px',
                                    family: fontFamily,
                                    weight: 'bold'
                                },
                                padding: {
                                    top: 4,
                                    bottom: 1,
                                    left: 3,
                                    right: 3
                                }
                            },
                            legend: {
                                display: true,
                                labels: {
                                    color: colors.bodyColor,
                                },
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: item.labelX,
                                    color: colors.bodyColor,
                                    font: {
                                        size: 14,
                                        family: fontFamily,
                                        weight: 'bold'
                                    }
                                },
                                display: true,
                                grid: {
                                    display: true,
                                    color: colors.gridBorder,
                                    borderColor: colors.gridBorder,
                                },
                                ticks: {
                                    color: colors.bodyColor,
                                    font: {
                                        size: 12,
                                        family: fontFamily
                                    }
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: item.labelY,
                                    color: colors.bodyColor,
                                    font: {
                                        size: 14,
                                        family: fontFamily,
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    display: true,
                                    color: colors.gridBorder,
                                    borderColor: colors.gridBorder,
                                },
                                ticks: {
                                    color: colors.bodyColor,
                                    font: {
                                        size: 12,
                                        family: fontFamily
                                    }
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels],
                });
            });
            
            // const chart1 = document.getElementById('barChart').getContext('2d');

            // new Chart(chart1, {
            //     type: 'bar',
            //     data: {
            //         labels: ['Label 1', 'Label 2', 'Label 3'],
            //         datasets: [{
            //             label: 'Dataset 1',
            //             data: [10, 20, 30],
            //             backgroundColor: 'rgba(5, 163, 74, 0.5)',
            //         }]
            //     },
            //     options: {
            //         plugins: {
            //             datalabels: {
            //                 align: 'end',
            //                 anchor: 'end',
            //                 color: colors.dark,
            //                 borderRadius: 5,
            //                 font: {
            //                     size: '9px',
            //                     family: fontFamily,
            //                     weight: 'bold'
            //                 },
            //                 padding: {
            //                     top: 4,
            //                     bottom: 1,
            //                     left: 3,
            //                     right: 3
            //                 }
            //             },
            //             legend: {
            //                 display: true,
            //                 labels: {
            //                     color: colors.bodyColor,
            //                 },
            //             },
            //         },
            //         scales: {
            //             x: {
            //                 title: {
            //                     display: true,
            //                     text: 'Sekolah',
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 14,
            //                         family: fontFamily,
            //                         weight: 'bold'
            //                     }
            //                 },
            //                 display: true,
            //                 grid: {
            //                     display: true,
            //                     color: colors.gridBorder,
            //                     borderColor: colors.gridBorder,
            //                 },
            //                 ticks: {
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 12,
            //                         family: fontFamily
            //                     }
            //                 }
            //             },
            //             y: {
            //                 title: {
            //                     display: true,
            //                     text: 'Persen',
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 14,
            //                         family: fontFamily,
            //                         weight: 'bold'
            //                     }
            //                 },
            //                 grid: {
            //                     display: true,
            //                     color: colors.gridBorder,
            //                     borderColor: colors.gridBorder,
            //                 },
            //                 ticks: {
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 12,
            //                         family: fontFamily
            //                     }
            //                 }
            //             }
            //         }
            //     },
            //     plugins: [ChartDataLabels],
            // });

            // const chart2 = document.getElementById('lineChart').getContext('2d');

            // new Chart(chart2, {
            //     type: 'line',
            //     data: {
            //         labels: ['Label 1', 'Label 2', 'Label 3'],
            //         datasets: [{
            //             label: 'Dataset 1',
            //             data: [10, 20, 30],
            //             borderColor: colors.info,
            //             backgroundColor: 'rgba(102,209,209,.1)',
            //             fill: true,
            //             pointBackgroundColor: colors.cardBg,
            //             pointBorderWidth: 3,
            //             pointHoverBorderWidth: 3,
            //         }]
            //     },
            //     options: {
            //         plugins: {
            //             datalabels: {
            //                 backgroundColor: colors.info,
            //                 color: colors.dark,
            //                 borderRadius: 5,
            //                 font: {
            //                     size: '9px',
            //                     family: fontFamily,
            //                     weight: 'bold'
            //                 },
            //                 padding: {
            //                     top: 4,
            //                     bottom: 1,
            //                     left: 3,
            //                     right: 3
            //                 }
            //             },
            //             legend: {
            //                 display: true,
            //                 labels: {
            //                     color: colors.bodyColor,
            //                 },
            //             },
            //         },
            //         scales: {
            //             x: {
            //                 title: {
            //                     display: true,
            //                     text: 'Sekolah',
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 14,
            //                         family: fontFamily,
            //                         weight: 'bold'
            //                     }
            //                 },
            //                 display: true,
            //                 grid: {
            //                     display: true,
            //                     color: colors.gridBorder,
            //                     borderColor: colors.gridBorder,
            //                 },
            //                 ticks: {
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 12,
            //                         family: fontFamily
            //                     }
            //                 }
            //             },
            //             y: {
            //                 min: 0,
            //                 title: {
            //                     display: true,
            //                     text: 'Percent(%)',
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 14,
            //                         family: fontFamily,
            //                         weight: 'bold'
            //                     }
            //                 },
            //                 grid: {
            //                     display: true,
            //                     color: colors.gridBorder,
            //                     borderColor: colors.gridBorder,
            //                 },
            //                 ticks: {
            //                     color: colors.bodyColor,
            //                     font: {
            //                         size: 12,
            //                         family: fontFamily
            //                     },
            //                     padding: 10,
            //                 }
            //             }
            //         }
            //     },
            //     plugins:[ChartDataLabels],
            // });

            // const dataChart = @json($dataTertinggi);
            // const chartTypes = ['bar', 'pie', 'line'];

            // const pieColors = [
            //     'rgba(255, 99, 132, 0.6)',
            //     'rgba(54, 162, 235, 0.6)',
            //     'rgba(255, 206, 86, 0.6)',
            //     'rgba(75, 192, 192, 0.6)',
            //     'rgba(153, 102, 255, 0.6)',
            //     'rgba(255, 159, 64, 0.6)',
            //     'rgba(199, 199, 199, 0.6)',
            //     'rgba(83, 102, 255, 0.6)',
            //     'rgba(60, 179, 113, 0.6)',
            //     'rgba(255, 140, 0, 0.6)'
            // ];

            // dataChart.forEach((item, index) => {
            //     const ctx = document.getElementById(item.name).getContext('2d');
            //     const labels = item.topData.map(d => d.nama);
            //     const values = item.topData.map(d => d.nilai);
            //     const chartType = chartTypes[index % chartTypes.length];

            //     const backgroundColor = chartType === 'pie'
            //         ? pieColors.slice(0, values.length)
            //         : 'rgba(54, 162, 235, 0.6)';

            //     new Chart(ctx, {
            //         type: chartType,
            //         data: {
            //             labels: labels,
            //             datasets: [{
            //                 label: item.kriteria,
            //                 data: values,
            //                 backgroundColor: backgroundColor,
            //                 borderColor: chartType === 'pie' ? undefined : 'rgba(54, 162, 235, 1)',
            //                 borderWidth: 1
            //             }]
            //         },
            //         options: {
            //             responsive: true,
            //             scales: chartType === 'bar' || chartType === 'line' ? {
            //                 y: {
            //                     beginAtZero: true,
            //                     min: 0
            //                 }
            //             } : {}
            //         }
            //     });
            // });
        </script>
    @endpush
@endsection