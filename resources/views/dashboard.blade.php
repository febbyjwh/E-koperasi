@extends('layout')

@section('title', 'Dashboard')

@section('content')

    <head>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
        <style>
            #pie-chart,
            #bar-pinjaman {
                height: 300px;
            }

            .stat-card {
                @apply p-6 rounded-xl shadow-lg bg-gradient-to-r from-teal-400 to-cyan-500 text-white;
                transition: transform 0.2s;
            }

            .stat-card:hover {
                transform: translateY(-4px);
            }

            .stat-value {
                @apply text-2xl font-bold mt-2;
            }

            .stat-label {
                @apply text-sm opacity-80;
            }

            .hide-scrollbar::-webkit-scrollbar {
                display: none;
                /* Chrome, Safari, Opera */
            }

            .hide-scrollbar {
                -ms-overflow-style: none;
                /* IE 10+ */
                scrollbar-width: none;
                /* Firefox */
            }
        </style>
    </head>

    <div class="container mx-auto px-6 mt-5">
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Kiri: Simulasi -->
            <div class="lg:w-1/4 flex-shrink-0">
                @include('partial.simulasi')
            </div>

            <!-- Tengah: 4 Card Vertikal -->
            <div class="lg:w-1/3 flex flex-col gap-6">
                @include('partial.card')

                <!-- Tabel Pinjaman Scrollable -->
                <div class="p-4 bg-gray-900 rounded-2xl shadow-lg hide-scrollbar"
                    style="max-height: 293px; overflow-y: auto;">
                    <h2 class="text-lg font-semibold text-white mb-2">Daftar Pinjaman</h2>
                    <table class="min-w-full text-left text-gray-100">
                        <thead class="bg-gray-800 sticky top-0">
                            <tr>
                                <th class="px-4 py-2">Nama</th>
                                <th class="px-4 py-2">Nominal Pinjaman</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($pengajuan as $item)
                                <tr class="hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ $item->user->name }}</td>
                                    <td class="px-4 py-2">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="@if ($item->status == 'aktif') text-green-400 @elseif($item->status == 'penting') text-yellow-400 @else text-gray-400 @endif font-semibold">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>

            <!-- Kanan: Charts -->
            <div class="lg:w-2/4 flex flex-col gap-6">
                <!-- Pie Chart -->
                <div class="p-6 rounded-2xl shadow-xl flex-1"
                    style="background: linear-gradient(135deg, #4ade80 0%, #06b6d4 100%); color: #fff;">
                    <h2 class="text-xl font-semibold mb-4">Distribusi Tabungan</h2>
                    <div id="pie-chart" class="w-full h-64"></div>
                </div>

                <!-- Bar Chart -->
                <div class="p-6 rounded-2xl shadow-xl flex-1"
                    style="background: linear-gradient(135deg, #facc15 0%, #f97316 100%); color: #fff;">
                    <h2 class="text-xl font-semibold mb-4">Jumlah Pinjaman per Jenis</h2>
                    <div id="bar-pinjaman" class="w-full h-64"></div>
                </div>
            </div>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pie Chart
            var pieOptions = {
                chart: {
                    type: 'pie',
                    height: 300,
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 2,
                        blur: 4,
                        opacity: 0.15
                    }
                },
                series: [{{ $totalTabunganWajib }}, {{ $totalTabunganManasuka }}],
                labels: ['Tabungan Wajib', 'Tabungan Manasuka'],
                colors: ['#38bdf8', '#0d9488'],
                stroke: {
                    width: 2,
                    colors: ['#fff']
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '14px',
                        colors: ['#fff']
                    },
                    formatter: function(val, opts) {
                        var total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                        var percent = (opts.w.globals.series[opts.seriesIndex] / total * 100).toFixed(1);
                        return opts.w.config.labels[opts.seriesIndex] + "\nRp " + opts.w.globals.series[opts
                            .seriesIndex].toLocaleString() + " (" + percent + "%)";
                    }
                },
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                        breakpoint: 1024,
                        options: {
                            chart: {
                                height: 250
                            }
                        }
                    },
                    {
                        breakpoint: 640,
                        options: {
                            chart: {
                                height: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                ]
            };
            new ApexCharts(document.querySelector("#pie-chart"), pieOptions).render();

            // Bar Chart
            var barOptions = {
                chart: {
                    type: 'bar',
                    height: 300
                },
                series: [{
                    name: 'Jumlah Pinjaman',
                    data: [{{ $pinjamanBarang }}, {{ $pinjamanManasuka }}]
                }],
                xaxis: {
                    categories: ['Barang', 'Manasuka']
                },
                colors: ['#0d9488'],
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: true
                }
            };
            new ApexCharts(document.querySelector("#bar-pinjaman"), barOptions).render();
        });
    </script>

@endsection
