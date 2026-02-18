@extends('layouts.app')

@section('title', ' — Новая задача')

@section('content')
<h1>Новая задача</h1>
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <div class="form-group">
        <label>Название</label>
        <input type="text" name="title" value="{{ old('title') }}" required>
        @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label>Описание</label>
        <textarea name="description" placeholder="Описание задачи...">{{ old('description') }}</textarea>
    </div>
    <div class="form-group">
        <label>Срок выполнения</label>
        <input type="date" name="due_date" value="{{ old('due_date') }}">
    </div>
    <button type="submit">Создать задачу</button>
</form>
@endsection
