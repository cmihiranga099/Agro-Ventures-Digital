<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskApiController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'priority', 'search', 'due_from', 'due_to', 'sort', 'trashed']);

        $query = Task::ownedBy(Auth::id())->filter($filters);

        $query = match ($filters['sort'] ?? 'newest') {
            'oldest' => $query->oldest(),
            'due_date' => $query->orderByRaw('due_date IS NULL')->orderBy('due_date'),
            'priority' => $query->orderByRaw("field(priority, 'high','medium','low')"),
            default => $query->latest(),
        };

        $tasks = $query->paginate(10)->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $tasks->items(),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Auth::user()->tasks()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Task created.',
            'data' => $task,
        ], 201);
    }

    public function show(Task $task)
    {
        Gate::authorize('view', $task);

        return response()->json([
            'success' => true,
            'data' => $task,
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);
        $task->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Task updated.',
            'data' => $task,
        ]);
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted.',
        ]);
    }

    public function trashed(Request $request)
    {
        $tasks = Task::onlyTrashed()
            ->ownedBy(Auth::id())
            ->filter($request->only(['status', 'priority', 'search', 'due_from', 'due_to']))
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $tasks->items(),
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function restore(int $id)
    {
        $task = Task::onlyTrashed()->ownedBy(Auth::id())->findOrFail($id);
        Gate::authorize('restore', $task);
        $task->restore();

        return response()->json([
            'success' => true,
            'message' => 'Task restored.',
            'data' => $task,
        ]);
    }
}
