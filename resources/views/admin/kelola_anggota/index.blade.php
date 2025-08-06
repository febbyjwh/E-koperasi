@extends('layout')

@section('title', 'Kelola Anggota')

@section('content')
@once
    @include('components.modal')
@endonce

<div class="p-4 bg-white rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Anggota</h2>
        
        <form action="{{ route('kelola_anggota.kelola_anggota') }}" method="GET" class="max-w-md w-full mr-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari...">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <button type="submit" style="cursor: pointer"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-lightgray-700 text-gray font-medium rounded-lg text-sm px-4 py-2 h-10">
                    Cari
                </button>   
            </div>
        </form>

        <a href="{{ route('kelola_anggota.create') }}"
           class="inline-block px-2 sm:px-4 py-2 text-sm bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
            Tambah Anggota
        </a>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nomor Anggota</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Username</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">No HP</th>
                    <th class="px-6 py-3">Jenis Kelamin</th>
                    <th class="px-6 py-3">Alamat</th>
                    <th class="px-6 py-3">Tanggal Lahir</th>
                    <th class="px-6 py-3">Tanggal Registrasi</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $user)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration + $anggota->firstItem() - 1 }}</td>
                        <td class="px-6 py-4">AG{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->username }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $user->jenis_kelamin ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $user->alamat ?? '-' }}</td>
                        <td class="px-6 py-4">
                            {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ optional($user->created_at)->format('d M Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex flex-row justify-end space-x-2">
                                <a href="{{ route('kelola_anggota.edit', $user->id) }}"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:outline-none font-medium rounded-full text-sm px-5 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700">
                                    Edit
                                </a>

                                <button
                                    onclick="showModal('{{ route('kelola_anggota.destroy', $user->id) }}')"
                                    class="text-white bg-red-700 hover:bg-red-800 focus:outline-none font-medium rounded-full text-sm px-5 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-gray-500 py-4">Belum ada anggota yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
      <!-- PAGINATION -->
    <div class="mt-4">
        {{ $anggota->withQueryString()->links('vendor.pagination.tailwind') }}
    </div>
</div>
</div>

@endsection
