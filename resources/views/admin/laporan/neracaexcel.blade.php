<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <!-- Kop Surat -->
    <table>
        <tr>
            <td rowspan="3" style="width: 100px; text-align: center;">
                <img src="{{ public_path('assets/img/logo-new.png') }}" alt="Logo" width="80">
            </td>
            <td style="font-size: 16px; font-weight: bold;">KOPERASI SMPN 1 CISARUA</td>
        </tr>
        <tr>
            <td>Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua</td>
        </tr>
        <tr>
            <td>Telp: (022) 2700003 | Instagram: @smpn1cisarua</td>
        </tr>
    </table>

    <br><br>

    <h3 style="text-align: center;">Laporan Neraca SMPN 1 Cisarua</h3>
    <h4 style="text-align: center; font-weight: normal;">Laporan keuangan yang menunjukkan posisi keuangan koperasi</h4>

    <br>

    <!-- Tabel Data -->
    <table border="1" cellspacing="0" cellpadding="6">
        <thead>
            <tr>
                <th><strong>Kategori</strong></th>
                <th><strong>Keterangan</strong></th>
                <th><strong>Jumlah (Rp)</strong></th>
            </tr>
        </thead>
        <tbody>
            <!-- Aset -->
            <tr>
                <td rowspan="2">Aset</td>
                <td>Kas / Saldo Kas</td>
                <td>{{ number_format($kas, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Piutang Anggota</td>
                <td>{{ number_format($piutang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total Aset</strong></td>
                <td><strong>{{ number_format($total_aset, 0, ',', '.') }}</strong></td>
            </tr>

            <!-- Modal -->
            <tr>
                <td rowspan="3">Modal</td>
                <td>Modal Awal</td>
                <td>{{ number_format($modal_awal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Modal Anggota</td>
                <td>{{ number_format($modal_anggota, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>SHU Ditahan</td>
                <td>{{ number_format($shu_ditahan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Total Modal</strong></td>
                <td><strong>{{ number_format($total_modal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <br><br>

    <div>
        Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
    </div>
</body>
</html>
