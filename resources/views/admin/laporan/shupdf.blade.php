<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SHU</title>
    <style>
        body 
        { 
            font-family: sans-serif; 
            font-size: 12px; 
        }

        h2, h4 
        { 
            text-align: center; 
            margin: 0; 
        }

        table 
        { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }

        th, td 
        { 
            border: 1px solid #ddd; 
            padding: 8px; 
        }

        th 
        { 
            background: #f4f4f4; 
        }

        .summary 
        { 
            font-weight: bold; 
            background: #f4f4f4; 
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
                <div style="font-size: 14px;">Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua, Kabupaten Bandung Barat,</div> 
                <div style="font-size: 14px;"> Jawa Barat 40551</div>
                <div style="font-size: 14px;">Telp: (022) 2700003 | Instagram: @smpn1cisarua</div>
            </td>
        </tr>
    </table>
    <hr style="border: 1px solid #000; margin-top: 5px;">

    <h3 style="text-align: center; margin-bottom: 4px; margin-top:20px;">Laporan Sisa Hasil Usaha (SHU) SMPN 1 Cisarua</h3>
    <h4 style="text-align: center; font-weight: normal; margin-top: 0;">Laporan Pembagian Sisa Hasil Usaha Koperasi</h4>
    
    <p style="text-align:center;">Periode: {{ $periode }}</p>

    <!-- Tabel Laporan SHU -->
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th style="text-align:right;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pendapatan (Bunga Pinjaman)</td>
                <td style="text-align:right;">{{ number_format($pendapatan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Operasional (10%)</td>
                <td style="text-align:right;">- {{ number_format($biaya_operasional, 0, ',', '.') }}</td>
            </tr>
            <tr class="summary">
                <td>SHU Bersih</td>
                <td style="text-align:right;">{{ number_format($shu_bersih, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Pembagian SHU -->
    <h3 style="margin-top: 20px;">Pembagian SHU</h3>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th style="text-align:right;">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Jasa Pinjaman (40%)</td>
                <td style="text-align:right;">{{ number_format($porsi['jasa_pinjaman'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Jasa Simpanan (35%)</td>
                <td style="text-align:right;">{{ number_format($porsi['jasa_simpanan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Dana Cadangan (15%)</td>
                <td style="text-align:right;">{{ number_format($porsi['dana_cadangan'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Dana Sosial (5%)</td>
                <td style="text-align:right;">{{ number_format($porsi['dana_sosial'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Pengurus (5%)</td>
                <td style="text-align:right;">{{ number_format($porsi['pengurus'], 0, ',', '.') }}</td>
            </tr>
            <tr class="summary">
                <td>Total Pembagian SHU</td>
                <td style="text-align:right;">{{ number_format(array_sum($porsi), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
