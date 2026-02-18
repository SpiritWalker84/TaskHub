<?php

namespace App\Modules\Task\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Task\Models\Task;
use App\Modules\Task\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(Request $request): View
    {
        $tasks = $this->taskService->paginate(
            (int) $request->get('per_page', 15),
            $request->only(['status', 'assignee_id', 'creator_id'])
        );
        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:new,in_progress,done',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);
        $task = $this->taskService->create($validated, $request->user());
        return redirect()->route('tasks.show', $task)->with('success', __('task.created'));
    }

    public function show(Task $task): View
    {
        $task->load(['creator', 'assignee', 'comments.user']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:new,in_progress,done',
            'assignee_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);
        $this->taskService->update($task, $validated);
        return redirect()->route('tasks.show', $task)->with('success', __('task.updated'));
    }

    public function destroy(Task $task)
    {
        $this->taskService->delete($task);
        return redirect()->route('tasks.index')->with('success', __('task.deleted'));
    }
}
