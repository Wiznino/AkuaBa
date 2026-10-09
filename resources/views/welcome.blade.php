<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#321057">
    <meta name="description" content="AkuaBa STEM Girls inspires, empowers, and equips girls through STEM education, mentorship, and practical learning experiences.">
    <title>AkuaBa STEM Girls | Our Heritage, Our STEM Future</title>
    <meta property="og:type" content="website">
    <meta property="og:title" content="AkuaBa STEM Girls | Our Heritage, Our STEM Future">
    <meta property="og:description" content="Inspire. Empower. Equip. Join AkuaBa in opening up STEM opportunities for girls.">
    <meta property="og:image" content="{{ asset('images/akuaba-stem-hero.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" href="{{ asset('images/akuaba-mark.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/akuaba.css') }}?v=39">
</head>
<body>
    @php
        $carouselSlides = $slides->map(fn ($slide) => [
                'type' => $slide->media_type,
                'url' => asset($slide->file_path),
                'mime_type' => $slide->mime_type,
                'title' => $slide->title,
                'caption' => $slide->caption,
                'alt' => $slide->caption ?: $slide->title,
                'poster' => false,
            ]);

        if ($carouselSlides->isEmpty() && ! $hasMediaLibrary) {
            $carouselSlides = collect([
                ['type' => 'image', 'url' => asset('images/akuaba-stem-hero.png'), 'mime_type' => null, 'title' => 'Girls building what comes next', 'caption' => 'Imagine it. Build it.', 'alt' => 'Illustration of girls in purple polos collaborating on a robotics project', 'poster' => false],
                ['type' => 'image', 'url' => asset('images/akuaba-mission.jpg'), 'mime_type' => null, 'title' => 'Our mission', 'caption' => 'Inspire. Empower. Equip.', 'alt' => 'AkuaBa STEM Girls mission poster', 'poster' => true],
                ['type' => 'image', 'url' => asset('images/akuaba-vision.jpg'), 'mime_type' => null, 'title' => 'Our vision', 'caption' => 'Our heritage. Our STEM future.', 'alt' => 'AkuaBa STEM Girls vision poster', 'poster' => true],
                ['type' => 'image', 'url' => asset('images/akuaba-fundraiser.jpg'), 'mime_type' => null, 'title' => 'Support the outreach', 'caption' => 'Help equip hands-on STEM outreach.', 'alt' => 'AkuaBa STEM Girls fundraising poster', 'poster' => true],
            ]);
        } elseif ($carouselSlides->isEmpty()) {
            $carouselSlides = collect([
                ['type' => 'image', 'url' => asset('images/akuaba-stem-hero.png'), 'mime_type' => null, 'title' => 'AkuaBa STEM Girls', 'caption' => 'More STEM stories coming soon.', 'alt' => 'Illustration of girls in purple polos collaborating on a robotics project', 'poster' => false],
            ]);
        }

        $carouselSlides = $carouselSlides->concat([
            ['type' => 'image', 'url' => asset('images/work-inspire.png'), 'mime_type' => null, 'title' => 'Inspire through science', 'caption' => 'Explore. Discover. Imagine.', 'alt' => 'Ghanaian girls exploring robotics together in a classroom', 'poster' => false],
            ['type' => 'image', 'url' => asset('images/work-experiment.png'), 'mime_type' => null, 'title' => 'Experiment and create', 'caption' => 'Learn by trying things out.', 'alt' => 'Ghanaian girls conducting a colorful chemistry experiment', 'poster' => false],
            ['type' => 'image', 'url' => asset('images/work-design.png'), 'mime_type' => null, 'title' => 'Design and build', 'caption' => 'Turn ideas into working projects.', 'alt' => 'Ghanaian girls building and coding a small robot', 'poster' => false],
            ['type' => 'image', 'url' => asset('images/akuaba-outreach-classroom.jpg'), 'mime_type' => null, 'title' => 'AkuaBa in the classroom', 'caption' => 'Inspiring girls through outreach.', 'alt' => 'AkuaBa outreach facilitator with students in a classroom', 'poster' => false, 'portrait' => true],
        ]);
    @endphp
    <a class="skip-link" href="#main-content">Skip to content</a>
    <div class="announcement">Our heritage. Our STEM future. <a href="#sponsor">Help equip the next generation <span aria-hidden="true">&#8599;</span></a></div>
    <header class="site-header">
        <a class="brand" href="#top" aria-label="AkuaBa STEM Girls home"><img class="brand-logo" src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a>
        <button class="menu-toggle" aria-label="Open navigation" aria-expanded="false" aria-controls="primary-navigation"><span></span><span></span><span></span></button>
        <nav class="main-nav" id="primary-navigation" aria-label="Main navigation">
            <a href="{{ route('information.show', 'about') }}">About AkuaBa</a><a href="{{ route('information.show', 'founder') }}">Our founder</a><a href="{{ route('information.show', 'mission') }}">Our mission</a><a href="{{ route('information.show', 'programs') }}">What we do</a><a href="{{ route('information.show', 'vision') }}">Our vision</a><a href="{{ route('information.show', 'impact') }}">Our impact</a><a href="{{ route('information.show', 'support') }}">Support us</a><a href="{{ route('admin.login') }}">Admin sign in</a>
        </nav>
        <a class="button button-dark header-cta" href="{{ route('information.show', 'support') }}" target="_blank" rel="noopener noreferrer">Support the outreach <span aria-hidden="true">&#8599;</span></a>
    </header>

    <section class="mission-ticker" aria-label="AkuaBa mission">
        <span class="visually-hidden">AkuaBa’s mission: to inspire, empower, and equip girls through STEM education, mentorship, and practical learning experiences that prepare them to become tomorrow’s leaders, innovators, and changemakers.</span>
        <div class="mission-ticker-track" aria-hidden="true">
            <div class="mission-ticker-group"><span class="mission-ticker-label">OUR MISSION</span><span class="mission-ticker-star">&#10038;</span><span>To inspire, empower, and equip girls through STEM education, mentorship, and practical learning experiences.</span><span class="mission-ticker-star">&#10038;</span><span>Prepare tomorrow’s leaders, innovators, and changemakers.</span><span class="mission-ticker-star">&#10038;</span></div>
            <div class="mission-ticker-group"><span class="mission-ticker-label">OUR MISSION</span><span class="mission-ticker-star">&#10038;</span><span>To inspire, empower, and equip girls through STEM education, mentorship, and practical learning experiences.</span><span class="mission-ticker-star">&#10038;</span><span>Prepare tomorrow’s leaders, innovators, and changemakers.</span><span class="mission-ticker-star">&#10038;</span></div>
        </div>
    </section>

    <main id="main-content" tabindex="-1">
        <section class="hero" id="top">
            <div class="hero-visual carousel" data-carousel aria-label="AkuaBa STEM Girls slideshow">
                <div class="carousel-stage">
                    @foreach ($carouselSlides as $index => $slide)
                        <figure class="carousel-slide {{ $index === 0 ? 'is-active' : '' }} {{ $slide['poster'] ? 'is-poster' : '' }} {{ ($slide['portrait'] ?? false) ? 'is-portrait' : '' }}" role="group" aria-roledescription="slide" aria-label="{{ $index + 1 }} of {{ $carouselSlides->count() }}: {{ $slide['title'] }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                            @if ($slide['type'] === 'video')
                                <video controls playsinline preload="metadata" aria-label="{{ $slide['title'] }}"><source src="{{ $slide['url'] }}" type="{{ $slide['mime_type'] }}">Your browser does not support embedded video.</video>
                            @else
                                <img src="{{ $slide['url'] }}" alt="{{ $slide['alt'] }}" @if ($index > 0) loading="lazy" @endif>
                            @endif
                            @if ($slide['caption'])
                                <figcaption class="slide-caption"><span>{{ $slide['title'] }}</span><strong>{{ $slide['caption'] }}</strong></figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
                @if ($carouselSlides->count() > 1)
                    <div class="carousel-controls" aria-label="Slideshow controls">
                        <button type="button" class="carousel-control" data-carousel-prev aria-label="Previous slide">&#8592;</button>
                        <span class="carousel-count" data-carousel-count aria-live="polite">01 / {{ str_pad((string) $carouselSlides->count(), 2, '0', STR_PAD_LEFT) }}</span>
                        <button type="button" class="carousel-control" data-carousel-pause aria-label="Pause slideshow">&#10074;&#10074;</button>
                        <button type="button" class="carousel-control" data-carousel-next aria-label="Next slide">&#8594;</button>
                    </div>
                @endif
            </div>
        </section>

        <section class="hero-below section-wrap" aria-label="AkuaBa introduction and videos">
            <div class="hero-copy">
                <p class="eyebrow"><span class="eyebrow-line"></span> AkuaBa STEM Girls Outreach</p>
                <h1>Our heritage.<br><em>Our STEM future.</em></h1>
                <p class="hero-text">We inspire, empower, and equip girls through STEM education, mentorship, and hands-on learning, opening doors to a future they can shape.</p>
                <div class="hero-actions"><a class="button button-orange" href="{{ route('information.show', 'support') }}">Support the outreach <span aria-hidden="true">&#8599;</span></a><a class="text-link" href="#mission">Discover our mission <span aria-hidden="true">&#8595;</span></a></div>
                <div class="hero-note"><div class="stem-icons" aria-hidden="true"><span>&#9883;</span><span>&#9881;</span><span>&#128187;</span></div><p><strong>Curiosity can change the world.</strong><br>Help more girls explore what is possible.</p></div>
            </div>
            @if ($videos->isNotEmpty())
            <div class="video-highlights" aria-labelledby="video-highlights-title">
                <div class="video-highlights-heading">
                    <div><p class="eyebrow"><span class="eyebrow-line"></span> STORIES IN MOTION</p><h2 id="video-highlights-title">From our <em>outreach.</em></h2><p>Watch AkuaBa girls explore, experiment, design, and create through STEM.</p></div>
                    <a class="text-link" href="{{ route('videos.index') }}">Open the full video album <span aria-hidden="true">&#8599;</span></a>
                </div>
                <div class="video-gallery video-highlights-gallery">
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
                            <div class="video-card-copy"><h2>{{ $video->title }}</h2>@if ($video->caption)<p>{{ $video->caption }}</p>@endif</div>
                        </article>
                    @endforeach
                </div>
            </div>
            @endif
        </section>

        <section class="about-section section-wrap" id="about">
            <div class="about-story">
                <p class="eyebrow"><span class="eyebrow-line"></span> Our heritage. Our STEM future.</p>
                <h2>About <em>AkuaBa.</em></h2>
                <p>AkuaBa STEM Girls Outreach helps girls explore science, technology, engineering, and mathematics through mentorship and practical learning.</p>
                <p>We believe every girl deserves the confidence, support, and tools to discover what she can do. Our work brings girls together to explore ideas, experiment, design, build, and learn.</p>
                <a class="text-link" href="{{ route('information.show', 'about') }}">Meet AkuaBa <span aria-hidden="true">&#8599;</span></a>
            </div>
            <div class="about-approach">
                <span class="about-index">THE AKUABA APPROACH</span>
                <div><strong>01</strong><span><b>Inspire</b><small>Make room for curiosity and big ideas.</small></span></div>
                <div><strong>02</strong><span><b>Empower</b><small>Build confidence through mentorship and support.</small></span></div>
                <div><strong>03</strong><span><b>Equip</b><small>Develop practical STEM skills by doing.</small></span></div>
            </div>
        </section>

        <section class="impact-summary" id="impact">
            <div class="impact-summary-heading"><p class="eyebrow"><span class="eyebrow-line"></span> Progress with integrity</p><h2>Our impact, <em>carefully counted.</em></h2><p>We’ll share verified outreach figures here once they’ve been confirmed by the team.</p></div>
            <div class="impact-measures"><div><strong>—</strong><span>Girls reached</span></div><div><strong>—</strong><span>Schools visited</span></div><div><strong>—</strong><span>Workshops held</span></div></div>
            <a class="text-link" href="{{ route('information.show', 'impact') }}">About our impact reporting <span aria-hidden="true">&#8599;</span></a>
        </section>

        <section class="intro section-wrap" id="mission">
            <div class="intro-label"><span class="tiny-star" aria-hidden="true">&#10038;</span> Our mission</div>
            <div class="intro-content"><h2>Inspire. Empower.<br><em>Equip.</em></h2><p>AkuaBa STEM Girls inspires, empowers, and equips girls through STEM education, mentorship, and practical learning experiences that prepare them to become tomorrow's leaders, innovators, and changemakers.</p><div class="intro-links"><a href="#programs" class="text-link">Explore our programs <span aria-hidden="true">&#8599;</span></a><a href="{{ asset('images/akuaba-mission.jpg') }}" class="text-link" target="_blank" rel="noopener noreferrer">View the mission poster <span aria-hidden="true">&#8599;</span></a></div></div>
            <div class="intro-doodle" aria-hidden="true">&#9883;</div>
        </section>

        <section class="work-section" id="programs">
            <div class="section-wrap">
                <div class="section-heading"><div><p class="eyebrow"><span class="eyebrow-line"></span> Learning with purpose</p><h2>Curiosity becomes<br><em>capability.</em></h2></div><p class="heading-side">Girls learn by exploring real ideas, trying things out, and building skills alongside mentors who encourage them to aim high.</p></div>
                <div class="work-grid">
                    <article class="work-card work-card-purple"><span class="card-number">01 / INSPIRE</span><div class="card-icon">&#9883;</div><h3>Explore & discover</h3><p>Spark curiosity through science and discovery. Help girls dream big and see their potential in STEM.</p></article>
                    <article class="work-card work-card-orange"><span class="card-number">02 / EMPOWER</span><div class="card-icon">&#9881;</div><h3>Experiment & create</h3><p>Build confidence, resilience, and leadership through practical projects, mentorship, and support.</p></article>
                    <article class="work-card work-card-green"><span class="card-number">03 / EQUIP</span><div class="card-icon">&#9889;</div><h3>Design & build</h3><p>Develop useful skills in engineering, coding, and problem-solving with hands-on learning experiences.</p></article>
                </div>
                <div class="discipline-strip"><span>Science</span><i></i><span>Technology</span><i></i><span>Engineering</span><i></i><span>Mathematics</span></div>
            </div>
        </section>

        <section class="impact-section" id="vision"><div class="impact-image"><a href="{{ asset('images/akuaba-vision.jpg') }}" target="_blank" rel="noopener noreferrer" aria-label="Open the AkuaBa vision poster"><img src="{{ asset('images/akuaba-vision.jpg') }}" alt="AkuaBa STEM Girls vision poster showing girls exploring science, engineering, and technology" loading="lazy"></a></div><div class="impact-copy"><p class="eyebrow"><span class="eyebrow-line"></span> Our vision</p><h2>Every girl deserves<br><em>room to imagine.</em></h2><p>We envision a future where every girl has the confidence, opportunity, and support to explore STEM, pursue her ambitions, and become a leader who transforms her community and the world.</p><div class="vision-note"><span aria-hidden="true">&#10038;</span> Scientists. Engineers. Technologists. Problem-solvers.</div><a class="poster-link" href="{{ asset('images/akuaba-vision.jpg') }}" target="_blank" rel="noopener noreferrer">Open the vision poster <span aria-hidden="true">&#8599;</span></a></div></section>

        <section class="fundraiser-section" id="sponsor"><div class="section-wrap">
            <div class="fundraiser-heading"><div><p class="eyebrow"><span class="eyebrow-line"></span> Help make hands-on STEM possible</p><h2>Equip a classroom.<br><em>Open up a future.</em></h2></div><div class="target-card"><span class="target-label">Outreach sponsorship target</span><strong>GH&#8373; {{ number_format($fundraisingTarget) }}</strong><span class="target-note">Every contribution moves us forward.</span><div class="fundraising-progress">
                @if ($fundraisingProgress?->amount_raised !== null)
                    @php($progressPercent = min(100, ((float) $fundraisingProgress->amount_raised / $fundraisingTarget) * 100))
                    <div class="fundraising-progress-current"><span>Confirmed amount raised</span><strong>GH&#8373; {{ number_format((float) $fundraisingProgress->amount_raised, 2) }}</strong></div>
                    <div class="fundraising-progress-track" role="progressbar" aria-label="Fundraising progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ number_format($progressPercent, 1, '.', '') }}"><span style="width:{{ $progressPercent }}%"></span></div>
                    <small>@if ($fundraisingProgress->confirmed_at) Confirmed {{ $fundraisingProgress->confirmed_at->format('j M Y') }} @else Confirmed update @endif</small>
                @else
                    <p class="fundraising-progress-pending">Verified amount raised coming soon.</p>
                @endif
            </div></div></div>
            <div class="fundraiser-grid">
                <div class="equipment-card"><h3><span aria-hidden="true">&#10003;</span> What the funds will support</h3><ul><li>Projector and screen</li><li>3.0 kW inverter generator</li><li>Rechargeable PA system</li><li>Cables, safety, and transport accessories</li><li>Pull-up banners, facilitator T-shirts, wristbands, and STEM prizes</li></ul><p class="equipment-note">Before purchasing equipment, please contact Patricia Kwakye-Boateng to confirm the recommended specifications.</p></div>
                <div class="donate-card"><div class="donate-card-top"><span class="donate-icon" aria-hidden="true">&#9829;</span><div><h3>Support the outreach</h3><p>Contribute any amount or donate equipment in kind. AkuaBa will begin purchasing and using equipment as funds are received.</p></div></div><div class="payment-details"><p class="eyebrow"><span class="eyebrow-line"></span> Mobile Money</p><div><span>Number</span><a href="tel:0207495972">020 749 5972</a></div><div><span>Name</span><strong>Patricia Kwakye-Boateng</strong></div><div><span>Reference</span><strong>AkuaBa</strong></div></div><a class="button button-dark donate-button" href="tel:0207495972">Call to confirm details <span aria-hidden="true">&#8599;</span></a><small>Please confirm payment instructions with AkuaBa before sending a contribution.</small><a class="flyer-link" href="{{ asset('images/akuaba-fundraiser.jpg') }}" download="AkuaBa-STEM-Girls-fundraiser.jpg">Download official sponsorship flyer <span aria-hidden="true">&#8595;</span></a></div>
            </div>
        </div></section>

        @if ($resources->isNotEmpty())
            <section class="resource-section section-wrap" aria-labelledby="resources-title">
                <div class="resource-heading"><p class="eyebrow"><span class="eyebrow-line"></span> Shared by AkuaBa</p><h2 id="resources-title">Resources for the <em>community.</em></h2></div>
                <div class="resource-grid">
                    @foreach ($resources as $resource)
                        <a class="resource-item" href="{{ asset($resource->file_path) }}" target="_blank" rel="noopener noreferrer">
                            <span class="resource-type">{{ strtoupper(pathinfo($resource->file_path, PATHINFO_EXTENSION)) }} / RESOURCE</span>
                            <strong>{{ $resource->title }}</strong>
                            @if ($resource->caption)<span>{{ $resource->caption }}</span>@endif
                            <span class="resource-open">Open resource &#8599;</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="join-section section-wrap" id="get-involved"><div class="join-flower" aria-hidden="true">&#9883;</div><p class="eyebrow"><span class="eyebrow-line"></span> For girls. For communities. For the future.</p><h2>Let's build a future<br>where every girl can <em>thrive.</em></h2><p>Volunteer, mentor, sponsor equipment, or share the work AkuaBa is doing.</p><a class="button button-orange" href="tel:0207495972">Connect with AkuaBa <span aria-hidden="true">&#8599;</span></a><small>AkuaBa STEM Girls Outreach · <a href="https://www.linkedin.com/search/results/all/?keywords=AkuaBa%20STEM%20Girls%20Outreach" target="_blank" rel="noopener noreferrer">Find us on LinkedIn</a></small></section>
    </main>
    <footer class="site-footer"><div class="footer-identity"><a class="brand footer-brand" href="#top"><img class="brand-logo" src="{{ asset('images/akuaba-mark.svg') }}" alt=""><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a><p>Our heritage. Our STEM future.</p></div><div class="footer-links"><a href="{{ route('information.show', 'about') }}">About AkuaBa</a><a href="{{ route('information.show', 'founder') }}">Our founder</a><a href="{{ route('information.show', 'mission') }}">Our mission</a><a href="{{ route('information.show', 'programs') }}">Programs</a><a href="{{ route('information.show', 'impact') }}">Our impact</a><a href="{{ route('information.show', 'support') }}">Support us</a><a href="tel:0207495972">Call AkuaBa</a><a href="https://www.linkedin.com/search/results/all/?keywords=AkuaBa%20STEM%20Girls%20Outreach" target="_blank" rel="noopener noreferrer">LinkedIn &#8599;</a></div><span class="copyright">&copy; {{ date('Y') }} AkuaBa STEM Girls</span></footer>
    <script>
        const menuButton = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-nav');
        menuButton.addEventListener('click', () => {
            const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', String(!isOpen));
            menuButton.setAttribute('aria-label', isOpen ? 'Open navigation' : 'Close navigation');
            navigation.classList.toggle('is-open', !isOpen);
        });
        navigation.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
            menuButton.setAttribute('aria-expanded', 'false');
            menuButton.setAttribute('aria-label', 'Open navigation');
            navigation.classList.remove('is-open');
        }));
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('aria-label', 'Open navigation');
                navigation.classList.remove('is-open');
                menuButton.focus();
            }
        });

        document.querySelectorAll('[data-carousel]').forEach((carousel) => {
            const slides = Array.from(carousel.querySelectorAll('.carousel-slide'));
            if (slides.length < 2) return;

            const count = carousel.querySelector('[data-carousel-count]');
            const pauseButton = carousel.querySelector('[data-carousel-pause]');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let current = 0;
            let manualPause = reducedMotion;
            let interactionPause = false;
            let paused = manualPause || interactionPause;

            if (reducedMotion) {
                pauseButton.hidden = true;
                pauseButton.setAttribute('aria-label', 'Play slideshow');
                pauseButton.innerHTML = '&#9654;';
            }

            const showSlide = (nextIndex) => {
                slides[current].classList.remove('is-active');
                slides[current].setAttribute('aria-hidden', 'true');
                slides[current].querySelector('video')?.pause();
                current = (nextIndex + slides.length) % slides.length;
                slides[current].classList.add('is-active');
                slides[current].setAttribute('aria-hidden', 'false');
                count.textContent = `${String(current + 1).padStart(2, '0')} / ${String(slides.length).padStart(2, '0')}`;

                const video = slides[current].querySelector('video');
                if (video && !paused) {
                    video.muted = true;
                    video.play().catch(() => {});
                }
            };

            carousel.querySelector('[data-carousel-prev]').addEventListener('click', () => showSlide(current - 1));
            carousel.querySelector('[data-carousel-next]').addEventListener('click', () => showSlide(current + 1));
            pauseButton.addEventListener('click', () => {
                manualPause = !manualPause;
                interactionPause = false;
                paused = manualPause;
                pauseButton.setAttribute('aria-label', manualPause ? 'Play slideshow' : 'Pause slideshow');
                pauseButton.innerHTML = manualPause ? '&#9654;' : '&#10074;&#10074;';
                if (!paused) showSlide(current + 1);
            });
            carousel.addEventListener('mouseenter', () => { interactionPause = true; paused = true; });
            carousel.addEventListener('mouseleave', () => { interactionPause = false; paused = manualPause; });
            carousel.addEventListener('focusin', () => { interactionPause = true; paused = true; });
            carousel.addEventListener('focusout', (event) => {
                if (!carousel.contains(event.relatedTarget)) {
                    interactionPause = false;
                    paused = manualPause;
                }
            });

            if (!reducedMotion) {
                window.setInterval(() => {
                    if (!paused && !document.hidden) showSlide(current + 1);
                }, 2000);
            }
        });
    </script>
</body>
</html>




















