<table>
    <tr>
        <td colspan="3" style="text-align: center; font-weight: bold;">LAPORAN ARUS KAS SMPN 1 CISARUA</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;">Periode: {{ $periode }}</td>
    </tr>
    <tr><td colspan="3"></td></tr>

    <tr style="font-weight: bold;">
        <td>Kategori</td>
        <td>Keterangan</td>
        <td>Jumlah (Rp)</td>
    </tr>

    <!-- Kas Masuk -->
    @foreach ($kasMasuk as $index => $item)
        <tr>
            @if ($index === 0)
                <td rowspan="{{ count($kasMasuk) + 1 }}">Kas Masuk</td>
            @endif
            <td>{{ $item['keterangan'] }}</td>
            <td>{{ $item['jumlah'] }}</td>
        </tr>
    @endforeach
    <tr style="font-weight: bold;">
        <td>Total Kas Masuk</td>
        <td>{{ $totalKasMasuk }}</td>
    </tr>

    <!-- Kas Keluar -->
    @foreach ($kasKeluar as $index => $item)
        <tr>
            @if ($index === 0)
                <td rowspan="{{ count($kasKeluar) + 1 }}">Kas Keluar</td>
            @endif
            <td>{{ $item['keterangan'] }}</td>
            <td>{{ $item['jumlah'] }}</td>
        </tr>
    @endforeach
    <tr style="font-weight: bold;">
        <td>Total Kas Keluar</td>
        <td>{{ $totalKasKeluar }}</td>
    </tr>

    <!-- Ringkasan -->
    <tr style="font-weight: bold;">
        <td colspan="2">Kenaikan Kas Bersih</td>
        <td>{{ $kasBersih }}</td>
    </tr>
    <tr style="font-weight: bold;">
        <td colspan="2">Saldo Kas Awal</td>
        <td>{{ $saldoKasAwal }}</td>
    </tr>
    <tr style="font-weight: bold;">
        <td colspan="2">Saldo Kas Akhir</td>
        <td>{{ $saldoKas }}</td>
    </tr>
</table>
