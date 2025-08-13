@extends('layout')

@section('title', 'Identitas Diri')

@section('content')
<div class="h-screen">

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

    <style>
        [x-cloak] {
            display: none;
        }

        [type="checkbox"] {
            box-sizing: border-box;
            padding: 0;
        }

        .form-checkbox,
        .form-radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            display: inline-block;
            vertical-align: middle;
            background-origin: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            flex-shrink: 0;
            color: currentColor;
            background-color: #fff;
            border-color: #e2e8f0;
            border-width: 1px;
            height: 1.4em;
            width: 1.4em;
        }

        .form-checkbox {
            border-radius: 0.25rem;
        }

        .form-radio {
            border-radius: 50%;
        }

        .form-checkbox:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-radio:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    @if ($errors->any())
    <div class="max-w-3xl mx-auto mt-6 mb-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Terjadi kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form x-ref="form" method="POST" enctype="multipart/form-data"
        action="{{ route('profile_anggota.datadiri.store') }}" x-data="app()">
        @csrf
        <div class="max-w-3xl mx-auto px-4 py-10">
            {{-- STEP 1 --}}
            <div x-show="step === 1" class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Data Pribadi</h2>
                <div class="mb-6 text-center"
                    x-data="{ image: {{ json_encode(optional($anggota)->foto_ktp ? asset('storage/' . $anggota->foto_ktp) : null) }} }">
                    <div class="mx-auto"
                        style="width: 323px; height: 204px; border: 1px solid #ccc; overflow: hidden; border-radius: 8px; background: #f3f4f6;">
                        <img class="object-cover w-full h-full"
                            :src="image || '{{ asset('images/placeholder-ktp.png') }}'" alt="Preview KTP"
                            style="width: 323px; height: 204px;" />
                    </div>

                    <label for="fileInput"
                        class="mt-3 cursor-pointer inline-flex items-center border px-4 py-2 rounded-lg shadow-sm bg-white hover:bg-gray-100 text-gray-600 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 7h1a2 2 0 002-2 1 1 0 011-1h6a1 1 0 011 1 2 2 0 002 2h1a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                            <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="2" />
                        </svg>
                        Pilih Foto KTP
                    </label>

                    <input type="file" id="fileInput" name="foto_ktp" accept="image/*" class="hidden" @change="
            let file = $event.target.files[0];
            if(file){
                let reader = new FileReader();
                reader.onload = e => image = e.target.result;
                reader.readAsDataURL(file);
            }
        ">
                    <input type="hidden" id="fileInput_existing"
                        value="{{ old('foto_ktp', $anggota->foto_ktp ?? '') }}">

                    <p class="text-red-500 text-sm mt-1" id="error-file"></p>
                    @error('foto_ktp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-gray-500 mt-2">Klik untuk mengunggah foto KTP</p>
                </div>


                <div class="space-y-5">
                    <label for="nama_pengguna" class="font-bold text-gray-700 block mb-1">Nama Lengkap</label>
                    <input id="nama_pengguna" name="nama_pengguna" type="text" placeholder="Nama Lengkap"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('nama_pengguna') border-red-500 @enderror"
                        value="{{ old('nama_pengguna', $anggota->nama_pengguna ?? '') }}">
                    @error('nama_pengguna')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="nik" class="font-bold text-gray-700 block mb-1">NIK</label>
                    <input id="nik" name="nik" type="text" placeholder="NIK"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('nik') border-red-500 @enderror"
                        value="{{ old('nik', $anggota->nik ?? '') }}">
                    @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="username" class="font-bold text-gray-700 block mb-1">Username</label>
                    <input id="username" name="username" type="text" placeholder="Username"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('username') border-red-500 @enderror"
                        value="{{ Auth::user()->username }}" disabled>
                    @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="tanggal_lahir" class="font-bold text-gray-700 block mb-1">Tanggal Lahir</label>
                    <input id="tanggal_lahir" name="tanggal_lahir" type="date"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('tanggal_lahir') border-red-500 @enderror"
                        value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ?? '') }}">
                    @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="jenis_kelamin" class="font-bold text-gray-700 block mb-1">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('jenis_kelamin') border-red-500 @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '')=='L' ? 'selected' : ''
                            }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '')=='P' ? 'selected' : ''
                            }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="email" class="font-bold text-gray-700 block mb-1">Email</label>
                    <input id="email" name="email" type="email" placeholder="Email"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('email') border-red-500 @enderror"
                        value="{{ old('email', $anggota->email ?? '') }}">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="no_wa" class="font-bold text-gray-700 block mb-1">Nomor WhatsApp</label>
                    <input id="no_wa" name="no_wa" type="text" placeholder="Nomor WhatsApp"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('no_wa') border-red-500 @enderror"
                        value="{{ old('no_wa', $anggota->no_wa ?? '') }}">
                    @error('no_wa')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="alamat" class="font-bold text-gray-700 block mb-1">Alamat KTP</label>
                    <textarea id="alamat" name="alamat" placeholder="Alamat KTP"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('alamat') border-red-500 @enderror">{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
                    @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- STEP 2 --}}
            <div x-show="step === 2">
                <h2 class="text-xl font-bold mb-4">Data Kepegawaian</h2>
                <div class="space-y-3">
                    <label for="no_anggota" class="font-bold text-gray-700 block mb-1">No Anggota</label>
                    <input id="no_anggota" name="no_anggota" type="text" placeholder="No Anggota"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('no_anggota') border-red-500 @enderror"
                        value="{{ old('no_anggota', $anggota->no_anggota ?? '') }}">
                    @error('no_anggota')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="nip" class="font-bold text-gray-700 block mb-1">NIP</label>
                    <input id="nip" name="nip" type="text" placeholder="NIP"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('nip') border-red-500 @enderror"
                        value="{{ old('nip', $anggota->nip ?? '') }}">
                    @error('nip')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="jabatan" class="font-bold text-gray-700 block mb-1">Jabatan</label>
                    <input id="jabatan" name="jabatan" type="text" placeholder="Jabatan"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('jabatan') border-red-500 @enderror"
                        value="{{ old('jabatan', $anggota->jabatan ?? '') }}">
                    @error('jabatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="unit_kerja" class="font-bold text-gray-700 block mb-1">Unit Kerja</label>
                    <input id="unit_kerja" name="unit_kerja" type="text" placeholder="Unit Kerja"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('unit_kerja') border-red-500 @enderror"
                        value="{{ old('unit_kerja', $anggota->unit_kerja ?? '') }}">
                    @error('unit_kerja')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="tanggal_mulai_kerja" class="font-bold text-gray-700 block mb-1">Tanggal Mulai
                        Kerja</label>
                    <input id="tanggal_mulai_kerja" name="tanggal_mulai_kerja" type="date"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('tanggal_mulai_kerja') border-red-500 @enderror"
                        value="{{ old('tanggal_mulai_kerja', $anggota->tanggal_mulai_kerja ?? '') }}">
                    @error('tanggal_mulai_kerja')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="status_kepegawaian" class="font-bold text-gray-700 block mb-1">Status
                        Kepegawaian</label>
                    <select id="status_kepegawaian" name="status_kepegawaian"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('status_kepegawaian') border-red-500 @enderror">
                        <option value="">Pilih Status Kepegawaian</option>
                        <option value="Tetap" {{ old('status_kepegawaian', $anggota->status_kepegawaian ?? '')=='Tetap'
                            ? 'selected' : '' }}>Tetap</option>
                        <option value="Kontrak" {{ old('status_kepegawaian', $anggota->status_kepegawaian ??
                            '')=='Kontrak' ? 'selected' : '' }}>Kontrak
                        </option>
                    </select>
                    @error('status_kepegawaian')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="tanggal_bergabung" class="font-bold text-gray-700 block mb-1">Tanggal Bergabung</label>
                    <input id="tanggal_bergabung" name="tanggal_bergabung" type="date"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('tanggal_bergabung') border-red-500 @enderror"
                        value="{{ old('tanggal_bergabung', $anggota->tanggal_bergabung ?? '') }}">
                    @error('tanggal_bergabung')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="status_keanggotaan" class="font-bold text-gray-700 block mb-1">Status
                        Keanggotaan</label>
                    <select id="status_keanggotaan" name="status_keanggotaan"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('status_keanggotaan') border-red-500 @enderror">
                        <option value="">Pilih Status Keanggotaan</option>
                        <option value="Aktif" {{ old('status_keanggotaan', $anggota->status_keanggotaan ?? '')=='Aktif'
                            ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status_keanggotaan', $anggota->status_keanggotaan ??
                            '')=='Tidak Aktif' ? 'selected' : '' }}>
                            Tidak Aktif</option>
                    </select>
                    @error('status_keanggotaan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- STEP 3 --}}
            <div x-show="step === 3">
                <h2 class="text-xl font-bold mb-4">Data Wali</h2>
                <div class="space-y-3">
                    <label for="nama_keluarga" class="font-bold text-gray-700 block mb-1">Nama Wali</label>
                    <input id="nama_keluarga" name="nama_keluarga" type="text" placeholder="Nama Wali"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('nama_keluarga') border-red-500 @enderror"
                        value="{{ old('nama_keluarga', $anggota->nama_keluarga ?? '') }}">
                    @error('nama_keluarga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="hubungan_keluarga" class="font-bold text-gray-700 block mb-1">Hubungan dengan
                        Wali</label>
                    <input id="hubungan_keluarga" name="hubungan_keluarga" type="text"
                        placeholder="Hubungan dengan Wali"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('hubungan_keluarga') border-red-500 @enderror"
                        value="{{ old('hubungan_keluarga', $anggota->hubungan_keluarga ?? '') }}">
                    @error('hubungan_keluarga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="nomor_telepon_keluarga" class="font-bold text-gray-700 block mb-1">No Telepon
                        Wali</label>
                    <input id="nomor_telepon_keluarga" name="nomor_telepon_keluarga" type="text"
                        placeholder="No Telepon Wali"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('nomor_telepon_keluarga') border-red-500 @enderror"
                        value="{{ old('nomor_telepon_keluarga', $anggota->nomor_telepon_keluarga ?? '') }}">
                    @error('nomor_telepon_keluarga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="alamat_keluarga" class="font-bold text-gray-700 block mb-1">Alamat Wali</label>
                    <textarea id="alamat_keluarga" name="alamat_keluarga" placeholder="Alamat Wali"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('alamat_keluarga') border-red-500 @enderror">{{ old('alamat_keluarga', $anggota->alamat_keluarga ?? '') }}</textarea>
                    @error('alamat_keluarga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <label for="email_keluarga" class="font-bold text-gray-700 block mb-1">Email Keluarga
                        (Opsional)</label>
                    <input id="email_keluarga" name="email_keluarga" type="text" placeholder="Email Keluarga (Opsional)"
                        class="w-full px-4 py-3 rounded-lg border shadow-sm focus:outline-none focus:border-blue-500 text-gray-700 @error('email_keluarga') border-red-500 @enderror"
                        value="{{ old('email_keluarga', $anggota->email_keluarga ?? '') }}">
                    @error('email_keluarga')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- NAVIGATION --}}
            <div class="flex justify-between mt-6">
                <button x-show="step > 1" type="button" @click="step--"
                    class="w-32 py-2 px-5 rounded-lg shadow-sm text-white bg-gray-500 hover:bg-gray-600 font-medium">
                    Previous
                </button>

                <button x-show="step < 3" type="button" @click="if(validateStep()) step++"
                    class="w-32 py-2 px-5 rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 font-medium">
                    Next
                </button>

                <button x-show="step === 3" type="submit"
                    @click.prevent="if(validateStep()) $el.closest('form').submit()"
                    class="w-32 py-2 px-5 rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 font-medium">
                    Complete
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .input-field {
        @apply border border-gray-300 rounded-lg p-2 w-full focus: outline-none focus:ring-2 focus:ring-blue-400;
    }

    .input-field.border-red-500 {
        @apply border-red-500 focus: ring-red-400;
    }
</style>

<script>
    function app() {
    return {
        step: 1,
        validateStep() {
            let valid = true;
            let fields = [];

            let foto_ktp = document.getElementById('fileInput').files[0];
            if (this.step === 1 && !foto_ktp && !document.getElementById('fileInput_existing').value) {
                document.getElementById('fileInput').classList.add('border-red-500');
                valid = false;
            } else {
                document.getElementById('fileInput').classList.remove('border-red-500');
            }

            if (this.step === 1) {
                let existingValue = document.getElementById('fileInput_existing')?.value.trim();
                if (!existingValue) {
                    // Kalau file lama tidak ada, wajib upload baru
                    fields = ['fileInput', 'nama_pengguna', 'nik', 'username', 'tanggal_lahir', 'jenis_kelamin', 'email', 'no_wa', 'alamat'];
                } else {
                    // Kalau file lama sudah ada, tidak perlu upload baru
                    fields = ['fileInput_existing', 'nama_pengguna', 'nik', 'username', 'tanggal_lahir', 'jenis_kelamin', 'email', 'no_wa', 'alamat'];
                }
            }
            if (this.step === 2) {
                fields = ['no_anggota', 'nip', 'jabatan', 'unit_kerja', 'tanggal_mulai_kerja', 'status_kepegawaian', 'tanggal_bergabung', 'status_keanggotaan'];
            }
            if (this.step === 3) {
                fields = ['nama_keluarga', 'hubungan_keluarga', 'nomor_telepon_keluarga', 'alamat_keluarga'];
            }

            fields.forEach(id => {
                let el = document.getElementById(id);
                if (!el || !el.value.trim()) {
                    el.classList.add('border-red-500');
                    valid = false;
                } else {
                    el.classList.remove('border-red-500');
                }
            });

            return valid;
        }
    }
}
</script>
@endsection