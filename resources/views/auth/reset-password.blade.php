@extends('layouts.auth')

@section('title', 'Reset Password - ' . config('app.name'))

@section('content')
<div class="max-w-md mx-auto">
    <!-- Card -->
    <div class="card bg-white dark:bg-gray-800 shadow-2xl">
        <div class="card-body">
            <!-- Logo and Title -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Reset Password</h1>
                <p class="text-gray-600 dark:text-gray-400">Enter your new password below</p>
            </div>

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-control w-full">
                    <label class="label" for="email">
                        <span class="label-text font-semibold">Email Address</span>
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}"
                        placeholder="your@email.com" 
                        class="input input-bordered w-full @error('email') input-error @enderror" 
                        required 
                        autofocus 
                        autocomplete="username"
                    />
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-control w-full">
                    <label class="label" for="password">
                        <span class="label-text font-semibold">New Password</span>
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="••••••••" 
                        class="input input-bordered w-full @error('password') input-error @enderror" 
                        required 
                        autocomplete="new-password"
                    />
                    <label class="label">
                        <span class="label-text-alt text-gray-500">Minimum 8 characters</span>
                    </label>
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-control w-full">
                    <label class="label" for="password_confirmation">
                        <span class="label-text font-semibold">Confirm New Password</span>
                    </label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="••••••••" 
                        class="input input-bordered w-full @error('password_confirmation') input-error @enderror" 
                        required 
                        autocomplete="new-password"
                    />
                    @error('password_confirmation')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
