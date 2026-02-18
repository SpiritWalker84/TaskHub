<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} @yield('title', '')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="antialiased">
    <nav class="flex gap-4 p-4 bg-gray-100 border-b">
        <a href="{{ route('tasks.index') }}">{{ config('app.name') }}</a>
        @auth
            <a href="{{ route('tasks.index') }}">Задачи</a>
            <a href="{{ route('tasks.create') }}">Создать</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit">Выход</button>
            </form>
        @else
            <a href="{{ route('login') }}">Вход</a>
            <a href="{{ route('register') }}">Регистрация</a>
        @endauth
    </nav>
    <main class="p-6">
        @if(session('success'))
            <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif
        @yield('content')
    </main>
</body>
</html>
