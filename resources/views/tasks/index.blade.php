@extends('layouts.app')

@section('title', ' — Задачи')

@section('content')
<h1>Задачи</h1>
<a href="{{ route('tasks.create') }}">Создать задачу</a>
<ul class="mt-4 space-y-2">
    @forelse($tasks as $task)
        <li>
            <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
            — {{ $task->status }}
            @if($task->assignee) ({{ $task->assignee->name }}) @endif
        </li>
    @empty
        <li>Нет задач.</li>
    @endforelse
</ul>
{{ $tasks->links() }}
@endsection
