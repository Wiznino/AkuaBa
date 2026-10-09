<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#321057">
    <meta name="description" content="Watch AkuaBa STEM Girls outreach videos and stories.">
    <title>Video Album | AkuaBa STEM Girls</title>
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
            <a href="{{ route('information.show', 'impact') }}">Our impact</a>
            <a href="{{ route('information.show', 'support') }}">Support us</a>
            <a href="{{ route('admin.login') }}">Admin sign in</a>
        </nav>
    </header>
    <main id="main-content" class="video-page-main" tabindex="-1">
        <a class="information-back" href="{{ route('home') }}"><span aria-hidden="true">&#8592;</span> Back to home</a>
        <div class="video-page-heading">
            <p class="eyebrow"><span class="eyebrow-line"></span> STORIES IN MOTION</p>
            <h1>AkuaBa <em>Video Album</em></h1>
            <p>Watch girls explore, experiment, design, and create through STEM.</p>
        </div>
        @if ($videos->isNotEmpty())
            <div class="video-gallery">
                @foreach ($videos as $video)
                    <article class="video-card">
                        @if ($video->youtube_video_id)
                            <iframe src="https://www.youtube-nocookie.com/embed/{{ $video->youtube_video_id }}" title="{{ $video->title }}" loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        @else
                            <video controls playsinline preload="metadata" aria-label="{{ $video->title }}">
                                <source src="{{ asset($video->file_path) }}" @if ($video->mime_type) type="{{ $video->mime_type }}" @endif>
                                Your browser does not support embedded video.
                            </video>
                        @endif
                        <div class="video-card-copy">
                            <h2>{{ $video->title }}</h2>
                            @if ($video->caption)<p>{{ $video->caption }}</p>@endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <section class="video-empty">
                <span aria-hidden="true">&#9654;</span>
                <h2>Videos are coming soon</h2>
                <p>AkuaBa’s published videos will appear here. Check back for stories from our STEM outreach.</p>
            </section>
        @endif
    </main>
    <footer class="site-footer information-footer">
        <div class="footer-identity"><a class="brand footer-brand" href="{{ route('home') }}"><img class="brand-logo" src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a><p>Our heritage. Our STEM future.</p></div>
        <span class="copyright">&copy; {{ date('Y') }} AkuaBa STEM Girls</span>
    </footer>
</body>
</html>
