@extends('layouts.auth')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="max-w-md mx-auto">
    <!-- Card -->
    <div class="card bg-white dark:bg-gray-800 shadow-2xl">
        <div class="card-body">
            <!-- Logo and Title -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome Back!</h1>
                <p class="text-gray-600 dark:text-gray-400">Login to your account to continue</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div class="form-control w-full">
                    <label class="label" for="email">
                        <span class="label-text font-semibold">Email Address</span>
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
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
                        <span class="label-text font-semibold">Password</span>
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="••••••••" 
                        class="input input-bordered w-full @error('password') input-error @enderror" 
                        required 
                        autocomplete="current-password"
                    />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="label cursor-pointer gap-2 p-0">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember" 
                            class="checkbox checkbox-primary checkbox-sm"
                        />
                        <span class="label-text text-sm">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link link-primary text-sm">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login
                    </button>
                </div>

                <!-- Divider -->
                <div class="divider">OR</div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="link link-primary font-semibold">
                            Register now
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Extra Info -->
    <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
        <p>By logging in, you agree to our <a href="#" class="link link-primary">Terms of Service</a> and <a href="#" class="link link-primary">Privacy Policy</a></p>
    </div>
</div>
@endsection
