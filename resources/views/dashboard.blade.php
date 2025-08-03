@extends('layout')

@section('title', 'Dashboard')

@section('content')
<head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
</head>
<h1 class="text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
    @include('partial.card')
    @include('partial.simulasi')
    @include('partial.tren')
@endsection
