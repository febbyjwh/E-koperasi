@extends('layout')

@section('title', 'Invoice Pengajuan Pinjaman')

@section('content')
<!-- Invoice Page -->
<div id="hs-ai-page" class="w-full max-w-3xl mx-auto p-4">
  <div class="flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-800">
    <div class="relative overflow-hidden min-h-32 bg-gray-900 text-center rounded-t-xl dark:bg-neutral-950">
        <div class="text-white py-4">
          <h1 class="text-2xl font-bold">KOPERASI SMPN 1 CISARUA</h1>
          <p class="text-sm">Jl. Kolonel Masturi No.312, Kertawangi, Kec. Cisarua, Kabupaten Bandung Barat, Jawa Barat 40551</p>
        </div>
      <!-- Logo -->

  <!-- Header SVG Decoration -->
  <figure class="absolute inset-x-0 bottom-0 -mb-px">
      <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
        <path fill="currentColor" class="fill-white dark:fill-neutral-800" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"></path>
      </svg>
    </figure>
  </div>

    <div class="relative z-10 -mt-12">
    <!-- Icon -->
    <span class="mx-auto flex justify-center items-center size-15.5 rounded-full border border-gray-200 bg-white text-gray-700 shadow-2xs dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
        <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z"/>
          <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </span>
    </div>

    <!-- Body -->
    <div class="p-4 sm:p-7 overflow-y-auto">
      <div class="text-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Bukti Pencairan Dana Koperasi</h3>
        @php
          $invoiceId = 'PINDA' . str_pad($pinjaman->id, 3, '0', STR_PAD_LEFT) . '-' . $tanggal->format('dmY');
        @endphp
        <p class="text-sm text-gray-500 dark:text-neutral-500">Bukti #{{ $invoiceId }}</p>
      </div>

      <!-- Grid -->
      <div class="mt-5 sm:mt-10 flex flex-col sm:flex-row justify-between gap-5">
        <div>
          <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Dana Diterima:</span>
          <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">Rp{{ number_format($jumlah_diterima, 2, ',', '.') }}</span>
        </div>
        <div>
          <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Tanggal:</span>
          <div class="text-sm font-medium text-gray-800 dark:text-neutral-200">
            <span>{{ $tanggal->format('d M Y') }}</span><br>
            <span class="text-xs text-gray-500 dark:text-neutral-400">
              Jam: {{ $tanggal->format('H:i') }}
            </span>
          </div>
        </div>
        <div>
          <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Metode Pembayaran:</span>
          <div class="flex items-center gap-x-2">
            <!-- SVG Logo -->
            <!-- (gunakan logo pembayaran seperti sebelumnya) -->
            <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">Tunai</span>
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div class="mt-5 sm:mt-10">
        <h4 class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Rincian</h4>
        <ul class="mt-3 flex flex-col">
          <li class="inline-flex items-center justify-between py-3 px-4 text-sm border border-gray-200 dark:border-neutral-700">
            <span>Nama Peminjam</span>
            <span>{{ $nama }}</span>
          </li>
          <li class="inline-flex items-center justify-between py-3 px-4 text-sm border border-gray-200 dark:border-neutral-700">
            <span>Dana Pinjaman</span>
            <span>Rp{{ number_format($jumlah_pinjaman, 2, ',', '.') }}</span>
          </li>
          <li class="inline-flex flex-col py-3 px-4 text-sm border border-gray-200 dark:border-neutral-700">
            <div class="flex items-center justify-between w-full">
              <span>Propisi</span>
              <span>Rp{{ number_format($propisi, 2, ',', '.') }}</span>
            </div>
            <p class="text-xs text-gray-500 mt-1 text-right">
              ({{ number_format(($propisi / $jumlah_pinjaman) * 100) }}% dari dana pinjaman)
            </p>
          </li>
          <li class="inline-flex items-center justify-between py-3 px-4 text-sm border border-gray-200 dark:border-neutral-700">
            <span>Jenis Pinjaman</span>
            <span>Kredit {{ ($jenis_pinjaman) }}</span>
          </li>
          <li class="inline-flex items-center justify-between py-3 px-4 text-sm border border-gray-200 dark:border-neutral-700">
            <span>Tenor</span>
            <span>{{ $lama_angsuran }} bulan</span>
          </li>
          <li class="inline-flex items-center justify-between py-3 px-4 text-sm border border-gray-200 dark:border-neutral-700">
            <span>Status Pencairan Dana</span>
            <span>
              {{ ucfirst ($status_konfirmasi) }}
            </span>
          </li>
          <li class="inline-flex items-center justify-between py-3 px-4 text-sm font-semibold bg-gray-50 border border-gray-200 dark:bg-neutral-800 dark:border-neutral-700">
            <span>Dana Diterima</span>
            <span>Rp{{ number_format($jumlah_diterima, 2, ',', '.') }}</span>
          </li>
          
        </ul>
      </div>

      <!-- Buttons -->
      <div class="mt-5 flex justify-end gap-x-2">
        @php
            $isAdmin = Auth::user()->role === 'admin';
        @endphp

        <a href="{{ $isAdmin ? route('pengajuan_pinjaman.index') : route('pinjaman_anggota.index') }}"
          class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 dark:bg-neutral-700 dark:text-white dark:hover:bg-neutral-600">
          Kembali
        </a>

        <a href="{{ route('pengajuan_pinjaman.invoicepdf', $pinjaman->id) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-blue-700 text-white shadow-2xs hover:bg-blue-500 dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
          <!-- Download Icon -->
          Bukti PDF
        </a>
      </div>

      <div class="mt-5 sm:mt-10">
        <p class="text-sm text-gray-500 dark:text-neutral-500">
          Jika ada kesalan dalam bukti pencairan dana ini silahkan hubungi
          <a class="text-blue-600 hover:underline dark:text-blue-500" href="tel:+1898345492">(022) 2700003</a>
        </p>
      </div>
    </div>
    <!-- End Body -->
  </div>
</div>
<!-- End Invoice Page -->
@endsection