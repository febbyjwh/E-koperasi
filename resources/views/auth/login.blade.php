@extends('auth')
@section('title', 'login')
@section('content')

    <div class="w-full md:w-1/2 flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Masuk</h2>

            @if (session('pesan'))
                <div
                    class="mb-4 text-red-600 text-sm text-center font-semibold bg-red-100 p-2 rounded-lg border border-red-300">
                    {{ session('pesan') }}
                </div>
            @endif
            <form action="{{ route('auth.login') }}" method="POST" class="space-y-10">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" id="username" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent" />
                </div>

                <div>
                    <button type="submit"
                        class="bg-teal-500 w-full  text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                        Masuk
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>

@endsection
