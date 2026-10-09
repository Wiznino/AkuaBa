<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#321057">
    <title>@yield('title', 'AkuaBa Content Studio') · AkuaBa</title>
    <link rel="icon" href="{{ asset('images/akuaba-logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=5">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a class="admin-brand" href="{{ route('admin.dashboard') }}"><span class="admin-brand-icon"><img src="{{ asset('images/akuaba-logo.png') }}" alt=""></span><span>AkuaBa <small>Content Studio</small></span></a>
        <div class="admin-header-actions"><a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">View website <span aria-hidden="true">&#8599;</span></a><span class="admin-user">{{ auth()->user()->name }}</span><form method="post" action="{{ route('admin.logout') }}">@csrf<button type="submit" class="quiet-button">Sign out</button></form></div>
    </header>
    <main class="admin-main">
        @if (session('status'))<div class="notice notice-success" role="status">{{ session('status') }}</div>@endif
        @yield('content')
    </main>
</body>
</html>

