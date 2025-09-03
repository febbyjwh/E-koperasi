@extends('layout')

@section('title', 'Bukti Pelunasan Pinjaman')

@section('content')
    <div class="w-full max-w-3xl mx-auto p-4">
        <div class="flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-800">
            <div class="relative overflow-hidden min-h-32 bg-gray-900 text-center rounded-t-xl dark:bg-neutral-950">
                <div class="text-white py-4">
                    <h1 class="text-2xl font-bold">KOPERASI SMPN 1 CISARUA</h1>
                    <p class="text-sm">Jl. Kolonel Masturi No.312, Kertawangi, Cisarua, Bandung Barat 40551</p>
                </div>
                <figure class="absolute inset-x-0 bottom-0 -mb-px">
                    <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 100.1">
                        <path fill="currentColor" class="fill-white dark:fill-neutral-800"
                            d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"></path>
                    </svg>
                </figure>
            </div>

            <div class="relative z-10 -mt-12">
                <span
                    class="mx-auto flex justify-center items-center size-15.5 rounded-full border border-gray-200 bg-white text-gray-700 shadow-2xs dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                    🧾
                </span>
            </div>

            <div class="p-4 sm:p-7 overflow-y-auto">
                <div class="text-center">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Bukti Pelunasan Pinjaman</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-500">Bukti #{{ $invoiceId }}</p>
                </div>

                <div class="mt-5 sm:mt-10 flex flex-col sm:flex-row justify-between gap-5">
                    <div>
                        <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Jumlah Dibayar:</span>
                        <span
                            class="block text-sm font-medium text-gray-800 dark:text-neutral-200">Rp{{ number_format($jumlahDibayar, 2, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Tanggal:</span>
                        <div class="text-sm font-medium text-gray-800 dark:text-neutral-200">
                            <span>{{ \Carbon\Carbon::parse($pelunasan->tanggal_bayar)->format('d M Y') }}</span>
                            {{-- <span class="text-xs text-gray-500 dark:text-neutral-400">Jam:
                                {{ \Carbon\Carbon::parse($tanggal)->format('H:i') }}</span> --}}
                        </div>
                    </div>
                    <div>
                        <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Metode:</span>
                        <span
                            class="block text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $metode }}</span>
                    </div>
                </div>

                <div class="mt-5 sm:mt-10">
                    <h4 class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Rincian</h4>
                    <ul class="mt-3 flex flex-col">
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Nama Anggota</span>
                            <span>{{ $nama }}</span>
                        </li>
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Jumlah Pinjaman</span>
                            <span>Rp{{ number_format($jumlahPinjaman, 2, ',', '.') }}</span>
                        </li>
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Jumlah Dibayar</span>
                            Rp{{ number_format($jumlahDibayar, 2, ',', '.') }}
                        </li>
                        {{-- <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Sisa Cicilan</span>
                            <span>Rp{{ number_format($sisaCicilan, 2, ',', '.') }}</span>
                        </li> --}}
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Metode Pembayaran</span>
                            <span>{{ $metode }}</span>
                        </li>
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Tanggal Pengajuan</span>
                            <span>{{ \Carbon\Carbon::parse($tanggalPengajuan)->format('d M Y') }}</span>
                        </li>
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Tanggal Dikonfirmasi</span>
                            <span>{{ \Carbon\Carbon::parse($tanggalDikonfirmasi)->format('d M Y') }}</span>
                        </li>
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Tanggal Dibayar</span>
                            <span>{{ \Carbon\Carbon::parse($tanggalBayar)->format('d M Y H:i') }}</span>
                        </li>
                        <li class="inline-flex justify-between py-2 px-4 border">
                            <span>Status</span>
                            <span>{{ ucfirst($status) }}</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    @php $isAdmin = auth()->user()->role === 'admin'; @endphp

                    <a href="{{ $isAdmin ? route('pelunasan_anggota.index') : route('cicilan_anggota.pelunasan_anggota.show', $pelunasan->id) }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">
                        Kembali
                    </a>

                    <a href="{{ route('print.buktipdf', $pelunasan->id) }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-blue-700 text-white shadow-2xs hover:bg-blue-500 dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                        Bukti PDF
                    </a>
                </div>

                <div class="mt-5 sm:mt-10">
                    <p class="text-sm text-gray-500 dark:text-neutral-500">
                        Jika ada kesalahan dalam bukti pelunasan ini silakan hubungi
                        <a class="text-blue-600 hover:underline dark:text-blue-500" href="tel:+62222700003">(022)
                            2700003</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
