@extends('auth')
@section('title', 'Registrasi')
@section('content')
<img src="{{ asset('assets/img/logo-new.png') }}" class="h-24" alt="Logo" />
<div class="w-full md:w-1/2 flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registrasi Akun</h2>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Terjadi kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('auth.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input type="text" name="no_hp" id="no_hp" maxlength="14"
                        value="{{ old('no_hp') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <small id="phoneHelp" class="text-sm mt-1 block text-red-600"></small>
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat') }}</textarea>
            </div>

            {{-- Optional: role bisa disembunyikan jika default 'anggota' --}}
            {{-- <input type="hidden" name="role" value="anggota"> --}}

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                <input type="password" name="password" id="password" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" />
                {{-- tombol show/hide password --}}
                <span id="togglePassword" class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-500">
                👁
                </span>
                </div>

                {{-- Checklist password requirement --}}
                <ul class="mt-2 space-y-1 text-sm" id="passwordRequirements">
                <li id="length" class="text-red-600">❌ Minimal 8 karakter</li>
                <li id="uppercase" class="text-red-600">❌ Mengandung huruf besar (A–Z)</li>
                <li id="lowercase" class="text-red-600">❌ Mengandung huruf kecil (a–z)</li>
                <li id="number" class="text-red-600">❌ Mengandung angka (0–9)</li>
                <li id="special" class="text-red-600">❌ Mengandung simbol (@$!%*?&)</li>
                </ul>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <button type="submit"
                    class="bg-green-500 w-full text-white font-semibold py-2 px-4 rounded-lg transition duration-300 cursor-pointer">
                    Daftar
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('formlogin') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");

    const rules = {
        length: document.getElementById("length"),
        uppercase: document.getElementById("uppercase"),
        lowercase: document.getElementById("lowercase"),
        number: document.getElementById("number"),
        special: document.getElementById("special"),
    };

    passwordInput.addEventListener("input", function () {
        const value = passwordInput.value;

        const checks = {
            length: value.length >= 8,
            uppercase: /[A-Z]/.test(value),
            lowercase: /[a-z]/.test(value),
            number: /[0-9]/.test(value),
            special: /[@$!%*?&]/.test(value),
        };

        for (const rule in checks) {
            if (checks[rule]) {
                rules[rule].textContent = "✔ " + rules[rule].textContent.replace("❌ ", "").replace("✔ ", "");
                rules[rule].classList.remove("text-red-600");
                rules[rule].classList.add("text-green-600");
            } else {
                rules[rule].textContent = "❌ " + rules[rule].textContent.replace("✔ ", "").replace("❌ ", "");
                rules[rule].classList.remove("text-green-600");
                rules[rule].classList.add("text-red-600");
            }
        }
    });

    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        togglePassword.textContent = type === "password" ? "👁" : "🙈";
    });
});
</script>

<script>
const phoneInput = document.getElementById('no_hp');
const phoneHelp = document.getElementById('phoneHelp');

phoneInput.addEventListener('input', function () {
    // hapus semua karakter non-digit
    this.value = this.value.replace(/\D/g, '');

    // batasi maksimal 14 digit
    if (this.value.length > 14) {
        this.value = this.value.slice(0, 14);
    }

    let regex = /^(?:\+62|62|0)8[1-9][0-9]{6,11}$/;
    let message = "";

    if (!regex.test(this.value)) {
        message = "Nomor HP harus diawali 08 / 62 / +62 dan panjang 10–14 digit.";
        phoneHelp.classList.remove('text-green-600');
        phoneHelp.classList.add('text-red-600');
    } else {
        message = "✅ Nomor HP valid";
        phoneHelp.classList.remove('text-red-600');
        phoneHelp.classList.add('text-green-600');
    }

    phoneHelp.innerText = message;
});
</script>

@endsection