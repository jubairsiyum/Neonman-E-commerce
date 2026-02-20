@extends('layouts.customer')

@section('title', 'Profile Settings - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Profile Settings</h1>
    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Manage your account information and preferences</p>
</div>

<!-- Profile Information -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Profile Information</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your account's profile information and email address</p>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Full Name
                </label>
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name', auth()->user()->name) }}"
                    class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                    required 
                />
                @error('name')
                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Email Address
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email', auth()->user()->email) }}"
                    class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
                    required 
                />
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    Save Changes
                </button>
                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-green-600 dark:text-green-400">Saved successfully!</p>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Update Password -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Update Password</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ensure your account is using a long, random password to stay secure</p>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Current Password
                </label>
                <input 
                    id="current_password" 
                    type="password" 
                    name="current_password" 
                    class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('current_password') border-red-500 @enderror" 
                />
                @error('current_password')
                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    New Password
                </label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror" 
                />
                @error('password')
                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                    Confirm Password
                </label>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center gap-4">
                <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    Update Password
                </button>
                @if (session('status') === 'password-updated')
                    <p class="text-sm text-green-600 dark:text-green-400">Password updated!</p>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Delete Account -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-800 overflow-hidden">
    <div class="px-6 py-4 border-b border-red-200 dark:border-red-800">
        <h2 class="text-lg font-bold text-red-600 dark:text-red-400">Delete Account</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Permanently delete your account</p>
    </div>
    <div class="p-6">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
        <button type="button" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
            Delete Account
        </button>
    </div>
</div>
@endsection
