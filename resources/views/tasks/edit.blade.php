@extends('layouts.app')

@section('title', ' — Редактировать')

@section('content')
<h1>Редактировать задачу</h1>
<form method="POST" action="{{ route('tasks.update', $task) }}">
    @csrf
    @method('PUT')
    <div>
        <label>Название</label>
        <input type="text" name="title" value="{{ old('title', $task->title) }}" required>
        @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>
    <div>
        <label>Описание</label>
        <textarea name="description">{{ old('description', $task->description) }}</textarea>
    </div>
    <div>
        <label>Статус</label>
        <select name="status">
            <option value="new" {{ $task->status === 'new' ? 'selected' : '' }}>Новая</option>
            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
            <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Выполнена</option>
        </select>
    </div>
    <div>
        <label>Срок</label>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
    </div>
    <button type="submit">Сохранить</button>
</form>
@endsection
