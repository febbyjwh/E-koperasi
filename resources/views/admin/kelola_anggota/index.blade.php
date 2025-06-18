@extends('layout')

@section('title', 'Kelola Anggota')

@section('content')
<div class="p-4 bg-white rounded-2xl shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm md:text-xl font-semibold text-gray-700">Daftar Anggota</h2>
        <a href="{{ route('kelola_anggota.create') }}"
           class="inline-block px-2 sm:px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
            Tambah Anggota
        </a>
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
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $user)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
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
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('kelola_anggota.edit', $user->id) }}"
                               class="font-medium text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('kelola_anggota.destroy', $user->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="font-medium text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">Belum ada anggota yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection