@extends('layouts.customer')

@section('title', 'Profile Settings - ' . config('app.name'))

@section('content')
<div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
    <p class="mt-2 text-sm sm:text-base text-gray-600 dark:text-gray-400">Keep your account information secure and up to date.</p>
</div>

<div class="space-y-6">
    <section class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="font-bold text-gray-900 dark:text-white">Profile Information</h2>
        </div>
        <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors duration-150">Save changes</button>
        </form>
    </section>

    <section class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="font-bold text-gray-900 dark:text-white">Change Password</h2>
        </div>
        <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current password</label>
                <input id="update_password_current_password" name="current_password" type="password" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white">
                @error('current_password', 'updatePassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New password</label>
                <input id="update_password_password" name="password" type="password" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white">
                @error('password', 'updatePassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm new password</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 text-gray-900 dark:text-white">
            </div>

            <button type="submit" class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors duration-150">Update password</button>
        </form>
    </section>

    <section class="rounded-xl border border-red-200 bg-white overflow-hidden">
        <div class="px-6 py-4 border-b border-red-200">
            <h2 class="font-bold text-red-700">Delete Account</h2>
        </div>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('DELETE')
            <p class="text-sm text-gray-600">This action is permanent. Please confirm your password.</p>
            <div>
                <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="delete_password" name="password" type="password" required class="w-full px-3.5 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900">
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors duration-150">Delete account</button>
        </form>
    </section>
</div>
@endsection
