<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm mb-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
        Jumlah Pinjaman per Jenis
        <hr class="mt-2 h-0.5 bg-teal-300 border-0 dark:bg-teal-600 rounded-full">
    </h2>
    <div id="bar-pinjaman" style="height: 350px;"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var optionsPinjaman = {
        chart: {
            type: 'bar',
            height: 350
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
                horizontal: false,
            }
        },
        dataLabels: {
            enabled: true
        }
    };

    var chartPinjaman = new ApexCharts(document.querySelector("#bar-pinjaman"), optionsPinjaman);
    chartPinjaman.render();
});
</script>
