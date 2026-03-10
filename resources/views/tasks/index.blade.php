<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-medium text-indigo-600 uppercase tracking-wider">Task Manager</p>
                <h1 class="text-2xl font-bold text-gray-900 mt-0.5">My Tasks</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('tasks.trashed') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Trash
                    @if($stats['deleted'] > 0)
                        <span class="ml-0.5 rounded-full bg-gray-100 px-1.5 py-0.5 text-xs font-semibold text-gray-600">{{ $stats['deleted'] }}</span>
                    @endif
                </a>
                <a href="{{ route('tasks.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New Task
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        {{-- Stats cards --}}
        <div class="grid gap-4 grid-cols-2 lg:grid-cols-5">
            @php
                $statCards = [
                    ['label' => 'Total', 'value' => $stats['total'], 'color' => 'bg-indigo-600', 'light' => 'bg-indigo-50 text-indigo-700', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'bg-amber-500', 'light' => 'bg-amber-50 text-amber-700', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'In Progress', 'value' => $stats['in_progress'], 'color' => 'bg-blue-600', 'light' => 'bg-blue-50 text-blue-700', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                    ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'bg-emerald-600', 'light' => 'bg-emerald-50 text-emerald-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'Deleted', 'value' => $stats['deleted'], 'color' => 'bg-slate-500', 'light' => 'bg-slate-50 text-slate-700', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
                ];
            @endphp
            @foreach ($statCards as $card)
                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm p-4 flex items-center gap-4">
                    <div class="h-11 w-11 rounded-xl {{ $card['color'] }} flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500">{{ $card['label'] }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Main content --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Filters --}}
                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm p-5">
                    <form method="GET" action="{{ route('tasks.index') }}">
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="sm:col-span-2">
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                                        class="block w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 pl-9 pr-4 text-sm placeholder-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition"
                                        placeholder="Search tasks..." />
                                </div>
                            </div>
                            <div>
                                <select name="status" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-3 text-sm text-gray-700 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition">
                                    <option value="">All statuses</option>
                                    @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $key => $label)
                                        <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="priority" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-3 text-sm text-gray-700 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition">
                                    <option value="">All priorities</option>
                                    @foreach (['high' => 'High', 'medium' => 'Medium', 'low' => 'Low'] as $key => $label)
                                        <option value="{{ $key }}" @selected(($filters['priority'] ?? '') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="date" name="due_from" value="{{ $filters['due_from'] ?? '' }}"
                                    class="block w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-3 text-sm text-gray-700 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition" />
                            </div>
                            <div>
                                <input type="date" name="due_to" value="{{ $filters['due_to'] ?? '' }}"
                                    class="block w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-3 text-sm text-gray-700 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition" />
                            </div>
                            <div>
                                <select name="sort" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-3 text-sm text-gray-700 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition">
                                    <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Newest first</option>
                                    <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Oldest first</option>
                                    <option value="due_date" @selected(($filters['sort'] ?? '') === 'due_date')>Due date</option>
                                    <option value="priority" @selected(($filters['sort'] ?? '') === 'priority')>Priority</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2 flex items-center gap-2">
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                                    Apply
                                </button>
                                <a href="{{ route('tasks.index') }}"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                                    Reset
                                </a>
                                @if(array_filter($filters))
                                    <span class="text-xs text-indigo-600 font-medium">Filters active</span>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Task list --}}
                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-900">Task List</h2>
                        <span class="text-xs text-gray-500 bg-gray-100 rounded-full px-2.5 py-1">{{ $tasks->total() }} {{ Str::plural('task', $tasks->total()) }}</span>
                    </div>

                    @if ($tasks->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead>
                                    <tr class="bg-gray-50/70 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        <th class="px-5 py-3">Task</th>
                                        <th class="px-5 py-3">Status</th>
                                        <th class="px-5 py-3">Priority</th>
                                        <th class="px-5 py-3">Due Date</th>
                                        <th class="px-5 py-3">Updated</th>
                                        <th class="px-5 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($tasks as $task)
                                        <tr class="group hover:bg-indigo-50/30 transition">
                                            <td class="px-5 py-4 max-w-xs">
                                                <div class="font-semibold text-gray-900 truncate">{{ $task->title }}</div>
                                                @if($task->description)
                                                    <div class="text-xs text-gray-400 mt-0.5 truncate">{{ $task->description }}</div>
                                                @endif
                                            </td>
                                            <td class="px-5 py-4">
                                                @include('tasks.partials.badge-status', ['status' => $task->status])
                                            </td>
                                            <td class="px-5 py-4">
                                                @include('tasks.partials.badge-priority', ['priority' => $task->priority])
                                            </td>
                                            <td class="px-5 py-4">
                                                @if($task->due_date)
                                                    @php $isOverdue = $task->due_date->isPast() && $task->status !== 'completed'; @endphp
                                                    <span class="text-sm {{ $isOverdue ? 'text-rose-600 font-medium' : 'text-gray-600' }}">
                                                        {{ $task->due_date->format('M d, Y') }}
                                                        @if($isOverdue) <span class="text-xs">(overdue)</span> @endif
                                                    </span>
                                                @else
                                                    <span class="text-gray-300">&mdash;</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-4 text-xs text-gray-400">
                                                {{ $task->updated_at->diffForHumans() }}
                                            </td>
                                            <td class="px-5 py-4 text-right">
                                                <div class="flex items-center justify-end gap-1 opacity-70 group-hover:opacity-100 transition">
                                                    <a href="{{ route('tasks.edit', $task) }}"
                                                       class="inline-flex items-center gap-1 rounded-lg border border-indigo-100 bg-indigo-50 px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                                          x-on:submit.prevent="$dispatch('confirm-delete', { message: 'Move &quot;{{ addslashes($task->title) }}&quot; to trash?', form: $event.target })">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-1 rounded-lg border border-rose-100 bg-rose-50 px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 transition">
                                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($tasks->hasPages())
                            <div class="px-5 py-4 border-t border-gray-100">
                                {{ $tasks->links() }}
                            </div>
                        @endif
                    @else
                        <div class="flex flex-col items-center text-center py-16 px-6">
                            <div class="h-16 w-16 rounded-2xl bg-indigo-50 flex items-center justify-center mb-4">
                                <svg class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 mb-1">No tasks found</h3>
                            <p class="text-sm text-gray-500 mb-4">
                                @if(array_filter($filters))
                                    No tasks match your current filters. Try adjusting or resetting them.
                                @else
                                    You haven't created any tasks yet. Get started now!
                                @endif
                            </p>
                            @if(array_filter($filters))
                                <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Clear filters</a>
                            @else
                                <a href="{{ route('tasks.create') }}"
                                   class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                    Create your first task
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-4">
                {{-- Upcoming deadlines --}}
                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 text-sm">Upcoming Deadlines</h3>
                        @if($upcoming->count())
                            <span class="rounded-full bg-amber-50 text-amber-700 text-xs font-semibold px-2 py-0.5">{{ $upcoming->count() }}</span>
                        @endif
                    </div>
                    <div class="space-y-2.5">
                        @forelse ($upcoming as $item)
                            <div class="flex items-start gap-3 rounded-xl border border-gray-100 p-3">
                                <div class="h-8 w-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->title }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-500">{{ $item->due_date?->format('M d') }}</span>
                                        @include('tasks.partials.badge-status', ['status' => $item->status])
                                    </div>
                                </div>
                                @include('tasks.partials.badge-priority', ['priority' => $item->priority])
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <svg class="h-8 w-8 text-gray-200 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs text-gray-400">No upcoming deadlines</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Recent activity --}}
                <div class="rounded-2xl bg-white border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-900 text-sm">Recent Activity</h3>
                        @if($recent->count())
                            <span class="rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5">{{ $recent->count() }}</span>
                        @endif
                    </div>
                    <div class="space-y-2.5">
                        @forelse ($recent as $item)
                            <div class="flex items-center gap-3 rounded-xl border border-gray-100 p-3">
                                <div class="h-8 w-8 rounded-lg bg-gray-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->updated_at->diffForHumans() }}</p>
                                </div>
                                @include('tasks.partials.badge-status', ['status' => $item->status])
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-xs text-gray-400">No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
