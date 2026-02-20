@extends('layouts.auth')

@section('title', 'Register - ' . config('app.name'))

@section('content')
<div class="max-w-md mx-auto">
    <!-- Card -->
    <div class="card bg-white dark:bg-gray-800 shadow-2xl">
        <div class="card-body">
            <!-- Logo and Title -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Create Account</h1>
                <p class="text-gray-600 dark:text-gray-400">Join us and start shopping today!</p>
            </div>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div class="form-control w-full">
                    <label class="label" for="name">
                        <span class="label-text font-semibold">Full Name</span>
                    </label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="John Doe" 
                        class="input input-bordered w-full @error('name') input-error @enderror" 
                        required 
                        autofocus 
                        autocomplete="name"
                    />
                    @error('name')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

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
                        <span class="label-text font-semibold">Confirm Password</span>
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

                <!-- Terms and Conditions -->
                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-2 p-0">
                        <input 
                            type="checkbox" 
                            name="terms" 
                            class="checkbox checkbox-primary checkbox-sm" 
                            required
                        />
                        <span class="label-text text-sm">
                            I agree to the <a href="#" class="link link-primary">Terms of Service</a> and 
                            <a href="#" class="link link-primary">Privacy Policy</a>
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-primary btn-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Create Account
                    </button>
                </div>

                <!-- Divider -->
                <div class="divider">OR</div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="link link-primary font-semibold">
                            Login here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Extra Info -->
    <div class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
        <p>🎉 Get 10% off your first order when you sign up!</p>
    </div>
</div>
@endsection
