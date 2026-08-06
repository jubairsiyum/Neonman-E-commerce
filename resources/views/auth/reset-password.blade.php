@extends('layouts.auth')

@section('title', 'Reset Password - ' . config('app.name'))

@push('styles')
@include('components.auth-styles')
@endpush

@section('content')
<div class="glass-card login-card animate-fadeIn">
    <div class="glass-card-inner">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary-900/10 mb-5">
                <svg class="w-8 h-8 text-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 font-display">Reset Password</h1>
            <p class="text-white/60 text-sm">Enter your new password below.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-medium text-white/80 mb-2">Email Address</label>
                <div class="input-group">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="input-field @error('email') input-error @enderror">
                </div>
                @error('email')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-white/80 mb-2">New Password</label>
                <div class="input-group">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" class="input-field @error('password') input-error @enderror">
                </div>
                <p class="text-white/40 text-xs mt-1.5">Minimum 8 characters</p>
                @error('password')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-white/80 mb-2">Confirm New Password</label>
                <div class="input-group">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" class="input-field">
                </div>
                @error('password_confirmation')<p class="text-red-400 text-xs mt-1.5">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary w-full py-3 text-base flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection
