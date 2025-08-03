
<div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
    <div>
    <form class="w-full">
        <label for="nominal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Nominal:</label>
        <input type="number" id="nominal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="1.000.000" required>

        <label for="tenor" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Tenor:</label>
        <input type="number" id="tenor" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="5" required>
    </form>
  </div>
  <div class="flex justify-between mb-5">
    <div class="grid gap-4 grid-cols-2">
      <div>
        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Kredit Manasuka
          <svg data-popover-target="clicks-info" data-popover-placement="bottom" class="w-3 h-3 text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
          </svg>
          <div data-popover id="clicks-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
              <div class="p-3 space-y-4">
                  <h3 class="font-semibold text-gray-900 dark:text-white">Kredit Manasuka</h3>
                  <p>Kredit Manasuka adalah pinjaman tunai yang diberikan kepada anggota koperasi. Dana diberikan dalam bentuk uang tunai dan bisa digunakan bebas oleh peminjam sesuai kebutuhan.</p>
                  <h3 class="font-semibold text-gray-900 dark:text-white">Contoh Perhitungan</h3>
                  <ul class="list-disc list-outside pl-6 text-sm text-gray-700 dark:text-gray-200">
                    <li>Jika pinjam Rp 1.000.000 dengan tenor 5 bulan:</li>
                    <li>Jasa bulan pertama: Rp 1.000.000 × 2.5% = Rp 25.000</li>
                    <li>Jasa bulan kedua: (sisa pokok) × 2.5%, dan seterusnya</li>
                    <li>Total jasa berkurang seiring waktu, cicilan menurun tiap bulan</li>
                    <li>Jumlah uang yang diterima sama dengan jumlah uang dipinjam (1.000.000)</li>
                  </ul>
                  {{-- <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"> --}}
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg></a>
              </div>
              <div data-popper-arrow></div>
          </div>
        </h5>
        <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Rp.0</p>
      </div>
      <div>
        <h5 class="inline-flex items-center text-gray-500 dark:text-gray-400 leading-none font-normal mb-2">Kredit Barang
        <svg data-popover-target="cpc-info" data-popover-placement="bottom" class="w-3 h-3 text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
          </svg>
          <div data-popover id="cpc-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
              <div class="p-3 space-y-2">
                  <h3 class="font-semibold text-gray-900 dark:text-white">Kredit Barang</h3>
                  <p>Kredit Barang adalah pembiayaan pembelian barang yang diberikan oleh koperasi. Dana tidak diberikan dalam bentuk uang, tapi barang dibeli oleh koperasi dan diserahkan ke anggota.</p>
                  <h3 class="font-semibold text-gray-900 dark:text-white">Contoh Perhitungan</h3>
                  <ul class="list-disc list-outside pl-6 text-sm text-gray-700 dark:text-gray-200">
                    <li>Jika beli barang senilai Rp 1.000.000 dengan tenor 5 bulan:</li>
                    <li>Jasa flat per bulan: Rp 1.000.000 × 2% = Rp 20.000</li>
                    <li>Total jasa: Rp 20.000 × 5 = Rp 100.000</li>
                    <li>Total yang dibayar: Rp 1.100.000, cicilan per bulan: Rp 220.000</li>
                    <li>Propisi 2% = Rp 20.000 → uang yang dibayarkan koperasi ke toko tetap Rp 1.000.000, tapi nilai pembiayaan yang dicairkan ke anggota adalah Rp 980.000</li>
                  </ul>
                  {{-- <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"> --}}
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg></a>
              </div>
              <div data-popper-arrow></div>
          </div>
        </h5>
        <p class="text-gray-900 dark:text-white text-2xl leading-none font-bold">Rp.0</p>
      </div>
    </div>
    <div>
      {{-- <button id="dropdownDefaultButton"
        data-dropdown-toggle="lastDaysdropdown"
        data-dropdown-placement="bottom" type="button" class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Last week <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
    </svg></button> --}}
    <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a>
            </li>
          </ul>
      </div>
    </div>
  </div>
  <div id="line-chart"></div>
  {{-- <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between mt-2.5">
    <div class="pt-5">      
      <a href="#" class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <svg class="w-3.5 h-3.5 text-white me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
          <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2Zm-3 15H4.828a1 1 0 0 1 0-2h6.238a1 1 0 0 1 0 2Zm0-4H4.828a1 1 0 0 1 0-2h6.238a1 1 0 1 1 0 2Z"/>
          <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
        </svg>
        View full report
      </a>
    </div>
  </div> --}}
</div>

<script>
const options = {
  chart: {
    height: "100%",
    maxWidth: "100%",
    type: "line",
    fontFamily: "Inter, sans-serif",
    dropShadow: {
      enabled: false,
    },
    toolbar: {
      show: false,
    },
  },
  tooltip: {
    enabled: true,
    x: {
      show: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 6,
  },
  grid: {
    show: true,
    strokeDashArray: 4,
    padding: {
      left: 2,
      right: 2,
      top: -26
    },
  },
  series: [
    {
      name: "Clicks",
      data: [6500, 6418, 6456, 6526, 6356, 6456],
      color: "#1A56DB",
    },
    {
      name: "CPC",
      data: [6456, 6356, 6526, 6332, 6418, 6500],
      color: "#7E3AF2",
    },
  ],
  legend: {
    show: false
  },
  stroke: {
    curve: 'smooth'
  },
  xaxis: {
    categories: ['01 Feb', '02 Feb', '03 Feb', '04 Feb', '05 Feb', '06 Feb', '07 Feb'],
    labels: {
      show: true,
      style: {
        fontFamily: "Inter, sans-serif",
        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
      }
    },
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
  },
  yaxis: {
    show: false,
  },
}

if (document.getElementById("line-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.getElementById("line-chart"), options);
  chart.render();
}

</script>
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

  return {
    barang: cicilanBarang,
    kms: cicilanKMS,
  };
}
</script>
<script>
document.getElementById("nominal").addEventListener("input", updateChart);
document.getElementById("tenor").addEventListener("input", updateChart);

let chart = null;

function updateChart() {
  const nominal = document.getElementById("nominal").value;
  const tenor = document.getElementById("tenor").value;

  if (!nominal || !tenor || tenor <= 0) return;

  const hasil = hitungSimulasiPinjaman(nominal, tenor);
  const categories = Array.from({ length: hasil.barang.length }, (_, i) => `Bulan ${i + 1}`);

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
    grid: {
      show: true,
      strokeDashArray: 4,
    },
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

  // Update text nilai total cicilan
  document.querySelectorAll('.text-2xl.leading-none.font-bold')[0].textContent = `Rp${Math.round(hasil.kms.reduce((a,b) => a + b, 0)).toLocaleString()}`;
  document.querySelectorAll('.text-2xl.leading-none.font-bold')[1].textContent = `Rp${Math.round(hasil.barang.reduce((a,b) => a + b, 0)).toLocaleString()}`;
}
</script>
