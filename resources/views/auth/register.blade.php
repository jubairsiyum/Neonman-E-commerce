@extends('layouts.auth')

@section('title', 'Register - ' . config('app.name'))

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
        --border:       #e8e8e8;
        --border-hover: #c0c0c0;
        --surface:      #ffffff;
        --error:        #b91c1c;
        --error-bg:     #fef2f2;
        --radius:       6px;
    }

    .auth-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        width: 100%;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .hero {
        background: #141414;
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 44px 52px;
        min-height: 80vh;
        overflow: hidden;
        color: #fff;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
    }

    .hero::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 2px; height: 100%;
        background: linear-gradient(to bottom,
            transparent 0%,
            rgba(106,4,4,0.6) 25%,
            var(--brand) 50%,
            rgba(106,4,4,0.6) 75%,
            transparent 100%);
    }

    .hero-watermark {
        position: absolute;
        bottom: -80px; right: -30px;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(240px, 30vw, 380px);
        font-weight: 700;
        line-height: 1;
        color: rgba(255,255,255,0.028);
        pointer-events: none;
        user-select: none;
        letter-spacing: -0.04em;
    }

    .hero-header {
        position: relative;
        z-index: 1;
        margin-bottom: auto;
    }

    .site-wordmark {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .site-wordmark-text {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -0.01em;
        color: #fff;
    }

    .site-wordmark-text span { color: var(--brand); }

    .hero-body {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 48px 0;
    }

    .hero-rule {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .hero-rule-line {
        width: 24px; height: 1px;
        background: var(--brand);
        flex-shrink: 0;
    }

    .hero-eyebrow {
        font-size: 10.5px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--brand);
    }

    .hero-heading {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(36px, 3.8vw, 56px);
        font-weight: 400;
        line-height: 1.1;
        letter-spacing: -0.02em;
        color: #fff;
        margin-bottom: 20px;
    }

    .hero-heading em {
        font-style: italic;
        color: rgba(255,255,255,0.45);
    }

    .hero-desc {
        font-size: 14.5px;
        line-height: 1.8;
        color: rgba(255,255,255,0.40);
        max-width: 340px;
    }

    .hero-footer {
        position: relative;
        z-index: 1;
        padding-top: 28px;
        border-top: 1px solid rgba(255,255,255,0.07);
    }

    .hero-perks {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .hero-perk {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12.5px;
        color: rgba(255,255,255,0.38);
    }

    .hero-perk::before {
        content: '';
        width: 3px; height: 3px;
        border-radius: 50%;
        background: var(--brand);
        flex-shrink: 0;
    }

    /* Form Panel */
    .form-panel {
        background: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 44px 52px;
        min-height: 80vh;
    }

    .form-inner {
        width: 100%;
        max-width: 380px;
        padding: 12px 0;
    }

    .form-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 30px;
        font-weight: 400;
        letter-spacing: -0.02em;
        color: var(--ink);
        margin-bottom: 5px;
    }

    .form-subtitle {
        font-size: 13.5px;
        color: var(--ink-muted);
        margin-bottom: 28px;
    }

    .field { margin-bottom: 15px; }

    .field-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--ink-sub);
        margin-bottom: 7px;
    }

    .field-input {
        display: block;
        width: 100%;
        padding: 10px 13px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: var(--ink);
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        transition: border-color 140ms, box-shadow 140ms;
        -webkit-appearance: none;
        appearance: none;
        outline: none;
    }

    .field-input:-webkit-autofill,
    .field-input:-webkit-autofill:hover,
    .field-input:-webkit-autofill:focus,
    .field-input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 40px #fff inset !important;
        -webkit-text-fill-color: var(--ink) !important;
        transition: background-color 9999s ease-in-out 0s;
    }

    .field-input::placeholder { color: var(--ink-faint); }
    .field-input:hover { border-color: var(--border-hover); }
    .field-input:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 3px rgba(106,4,4,0.09);
    }

    .field-input.is-error { border-color: var(--error); background: var(--error-bg); }
    .field-input.is-error:focus { box-shadow: 0 0 0 3px rgba(185,28,28,0.09); }

    .field-error {
        margin-top: 5px;
        font-size: 12px;
        color: var(--error);
    }

    .terms-row {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .terms-row input[type="checkbox"] {
        width: 15px; height: 15px;
        margin-top: 2px;
        accent-color: var(--brand);
        cursor: pointer;
        flex-shrink: 0;
    }

    .terms-row span {
        font-size: 13px;
        color: var(--ink-muted);
        line-height: 1.55;
    }

    .terms-row a {
        color: var(--brand);
        font-weight: 500;
        text-decoration: none;
        transition: color 140ms;
    }

    .terms-row a:hover { color: var(--brand-dark); }

    .btn-primary {
        display: block;
        width: 100%;
        padding: 12px 20px;
        font-family: 'Inter', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #fff;
        background: var(--ink);
        border: none;
        border-radius: var(--radius);
        cursor: pointer;
        transition: background 140ms, transform 120ms, box-shadow 140ms;
        outline: none;
    }

    .btn-primary:hover {
        background: #1e1e1e;
        transform: translateY(-1px);
        box-shadow: 0 5px 18px rgba(0,0,0,0.18);
    }

    .btn-primary:active { transform: translateY(0); box-shadow: none; }
    .btn-primary:focus-visible { box-shadow: 0 0 0 3px rgba(0,0,0,0.15); }

    .form-footer {
        margin-top: 20px;
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
        margin-top: 24px;
        text-align: center;
        font-size: 11px;
        color: var(--ink-faint);
        line-height: 1.7;
    }

    .legal a {
        color: var(--ink-faint);
        text-decoration: underline;
        text-underline-offset: 2px;
        transition: color 140ms;
    }

    .legal a:hover { color: var(--ink-muted); }

    @media (max-width: 1024px) {
        .auth-wrap {
            grid-template-columns: 1fr;
        }
        .hero { min-height: 44vh; padding: 36px 32px; }
        .hero-footer { display: none; }
        .form-panel { min-height: auto; padding: 48px 32px; }
    }

    @media (max-width: 640px) {
        .hero { padding: 28px 20px; min-height: 38vh; }
        .hero-body { padding: 28px 0; }
        .form-panel { padding: 36px 20px; }
        .form-inner { max-width: 100%; padding: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { transition-duration: 0.01ms !important; }
    }
</style>

<div class="auth-wrap">

    {{-- ── Left: Hero Panel ──────────────────── --}}
    <div class="hero">
        <div class="hero-watermark">N</div>

        <div class="hero-header">
            <a href="{{ url('/') }}" class="site-wordmark">
                <span class="site-wordmark-text">Neo<span>n</span>man</span>
            </a>
        </div>

        <div class="hero-body">
            <div class="hero-rule">
                <div class="hero-rule-line"></div>
                <span class="hero-eyebrow">New Member</span>
            </div>
            <h1 class="hero-heading">
                Join the<br>
                <em>Neonman</em><br>
                community.
            </h1>
            <p class="hero-desc">
                Create your account and get access to exclusive drops, member deals, and Bangladesh's boldest streetwear.
            </p>
        </div>

        <div class="hero-footer">
            <div class="hero-perks">
                <div class="hero-perk">10% off your very first order</div>
                <div class="hero-perk">Early access to limited drops</div>
                <div class="hero-perk">Member-only sales &amp; events</div>
            </div>
        </div>
    </div>

    {{-- ── Right: Form Panel ─────────────────── --}}
    <div class="form-panel">
        <div class="form-inner">

            <h2 class="form-title">Create account</h2>
            <p class="form-subtitle">Fill in the details below to get started</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label for="name" class="field-label">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           placeholder="John Doe" autocomplete="name" required autofocus
                           class="field-input {{ $errors->has('name') ? 'is-error' : '' }}" />
                    @error('name') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="email" class="field-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="you@example.com" autocomplete="username" required
                           class="field-input {{ $errors->has('email') ? 'is-error' : '' }}" />
                    @error('email') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password" class="field-label">Password</label>
                    <input id="password" type="password" name="password"
                           placeholder="Min. 8 characters" autocomplete="new-password" required
                           class="field-input {{ $errors->has('password') ? 'is-error' : '' }}" />
                    @error('password') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation" class="field-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           placeholder="Repeat your password" autocomplete="new-password" required
                           class="field-input {{ $errors->has('password_confirmation') ? 'is-error' : '' }}" />
                    @error('password_confirmation') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <label class="terms-row">
                    <input type="checkbox" name="terms" required />
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>

                <button type="submit" class="btn-primary">Create account</button>
            </form>

            <div class="form-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>

            <p class="legal">
                By registering, you agree to our
                <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </p>

        </div>
    </div>

</div>
@endsection
