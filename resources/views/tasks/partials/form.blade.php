@csrf
<div class="space-y-5">
    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
            Title <span class="text-rose-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $task->title ?? '') }}"
               class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400
                      focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition"
               placeholder="Write a clear, short title" required maxlength="255" />
        @error('title')
            <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1">
                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
            Description
            <span class="ml-1 text-xs font-normal text-gray-400">(optional)</span>
        </label>
        <textarea id="description" name="description" rows="4"
                  class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 placeholder-gray-400
                         focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition resize-none"
                  placeholder="Add context, acceptance criteria, or notes...">{{ old('description', $task->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1">
                <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Status / Priority / Due Date --}}
    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                Status <span class="text-rose-500">*</span>
            </label>
            <select id="status" name="status" required
                    class="block w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-3 text-sm text-gray-700
                           focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition">
                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $key => $label)
                    <option value="{{ $key }}" @selected(old('status', $task->status ?? 'pending') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                Priority <span class="text-rose-500">*</span>
            </label>
            <select id="priority" name="priority" required
                    class="block w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-3 text-sm text-gray-700
                           focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition">
                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $key => $label)
                    <option value="{{ $key }}" @selected(old('priority', $task->priority ?? 'medium') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @error('priority')
                <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">
                Due Date
                <span class="ml-1 text-xs font-normal text-gray-400">(optional)</span>
            </label>
            <input type="date" id="due_date" name="due_date"
                   value="{{ old('due_date', optional($task->due_date ?? null)->format('Y-m-d')) }}"
                   class="block w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-3 text-sm text-gray-700
                          focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 transition" />
            @error('due_date')
                <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-5">
    <a href="{{ route('tasks.index') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Cancel
    </a>
    <button type="submit"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        {{ $buttonLabel }}
    </button>
</div>
