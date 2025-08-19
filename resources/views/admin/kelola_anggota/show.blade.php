@extends('layout')

@section('title', 'Detail Anggota')

@section('content')
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Detail Anggota</h2>
                <a href="{{ route('kelola_anggota.kelola_anggota') }}"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 text-gray-700 font-medium transition">
                    Kembali
                </a>
            </div>

            <!-- Collapsible Akun -->
            <div class="bg-white shadow-md rounded-2xl border mb-4">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                    onclick="toggleSection('akun')">
                    <span class="font-semibold text-gray-700">Informasi Akun</span>
                    <span id="icon-akun" class="transform transition-transform">▼</span>
                </button>
                <div id="akun" class="px-6 pb-4 hidden">
                    <div class="space-y-2 text-gray-700">
                        <div><strong>Nama:</strong> {{ $anggota->name }}</div>
                        <div><strong>Username:</strong> {{ $anggota->username }}</div>
                        <div><strong>Email:</strong> {{ $anggota->email }}</div>
                        <div><strong>No HP:</strong> {{ $anggota->no_hp ?? '-' }}</div>
                        <div><strong>Jenis Kelamin:</strong> {{ $anggota->jenis_kelamin ?? '-' }}</div>
                        <div><strong>Tanggal Lahir:</strong>
                            {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') : '-' }}
                        </div>
                        <div><strong>Alamat:</strong> {{ $anggota->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Collapsible Identitas -->
            <div class="bg-white shadow-md rounded-2xl border mb-4">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                    onclick="toggleSection('identitas')">
                    <span class="font-semibold text-gray-700">Identitas Lengkap</span>
                    <span id="icon-identitas" class="transform transition-transform">▼</span>
                </button>
                <div id="identitas" class="px-6 pb-4 hidden">
                    @if ($anggota->datadiri)
                        <div class="flex flex-col items-center mb-4">
                            <img src="{{ asset('storage/' . $anggota->datadiri->foto_ktp) }}" alt="Foto KTP"
                                class="w-40 h-40 rounded-xl object-cover mb-2 shadow">
                            <span class="text-gray-600 font-medium">Foto KTP</span>
                        </div>
                        <div class="grid grid-cols-1 gap-2 text-gray-700">
                            <div><strong>NIK:</strong> {{ $anggota->datadiri->nik }}</div>
                            <div><strong>Nama Pengguna:</strong> {{ $anggota->datadiri->nama_pengguna }}</div>
                            <div><strong>Tanggal Lahir:</strong>
                                {{ \Carbon\Carbon::parse($anggota->datadiri->tanggal_lahir)->format('d M Y') }}</div>
                            <div><strong>Jenis Kelamin:</strong> {{ $anggota->datadiri->jenis_kelamin }}</div>
                            <div><strong>Email:</strong> {{ $anggota->datadiri->email }}</div>
                            <div><strong>No WA:</strong> {{ $anggota->datadiri->no_wa ?? '-' }}</div>
                            <div><strong>Alamat:</strong> {{ $anggota->datadiri->alamat }}</div>
                        </div>
                    @else
                        <p class="text-gray-500">Data identitas anggota belum lengkap.</p>
                    @endif
                </div>
            </div>

            <!-- Collapsible Data Kepegawaian -->
            <div class="bg-white shadow-md rounded-2xl border mb-4">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                    onclick="toggleSection('kepegawaian')">
                    <span class="font-semibold text-gray-700">Data Kepegawaian</span>
                    <span id="icon-kepegawaian" class="transform transition-transform">▼</span>
                </button>
                <div id="kepegawaian" class="px-6 pb-4 hidden text-gray-700">
                    @if ($anggota->datadiri)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <div><strong>No Anggota:</strong> {{ $anggota->datadiri->no_anggota ?? '-' }}</div>
                            <div><strong>NIP:</strong> {{ $anggota->datadiri->nip ?? '-' }}</div>
                            <div><strong>Jabatan:</strong> {{ $anggota->datadiri->jabatan ?? '-' }}</div>
                            <div><strong>Unit Kerja:</strong> {{ $anggota->datadiri->unit_kerja ?? '-' }}</div>
                            <div><strong>Tanggal Mulai Kerja:</strong>
                                {{ $anggota->datadiri->tanggal_mulai_kerja ? \Carbon\Carbon::parse($anggota->datadiri->tanggal_mulai_kerja)->format('d M Y') : '-' }}
                            </div>
                            <div><strong>Status Kepegawaian:</strong> {{ $anggota->datadiri->status_kepegawaian ?? '-' }}
                            </div>
                            <div><strong>Tanggal Bergabung:</strong>
                                {{ $anggota->datadiri->tanggal_bergabung ? \Carbon\Carbon::parse($anggota->datadiri->tanggal_bergabung)->format('d M Y') : '-' }}
                            </div>
                            <div><strong>Status Keanggotaan:</strong> {{ $anggota->datadiri->status_keanggotaan ?? '-' }}
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">Data kepegawaian belum tersedia.</p>
                    @endif
                </div>
            </div>

            <!-- Collapsible Data Keluarga -->
            <div class="bg-white shadow-md rounded-2xl border mb-4">
                <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none"
                    onclick="toggleSection('keluarga')">
                    <span class="font-semibold text-gray-700">Data Keluarga</span>
                    <span id="icon-keluarga" class="transform transition-transform">▼</span>
                </button>
                <div id="keluarga" class="px-6 pb-4 hidden text-gray-700">
                    @if ($anggota->datadiri)
                        <div class="grid grid-cols-1 gap-2">
                            <div><strong>Nama Keluarga:</strong> {{ $anggota->datadiri->nama_keluarga ?? '-' }}</div>
                            <div><strong>Hubungan:</strong> {{ $anggota->datadiri->hubungan_keluarga ?? '-' }}</div>
                            <div><strong>No Telepon Keluarga:</strong>
                                {{ $anggota->datadiri->nomor_telepon_keluarga ?? '-' }}</div>
                            <div><strong>Alamat Keluarga:</strong> {{ $anggota->datadiri->alamat_keluarga ?? '-' }}</div>
                            <div><strong>Email Keluarga:</strong> {{ $anggota->datadiri->email_keluarga ?? '-' }}</div>
                        </div>
                    @else
                        <p class="text-gray-500">Data keluarga belum tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSection(id) {
            const section = document.getElementById(id);
            const icon = document.getElementById('icon-' + id);
            section.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
@endsection
