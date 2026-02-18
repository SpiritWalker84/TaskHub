@extends('layouts.app')

@section('title', ' — ' . $task->title)

@section('content')
<h1>{{ $task->title }}</h1>
<p>Статус: {{ $task->status }}</p>
<p>Создал: {{ $task->creator->name }}</p>
@if($task->assignee)
    <p>Исполнитель: {{ $task->assignee->name }}</p>
@endif
@if($task->due_date)
    <p>Срок: {{ $task->due_date->format('d.m.Y') }}</p>
@endif
<p>{{ $task->description }}</p>

@auth
    <p><a href="{{ route('tasks.edit', $task) }}">Редактировать</a></p>
    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Удалить?');">
        @csrf
        @method('DELETE')
        <button type="submit">Удалить</button>
    </form>

    <h2>Комментарии</h2>
    <form method="POST" action="{{ route('comments.store', $task) }}">
        @csrf
        <textarea name="body" required placeholder="Текст комментария"></textarea>
        <button type="submit">Добавить</button>
    </form>
@endauth

<ul class="mt-4">
    @foreach($task->comments as $comment)
        <li><strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}</li>
    @endforeach
</ul>
@endsection
