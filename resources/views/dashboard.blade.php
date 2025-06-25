@extends ('layout')

@section ('title','Dashboard')

@section ('content')


<div class="flex justify-between w-full">
  <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
      <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
  </a>

  <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
      <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
  </a>

  <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
      <p class="font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
  </a>
</div>




{{-- <div class="relative h-56 overflow-hidden rounded-lg md:h-64">
    <!-- Slide 1: Total Pengajuan -->
    <div class="flex items-center justify-center" data-carousel-item="active">
        <div class="text-center">
            <h5 class="text-lg font-semibold text-gray-700">Total Pengajuan</h5>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalPengajuan }}</p>
        </div>
    </div>

    <!-- Slide 2: Disetujui -->
    <div class="hidden duration-700 ease-in-out flex items-center justify-center" data-carousel-item>
        <div class="text-center">
            <h5 class="text-lg font-semibold text-gray-700 dark:text-white">Pengajuan Disetujui</h5>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $disetujui }}</p>
        </div>
    </div>

    <!-- Slide 3: Pending -->
    <div class="hidden duration-700 ease-in-out flex items-center justify-center" data-carousel-item>
        <div class="text-center">
            <h5 class="text-lg font-semibold text-gray-700 dark:text-white">Pengajuan Pending</h5>
            <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $pending }}</p>
        </div>
    </div>

    <!-- Slide 4: Total Dana -->
    <div class="hidden duration-700 ease-in-out flex items-center justify-center" data-carousel-item>
        <div class="text-center">
            <h5 class="text-lg font-semibold text-gray-700 dark:text-white">Total Dana Dipinjamkan</h5>
            <p class="text-2xl font-bold text-purple-600 mt-2">
                Rp {{ number_format($totalDana, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div> --}}

@endsection