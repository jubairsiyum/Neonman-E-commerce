@extends('layouts.auth')

@section('title', 'Create Account - ' . config('app.name'))

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    /* Brand Colors - Vibrant Neon feel */
    --brand: #E11D48; 
    --brand-hover: #BE123C;
    --brand-dark: #881337;
    --brand-alpha: rgba(225, 29, 72, 0.12);
    
    /* Grayscale */
    --ink: #0F172A;
    --ink-2: #334155;
    --ink-3: #64748B;
    --ink-4: #94A3B8;
    --ink-5: #CBD5E1;
    --border: #E2E8F0;
    
    /* Interactive Background Variables (Updated by JS) */
    --mouse-x: 50%;
    --mouse-y: 50%;
    --bg-page: #030305;
    
    /* Geometry */
    --r-lg: 16px;
    --r: 10px;
    --r-sm: 8px;
    
    /* Typography */
    --font: 'Inter', system-ui, sans-serif;
    --font-head: 'Sora', system-ui, sans-serif;
    
    /* Status Colors */
    --error: #E11D48;
    --error-bg: #FFF1F2;
    --error-border: #FECDD3;
}

html, body {
    min-height: 100%;
    font-family: var(--font);
    background: var(--bg-page);
    -webkit-font-smoothing: antialiased;
}

/* ── Interactive Page Wrapper ─────────────────── */
.auth-page {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 16px 60px;
    position: relative;
    overflow: hidden;
    background-color: var(--bg-page);
}

.auth-page::before {
    content: ''; position: absolute; inset: -100px; 
    background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(225, 29, 72, 0.18), transparent 60%);
    z-index: 0; pointer-events: none; transition: background 0.1s ease;
}

.auth-page::after {
    content: ''; position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
    background-size: 32px 32px;
    mask-image: radial-gradient(400px circle at var(--mouse-x) var(--mouse-y), black 10%, transparent 100%);
    -webkit-mask-image: radial-gradient(400px circle at var(--mouse-x) var(--mouse-y), black 10%, transparent 100%);
    z-index: 0; pointer-events: none;
}

/* ── Glassmorphism Card ───────────────────────── */
.auth-card {
    position: relative; z-index: 10;
    width: 100%; max-width: 520px; /* Slightly wider for the 2-column grid */
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-radius: var(--r-lg); border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.2) inset;
    overflow: hidden;
    animation: cardFloat 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}

@keyframes cardFloat {
    from { opacity: 0; transform: translateY(30px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.card-stripe {
    height: 4px;
    background: linear-gradient(90deg, #FF4B2B, #FF416C, var(--brand), #FF4B2B);
    background-size: 300% 100%;
    animation: stripeShift 3s linear infinite;
}

@keyframes stripeShift {
    0% { background-position: 100% 0; }
    100% { background-position: -200% 0; }
}

.card-body { padding: 40px 40px 32px; }

/* ── Logo & Typography ────────────────────────── */
.card-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
.brand-icon {
    width: 40px; height: 40px; background: linear-gradient(135deg, var(--brand) 0%, #FF416C 100%);
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 12px rgba(225, 29, 72, 0.3); flex-shrink: 0;
}
.brand-icon svg { fill: #fff; width: 22px; height: 22px; }
.brand-name { font-family: var(--font-head); font-size: 20px; font-weight: 800; color: var(--ink); letter-spacing: -0.02em; }

.card-title { font-family: var(--font-head); font-size: 28px; font-weight: 700; color: var(--ink); letter-spacing: -0.03em; line-height: 1.2; margin-bottom: 6px; }
.card-sub { font-size: 14px; color: var(--ink-3); margin-bottom: 28px; }

/* ── Form Fields ──────────────────────────────── */
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.field { margin-bottom: 20px; position: relative; }

.field-label { display: block; font-size: 13px; font-weight: 600; color: var(--ink-2); margin-bottom: 8px; }
.field-label span { font-size: 11px; font-weight: 400; color: var(--ink-4); margin-left: 4px; }

.field-wrapper { position: relative; display: flex; align-items: center; }
.field-icon { position: absolute; left: 14px; color: var(--ink-4); pointer-events: none; transition: color 0.3s ease; display: flex; }

/* Eye Toggle Button */
.btn-reveal {
    position: absolute; right: 10px; background: none; border: none;
    color: var(--ink-4); cursor: pointer; padding: 6px; display: flex; align-items: center; justify-content: center;
    border-radius: 6px; transition: all 0.2s ease;
}
.btn-reveal:hover, .btn-reveal:focus { color: var(--brand); background: rgba(225, 29, 72, 0.08); outline: none; }
.d-none { display: none !important; }

.field-input {
    display: block; width: 100%; padding: 12px 14px 12px 42px;
    font-family: var(--font); font-size: 14px; color: var(--ink);
    background: rgba(248, 250, 252, 0.8); border: 1px solid var(--border);
    border-radius: var(--r-sm); outline: none; transition: all 0.2s ease;
}
.field-input.has-eye { padding-right: 44px; }
.field-input:focus { background: #fff; border-color: var(--brand); box-shadow: 0 0 0 4px var(--brand-alpha); }
.field:focus-within .field-icon { color: var(--brand); }

.field-input.is-error { border-color: var(--error-border); background: var(--error-bg); color: var(--error); }
.field-error { margin-top: 6px; font-size: 12px; color: var(--error); display: flex; align-items: center; gap: 6px; font-weight: 500; }

/* ── Terms & Buttons ──────────────────────────── */
.terms-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 24px; cursor: pointer; }
.terms-row input[type="checkbox"] { width: 16px; height: 16px; margin-top: 2px; accent-color: var(--brand); cursor: pointer; flex-shrink: 0; border: 1px solid var(--border); border-radius: 4px; }
.terms-row span { font-size: 13.5px; color: var(--ink-3); line-height: 1.5; font-weight: 500; }
.terms-row a { color: var(--brand); font-weight: 600; text-decoration: none; transition: color 0.2s ease; }
.terms-row a:hover { color: var(--brand-hover); text-decoration: underline; }

.btn-submit {
    display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px 20px;
    font-family: var(--font-head); font-size: 15px; font-weight: 600; color: #fff;
    background: linear-gradient(135deg, var(--brand) 0%, #FF416C 100%);
    border: none; border-radius: var(--r-sm); cursor: pointer; transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(225, 29, 72, 0.25);
}
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(225, 29, 72, 0.4); }
.btn-submit:active { transform: translateY(1px); }
.btn-submit svg { transition: transform 0.3s ease; }
.btn-submit:hover svg { transform: translateX(4px); }

/* ── Footer Elements ──────────────────────────── */
.card-switch { text-align: center; font-size: 14px; color: var(--ink-3); margin-top: 24px; }
.card-switch a { color: var(--ink); font-weight: 600; text-decoration: none; transition: color 0.2s ease; }
.card-switch a:hover { color: var(--brand); }

.auth-note { position: relative; z-index: 10; margin-top: 24px; text-align: center; font-size: 12px; color: rgba(255,255,255,0.4); line-height: 1.6; }
.auth-note a { color: rgba(255,255,255,0.7); text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 1px; transition: all 0.2s ease; }
.auth-note a:hover { color: #fff; border-color: #fff; }

@media(max-width: 520px) {
    .auth-page { padding: 20px 16px; }
    .card-body { padding: 32px 24px; }
    .field-row { grid-template-columns: 1fr; gap: 0; }
}
</style>

<div class="auth-page" id="auth-page">
    <div class="auth-card">
        <div class="card-stripe"></div>
        <div class="card-body"> 
            
            <div class="card-brand">
                <div class="brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="brand-name">Neonman</div>
            </div>

            <h1 class="card-title">Create your account</h1>
            <p class="card-sub">Join thousands of shoppers across Bangladesh</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field-row">
                    <div class="field">
                        <label class="field-label" for="name">Full Name</label>
                        <div class="field-wrapper">
                            <span class="field-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Rahim Uddin" autocomplete="name" required autofocus class="field-input {{ $errors->has('name') ? 'is-error' : '' }}" />
                        </div>
                        @error('name')<p class="field-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="phone">Phone <span>(optional)</span></label>
                        <div class="field-wrapper">
                            <span class="field-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="01XXXXXXXXX" autocomplete="tel" class="field-input {{ $errors->has('phone') ? 'is-error' : '' }}" />
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label" for="email">Email Address</label>
                    <div class="field-wrapper">
                        <span class="field-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="username" required class="field-input {{ $errors->has('email') ? 'is-error' : '' }}" />
                    </div>
                    @error('email')<p class="field-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>@enderror
                </div>

                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-wrapper">
                        <span class="field-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input id="password" type="password" name="password" placeholder="At least 8 characters" autocomplete="new-password" required class="field-input has-eye {{ $errors->has('password') ? 'is-error' : '' }}" />
                        
                        <button type="button" class="btn-reveal" data-target="password" aria-label="Toggle password visibility">
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="eye-slash-icon d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="field-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $message }}
                    </p>@enderror
                </div>

                <div class="field">
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <div class="field-wrapper">
                        <span class="field-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password" autocomplete="new-password" required class="field-input has-eye {{ $errors->has('password_confirmation') ? 'is-error' : '' }}" />
                        
                        <button type="button" class="btn-reveal" data-target="password_confirmation" aria-label="Toggle password visibility">
                            <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="eye-slash-icon d-none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <label class="terms-row">
                    <input type="checkbox" name="terms" required />
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>

                <button type="submit" class="btn-submit">
                    <span>Create my account</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>

            <div class="card-switch">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>

        </div>
    </div>

    <p class="auth-note">
        By creating an account you agree to our <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>
    </p>

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Interactive Cursor Glow Background
        const page = document.getElementById('auth-page');
        page.addEventListener('mousemove', (e) => {
            const rect = page.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            
            page.style.setProperty('--mouse-x', `${x}%`);
            page.style.setProperty('--mouse-y', `${y}%`);
        });

        // 2. Multi-Field Reveal Password Toggle
        const toggleBtns = document.querySelectorAll('.btn-reveal');
        
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const eyeIcon = btn.querySelector('.eye-icon');
                const eyeSlashIcon = btn.querySelector('.eye-slash-icon');

                // Toggle type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icons
                eyeIcon.classList.toggle('d-none');
                eyeSlashIcon.classList.toggle('d-none');
            });
        });
    });
</script>
@endsection