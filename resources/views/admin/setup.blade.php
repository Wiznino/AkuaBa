<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#321057"><title>Create admin · AkuaBa</title><link rel="icon" href="{{ asset('images/akuaba-mark.svg') }}" type="image/svg+xml"><link rel="stylesheet" href="{{ asset('css/admin.css') }}"></head>
<body class="auth-body"><main class="auth-card"><a class="back-link" href="{{ route('home') }}" onclick="if (window.history.length > 1) { window.history.back(); return false; }"><span aria-hidden="true">&#8592;</span> Go back</a><a class="admin-brand" href="{{ route('home') }}"><img src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span>AkuaBa <small>Content Studio</small></span></a><p class="auth-kicker">FIRST-TIME SETUP</p><h1>Create your admin account</h1><p class="auth-intro">Set up your private account to manage AkuaBa's slideshow, videos, and shared files. This setup page closes after the first admin account is created.</p>
    <form method="post" action="{{ route('admin.setup.store') }}" class="auth-form">@csrf
        <label for="name">Your name</label><input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required>@error('name')<span class="field-error">{{ $message }}</span>@enderror
        <label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<span class="field-error">{{ $message }}</span>@enderror
        <label for="password">Password</label><input id="password" name="password" type="password" autocomplete="new-password" minlength="12" required><span class="field-hint">Use at least 12 characters.</span>@error('password')<span class="field-error">{{ $message }}</span>@enderror
        <label for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="12" required>
        <button class="primary-button" type="submit">Create admin account <span aria-hidden="true">&#8594;</span></button>
    </form>
</main></body></html>
