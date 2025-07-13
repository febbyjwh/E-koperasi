@extends('layout')

@section('title', 'Konfirmasi Pengajuan Pinjaman')

@section('content')
<!-- Invoice Page -->
<div id="hs-ai-page" class="w-full max-w-3xl mx-auto p-4">
  <div class="flex flex-col bg-white shadow-lg rounded-xl dark:bg-neutral-800">
    <div class="relative overflow-hidden min-h-32 bg-gray-900 text-center rounded-t-xl dark:bg-neutral-950">
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
        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Bukti Peminjaman Dana Koperasi</h3>
        <p class="text-sm text-gray-500 dark:text-neutral-500">Invoice #3682303</p>
      </div>

      <!-- Grid -->
      <div class="mt-5 sm:mt-10 grid grid-cols-2 sm:grid-cols-3 gap-5">
        <div>
          <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Dana Diterima:</span>
          <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">$316.8</span>
        </div>
        <div>
          <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Tanggal Diterima:</span>
          <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">April 22, 2020</span>
        </div>
        <div>
          <span class="block text-xs uppercase text-gray-500 dark:text-neutral-500">Metode Pembayaran:</span>
          <div class="flex items-center gap-x-2">
            <!-- SVG Logo -->
            <!-- (gunakan logo pembayaran seperti sebelumnya) -->
            <span class="block text-sm font-medium text-gray-800 dark:text-neutral-200">•••• 4242</span>
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div class="mt-5 sm:mt-10">
        <h4 class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Summary</h4>
        <ul class="mt-3 flex flex-col">
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 dark:border-neutral-700 dark:text-neutral-200">
            <div class="flex items-center justify-between w-full">
              <span>Nama Peminjam</span>
              <span>$264.00</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 dark:border-neutral-700 dark:text-neutral-200">
            <div class="flex items-center justify-between w-full">
              <span>Dana Pinjaman</span>
              <span>$264.00</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 dark:border-neutral-700 dark:text-neutral-200">
            <div class="flex items-center justify-between w-full">
              <span>Propisi</span>
              <span>$52.8</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 dark:border-neutral-700 dark:text-neutral-200">
            <div class="flex items-center justify-between w-full">
              <span>Jenis Pinjaman</span>
              <span>$52.8</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border border-gray-200 text-gray-800 dark:border-neutral-700 dark:text-neutral-200">
            <div class="flex items-center justify-between w-full">
              <span>Tenor</span>
              <span>$52.8</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border border-gray-200 text-gray-800 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200">
            <div class="flex items-center justify-between w-full">
              <span>Dana Diterima</span>
              <span>$316.8</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Buttons -->
      <div class="mt-5 flex justify-end gap-x-2">
        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800" href="#">
          <!-- Download Icon -->
          Invoice PDF
        </a>
        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-600" href="#">
          <!-- Print Icon -->
          Print
        </a>
      </div>

      <div class="mt-5 sm:mt-10">
        <p class="text-sm text-gray-500 dark:text-neutral-500">
          If you have any questions, please contact us at
          <a class="text-blue-600 hover:underline dark:text-blue-500" href="#">example@site.com</a>
          or call at
          <a class="text-blue-600 hover:underline dark:text-blue-500" href="tel:+1898345492">+1 898-34-5492</a>
        </p>
      </div>
    </div>
    <!-- End Body -->
  </div>
</div>
<!-- End Invoice Page -->
@endsection