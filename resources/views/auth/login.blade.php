@extends('layouts.auth')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --brand:        #6A0404;
        --brand-hover:  #820505;
        --brand-dark:   #450303;
        --ink:          #0f0f0f;
        --ink-sub:      #3d3d3d;
        --ink-muted:    #6b6b6b;
        --ink-faint:    #9e9e9e;
        --border:       #e3e3e3;
        --border-hover: #c0c0c0;
        --surface:      #ffffff;
        --error:        #b91c1c;
        --error-bg:     #fef2f2;
        --success:      #15803d;
        --success-bg:   #f0fdf4;
        --radius:       6px;
    }

    html, body { height: 100%; }

    /* Layout */
    .auth-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* Hero Panel */
    .hero {
        background: #0f0f0f;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 48px 56px;
        overflow: hidden;
        color: #fff;
    }

    /* Dot grid — no image, no color overlay */
    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
    }

    /* Thin brand accent on the right edge */
    .hero::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 3px; height: 100%;
        background: linear-gradient(to bottom, transparent 0%, var(--brand) 30%, var(--brand) 70%, transparent 100%);
    }

    /* Decorative large letter — only faint watermark */
    .hero-bg-letter {
        position: absolute;
        bottom: -60px; right: -20px;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 400px;
        font-weight: 700;
        line-height: 1;
        color: rgba(255,255,255,0.025);
        pointer-events: none;
        user-select: none;
    }

    .hero-top { position: relative; z-index: 1; }

    .hero-logo {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .hero-logo-mark {
        width: 32px; height: 32px;
        background: var(--brand);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .hero-logo-name {
        font-size: 15px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        letter-spacing: 0.02em;
    }

    .hero-mid {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 64px 0;
    }

    .hero-eyebrow-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .hero-eyebrow-wrap::before {
        content: '';
        width: 28px; height: 1px;
        background: var(--brand);
        flex-shrink: 0;
    }

    .hero-eyebrow {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--brand);
    }

    .hero-heading {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(40px, 4.5vw, 60px);
        font-weight: 400;
        line-height: 1.12;
        letter-spacing: -0.02em;
        color: #fff;
        margin-bottom: 24px;
    }

    .hero-heading em {
        font-style: italic;
        color: rgba(255,255,255,0.48);
    }

    .hero-desc {
        font-size: 15px;
        line-height: 1.75;
        color: rgba(255,255,255,0.42);
        max-width: 380px;
    }

    .hero-features {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding-top: 36px;
        border-top: 1px solid rgba(255,255,255,0.07);
    }

    .hero-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: rgba(255,255,255,0.42);
    }

    .hero-feature-dot {
        width: 4px; height: 4px;
        border-radius: 50%;
        background: var(--brand);
        flex-shrink: 0;
    }

    /* Form Panel */
    .form-panel {
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 56px;
        min-height: 100vh;
    }

    .form-inner { width: 100%; max-width: 400px; }

    .form-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 32px;
        font-weight: 400;
        letter-spacing: -0.02em;
        color: var(--ink);
        margin-bottom: 6px;
    }

    .form-subtitle {
        font-size: 14px;
        color: var(--ink-muted);
        margin-bottom: 40px;
    }

    .status-msg {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        margin-bottom: 24px;
        background: var(--success-bg);
        border: 1px solid #bbf7d0;
        border-radius: var(--radius);
        font-size: 13px;
        color: var(--success);
    }

    .field { margin-bottom: 20px; }

    .field-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--ink-sub);
        margin-bottom: 8px;
    }

    .field-input {
        display: block;
        width: 100%;
        padding: 11px 14px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: var(--ink);
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        transition: border-color 140ms ease, box-shadow 140ms ease;
        -webkit-appearance: none;
        appearance: none;
        outline: none;
    }

    .field-input::placeholder { color: var(--ink-faint); }
    .field-input:hover { border-color: var(--border-hover); }

    .field-input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(106,4,4,0.10);
    }

    .field-input.is-error { border-color: var(--error); background: var(--error-bg); }
    .field-input.is-error:focus { box-shadow: 0 0 0 3px rgba(185,28,28,0.10); }

    .field-error {
        margin-top: 6px;
        font-size: 12px;
        color: var(--error);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .field-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 24px;
    }

    .check-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 13px;
        color: var(--ink-muted);
        user-select: none;
    }

    .check-label input[type="checkbox"] {
        width: 15px; height: 15px;
        accent-color: var(--brand);
        cursor: pointer;
    }

    .link-subtle {
        font-size: 13px;
        color: var(--ink-muted);
        text-decoration: none;
        transition: color 140ms;
    }

    .link-subtle:hover { color: var(--brand); }

    .btn-primary {
        display: block;
        width: 100%;
        padding: 13px 20px;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #fff;
        background: var(--brand);
        border: none;
        border-radius: var(--radius);
        cursor: pointer;
        transition: background 140ms ease, transform 120ms ease, box-shadow 140ms ease;
        outline: none;
    }

    .btn-primary:hover {
        background: var(--brand-hover);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(106,4,4,0.28);
    }

    .btn-primary:active { transform: translateY(0); box-shadow: none; }
    .btn-primary:focus-visible { box-shadow: 0 0 0 3px rgba(106,4,4,0.25); }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 28px 0;
        font-size: 12px;
        color: var(--ink-faint);
    }

    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .form-footer {
        text-align: center;
        font-size: 13px;
        color: var(--ink-muted);
    }

    .form-footer a {
        color: var(--brand);
        font-weight: 600;
        text-decoration: none;
        transition: color 140ms;
    }

    .form-footer a:hover { color: var(--brand-dark); }

    .legal {
        margin-top: 32px;
        text-align: center;
        font-size: 11px;
        color: var(--ink-faint);
        line-height: 1.7;
    }

    .legal a {
        color: var(--ink-faint);
        text-decoration: underline;
        text-decoration-color: transparent;
        transition: color 140ms, text-decoration-color 140ms;
    }

    .legal a:hover { color: var(--ink-muted); text-decoration-color: var(--ink-muted); }

    /* Responsive */
    @media (max-width: 1024px) {
        .auth-wrap { grid-template-columns: 1fr; }
        .hero { min-height: 46vh; padding: 40px 36px; }
        .hero-mid { padding: 40px 0; }
        .hero-features { display: none; }
        .form-panel { min-height: auto; padding: 48px 36px; }
    }

    @media (max-width: 640px) {
        .hero { padding: 32px 24px; min-height: 38vh; }
        .form-panel { padding: 40px 20px; }
        .hero-heading { font-size: clamp(34px, 9vw, 48px); }
        .field-row { flex-direction: column; align-items: flex-start; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { transition-duration: 0.01ms !important; animation-duration: 0.01ms !important; }
    }
</style>

<div class="auth-wrap">

    {{-- Hero Panel --}}
    <div class="hero">
        <div class="hero-bg-letter">N</div>

        <div class="hero-top">
            <a href="{{ url('/') }}" class="hero-logo">
                <div class="hero-logo-mark">N</div>
                <span class="hero-logo-name">Neonman</span>
            </a>
        </div>

        <div class="hero-mid">
            <div class="hero-eyebrow-wrap">
                <span class="hero-eyebrow">Member Access</span>
            </div>
            <h1 class="hero-heading">
                Welcome<br>back to<br>
                <em>Neonman.</em>
            </h1>
            <p class="hero-desc">
                Sign in to access your orders, wishlist, and exclusive drops from
                Bangladesh's funniest streetwear brand.
            </p>
        </div>

        <div class="hero-features">
            <div class="hero-feature">
                <div class="hero-feature-dot"></div>
                <span>Exclusive member drops &amp; early access</span>
            </div>
            <div class="hero-feature">
                <div class="hero-feature-dot"></div>
                <span>Order tracking &amp; full purchase history</span>
            </div>
            <div class="hero-feature">
                <div class="hero-feature-dot"></div>
                <span>Wishlist &amp; personalised picks</span>
            </div>
        </div>
    </div>

    {{-- Form Panel --}}
    <div class="form-panel">
        <div class="form-inner">

            <h2 class="form-title">Sign in</h2>
            <p class="form-subtitle">Enter your credentials to continue</p>

            @if (session('status'))
                <div class="status-msg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email" class="field-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="you@example.com" autocomplete="username" required autofocus
                           class="field-input {{ $errors->has('email') ? 'is-error' : '' }}" />
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password" class="field-label">Password</label>
                    <input id="password" type="password" name="password"
                           placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" autocomplete="current-password" required
                           class="field-input {{ $errors->has('password') ? 'is-error' : '' }}" />
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember" id="remember_me" />
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-subtle">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">Sign in</button>
            </form>

            <div class="divider">or</div>

            <div class="form-footer">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </div>

            <p class="legal">
                By continuing, you agree to our
                <a href="#">Terms&nbsp;of&nbsp;Service</a> and <a href="#">Privacy&nbsp;Policy</a>.
            </p>

        </div>
    </div>

</div>
@endsection
