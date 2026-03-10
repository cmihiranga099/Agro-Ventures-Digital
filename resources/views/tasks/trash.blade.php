<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tasks.index') }}" class="flex items-center justify-center h-8 w-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Task Manager</p>
                    <h1 class="text-2xl font-bold text-gray-900 mt-0.5">Trash</h1>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center">
                        <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-gray-900">Deleted Tasks</h2>
                </div>
                <span class="rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-2.5 py-1">{{ $tasks->total() }} items</span>
            </div>

            @if($tasks->count())
                <div class="divide-y divide-gray-50">
                    @foreach($tasks as $task)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-5 py-4 hover:bg-gray-50/50 transition">
                            <div class="flex items-start gap-3 flex-1 min-w-0">
                                <div class="h-9 w-9 rounded-xl bg-rose-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="h-4 w-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $task->title }}</p>
                                    @if($task->description)
                                        <p class="text-xs text-gray-400 truncate mt-0.5">{{ $task->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1.5">
                                        @include('tasks.partials.badge-priority', ['priority' => $task->priority])
                                        @include('tasks.partials.badge-status', ['status' => $task->status])
                                        <span class="text-xs text-gray-400">Deleted {{ $task->deleted_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <form method="POST" action="{{ route('tasks.restore', $task->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Restore
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('tasks.force-delete', $task->id) }}"
                                      x-on:submit.prevent="$dispatch('confirm-delete', { message: 'Permanently delete &quot;{{ addslashes($task->title) }}&quot;? This cannot be undone.', form: $event.target })">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 transition">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete forever
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($tasks->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100">
                        {{ $tasks->links() }}
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center text-center py-16 px-6">
                    <div class="h-16 w-16 rounded-2xl bg-slate-50 flex items-center justify-center mb-4">
                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">Trash is empty</h3>
                    <p class="text-sm text-gray-500 mb-4">Deleted tasks will appear here. You can restore or permanently delete them.</p>
                    <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Back to tasks</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
