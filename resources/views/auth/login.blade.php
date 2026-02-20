@extends('layouts.auth')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="w-full max-w-md mx-auto">
    
    <!-- Brand Header -->
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-primary-900 to-primary-700 rounded-xl mb-3 shadow-lg shadow-primary-900/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Welcome Back</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400">Sign in to your account</p>
    </div>

    <!-- Login Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm text-green-800 dark:text-green-200">{{ session('status') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="you@example.com" 
                        class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-red-500 focus:ring-red-500 @enderror" 
                        required 
                        autofocus 
                        autocomplete="username"
                    />
                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="••••••••" 
                        class="w-full px-3.5 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('password') border-red-500 focus:ring-red-500 @enderror" 
                        required 
                        autocomplete="current-password"
                    />
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500"
                        />
                        <span class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 transition-colors">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white font-medium rounded-xl shadow-lg shadow-primary-900/30 hover:shadow-xl hover:shadow-primary-900/40 transition-all duration-200 transform hover:-translate-y-0.5">
                    Sign In
                </button>

            </form>
        </div>

        <!-- Register Link -->
        <div class="px-6 sm:px-8 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700">
            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                    Create account
                </a>
            </p>
        </div>
    </div>

    <!-- Footer Links -->
    <div class="text-center mt-6 sm:mt-8">
        <p class="text-xs text-gray-500 dark:text-gray-500">
            By signing in, you agree to our 
            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline">Terms</a> and 
            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline">Privacy Policy</a>
        </p>
    </div>
</div>
@endsection
