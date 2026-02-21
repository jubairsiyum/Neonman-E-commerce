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
        --border:       #e3e3e3;
        --border-hover: #c0c0c0;
        --surface:      #ffffff;
        --error:        #b91c1c;
        --error-bg:     #fef2f2;
        --radius:       6px;
    }

    html, body { height: 100%; }

    .auth-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
        font-family: 'Inter', system-ui, sans-serif;
    }

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

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, rgba(255,255,255,0.055) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
    }

    .hero::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 3px; height: 100%;
        background: linear-gradient(to bottom, transparent 0%, var(--brand) 30%, var(--brand) 70%, transparent 100%);
    }

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

    .hero-perks {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding-top: 36px;
        border-top: 1px solid rgba(255,255,255,0.07);
    }

    .hero-perk {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: rgba(255,255,255,0.42);
    }

    .hero-perk-dot {
        width: 4px; height: 4px;
        border-radius: 50%;
        background: var(--brand);
        flex-shrink: 0;
    }

    .form-panel {
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 56px;
        min-height: 100vh;
        overflow-y: auto;
    }

    .form-inner {
        width: 100%;
        max-width: 400px;
        padding: 16px 0;
    }

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
        margin-bottom: 36px;
    }

    .field { margin-bottom: 18px; }

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

    .terms-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 22px;
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

    .form-footer {
        margin-top: 24px;
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
        margin-top: 28px;
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

    @media (max-width: 1024px) {
        .auth-wrap { grid-template-columns: 1fr; }
        .hero { min-height: 44vh; padding: 40px 36px; }
        .hero-mid { padding: 36px 0; }
        .hero-perks { display: none; }
        .form-panel { min-height: auto; padding: 48px 36px; }
    }

    @media (max-width: 640px) {
        .hero { padding: 32px 24px; min-height: 36vh; }
        .form-panel { padding: 40px 20px; }
        .hero-heading { font-size: clamp(34px, 9vw, 48px); }
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
                <span class="hero-eyebrow">New Member</span>
            </div>
            <h1 class="hero-heading">
                Join the<br>
                <em>Neonman</em><br>
                community.
            </h1>
            <p class="hero-desc">
                Create your account and get access to exclusive drops, member deals,
                and Bangladesh's boldest streetwear.
            </p>
        </div>

        <div class="hero-perks">
            <div class="hero-perk">
                <div class="hero-perk-dot"></div>
                <span>10% off your very first order</span>
            </div>
            <div class="hero-perk">
                <div class="hero-perk-dot"></div>
                <span>Early access to limited drops</span>
            </div>
            <div class="hero-perk">
                <div class="hero-perk-dot"></div>
                <span>Member-only sales &amp; events</span>
            </div>
        </div>
    </div>

    {{-- Form Panel --}}
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
                    <span>
                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                    </span>
                </label>

                <button type="submit" class="btn-primary">Create account</button>
            </form>

            <div class="form-footer">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>

            <p class="legal">
                By registering, you agree to our
                <a href="#">Terms&nbsp;of&nbsp;Service</a> and <a href="#">Privacy&nbsp;Policy</a>.
            </p>

        </div>
    </div>

</div>
@endsection
