@extends('layouts.guest')

@section('title', 'Login — MR BONGKENG')

@section('styles')
<style>
    /* ── Login Card ── */
    .card {
        background: var(--dark);
        border: 1px solid var(--border);
        border-radius: 50px;
        padding: 48px 40px 40px;
        box-shadow:
            0 0 0 1px rgba(255,255,255,0.04) inset,
            0 40px 80px rgba(0,0,0,0.6),
            0 8px 24px rgba(0,0,0,0.4);
        animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0);    }
    }

    /* ── Brand ── */
    .brand {
        text-align: center;
        margin-bottom: 36px;
    }

    .brand-icon {
        width: 52px;
        height: 52px;
        background: var(--white);
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(255,255,255,0.15);
    }

    .brand-icon svg {
        width: 26px;
        height: 26px;
        color: var(--black);
    }

    .brand h1 {
        font-size: 20px;
        font-weight: 700;
        color: var(--white);
        letter-spacing: -0.3px;
        line-height: 1.2;
    }

    .brand p {
        margin-top: 6px;
        font-size: 13.5px;
        color: var(--subtle);
        font-weight: 400;
    }

    /* ── Flash messages ── */
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13.5px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.25);
        color: #fca5a5;
    }

    .alert-success {
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        color: var(--light);
    }

    /* ── Form ── */
    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--light);
        margin-bottom: 8px;
        letter-spacing: 0.01em;
    }

    .input-wrap {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        width: 16px;
        height: 16px;
        transition: color var(--transition);
        pointer-events: none;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 13px 14px 13px 42px;
        background: var(--mid);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--white);
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
    }

    input[type="email"]::placeholder,
    input[type="password"]::placeholder {
        color: var(--muted);
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: rgba(255,255,255,0.4);
        background: #222222;
        box-shadow: 0 0 0 3px rgba(255,255,255,0.06);
    }

    .input-wrap:focus-within .input-icon {
        color: var(--light);
    }

    /* ── Toggle Password ── */
    .toggle-pw {
        position: absolute;
        right: 13px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--muted);
        padding: 4px;
        line-height: 0;
        transition: color var(--transition);
    }

    .toggle-pw:hover { color: var(--light); }

    /* ── Options row ── */
    .options-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        margin-top: 2px;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        user-select: none;
    }

    .remember input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--white);
        cursor: pointer;
    }

    .remember span {
        font-size: 13px;
        color: var(--subtle);
    }

    /* ── Submit Button ── */
    .btn-login {
        width: 100%;
        padding: 14px;
        background: var(--white);
        color: var(--black);
        border: none;
        border-radius: var(--radius);
        font-size: 14.5px;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        letter-spacing: 0.01em;
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        box-shadow: 0 4px 16px rgba(255,255,255,0.15);
    }

    .btn-login:hover {
        background: #e8e8e8;
        transform: translateY(-1px);
        box-shadow: 0 8px 24px rgba(255,255,255,0.2);
    }

    .btn-login:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(255,255,255,0.1);
    }

    /* ── Footer ── */
    .card-footer {
        margin-top: 28px;
        text-align: center;
        font-size: 12px;
        color: var(--muted);
    }
</style>
@endsection

@section('content')
<div class="card">
    {{-- Brand --}}
    <div class="brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
        <h1>MR BONGKENG</h1>
        <p>Manage System — Sign in to continue</p>
    </div>

    {{-- Flash Messages --}}
    @if ($errors->any())
        <div class="alert alert-error">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Login Form --}}
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email">Email address</label>
            <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input
                    id="email"
                    type="email"
                    name="email"
                    placeholder="you@example.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    autofocus
                >
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrap">
                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password visibility">
                    <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
        </div>

        <div class="options-row">
            <label class="remember">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="btn-login" id="loginBtn">Sign In</button>
    </form>

    <div class="card-footer">
        &copy; {{ date('Y') }} MR BONGKENG Manage System
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    const togglePw = document.getElementById('togglePw');
    const pwInput  = document.getElementById('password');
    const eyeIcon  = document.getElementById('eyeIcon');

    const eyeOpen   = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    const eyeClosed = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;

    togglePw.addEventListener('click', () => {
        const isHidden = pwInput.type === 'password';
        pwInput.type = isHidden ? 'text' : 'password';
        eyeIcon.innerHTML = isHidden ? eyeClosed : eyeOpen;
    });

    // Button loading state on submit
    const form     = document.querySelector('form');
    const loginBtn = document.getElementById('loginBtn');

    form.addEventListener('submit', () => {
        loginBtn.textContent = 'Signing in…';
        loginBtn.disabled = true;
        loginBtn.style.opacity = '0.7';
    });
</script>
@endsection