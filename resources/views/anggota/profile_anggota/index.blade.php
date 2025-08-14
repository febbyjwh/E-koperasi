@extends('layout')

@section('title', 'Profile Admin')

@section('content')
    <div class="flex flex-col md:flex-row gap-6 p-6 bg-gray-50 min-h-screen">
        <!-- Left Sidebar -->
        <div class="w-full md:w-1/3 bg-white shadow-sm rounded-md p-6">
            <div class="flex flex-col items-center text-center">
                {{-- Avatar --}}
                <img src="{{ asset('storage/' . $user->photo) }}" class="w-24 h-24 rounded-full mb-4" alt="Avatar">

                {{-- Email --}}
                <h2 class="text-lg font-semibold">{{ $user->email }}</h2>

                {{-- Last login info (opsional: tambahkan di DB kalau belum ada) --}}
                <p class="text-sm text-gray-500 mt-1">Terakhir Menggunakan: {{ $user->last_login_at ?? 'Baru login' }}</p>

                {{-- User ID --}}
                <div class="flex items-center gap-2 mt-4">
                    <span id="userIdText" class="text-sm bg-gray-100 px-3 py-1 rounded text-gray-700">
                        User ID: UsrAnGKpRSMP1C{{ $user->id }}
                    </span>
                    <button onclick="copyToClipboard(event)"
                        class="cursor-pointer text-xs text-gray-600 border px-2 py-1 rounded hover:bg-gray-100">
                        Copy
                    </button>
                </div>

                <!-- Floating Tooltip -->
                <div id="copyToast"
                    class="absolute z-50 hidden px-3 py-1 bg-white border border-gray-300 text-gray-600 text-xs rounded shadow-sm opacity-0 transition-opacity duration-300">
                    Salin
                </div>
            </div>

            {{-- Sidebar Actions --}}
            <div class="mt-6 space-y-3">
                <button class="w-full text-left px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 text-sm">
                    🧑 {{ $user->name }}
                </button>

                <a href="{{ route('profile_admin.changepass') }}"
                    class="cursor-pointer block w-full text-left px-4 py-2 bg-blue-100 rounded hover:bg-blue-200 text-sm">
                    🔐 Ganti Kata Sandi
                </a>

                <a href="{{ route('profile_admin.changephoto') }}"
                    class="cursor-pointer block w-full text-left px-4 py-2 bg-orange-100 rounded hover:bg-orange-200 text-sm">
                    🧑‍💼 Ganti Foto Profile
                </a>

                {{-- <button
                    class="cursor-pointer w-full text-left px-4 py-2 bg-red-100 rounded hover:bg-red-200 text-sm text-red-700">
                    ❌ Hapus Akun Pengguna
                </button> --}}
            </div>
        </div>

        <!-- Right Content -->
        <div class="w-full md:w-2/3 h-[calc(100vh-3rem)] overflow-y-auto scroll-hidden pr-2 space-y-6">
            <!-- Personal Info -->
            <div class="bg-white shadow-sm rounded-md p-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                        <div class="bg-gray-100 p-2 rounded">{{ $user->name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Username</label>
                        <div class="bg-gray-100 p-2 rounded">{{ $user->username }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600 mb-1">Alamat Email</label>
                        <div class="flex items-center gap-2 bg-gray-100 p-2 rounded justify-between">
                            <span>{{ $user->email }}</span>
                            <span
                                class="text-green-600 text-xs border border-green-600 px-2 py-0.5 rounded-full bg-transparent">Verified</span>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600 mb-1">Nomber Handphone</label>
                        <div class="flex items-center gap-2 bg-gray-100 p-2 rounded justify-between">
                            <span>{{ $user->no_hp ?? '-' }}</span>
                            {{-- <span class="text-green-600 text-xs bg-green-100 px-2 py-0.5 rounded">Verified</span> --}}
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                        <div class="bg-gray-100 p-2 rounded">{{ $user->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Informasi Keangotaan -->
            <div class="bg-white shadow-sm rounded-md p-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Keanggotaan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nomor Anggota</label>
                        <div class="bg-gray-100 p-2 rounded">
                            {{ $user->nomor_anggota ?? '-' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Status Keanggotaan</label>
                        <div class="bg-gray-100 p-2 rounded">
                            {{ $user->status_keanggotaan ?? 'Aktif' }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Tanggal Bergabung</label>
                        <div class="bg-gray-100 p-2 rounded">
                            {{ $user->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Change photo --}}
            <div id="profile-admin-section" class="bg-white shadow-sm rounded-md p-6">
                <h3 class="text-lg font-semibold mb-4">Profile Admin</h3>
                <div class="space-y-4">
                    Admin
                    <label class="block text-sm text-gray-600 mb-1">Ubah Foto Propil</label>
                    <form action="{{ route('profile_anggota.changephoto') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex justify-between gap-3">
                            <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/jpg"
                                class="bg-gray-100 p-2 rounded w-full">
                            <button type="submit" class="bg-teal-500 hover:bg-teal-700 rounded p-2 text-white">
                                Ubah
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        function copyToClipboard(event) {
            const text = document.getElementById('userIdText').innerText.replace('User ID: ', '');
            navigator.clipboard.writeText(text);

            const toast = document.getElementById('copyToast');

            // Posisi dekat kursor + jarak
            const offsetX = 12;
            const offsetY = 12;
            const mouseX = event.clientX + offsetX;
            const mouseY = event.clientY + offsetY;

            toast.style.left = `${mouseX}px`;
            toast.style.top = `${mouseY}px`;

            toast.classList.remove('hidden');
            // Fade in
            requestAnimationFrame(() => {
                toast.classList.remove('opacity-0');
            });

            // Sembunyikan setelah 1 detik
            setTimeout(() => {
                toast.classList.add('opacity-0');
                // Setelah transisi selesai, sembunyikan
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300); // sama dengan duration-300
            }, 1000);
        }
    </script>

@endsection
