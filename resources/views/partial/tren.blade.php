<!-- Tambahkan di blade dashboard -->
<div id="chart" class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow my-6"></div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Ambil data dari backend (Blade)
    const pengajuanData = @json($pengajuanPerBulan);

    const data = pengajuanData.map(item => {
        return {
            x: new Date(item.bulan + '-01').getTime(),
            y: item.jumlah
        };
    });

    const XAXISRANGE = 365 * 24 * 60 * 60 * 1000; // 1 tahun

    var options = {
        series: [{
            data: data.slice()
        }],
        chart: {
            id: 'realtime',
            height: 350,
            type: 'line',
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 1000
                }
            },
            toolbar: {
                show: true
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Tren Pengajuan Pinjaman per Bulan',
            align: 'left'
        },
        markers: {
            size: 4
        },
        xaxis: {
            type: 'datetime',
            labels: {
                format: 'MMM yyyy'
            },
            range: XAXISRANGE
        },
        yaxis: {
            title: {
                text: 'Jumlah Pengajuan'
            }
        },
        legend: {
            show: false
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
