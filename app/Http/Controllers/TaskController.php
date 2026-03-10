<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $filters = $this->filters($request);

        $query = Task::ownedBy(Auth::id())
            ->filter($filters);

        $query = match ($filters['sort'] ?? 'newest') {
            'oldest' => $query->oldest(),
            'due_date' => $query->orderByRaw('due_date IS NULL')->orderBy('due_date'),
            'priority' => $query->orderByRaw("field(priority, 'high','medium','low')"),
            default => $query->latest(),
        };

        $tasks = $query->paginate(8)->withQueryString();

        $stats = [
            'total' => Task::ownedBy(Auth::id())->count(),
            'pending' => Task::ownedBy(Auth::id())->where('status', 'pending')->count(),
            'in_progress' => Task::ownedBy(Auth::id())->where('status', 'in_progress')->count(),
            'completed' => Task::ownedBy(Auth::id())->where('status', 'completed')->count(),
            'deleted' => Task::onlyTrashed()->ownedBy(Auth::id())->count(),
        ];

        $recent = Task::ownedBy(Auth::id())->latest()->take(5)->get();
        $upcoming = Task::ownedBy(Auth::id())
            ->whereNotNull('due_date')
            ->whereDate('due_date', '>=', now()->startOfDay())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('tasks.index', compact('tasks', 'filters', 'stats', 'recent', 'upcoming'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Auth::user()->tasks()->create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return back()->with('success', 'Task moved to trash.');
    }

    public function trashed(Request $request)
    {
        $tasks = Task::onlyTrashed()
            ->ownedBy(Auth::id())
            ->filter($this->filters($request))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('tasks.trash', ['tasks' => $tasks]);
    }

    public function restore(int $id)
    {
        $task = Task::onlyTrashed()->ownedBy(Auth::id())->findOrFail($id);
        Gate::authorize('restore', $task);
        $task->restore();

        return back()->with('success', 'Task restored.');
    }

    public function forceDelete(int $id)
    {
        $task = Task::onlyTrashed()->ownedBy(Auth::id())->findOrFail($id);
        Gate::authorize('forceDelete', $task);
        $task->forceDelete();

        return back()->with('success', 'Task permanently deleted.');
    }

    private function filters(Request $request): array
    {
        return $request->only(['status', 'priority', 'search', 'due_from', 'due_to', 'sort', 'trashed']);
    }
}
