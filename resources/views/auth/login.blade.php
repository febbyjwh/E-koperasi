@extends('auth')
@section('title', 'login')
@section('content')
    <img src="{{ asset('assets/img/logo-new.png') }}" class="h-24" alt="Logo" />

    <div class="w-full md:w-1/2 flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Masuk</h2>

            @if (session('pesan'))
                <div
                    class="mb-4 text-red-600 text-sm text-center font-semibold bg-red-100 p-2 rounded-lg border border-red-300">
                    {{ session('pesan') }}
                </div>
            @endif
            @if (session('success'))
                <div
                    class="mb-4 text-green-600 text-sm text-center font-semibold bg-green-100 p-2 rounded-lg border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('auth.login') }}" method="POST" class="space-y-10">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" id="username" placeholder="Masukan Username" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                <div class="max-w-sm">
                    <label for="password"
                        class="block text-sm font-medium text-gray-700 dark:text-white mb-2">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" placeholder="Masukan Kata sandi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 pe-10 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" />

                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 end-0 flex items-center px-3 text-gray-400 hover:text-teal-600 focus:outline-none"
                            aria-label="Toggle password visibility">
                            <!-- Eye Open -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <!-- Eye Closed -->
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden cursor-pointer"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9.27-3.11-10.543-7a10.059 10.059 0 012.617-4.147M9.88 9.88a3 3 0 014.24 4.24" />
                                <path d="M6.61 6.61L2 2m20 20l-4.61-4.61" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="bg-teal-500 w-full  text-white font-semibold py-2 px-4 rounded-lg transition duration-300 cursor-pointer">
                        Masuk
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Daftar di sini</a>
            </p>
            <p class="mt-2 text-center text-sm text-gray-600">
                Lupa kata sandi?
                <a href="{{ route('forgot-password') }}" class="text-teal-600 hover:underline">Atur ulang di sini</a>

            </p>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById("password");
        const toggleBtn = document.getElementById("togglePassword");
        const eyeOpen = document.getElementById("eyeOpen");
        const eyeClosed = document.getElementById("eyeClosed");

        toggleBtn.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";
            passwordInput.type = isPassword ? "text" : "password";

            eyeOpen.classList.toggle("hidden", !isPassword);
            eyeClosed.classList.toggle("hidden", isPassword);
        });
    </script>

@endsection
