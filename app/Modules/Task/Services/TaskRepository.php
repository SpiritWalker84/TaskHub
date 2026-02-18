<?php

namespace App\Modules\Task\Services;

use App\Modules\Task\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements TaskRepositoryInterface
{
    public function find(int $id): ?Task
    {
        return Task::with(['creator', 'assignee', 'comments'])->find($id);
    }

    public function paginate(int $perPage = 15, ?array $filters = null): LengthAwarePaginator
    {
        $query = Task::with(['creator', 'assignee']);

        if ($filters) {
            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }
            if (!empty($filters['assignee_id'])) {
                $query->where('assignee_id', $filters['assignee_id']);
            }
            if (!empty($filters['creator_id'])) {
                $query->where('creator_id', $filters['creator_id']);
            }
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
