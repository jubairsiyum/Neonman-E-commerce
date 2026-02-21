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

.field{margin-bottom:16px;position:relative}
.field-label{
    display:block;
    font-size:12px;font-weight:600;
    letter-spacing:.04em;text-transform:uppercase;
    color:var(--ink-2);
    margin-bottom:8px;
}

/* Input wrapper for icon */
.field-wrapper{
    position:relative;
    display:flex;
    align-items:center;
}

.field-icon{
    position:absolute;
    left:14px;
    color:var(--ink-4);
    pointer-events:none;
    transition:color .2s ease;
    display:flex;
    align-items:center;
}

.field-input{
    display:block;width:100%;
    padding:12px 14px;
    font-family:var(--font);font-size:14px;
    color:var(--ink);background:#fafafa;
    border:2px solid transparent;
    border-radius:var(--r-sm);
    outline:none;-webkit-appearance:none;
    transition:all .25s cubic-bezier(.4,0,.2,1);
    box-shadow:0 1px 2px rgba(0,0,0,0.04);
}

.field-input.has-icon{
    padding-left:44px;
}

.field-input::placeholder{
    color:var(--ink-5);
    transition:color .2s;
}

.field-input:hover{
    background:#f5f5f5;
    box-shadow:0 2px 4px rgba(0,0,0,0.06);
}

.field-input:focus{
    background:#fff;
    border-color:var(--brand);
    box-shadow:0 0 0 4px rgba(106,4,4,0.08), 0 4px 12px rgba(106,4,4,0.12);
    transform:translateY(-1px);
}

.field-input:focus::placeholder{color:var(--ink-4)}

.field:focus-within .field-icon{color:var(--brand)}

.field-input.is-error{
    border-color:var(--error);
    background:#fff5f5;
}
.field-input.is-error:focus{
    box-shadow:0 0 0 4px rgba(192,57,43,0.10), 0 4px 12px rgba(192,57,43,0.12);
}

.field-input:-webkit-autofill,
.field-input:-webkit-autofill:hover,
.field-input:-webkit-autofill:focus{
    -webkit-box-shadow:0 0 0 40px #fafafa inset!important;
    -webkit-text-fill-color:var(--ink)!important;
    transition:background-color 9999s ease 0s;
}

.field-error{
    margin-top:6px;font-size:12px;color:var(--error);
    display:flex;align-items:center;gap:5px;
    font-weight:500;
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
    padding:14px 20px;
    margin-top:24px;
    font-family:var(--font-head);
    font-size:14px;font-weight:700;letter-spacing:-0.01em;
    color:#fff;
    background:linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
    border:none;border-radius:var(--r-sm);
    cursor:pointer;outline:none;
    position:relative;
    overflow:hidden;
    transition:all .25s cubic-bezier(.4,0,.2,1);
    box-shadow:0 4px 12px rgba(0,0,0,0.15), 0 2px 4px rgba(0,0,0,0.1);
}

.btn-submit::before{
    content:'';
    position:absolute;
    top:0;left:0;right:0;bottom:0;
    background:linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
    opacity:0;
    transition:opacity .25s ease;
}

.btn-submit:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,0.25), 0 4px 8px rgba(0,0,0,0.15);
}

.btn-submit:hover::before{opacity:1}

.btn-submit:active{
    transform:translateY(0);
    box-shadow:0 2px 8px rgba(0,0,0,0.2);
}

.btn-submit span,
.btn-submit svg{
    position:relative;
    z-index:1;
}

.btn-submit svg{
    flex-shrink:0;
    opacity:.85;
    transition:transform .3s ease;
}

.btn-submit:hover svg{
    transform:translateX(3px);
}

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
                            <input id="name" type="text" name="name"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Rahim Uddin"
                                   autocomplete="name" required autofocus
                                   class="field-input has-icon {{ $errors->has('name') ? 'is-error' : '' }}" />
                        </div>
                        @error('name')<p class="field-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>@enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="phone">Phone <span style="font-size:10px;font-weight:400;color:#b0b0b0;text-transform:none">(optional)</span></label>
                        <div class="field-wrapper">
                            <span class="field-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            <input id="phone" type="tel" name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="01XXXXXXXXX"
                                   autocomplete="tel"
                                   class="field-input has-icon" />
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
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="you@example.com"
                               autocomplete="username" required
                               class="field-input has-icon {{ $errors->has('email') ? 'is-error' : '' }}" />
                    </div>
                    @error('email')<p class="field-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
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
                        <input id="password" type="password" name="password"
                               placeholder="At least 8 characters"
                               autocomplete="new-password" required
                               class="field-input has-icon {{ $errors->has('password') ? 'is-error' : '' }}" />
                    </div>
                    @error('password')<p class="field-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
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
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               placeholder="Repeat your password"
                               autocomplete="new-password" required
                               class="field-input has-icon {{ $errors->has('password_confirmation') ? 'is-error' : '' }}" />
                    </div>
                    @error('password_confirmation')<p class="field-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>@enderror
                </div>

                <label class="terms-row">
                    <input type="checkbox" name="terms" required />
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>

                <button type="submit" class="btn-submit">
                    <span>Create my account</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>

            <div class="card-switch">
                Already have an account? <a href="{{ route('login') }}">Sign in</a>
            </div>

        </div>

        {{-- <div class="card-footer">
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
        </div> --}}
    </div>

    <p class="auth-note">
        By creating an account you agree to our <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>
    </p>

</div>
@endsection