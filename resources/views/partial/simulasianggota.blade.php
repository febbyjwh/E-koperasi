<div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
    <h2 class="text-xl md:text-1xl font-semibold text-gray-900 dark:text-white mb-4">
        Simulasi Peminjaman
        <hr class="mt-2 h-1 bg-teal-300 border-0 dark:bg-teal-600 rounded-full">
    </h2>
    <div>
        <form class="w-full">
            <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Masukan Nominal:
            </label>
            <input type="number" id="nominal" value="1000000"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="1.000.000" required>

            <label for="tenor" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Masukan Tenor:
            </label>
            <input type="number" id="tenor" value="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                placeholder="5" required>
        </form>
    </div>

    <div class="mt-4">
        <p id="total-semua" class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal">
            Jumlah uang yang harus dibayar
        </p>
    </div>
    <div class="flex justify-between mb-5 mt-1">
        <div class="grid gap-4 grid-cols-2">
            <!-- Kredit Manasuka -->
            <div>
                <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">
                    Kredit Manasuka
                    <svg data-popover-target="kms-info" data-popover-placement="bottom"
                        class="w-3 h-3 text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div data-popover id="kms-info" role="tooltip"
                        class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3 space-y-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Kredit Manasuka</h3>
                            <p>Kredit Manasuka adalah pinjaman tunai yang diberikan kepada anggota koperasi. Dana bisa
                                digunakan bebas sesuai kebutuhan.</p>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Contoh Perhitungan</h3>
                            <ul class="list-disc list-outside pl-6 text-sm">
                                <li>Pinjam Rp 1.000.000, tenor 5 bulan</li>
                                <li>Bulan 1: Rp 1.000.000 × 2.5% = Rp 25.000 jasa jadi total pokok + jasa = Rp 225.000
                                </li>
                                <li>Bulan berikutnya jasa menurun sesuai sisa pokok</li>
                            </ul>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </h5>
                <p id="total-kms" class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Rp0</p>
            </div>

            <!-- Kredit Barang -->
            <div>
                <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">
                    Kredit Barang
                    <svg data-popover-target="barang-info" data-popover-placement="bottom"
                        class="w-3 h-3 text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <div data-popover id="barang-info" role="tooltip"
                        class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3 space-y-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Kredit Barang</h3>
                            <p>Pembiayaan pembelian barang oleh koperasi. Barang dibeli oleh koperasi lalu diserahkan ke
                                anggota.</p>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Contoh Perhitungan</h3>
                            <ul class="list-disc list-outside pl-6 text-sm">
                                <li>Barang Rp 1.000.000, tenor 5 bulan</li>
                                <li>Jasa flat 2% per bulan</li>
                                <li>Total jasa: Rp 100.000, cicilan: Rp 220.000/bulan</li>
                            </ul>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </h5>
                <p id="total-barang" class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Rp0</p>
            </div>
        </div>
    </div>

    <div id="line-chart"></div>
</div>

<script>
    function hitungSimulasiPinjaman(nominal, tenor) {
        nominal = parseFloat(nominal);
        tenor = parseInt(tenor);

        // Kredit Barang (flat rate)
        const jasaFlatBarang = nominal * 0.02;
        const totalJasaBarang = jasaFlatBarang * tenor;
        const cicilanBarang = Array.from({
            length: tenor
        }, () => (nominal + totalJasaBarang) / tenor);

        // Kredit Manasuka (menurun)
        const pokokBulanan = nominal / tenor;
        let sisaPokok = nominal;
        const cicilanKMS = [];
        for (let i = 0; i < tenor; i++) {
            const jasaBulan = sisaPokok * 0.025;
            cicilanKMS.push(pokokBulanan + jasaBulan);
            sisaPokok -= pokokBulanan;
        }

        return {
            barang: cicilanBarang,
            kms: cicilanKMS
        };
    }

    let chart = null;

    function updateChart() {
        const nominal = document.getElementById("nominal").value;
        const tenor = document.getElementById("tenor").value;

        if (!nominal || !tenor || tenor <= 0) return;

        const hasil = hitungSimulasiPinjaman(nominal, tenor);
        const categories = Array.from({
            length: tenor
        }, (_, i) => `Bulan ${i + 1}`);

        const options = {
            chart: {
                height: "100%",
                type: "line",
                fontFamily: "Inter, sans-serif",
                toolbar: {
                    show: false
                }
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: true,
                strokeDashArray: 4
            },
            series: [{
                    name: "Kredit Manasuka",
                    data: hasil.kms.map(v => Math.round(v)),
                    color: "#1A56DB"
                },
                {
                    name: "Kredit Barang",
                    data: hasil.barang.map(v => Math.round(v)),
                    color: "#7E3AF2"
                }
            ],
            xaxis: {
                categories,
                labels: {
                    style: {
                        fontFamily: "Inter, sans-serif"
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: (val) => `Rp${val.toLocaleString()}`
                }
            }
        };

        if (chart) {
            chart.updateOptions(options);
        } else {
            chart = new ApexCharts(document.getElementById("line-chart"), options);
            chart.render();
        }

        document.getElementById("total-kms").textContent =
            `Rp${Math.round(hasil.kms.reduce((a, b) => a + b, 0)).toLocaleString()}`;
        document.getElementById("total-barang").textContent =
            `Rp${Math.round(hasil.barang.reduce((a, b) => a + b, 0)).toLocaleString()}`;
    }

    document.getElementById("nominal").addEventListener("input", updateChart);
    document.getElementById("tenor").addEventListener("input", updateChart);

    updateChart();
</script>
