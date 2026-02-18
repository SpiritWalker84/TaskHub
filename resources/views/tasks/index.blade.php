@extends('layouts.app')

@section('title', ' — Задачи')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 style="margin: 0;">Задачи</h1>
    <a href="{{ route('tasks.create') }}" class="btn" style="text-decoration: none;">+ Создать задачу</a>
</div>
@if($tasks->count() > 0)
    <ul class="task-list">
        @foreach($tasks as $task)
            <li class="task-item">
                <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                <div class="task-meta">
                    <span class="task-status {{ $task->status }}">{{ __('task.status.' . $task->status, ['new' => 'Новая', 'in_progress' => 'В работе', 'done' => 'Выполнена'][$task->status] ?? $task->status) }}</span>
                    @if($task->assignee) • Исполнитель: {{ $task->assignee->name }} @endif
                    @if($task->due_date) • Срок: {{ $task->due_date->format('d.m.Y') }} @endif
                </div>
            </li>
        @endforeach
    </ul>
    <div class="pagination">{{ $tasks->links() }}</div>
@else
    <div class="empty-state">
        <p>Нет задач. <a href="{{ route('tasks.create') }}">Создайте первую задачу</a></p>
    </div>
@endif
@endsection
