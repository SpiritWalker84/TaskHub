@extends('layouts.app')

@section('title', ' — Вход')

@section('content')
<h1>Вход</h1>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>
    <div>
        <label>Пароль</label>
        <input type="password" name="password" required>
        @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>
    <div>
        <label><input type="checkbox" name="remember"> Запомнить</label>
    </div>
    <button type="submit">Войти</button>
</form>
@endsection
