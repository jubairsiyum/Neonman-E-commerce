@extends('layouts.auth')

@section('title', 'Create Account - ' . config('app.name'))

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Sora:wght@400;600;700;800&display=swap');

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

:root{
    --brand:#6A0404;
    --brand-hover:#820505;
    --brand-dark:#450303;
    --ink:#111111;
    --ink-2:#3a3a3a;
    --ink-3:#6b6b6b;
    --ink-4:#a0a0a0;
    --ink-5:#d0d0d0;
    --border:#ebebeb;
    --bg-page:#0c0c0c;
    --error:#c0392b;
    --error-bg:#fff5f5;
    --success:#16a34a;
    --r:10px;
    --r-sm:6px;
    --font:'Inter',system-ui,sans-serif;
    --font-head:'Sora',system-ui,sans-serif;
}

html,body{
    min-height:100%;
    font-family:var(--font);
    background:var(--bg-page);
}

.auth-page{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:40px 16px 60px;
    position:relative;
    overflow:hidden;
}

.auth-page::before{
    content:'';
    position:absolute;
    top:-120px;left:50%;
    transform:translateX(-50%);
    width:700px;height:500px;
    background:radial-gradient(ellipse at center,rgba(106,4,4,0.18) 0%,transparent 65%);
    pointer-events:none;
}

.auth-page::after{
    content:'';
    position:absolute;
    inset:0;
    background-image:radial-gradient(circle,rgba(255,255,255,0.04) 1px,transparent 1px);
    background-size:32px 32px;
    pointer-events:none;
}

.auth-card{
    position:relative;
    z-index:1;
    width:100%;
    max-width:480px;
    background:#fff;
    border-radius:var(--r);
    box-shadow:0 0 0 1px rgba(255,255,255,0.04),
               0 8px 24px rgba(0,0,0,0.45),
               0 32px 80px rgba(0,0,0,0.35);
    overflow:hidden;
    animation:cardIn .4s cubic-bezier(.22,.68,0,1.2) both;
}

@keyframes cardIn{
    from{opacity:0;transform:translateY(20px) scale(.98)}
    to{opacity:1;transform:translateY(0) scale(1)}
}

.card-stripe{
    height:3px;
    background:linear-gradient(90deg,var(--brand-dark),var(--brand),#c0392b,var(--brand));
    background-size:200% 100%;
    animation:stripeShift 4s linear infinite;
}

@keyframes stripeShift{
    0%{background-position:0 0}
    100%{background-position:200% 0}
}

.card-body{padding:36px 40px 32px}

/* Brand */
.card-brand a{
    display:inline-flex;align-items:center;gap:11px;
    text-decoration:none;
    margin-bottom:28px;
}
.brand-icon{
    width:38px;height:38px;
    background:var(--ink);
    border-radius:8px;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.brand-icon svg{fill:#fff}
.brand-name{
    font-family:var(--font-head);
    font-size:18px;font-weight:700;
    color:var(--ink);letter-spacing:-0.02em;
}
.brand-name span{color:var(--brand)}

/* Heading */
.card-title{
    font-family:var(--font-head);
    font-size:26px;font-weight:700;
    color:var(--ink);
    letter-spacing:-0.03em;
    line-height:1.15;
    margin-bottom:6px;
}
.card-sub{
    font-size:13.5px;color:var(--ink-3);
    line-height:1.5;
    margin-bottom:28px;
}

/* Perks banner */
.reg-perks{
    display:flex;
    gap:6px;
    flex-wrap:wrap;
    margin-bottom:28px;
}
.reg-perk{
    display:inline-flex;align-items:center;gap:5px;
    padding:5px 10px;
    background:#f9f9f9;
    border:1px solid var(--border);
    border-radius:40px;
    font-size:11.5px;
    color:var(--ink-3);
    font-weight:500;
    white-space:nowrap;
}
.reg-perk svg{color:var(--brand)}

/* Name row */
.field-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

.field{margin-bottom:14px}
.field-label{
    display:block;
    font-size:12px;font-weight:600;
    letter-spacing:.04em;text-transform:uppercase;
    color:var(--ink-2);
    margin-bottom:7px;
}

.field-input{
    display:block;width:100%;
    padding:11px 14px;
    font-family:var(--font);font-size:14px;
    color:var(--ink);background:#fff;
    border:1.5px solid var(--border);
    border-radius:var(--r-sm);
    outline:none;-webkit-appearance:none;
    transition:border-color .15s,box-shadow .15s;
}
.field-input::placeholder{color:var(--ink-5)}
.field-input:hover{border-color:#c8c8c8}
.field-input:focus{
    border-color:var(--brand);
    box-shadow:0 0 0 3px rgba(106,4,4,0.10);
}
.field-input.is-error{border-color:var(--error);background:var(--error-bg)}
.field-input.is-error:focus{box-shadow:0 0 0 3px rgba(192,57,43,0.10)}

.field-input:-webkit-autofill,
.field-input:-webkit-autofill:hover,
.field-input:-webkit-autofill:focus{
    -webkit-box-shadow:0 0 0 40px #fff inset!important;
    -webkit-text-fill-color:var(--ink)!important;
    transition:background-color 9999s ease 0s;
}

.field-error{
    margin-top:5px;font-size:12px;color:var(--error);
    display:flex;align-items:center;gap:5px;
}

/* Password hint */
.pw-hint{
    margin-top:4px;
    font-size:11.5px;color:var(--ink-4);
}

/* Terms */
.terms-row{
    display:flex;align-items:flex-start;gap:9px;
    margin-bottom:20px;cursor:pointer;
}
.terms-row input[type="checkbox"]{
    width:15px;height:15px;
    margin-top:2px;
    accent-color:var(--brand);
    cursor:pointer;flex-shrink:0;
}
.terms-row span{
    font-size:13px;color:var(--ink-3);line-height:1.55;
}
.terms-row a{
    color:var(--brand);font-weight:500;
    text-decoration:none;transition:color .15s;
}
.terms-row a:hover{color:var(--brand-dark)}

/* Submit */
.btn-submit{
    display:flex;align-items:center;justify-content:center;gap:8px;
    width:100%;
    padding:13px 20px;
    font-family:var(--font-head);
    font-size:14px;font-weight:700;letter-spacing:-0.01em;
    color:#fff;background:var(--ink);
    border:none;border-radius:var(--r-sm);
    cursor:pointer;outline:none;
    transition:background .15s,transform .12s,box-shadow .15s;
}
.btn-submit:hover{
    background:#222;
    transform:translateY(-1px);
    box-shadow:0 6px 20px rgba(0,0,0,0.25);
}
.btn-submit:active{transform:translateY(0);box-shadow:none}
.btn-submit svg{flex-shrink:0;opacity:.7}

.card-switch{
    margin-top:18px;
    text-align:center;font-size:13.5px;color:var(--ink-3);
}
.card-switch a{
    color:var(--brand);font-weight:600;
    text-decoration:none;transition:color .15s;
}
.card-switch a:hover{color:var(--brand-dark)}

/* Footer */
.card-footer{
    padding:14px 40px;
    border-top:1px solid #f4f4f4;
    background:#fafafa;
    display:flex;align-items:center;justify-content:center;
    gap:20px;flex-wrap:wrap;
}
.trust-item{
    display:flex;align-items:center;gap:6px;
    font-size:11px;color:var(--ink-4);
    font-weight:500;letter-spacing:.02em;white-space:nowrap;
}
.trust-item svg{color:var(--ink-5)}

.auth-note{
    position:relative;z-index:1;
    margin-top:18px;
    text-align:center;
    font-size:11.5px;color:rgba(255,255,255,0.3);
    line-height:1.6;
}
.auth-note a{
    color:rgba(255,255,255,0.45);
    text-decoration:underline;text-underline-offset:2px;
    transition:color .15s;
}
.auth-note a:hover{color:rgba(255,255,255,0.7)}

@media(max-width:520px){
    .card-body{padding:28px 24px 24px}
    .card-footer{padding:12px 24px;gap:14px}
    .card-title{font-size:22px}
    .field-row{grid-template-columns:1fr}
    .reg-perk:last-child{display:none}
}
@media(prefers-reduced-motion:reduce){
    *,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important}
}
</style>

<div class="auth-page">

    <div class="auth-card">
        <div class="card-stripe"></div>

        <div class="card-body">

            {{-- Brand --}}
            <div class="card-brand">
                <a href="{{ url('/') }}">
                    <div class="brand-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24"><path d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v7h-7V3zm0 11h7v7h-7v-7z"/></svg>
                    </div>
                    <span class="brand-name">Neo<span>n</span>man</span>
                </a>
            </div>

            <h1 class="card-title">Create your account</h1>
            <p class="card-sub">Join thousands of shoppers across Bangladesh</p>

            {{-- Perks --}}
            <div class="reg-perks">
                <div class="reg-perk">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    10% off first order
                </div>
                <div class="reg-perk">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Early drop access
                </div>
                <div class="reg-perk">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Free returns
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field-row">
                    <div class="field">
                        <label class="field-label" for="name">Full Name</label>
                        <input id="name" type="text" name="name"
                               value="{{ old('name') }}"
                               placeholder="e.g. Rahim Uddin"
                               autocomplete="name" required autofocus
                               class="field-input {{ $errors->has('name') ? 'is-error' : '' }}" />
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="phone">Phone <span style="font-size:10px;font-weight:400;color:#b0b0b0;text-transform:none">(optional)</span></label>
                        <input id="phone" type="tel" name="phone"
                               value="{{ old('phone') }}"
                               placeholder="01XXXXXXXXX"
                               autocomplete="tel"
                               class="field-input" />
                    </div>
                </div>

                <div class="field">
                    <label class="field-label" for="email">Email Address</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="you@example.com"
                           autocomplete="username" required
                           class="field-input {{ $errors->has('email') ? 'is-error' : '' }}" />
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <input id="password" type="password" name="password"
                           placeholder="At least 8 characters"
                           autocomplete="new-password" required
                           class="field-input {{ $errors->has('password') ? 'is-error' : '' }}" />
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           placeholder="Repeat your password"
                           autocomplete="new-password" required
                           class="field-input {{ $errors->has('password_confirmation') ? 'is-error' : '' }}" />
                    @error('password_confirmation')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                <label class="terms-row">
                    <input type="checkbox" name="terms" required />
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>

                <button type="submit" class="btn-submit">
                    Create my account
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>

            <div class="card-switch">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>

        </div>

        <div class="card-footer">
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                SSL Secured
            </div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 01-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 011-.98l7-3 7 3a1 1 0 011 .98v7z"/></svg>
                Trusted by 10,000+
            </div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Cash on Delivery
            </div>
        </div>
    </div>

    <p class="auth-note">
        By creating an account you agree to our <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>
    </p>

</div>
@endsection