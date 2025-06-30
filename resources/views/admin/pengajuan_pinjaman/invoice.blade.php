<div class="text-sm space-y-2">
    <p><strong>Nama:</strong> {{ $pinjaman->user->name }}</p>
    <p><strong>Jumlah Pinjaman:</strong> Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</p>
    <p><strong>Jumlah Harus Dibayar:</strong> Rp {{ number_format($pinjaman->jumlah_harus_dibayar, 0, ',', '.') }}</p>
    <p><strong>Tenor:</strong> {{ $pinjaman->lama_angsuran }} bulan</p>
    <p><strong>Tujuan:</strong> {{ $pinjaman->tujuan }}</p>
    <p><strong>Tanggal Pengajuan:</strong> {{ \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->format('d M Y') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($pinjaman->status) }}</p>
</div>
