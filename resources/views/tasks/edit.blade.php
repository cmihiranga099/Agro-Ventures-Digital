<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}" class="flex items-center justify-center h-8 w-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <p class="text-xs font-medium text-indigo-600 uppercase tracking-wider">Tasks</p>
                <h1 class="text-2xl font-bold text-gray-900 mt-0.5">Edit Task</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $task->title }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Last updated {{ $task->updated_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @include('tasks.partials.badge-status', ['status' => $task->status])
                    @include('tasks.partials.badge-priority', ['priority' => $task->priority])
                </div>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')
                    @include('tasks.partials.form', ['buttonLabel' => 'Save Changes'])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
