<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 w-full max-w-lg mx-auto">
    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
        Distribusi Tabungan Wajib & Manasuka
    </h3>
    <div id="pie-chart-tabungan" class="w-full h-64"></div>
</div>

<!-- Pie Chart -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl flex-1">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
        Distribusi Tabungan
    </h2>
    <div id="pie-chart" class="w-full h-64"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
        stroke: { width: 2, colors: ['#fff'] },
        dataLabels: {
            enabled: true,
            style: { fontSize: '14px', colors: ['#fff'] },
            formatter: function(val, opts) {
                var total = opts.w.globals.seriesTotals.reduce((a,b) => a+b, 0);
                var percent = (opts.w.globals.series[opts.seriesIndex] / total * 100).toFixed(1);
                return opts.w.config.labels[opts.seriesIndex] + "\nRp " + opts.w.globals.series[opts.seriesIndex].toLocaleString() + " (" + percent + "%)";
            }
        },
        legend: { position: 'bottom' },
        responsive: [
            { breakpoint: 1024, options: { chart: { height: 250 } } },
            { breakpoint: 640, options: { chart: { height: 200 }, legend: { position: 'bottom' } } }
        ]
    };

    var pieChart = new ApexCharts(document.querySelector("#pie-chart"), pieOptions);
    pieChart.render();
});
</script>

