@extends('layouts.auth')

@section('title', 'Forgot Password - ' . config('app.name'))

@push('styles')
@include('components.auth-styles')
@endpush

@section('content')
<div class="glass-card login-card animate-fadeIn">
    <div class="glass-card-inner">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-900/10 mb-5">
                <svg class="w-8 h-8 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 font-display">Forgot Password?</h1>
            <p class="text-white/60 text-sm">Enter your email and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-white/80 mb-2">Email Address</label>
                <div class="input-group">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required autofocus class="input-field @error('email') input-error @enderror">
                </div>
                @error('email')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary w-full py-3 text-base flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Email Password Reset Link
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-white/60 hover:text-white/90 transition-colors flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Sign In
            </a>
        </div>
    </div>
</div>
@endsection
