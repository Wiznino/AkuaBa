<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#321057">
    <meta name="description" content="{{ $page['lead'] }}">
    <title>{{ $page['title'] }} | AkuaBa STEM Girls</title>
    <link rel="icon" href="{{ asset('images/akuaba-mark.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/akuaba.css') }}?v=12">
</head>
<body class="information-body">
    <a class="skip-link" href="#main-content">Skip to content</a>
    <header class="site-header information-header">
        <a class="brand" href="{{ route('home') }}" aria-label="AkuaBa STEM Girls home"><img class="brand-logo" src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a>
        <nav class="information-nav" aria-label="Main navigation">
            <a href="{{ route('information.show', 'about') }}">About AkuaBa</a>
            <a href="{{ route('information.show', 'mission') }}">Our mission</a>
            <a href="{{ route('information.show', 'programs') }}">What we do</a>
            <a href="{{ route('information.show', 'vision') }}">Our vision</a>
            <a href="{{ route('information.show', 'impact') }}">Our impact</a>
            <a href="{{ route('information.show', 'support') }}">Support us</a>
            <a href="{{ route('admin.login') }}">Admin sign in</a>
        </nav>
    </header>
    <main id="main-content" class="information-main" tabindex="-1">
        <a class="information-back" href="{{ route('home') }}"><span aria-hidden="true">&#8592;</span> Back to home</a>
        <section class="information-card" aria-labelledby="information-title">
            <p class="eyebrow"><span class="eyebrow-line"></span> {{ $page['eyebrow'] }}</p>
            <h1 id="information-title">{{ $page['title'] }}</h1>
            <p class="information-lead">{{ $page['lead'] }}</p>
            <div class="information-copy">
                @foreach ($page['paragraphs'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
            @if (isset($page['impact_measures']))
                <div class="impact-measures information-impact-measures">
                    @foreach ($page['impact_measures'] as $measure)
                        <div><strong>—</strong><span>{{ $measure }}</span><small>Verified update coming soon</small></div>
                    @endforeach
                </div>
            @endif
            @if (count($page['points']))
                <ul class="information-points" @if ($pageSlug === 'support') id="equipment-list" @endif>
                    @foreach ($page['points'] as $point)
                        <li><span aria-hidden="true">&#10003;</span>{{ $point }}</li>
                    @endforeach
                </ul>
            @endif
            @if (isset($page['support_actions']))
                <div class="information-support-actions" aria-label="Ways to support AkuaBa">
                    @foreach ($page['support_actions'] as $action)
                        <article><h2>{{ $action['title'] }}</h2><p>{{ $action['description'] }}</p><a href="{{ $action['href'] }}">{{ $action['label'] }} <span aria-hidden="true">&#8599;</span></a></article>
                    @endforeach
                </div>
            @endif
            @if (isset($page['outreach_contact']))
                <aside class="information-contact"><span>OUTREACH CONTACT</span><strong>{{ $page['outreach_contact']['name'] }}</strong><a href="tel:{{ str_replace(' ', '', $page['outreach_contact']['phone']) }}">{{ $page['outreach_contact']['phone'] }}</a></aside>
            @endif
            @if (isset($page['mobile_money']))
                <div class="information-payment" id="mobile-money">
                    <h2>Mobile Money details</h2>
                    <p><span>Number</span><a href="tel:{{ str_replace(' ', '', $page['mobile_money']['number']) }}">{{ $page['mobile_money']['number'] }}</a></p>
                    <p><span>Name</span><strong>{{ $page['mobile_money']['name'] }}</strong></p>
                    <p><span>Reference</span><strong>{{ $page['mobile_money']['reference'] }}</strong></p>
                    <small>Please confirm payment instructions with AkuaBa before sending a contribution.</small>
                </div>
            @endif
            <a class="button button-orange information-action" href="{{ $pageSlug === 'support' ? 'tel:0207495972' : route('information.show', 'support') }}">
                {{ $pageSlug === 'support' ? 'Call to confirm details' : 'Support the outreach' }} <span aria-hidden="true">&#8599;</span>
            </a>
        </section>
    </main>
    <footer class="site-footer information-footer">
        <div class="footer-identity"><a class="brand footer-brand" href="{{ route('home') }}"><img class="brand-logo" src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a><p>Our heritage. Our STEM future.</p></div>
        <span class="copyright">&copy; {{ date('Y') }} AkuaBa STEM Girls</span>
    </footer>
</body>
</html>
