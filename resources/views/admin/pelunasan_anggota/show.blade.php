@extends('layout')

@section('content')
<div class="max-w-full mx-auto bg-white shadow-md p-6 rounded-lg">
    <h2 class="text-xl font-semibold mb-4">Detail Angsuran</h2>
    <table class="min-w-full border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Bulan Ke</th>
                <th class="px-4 py-2 border">Pokok</th>
                <th class="px-4 py-2 border">Bunga</th>
                <th class="px-4 py-2 border">Total Angsuran</th>
                <th class="px-4 py-2 border">Status Pelunasan</th>
                <th class="px-4 py-2 border">Tanggal Bayar</th>
                <th class="px-4 py-2 w-10 border">Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelunasans as $pelunasan)
                <tr>
                    <td class="px-4 py-2 border">{{ $pelunasan->bulan_ke }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($pelunasan->pokok, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($pelunasan->bunga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($pelunasan->total_angsuran, 0, ',', '.') }}</td>
                    <td class="px-4 py-2 border">{{ ucfirst($pelunasan->status) }}</td>
                    <td class="px-4 py-2 border">{{ $pelunasan->tanggal_bayar ?? 'Belum Bayar' }}</td>
                    <td class="px-4 py-2 border">
                        @if($pelunasan->status !== 'lunas')
                            {{-- <form action="{{ route('pelunasan_anggota.bayar', $pelunasan->id) }}" method="POST"> --}}
                            <form action="" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Bayar</button>
                            </form>
                        @else
                            <span class="text-green-600 font-semibold">Lunas</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <a href="{{ route('pelunasan_anggota.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">← Kembali</a>
    </div>
</div>
@endsection
