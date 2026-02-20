@extends('layouts.auth')

@section('title', 'Register - ' . config('app.name'))

@section('content')
<div class="w-full max-w-md mx-auto px-4 sm:px-6">
    
    <!-- Brand Header -->
    <div class="text-center mb-8 sm:mb-10">
        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-primary-900 to-primary-700 rounded-2xl mb-4 shadow-lg shadow-primary-900/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Create Account</h1>
        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400">Join us and start shopping</p>
    </div>

    <!-- Register Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 sm:p-8">
            
            <!-- Welcome Offer Badge -->
            <div class="mb-6 p-4 bg-gradient-to-r from-primary-50 to-red-50 dark:from-primary-900/20 dark:to-red-900/20 border border-primary-100 dark:border-primary-800 rounded-xl">
                <p class="text-sm text-center text-primary-900 dark:text-primary-200 font-medium">
                    🎉 Get <span class="font-bold">10% OFF</span> your first order!
                </p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Full Name
                    </label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="John Doe" 
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 focus:ring-red-500 @enderror" 
                        required 
                        autofocus 
                        autocomplete="name"
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Email Address
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="you@example.com" 
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 focus:ring-red-500 @enderror" 
                        required 
                        autocomplete="username"
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        placeholder="••••••••" 
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 focus:ring-red-500 @enderror" 
                        required 
                        autocomplete="new-password"
                    />
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">At least 8 characters</p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirm Password
                    </label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="••••••••" 
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200 @error('password_confirmation') border-red-500 focus:ring-red-500 @enderror" 
                        required 
                        autocomplete="new-password"
                    />
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div>
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input 
                            type="checkbox" 
                            name="terms" 
                            class="w-4 h-4 mt-0.5 text-primary-600 border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 flex-shrink-0" 
                            required
                        />
                        <span class="text-sm text-gray-600 dark:text-gray-400 leading-5">
                            I agree to the 
                            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline font-medium">Terms of Service</a> 
                            and 
                            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline font-medium">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-primary-900 to-primary-700 hover:from-primary-800 hover:to-primary-600 text-white font-medium rounded-xl shadow-lg shadow-primary-900/30 hover:shadow-xl hover:shadow-primary-900/40 transition-all duration-200 transform hover:-translate-y-0.5">
                    Create Account
                </button>

            </form>
        </div>

        <!-- Login Link -->
        <div class="px-6 sm:px-8 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700">
            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                    Sign in
                </a>
            </p>
        </div>
    </div>

    <!-- Footer Links -->
    <div class="text-center mt-6 sm:mt-8">
        <p class="text-xs text-gray-500 dark:text-gray-500">
            By creating an account, you agree to our 
            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline">Terms</a> and 
            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:underline">Privacy Policy</a>
        </p>
    </div>
</div>
@endsection
