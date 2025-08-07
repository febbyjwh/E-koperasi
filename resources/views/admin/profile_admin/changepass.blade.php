@extends('layout')

@section('title', 'Change Password')

@section('content')
<section class="p-6 lg:p-8">
  <div class="grid items-center grid-cols-12 p-8 bg-gray-900 rounded-2xl">
    {{-- Left text block --}}
    <div class="text-left col-span-full lg:col-span-7 xl:col-span-8">
      <div class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-gray-700 shadow-md xl:pl-32">
        <div class="lg:max-w-lg">
          <h2 class="block antialiased tracking-normal font-sans font-semibold leading-[1.3] text-white mb-4 text-3xl lg:text-4xl">Form Atur Ulang Kata Sandi</h2>
          <p class="block antialiased font-sans text-xl font-normal leading-relaxed text-white mb-9 opacity-70">Form Untuk Mengatur Ulang Password, Pastikan Password Yang Di Ganti Dicatat Terlebih Dahulu Sebelum Submit</p>

          <div class="grid gap-6 my-16">
            <div class="flex items-center gap-4 text-white">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="..." clip-rule="evenodd"/></svg>
              <p class="font-bold">Aman dan Cepat</p>
            </div>
            <div class="flex items-center gap-4 text-white">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="..." /></svg>
              <p class="font-bold">Kata Sandi Terenkripsi</p>
            </div>
            <div class="flex items-center gap-4 text-white">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="..." clip-rule="evenodd"/></svg>
              <p class="font-bold">Support Available</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Form --}}
    <div class="relative flex flex-col bg-clip-border text-gray-700 shadow-md w-full h-full px-8 py-12 text-left bg-white col-span-full rounded-xl lg:col-span-5 lg:px-16 lg:py-40 xl:col-span-4">
      <form action="{{ route('profile_admin.updatepassword') }}" method="POST">
        @csrf

        {{-- Name (readonly) --}}
        <div class="mb-4">
          <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Nama Lengkap</label>
          <input type="email" name="" id="email" value="{{ auth()->user()->name }}" readonly class="w-full px-4 py-2 rounded-md bg-gray-100 border border-gray-300 text-sm text-gray-700" />
        </div>

        {{-- New password --}}
        <div class="mb-4">
          <label for="new_password" class="block mb-2 text-sm font-medium text-gray-700">Kata Sandi Baru</label>
          <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700" required>
        </div>

        {{-- Confirm password --}}
        <div class="mb-4">
          <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
          <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700" required>
        </div>

        {{-- Agree to terms --}}
        <div class="flex items-start mb-6">
          <input
            id="showPassword"
            type="checkbox"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
            onclick="togglePasswordVisibility()"
          />
          <label for="showPassword" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer">Tampilakn Kata Sandi</label>
        </div>

        {{-- Submit button --}}
        <button type="submit" class="cursor-pointer w-full py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition">Ganti Kata sandi</button>
        {{-- Back button --}}
        <a href="{{ route('profile_admin.index') }}" class="mt-4 inline-block text-center w-full py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition">
        Kembali
        </a>
    </form>
    </div>
  </div>
</section>

<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    const isChecked = document.getElementById('showPassword').checked;

    passwordInput.type = isChecked ? 'text' : 'password';
    confirmPasswordInput.type = isChecked ? 'text' : 'password';
  }
</script>

@endsection
