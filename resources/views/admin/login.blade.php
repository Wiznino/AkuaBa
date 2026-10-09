<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#321057"><title>Admin sign in · AkuaBa</title><link rel="icon" href="{{ asset('images/akuaba-mark.svg') }}" type="image/svg+xml"><link rel="stylesheet" href="{{ asset('css/admin.css') }}"></head>
<body class="auth-body"><main class="auth-card"><a class="back-link" href="{{ route('home') }}" onclick="if (window.history.length > 1) { window.history.back(); return false; }"><span aria-hidden="true">&#8592;</span> Go back</a><a class="admin-brand" href="{{ route('home') }}"><img src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span>AkuaBa <small>Content Studio</small></span></a><p class="auth-kicker">PRIVATE ADMIN AREA</p><h1>Welcome back.</h1><p class="auth-intro">Sign in to manage the AkuaBa STEM Girls website.</p>
    @if (session('status'))<div class="notice notice-success" role="status">{{ session('status') }}</div>@endif
    <form method="post" action="{{ route('admin.authenticate') }}" class="auth-form">@csrf
        <label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required>@error('email')<span class="field-error">{{ $message }}</span>@enderror
        <label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required>@error('password')<span class="field-error">{{ $message }}</span>@enderror
        <button class="primary-button" type="submit">Sign in <span aria-hidden="true">&#8594;</span></button>
    </form>
    @if ($setupAvailable)<p class="setup-hint">First time here? <a href="{{ route('admin.setup') }}">Create the first admin account</a>.</p>@endif
</main></body></html>
