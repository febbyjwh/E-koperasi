@extends('layout')

@section('title', 'anggota')

@section('content')
<head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
</head>

<div class="grid grid-cols-1 lg:grid-cols-[minmax(280px,380px)_1fr] gap-6 w-full">
    {{-- Simulasi --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm order-2 lg:order-1">
        @include('partial.simulasianggota
        ')
    </div>

    {{-- Kanan --}}
    <div class="flex flex-col gap-4 min-w-0 order-1 lg:order-2">
        {{-- Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
            @include('partial.cardanggota')
        </div>

        {{-- Tabel --}}
        <div class="mt-5 bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm overflow-x-auto">
            @include('partial.tabelanggota')
        </div>
    </div>
</div>

@endsection
