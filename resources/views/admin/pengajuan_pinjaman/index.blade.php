@extends('layout')

@section('title', 'Konfirmasi Pengajuan Pinjaman')

@section('content')
@include('components.alert')


<div class="p-4 bg-white rounded-2xl shadow-lg mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <h2 class="text-lg md:text-xl font-semibold text-gray-700">Daftar Pengajuan Pinjaman</h2>

        <form action="{{ route('pengajuan_pinjaman.index') }}" method="GET" class="w-full md:max-w-md">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari...">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <button type="submit"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-lightgray-700 text-gray font-medium rounded-lg text-sm px-4 py-2 h-10">
                    Cari
                </button>
            </div>
        </form>

        <a href="{{ route('pengajuan_pinjaman.create') }}"
            class="inline-block px-4 py-2 text-sm bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
            Tambah Pengajuan
        </a>
    </div>
</div>

{{-- Tabel Pengajuan --}}
@include('admin.pengajuan_pinjaman.table', [
    'judul' => 'Pengajuan Menunggu Konfirmasi',
    'data' => $pengajuanPending,
    'showKonfirmasi' => true,
])

@include('admin.pengajuan_pinjaman.table', [
    'judul' => 'Pengajuan Disetujui',
    'data' => $pengajuanDisetujui,
])

@include('admin.pengajuan_pinjaman.table', [
    'judul' => 'Pengajuan Ditolak',
    'data' => $pengajuanDitolak,
])
@endsection
