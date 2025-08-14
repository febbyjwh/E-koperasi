<div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
  <div>
    <form class="w-full">
      <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Masukan Nominal:
      </label>
      <input type="number" id="nominal" value="5000000"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
        placeholder="1.000.000" required>

      <label for="tenor" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">
        Masukan Tenor:
      </label>
      <input type="number" id="tenor" value="10"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
        placeholder="5" required>
    </form>
  </div>

  <div class="flex justify-between mb-5 mt-4">
    <div class="grid gap-4 grid-cols-2">
      <div>
        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">
          Kredit Manasuka
        </h5>
        <p id="total-kms" class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Rp0</p>
      </div>
      <div>
        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">
          Kredit Barang
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
    const cicilanBarang = Array.from({ length: tenor }, () => (nominal + totalJasaBarang) / tenor);

    // Kredit Manasuka (menurun)
    const pokokBulanan = nominal / tenor;
    let sisaPokok = nominal;
    const cicilanKMS = [];
    for (let i = 0; i < tenor; i++) {
      const jasaBulan = sisaPokok * 0.025;
      cicilanKMS.push(pokokBulanan + jasaBulan);
      sisaPokok -= pokokBulanan;
    }

    return { barang: cicilanBarang, kms: cicilanKMS };
  }

  let chart = null;

  function updateChart() {
    const nominal = document.getElementById("nominal").value;
    const tenor = document.getElementById("tenor").value;

    if (!nominal || !tenor || tenor <= 0) return;

    const hasil = hitungSimulasiPinjaman(nominal, tenor);
    const categories = Array.from({ length: tenor }, (_, i) => `Bulan ${i + 1}`);

    const options = {
      chart: {
        height: "100%",
        maxWidth: "100%",
        type: "line",
        fontFamily: "Inter, sans-serif",
        toolbar: { show: false }
      },
      stroke: { width: 3, curve: 'smooth' },
      dataLabels: { enabled: false },
      grid: { show: true, strokeDashArray: 4 },
      series: [
        {
          name: "Kredit Manasuka",
          data: hasil.kms.map(v => Math.round(v)),
          color: "#1A56DB",
        },
        {
          name: "Kredit Barang",
          data: hasil.barang.map(v => Math.round(v)),
          color: "#7E3AF2",
        }
      ],
      xaxis: {
        categories: categories,
        labels: {
          style: {
            fontFamily: "Inter, sans-serif",
            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
          }
        },
      },
      yaxis: {
        labels: {
          formatter: (val) => `Rp${val.toLocaleString()}`,
        }
      }
    };

    if (chart) {
      chart.updateOptions(options);
    } else {
      chart = new ApexCharts(document.getElementById("line-chart"), options);
      chart.render();
    }

    // Update total nilai
    document.getElementById("total-kms").textContent = `Rp${Math.round(hasil.kms.reduce((a, b) => a + b, 0)).toLocaleString()}`;
    document.getElementById("total-barang").textContent = `Rp${Math.round(hasil.barang.reduce((a, b) => a + b, 0)).toLocaleString()}`;
  }

  // Event listener untuk input
  document.getElementById("nominal").addEventListener("input", updateChart);
  document.getElementById("tenor").addEventListener("input", updateChart);

  // Render awal
  updateChart();
</script>
