<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Arus Kas</title>
    <style>
        body 
        { 
            font-family: sans-serif; 
            font-size: 12px; 
            color: #333; 
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

        .title 
        { 
            text-align: center; 
            margin-bottom: 10px; 
        }

        table 
        { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }

        th, td 
        { 
            border: 1px solid #000; 
            padding: 6px; 
            text-align: left;
        }

        th 
        { 
            background-color: #f0f0f0; 
        }

        .text-end 
        { 
            text-align: right; 
        }

        .summary-row 
        { 
            background-color: #f9f9f9; 
            font-weight: bold; 
        }

        .section-title 
        { 
            background-color: #ddd; 
            font-weight: bold; 
        }

        .footer 
        { 
            margin-top: 30px; 
            text-align: right; 
        }

        .title {
            padding-top: 15px;
            padding-bottom: 15px;
            text-align: center;
            margin-bottom: 10px;
        }

        .title h3 {
            margin: 0;
            font-size: 18px;
        }

        .title p {
            margin: 2px 0;
            font-size: 12px;
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
                <div style="font-size: 16px; font-weight: bold; padding-bottom: 5px;">KOPERASI SMPN 1 CISARUA</div>
                <div style="font-size: 14px;">Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua, Kabupaten Bandung Barat, Jawa Barat 40551</div>
                <div style="font-size: 14px;">Telp: (022) 2700003 | Instagram: @smpn1cisarua</div>
            </td>
        </tr>
    </table>
    <hr style="border: 1px solid #000; margin-top: 5px;">

    <div class="title">
        <h3>Laporan Arus Kas</h3>
        <p>Laporan keuangan arus kas masuk dan kas keluar pada priode saat ini</p>
        <p>Per {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-end">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-title"><td colspan="3">Kas Masuk</td></tr>
            @foreach($kasMasuk as $item)
                <tr>
                    <td></td>
                    <td>{{ $item['keterangan'] }}</td>
                    <td class="text-end">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="summary-row">
                <td colspan="2">Total Kas Masuk</td>
                <td class="text-end">{{ number_format($totalKasMasuk, 0, ',', '.') }}</td>
            </tr>

            <tr class="section-title"><td colspan="3">Kas Keluar</td></tr>
            @foreach($kasKeluar as $item)
                <tr>
                    <td></td>
                    <td>{{ $item['keterangan'] }}</td>
                    <td class="text-end">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="summary-row">
                <td colspan="2">Total Kas Keluar</td>
                <td class="text-end">{{ number_format($totalKasKeluar, 0, ',', '.') }}</td>
            </tr>

            <tr class="summary-row">
                <td colspan="2">Kenaikan Kas Bersih</td>
                <td class="text-end">{{ number_format($kasBersih, 0, ',', '.') }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2">Saldo Kas Awal</td>
                <td class="text-end">{{ number_format($saldoKasAwal, 0, ',', '.') }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2">Saldo Kas Akhir</td>
                <td class="text-end">{{ number_format($saldoKas, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>
</body>
</html>
