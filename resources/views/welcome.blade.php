<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Task Manager') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-sm text-center">
            <div class="flex items-center justify-center gap-2.5 mb-6">
                <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-900">{{ config('app.name', 'Task Manager') }}</span>
            </div>

            <p class="text-gray-500 text-sm mb-8">
                A task management app built with Laravel and MySQL.
            </p>

            <div class="flex flex-col gap-3">
                @auth
                    <a href="{{ route('tasks.index') }}"
                       class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                        Go to my tasks
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                       class="w-full inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Create an account
                    </a>
                @endauth
            </div>
        </div>
    </div>

</body>
</html>
