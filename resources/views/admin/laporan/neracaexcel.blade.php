<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
        .kop td {
            border: none;
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <table class="kop">
        <tr>
            <td rowspan="3" style="width: 100px; text-align: center;">
                <img src="{{ public_path('assets/img/logo-new.png') }}" alt="Logo" width="80">
            </td>
            <td class="bold" style="font-size: 16px;">KOPERASI SMPN 1 CISARUA</td>
        </tr>
        <tr>
            <td>Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua</td>
        </tr>
        <tr>
            <td>Telp: (022) 2700003 | Instagram: @smpn1cisarua</td>
        </tr>
    </table>

    <br><br>

    <h3 class="center">Laporan Neraca SMPN 1 Cisarua</h3>
    <h4 class="center" style="font-weight: normal;">Laporan keuangan yang menunjukkan posisi keuangan koperasi</h4>

    <br>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aset -->
            <tr>
                <td rowspan="2">Aset</td>
                <td>Kas / Saldo Kas</td>
                <td class="right">{{ number_format($kas, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Piutang Anggota</td>
                <td class="right">{{ number_format($piutang, 0, ',', '.') }}</td>
            </tr>
            <tr class="bold">
                <td colspan="2">Total Aset</td>
                <td>{{ number_format($total_aset, 0, ',', '.') }}</td>
            </tr>

            <!-- Modal -->
            <tr>
                <td rowspan="3">Modal</td>
                <td>Modal Awal</td>
                <td class="right">{{ number_format($modal_awal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Modal Anggota</td>
                <td class="right">{{ number_format($modal_anggota, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>SHU Ditahan</td>
                <td class="right">{{ number_format($shu_ditahan, 0, ',', '.') }}</td>
            </tr>
            <tr class="bold">
                <td colspan="2">Total Modal</td>
                <td>{{ number_format($total_modal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <br><br>

    <div>
        Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
    </div>
</body>
</html>
