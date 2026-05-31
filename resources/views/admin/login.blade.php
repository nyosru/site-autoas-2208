@extends('admin.layouts.app')

@section('title', 'Вход в админ-панель')

@section('login')
    <div class="bg-white rounded-xl shadow-lg p-10 text-center max-w-md w-full">
        <h1 class="text-2xl font-bold mb-2">Админ-панель</h1>
        <p class="text-gray-500 mb-8">Войдите через VK для управления сайтом</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <a href="{{ url('/auth/vk/redirect') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-8 py-3 rounded-lg transition">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                <rect width="24" height="24" rx="4" fill="#0077FF"/>
                <path d="M12.4 17.3c-4.5 0-7.1-3.1-7.2-8.2h2.3c.1 3.8 1.7 5.4 3 5.7V9.1h2.1v3.2c1.3-.1 2.6-1.6 3-3.2h2.1c-.3 2-2 3.4-3.2 3.9 1.3.6 3.4 2.3 3.8 5.3h-2.3c-.3-1.7-1.4-3-2.8-3.3v3.3h-.3z" fill="white"/>
            </svg>
            Войти через VK
        </a>
    </div>
@endsection
