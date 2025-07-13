<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Neraca</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-end {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .kop-surat 
        { 
            text-align: center; 
            border-bottom: 2px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }

        .kop-surat h2 
        { 
            margin: 0; 
            font-size: 18px; 
        }

        .kop-surat p 
        { 
            margin: 0; 
            font-size: 12px; 
        }

        .kop-surat, .kop-surat td 
        {
            border: none !important;
            padding: 0 !important;
        }
    </style>
</head>
<body>
    <table class="kop-surat">
        <tr>
            <td style="width: 15%; text-align: center;">
                <img src="{{ public_path('assets/img/logo-new.png') }}" alt="Logo" width="80">
            </td>
            <td style="text-align: center;">
                <div style="font-size: 16px; font-weight: bold;">KOPERASI SMPN 1 CISARUA</div>
                <div style="font-size: 14px;">Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua, Kabupaten Bandung Barat, Jawa Barat 40551</div>
                <div style="font-size: 14px;">Telp: (022) 2700003 | Instagram: @smpn1cisarua</div>
            </td>
        </tr>
    </table>

    <hr style="border: 1px solid #000; margin-top: 5px;">

    <h2 style="text-align: center; margin-bottom: 4px;">Laporan Neraca SMPN 1 Cisarua</h2>
    <h4 style="text-align: center; font-weight: normal; margin-top: 0;">Laporan keuangan yang menunjukkan posisi keuangan koperasi</h4>

    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- ASET -->
            <tr>
                <td rowspan="2">Aset</td>
                <td>Kas / Saldo Kas</td>
                <td class="text-end">{{ number_format($kas, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Piutang Anggota</td>
                <td class="text-end">{{ number_format($piutang, 0, ',', '.') }}</td>
            </tr>
            <tr class="bold">
                <td colspan="2">Total Aset</td>
                <td class="text-end">{{ number_format($total_aset, 0, ',', '.') }}</td>
            </tr>

            <!-- MODAL -->
            <tr>
                <td rowspan="3">Modal</td>
                <td>Modal Awal</td>
                <td class="text-end">{{ number_format($modal_awal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Modal Anggota</td>
                <td class="text-end">{{ number_format($modal_anggota, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>SHU Ditahan</td>
                <td class="text-end">{{ number_format($shu_ditahan, 0, ',', '.') }}</td>
            </tr>
            <tr class="bold">
                <td colspan="2">Total Modal</td>
                <td class="text-end">{{ number_format($total_modal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: right; margin-top: 30px;">
        Dicetak pada: {{ $tanggal_cetak }}
    </p>

</body>
</html>
