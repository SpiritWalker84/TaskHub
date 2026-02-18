@extends('layouts.app')

@section('title', ' — Новая задача')

@section('content')
<h1>Новая задача</h1>
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <div>
        <label>Название</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>
    <div>
        <label>Описание</label>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>
    <div>
        <label>Срок</label>
        <input type="date" name="due_date" value="{{ old('due_date') }}">
    </div>
    <button type="submit">Создать</button>
</form>
@endsection
