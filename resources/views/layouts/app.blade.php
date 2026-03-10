<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'TaskFlow') }}</title>
        <style>[x-cloak]{display:none;}</style>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50"
          x-data="{ confirmOpen: false, confirmText: '', confirmForm: null }"
          x-on:confirm-delete.window="confirmText = $event.detail.message || 'Are you sure?'; confirmForm = $event.detail.form; confirmOpen = true">

        <div class="min-h-screen">
            @include('layouts.navigation')

            {{-- Page header --}}
            @isset($header)
                <div class="bg-white border-b border-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            {{-- Toast notifications --}}
            @if (session('success'))
                <div class="fixed top-4 right-4 z-50 max-w-sm w-full"
                     x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-show="show"
                     x-transition:enter="transform transition ease-out duration-300"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transform transition ease-in duration-200"
                     x-transition:leave-start="translate-x-0 opacity-100"
                     x-transition:leave-end="translate-x-full opacity-0">
                    <div class="flex items-start gap-3 rounded-2xl bg-white px-4 py-3.5 shadow-xl border border-gray-100">
                        <div class="h-9 w-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">Success</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="fixed top-4 right-4 z-50 max-w-sm w-full"
                     x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition:enter="transform transition ease-out duration-300"
                     x-transition:enter-start="translate-x-full opacity-0"
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="transform transition ease-in duration-200"
                     x-transition:leave-start="translate-x-0 opacity-100"
                     x-transition:leave-end="translate-x-full opacity-0">
                    <div class="flex items-start gap-3 rounded-2xl bg-white px-4 py-3.5 shadow-xl border border-gray-100">
                        <div class="h-9 w-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">Error</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="py-8">
                {{ $slot }}
            </main>
        </div>

        {{-- Confirm modal --}}
        <div x-cloak x-show="confirmOpen"
             class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="confirmOpen = false"></div>
            <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl border border-gray-100 p-6"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-full bg-rose-100 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Confirm action</p>
                        <p class="text-sm text-gray-500" x-text="confirmText"></p>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button"
                            class="rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition"
                            @click="confirmOpen = false; confirmForm = null">
                        Cancel
                    </button>
                    <button type="button"
                            class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 transition"
                            @click="confirmForm?.submit(); confirmOpen = false">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </body>
</html>
