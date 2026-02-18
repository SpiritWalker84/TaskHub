@extends('layouts.app')

@section('title', ' — ' . $task->title)

@section('content')
<div class="task-header">
    <h1 style="margin: 0 0 1rem 0;">{{ $task->title }}</h1>
    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
        <div>
            <strong>Статус:</strong> 
            <span class="task-status {{ $task->status }}">{{ ['new' => 'Новая', 'in_progress' => 'В работе', 'done' => 'Выполнена'][$task->status] ?? $task->status }}</span>
        </div>
        <div><strong>Создал:</strong> {{ $task->creator->name }}</div>
        @if($task->assignee)
            <div><strong>Исполнитель:</strong> {{ $task->assignee->name }}</div>
        @endif
        @if($task->due_date)
            <div><strong>Срок:</strong> {{ $task->due_date->format('d.m.Y') }}</div>
        @endif
    </div>
    @if($task->description)
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
            <p style="margin: 0; color: #374151; white-space: pre-wrap;">{{ $task->description }}</p>
        </div>
    @endif
    @auth
        <div class="task-actions">
            <a href="{{ route('tasks.edit', $task) }}">Редактировать</a>
            <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: inline;" onsubmit="return confirm('Удалить задачу?');">
                @csrf
                @method('DELETE')
                <button type="submit">Удалить</button>
            </form>
        </div>
    @endauth
</div>

@auth
    <div class="comments-section">
        <h2>Комментарии</h2>
        <form method="POST" action="{{ route('comments.store', $task) }}" class="comment-form">
            @csrf
            <div class="form-group">
                <label>Добавить комментарий</label>
                <textarea name="body" required placeholder="Напишите комментарий..."></textarea>
            </div>
            <button type="submit">Добавить комментарий</button>
        </form>
        @if($task->comments->count() > 0)
            @foreach($task->comments as $comment)
                <div class="comment-item">
                    <div class="comment-author">{{ $comment->user->name }}</div>
                    <div class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</div>
                    <div class="comment-body">{{ $comment->body }}</div>
                </div>
            @endforeach
        @else
            <p style="color: #9ca3af; text-align: center; padding: 2rem;">Пока нет комментариев</p>
        @endif
    </div>
@endauth
@endsection
