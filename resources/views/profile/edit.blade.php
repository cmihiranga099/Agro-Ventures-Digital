<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}" class="flex items-center justify-center h-8 w-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <p class="text-xs font-medium text-indigo-600 uppercase tracking-wider">Account</p>
                <h1 class="text-2xl font-bold text-gray-900 mt-0.5">Profile Settings</h1>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
        {{-- User info card --}}
        <div class="rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 p-5 text-white shadow-lg">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-lg">{{ Auth::user()->name }}</p>
                    <p class="text-indigo-200 text-sm">{{ Auth::user()->email }}</p>
                    <p class="text-indigo-300 text-xs mt-0.5">Member since {{ Auth::user()->created_at->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-sm font-semibold text-gray-900">Profile Information</h2>
                <p class="text-xs text-gray-500 mt-0.5">Update your name and email address.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-sm font-semibold text-gray-900">Update Password</h2>
                <p class="text-xs text-gray-500 mt-0.5">Use a long, random password to keep your account secure.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-rose-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-rose-50 bg-rose-50/50">
                <h2 class="text-sm font-semibold text-rose-700">Danger Zone</h2>
                <p class="text-xs text-rose-500 mt-0.5">Permanently delete your account and all your data.</p>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
