<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#321057">
    <meta name="description" content="Sign up to receive occasional email updates about AkuaBa STEM Girls outreach.">
    <title>Sign up for updates · AkuaBa STEM Girls</title>
    <link rel="icon" href="{{ asset('images/akuaba-logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/akuaba.css') }}?v=56">
</head>
<body class="signup-page">
    <header class="site-header signup-page-header">
        <a class="brand" href="{{ route('home') }}" aria-label="AkuaBa STEM Girls home"><span class="brand-icon"><img src="{{ asset('images/akuaba-logo.png') }}" alt=""></span><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a>
        <button class="menu-toggle" aria-label="Open navigation" aria-expanded="false" aria-controls="signup-navigation signup-desktop-navigation"><span></span><span></span><span></span></button>
        <nav class="main-nav" id="signup-navigation" aria-label="Main navigation">
            <a href="{{ route('information.show', 'about') }}">About AkuaBa</a><a href="{{ route('information.show', 'founder') }}">Our founder</a><a href="{{ route('information.show', 'mission') }}">Our mission</a><a href="{{ route('information.show', 'programs') }}">What we do</a><a href="{{ route('information.show', 'vision') }}">Our vision</a><a href="{{ route('information.show', 'impact') }}">Our impact</a><a href="{{ route('information.show', 'support') }}">Donate</a><a href="{{ route('outreach.signup') }}">Sign up</a><a class="admin-menu-link" href="{{ route('admin.login') }}">Admin sign in</a>
        </nav>
        <nav class="desktop-menu-panel main-nav" id="signup-desktop-navigation" aria-label="Expanded navigation" hidden>
            <a href="{{ route('information.show', 'about') }}">About AkuaBa</a><a href="{{ route('information.show', 'founder') }}">Our founder</a><a href="{{ route('information.show', 'mission') }}">Our mission</a><a href="{{ route('information.show', 'programs') }}">What we do</a><a href="{{ route('information.show', 'vision') }}">Our vision</a><a href="{{ route('information.show', 'impact') }}">Our impact</a><a href="{{ route('information.show', 'support') }}">Donate</a><a href="{{ route('outreach.signup') }}">Sign up</a><a class="admin-menu-link" href="{{ route('admin.login') }}">Admin sign in</a>
        </nav>
        <a class="signup-home-link" href="{{ route('home') }}"><span aria-hidden="true">&#8592;</span> Back to AkuaBa</a>
    </header>
    <main class="signup-page-main">
        <p class="signup-page-kicker">Stay connected with AkuaBa</p>
        <section class="newsletter-section signup-page-newsletter" id="newsletter" aria-labelledby="newsletter-title">
            <div class="newsletter-copy">
                <p class="eyebrow"><span class="eyebrow-line"></span> AkuaBa email updates</p>
                <h1 id="newsletter-title">Stay close to the <em>outreach.</em></h1>
                <p>Sign up for occasional news about AkuaBa’s STEM activities, upcoming outreach, and ways to get involved.</p>
            </div>
            @include('partials.outreach-signup-form')
        </section>
    </main>
    <footer class="signup-page-footer"><a href="{{ route('home') }}">AkuaBa STEM Girls</a><span>Our heritage. Our STEM future.</span></footer>
    <script>
        const menuButton = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('#signup-navigation');
        const desktopMenu = document.querySelector('#signup-desktop-navigation');

        menuButton.addEventListener('click', () => {
            const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', String(!isOpen));
            menuButton.setAttribute('aria-label', isOpen ? 'Open navigation' : 'Close navigation');

            if (window.matchMedia('(min-width: 1151px)').matches) {
                desktopMenu.hidden = isOpen;
                desktopMenu.classList.toggle('is-open', !isOpen);
            } else {
                navigation.classList.toggle('is-open', !isOpen);
            }
        });

        [...navigation.querySelectorAll('a'), ...desktopMenu.querySelectorAll('a')].forEach((link) => link.addEventListener('click', () => {
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Open navigation');
            navigation.classList.remove('is-open');
            desktopMenu.classList.remove('is-open');
            desktopMenu.hidden = true;
        }));

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('aria-label', 'Open navigation');
                navigation.classList.remove('is-open');
                desktopMenu.classList.remove('is-open');
                desktopMenu.hidden = true;
                menuButton.focus();
            }
        });
    </script>
</body>
</html>
