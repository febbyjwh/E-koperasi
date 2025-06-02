@extends('layout')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
            <div class="flex flex-row justify-between items-center">
                <div class="h6 text-indigo-700 fad fa-shopping-cart"></div>
                <span class="rounded-full text-white p-2 badge bg-teal-400 text-xs">
                    12%
                    <i class="fal fa-chevron-up ml-1"></i>
                </span>
            </div>
            <!-- end top -->

            <!-- bottom -->
            <div class="mt-8">
                <h1 class="text-3xl font-bold">5000</h1>
                <p>items sales</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
            02
        </div>
    </div>
@endsection
