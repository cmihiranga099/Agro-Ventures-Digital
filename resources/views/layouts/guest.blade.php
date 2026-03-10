<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Task Manager') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen flex">
            {{-- Left panel --}}
            <div class="hidden lg:flex lg:w-5/12 bg-indigo-600 flex-col justify-between p-12">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <div class="h-9 w-9 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">{{ config('app.name', 'Task Manager') }}</span>
                </a>

                <div>
                    <h2 class="text-3xl font-bold text-white leading-snug">
                        Keep track of<br>your tasks.
                    </h2>
                    <p class="mt-3 text-indigo-200 text-sm leading-relaxed">
                        Create, organize, and manage your tasks with priorities, due dates, and status tracking.
                    </p>
                </div>

                <p class="text-indigo-300 text-xs">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
            </div>

            {{-- Right form panel --}}
            <div class="flex-1 flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16">
                <div class="w-full max-w-md mx-auto">
                    <div class="lg:hidden mb-8 flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ config('app.name', 'Task Manager') }}</span>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
