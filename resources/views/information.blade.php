<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#321057">
    <meta name="description" content="{{ $page['lead'] }}">
    <title>{{ $page['title'] }} | AkuaBa STEM Girls</title>
    <link rel="icon" href="{{ asset('images/akuaba-logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/akuaba.css') }}?v=68">
</head>
<body class="information-body">
    <a class="skip-link" href="#main-content">Skip to content</a>
    <header class="site-header information-header">
        <a class="brand" href="{{ route('home') }}" aria-label="AkuaBa STEM Girls home"><span class="brand-icon"><img src="{{ asset('images/akuaba-logo.png') }}" alt=""></span><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a>
        @include('partials.site-navigation')
    </header>
    <main id="main-content" class="information-main" tabindex="-1">
        <a class="information-back" href="{{ route('home') }}" data-history-back><span aria-hidden="true">&#8592;</span> Back</a>
        <section class="information-card" aria-labelledby="information-title">
            <p class="eyebrow"><span class="eyebrow-line"></span> {{ $page['eyebrow'] }}</p>
            <h1 id="information-title">{{ $page['title'] }}</h1>
            @if (isset($page['founder_image']))
                <div class="founder-profile">
                    <img src="{{ asset($page['founder_image']) }}" alt="{{ $page['founder_image_alt'] }}">
                    <div>
                        <p class="founder-passion-label">The founder’s passion</p>
                        <p class="information-lead founder-passion-lead">{{ $page['lead'] }}</p>
                        @if (isset($page['founder_credentials']))
                            <div class="founder-credentials">
                                @foreach ($page['founder_credentials'] as $credential)
                                    <p class="information-lead">{{ $credential }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <p class="information-lead">{{ $page['lead'] }}</p>
            @endif
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
                        <a class="information-support-action" href="{{ route('information.show', $action['page']) }}">
                            <h2>{{ $action['title'] }}</h2>
                            <p>{{ $action['description'] }}</p>
                            <span class="information-support-action-label">{{ $action['label'] }} <span aria-hidden="true">&#8599;</span></span>
                        </a>
                    @endforeach
                </div>
            @endif
            @if (isset($page['outreach_contact']))
                <aside class="information-contact"><span>OUTREACH CONTACT</span><strong>{{ $page['outreach_contact']['name'] }}</strong><a href="tel:{{ str_replace(' ', '', $page['outreach_contact']['phone']) }}">{{ $page['outreach_contact']['phone'] }}</a></aside>
            @endif
            @if ($pageSlug === 'sponsor-equipment')
                <section class="volunteer-registration" aria-labelledby="equipment-sponsorship-heading">
                    <h2 id="equipment-sponsorship-heading">Equipment sponsorship inquiry</h2>
                    <p>Select the equipment you would like to sponsor and share your contact details so the AkuaBa team can follow up.</p>
                    @if (session('status'))<p class="volunteer-status" role="status">{{ session('status') }}</p>@endif
                    <form action="{{ route('equipment-sponsorships.store') }}" method="post" class="volunteer-registration-form">
                        @csrf
                        <div class="volunteer-form-fields">
                            <div class="volunteer-form-field">
                                <label for="sponsor-contact-name">Your name</label>
                                <input id="sponsor-contact-name" name="contact_name" value="{{ old('contact_name') }}" autocomplete="name" maxlength="150" required>
                                @error('contact_name')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="sponsor-email">Email address</label>
                                <input id="sponsor-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required>
                                @error('email')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="sponsor-phone">Phone number</label>
                                <input id="sponsor-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" maxlength="40" required>
                                @error('phone')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="sponsor-equipment">Equipment you would like to sponsor</label>
                                <select id="sponsor-equipment" name="equipment" required>
                                    <option value="">Select equipment</option>
                                    @foreach ($page['points'] as $equipment)
                                        <option value="{{ $equipment }}" @selected(old('equipment') === $equipment)>{{ $equipment }}</option>
                                    @endforeach
                                </select>
                                @error('equipment')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field volunteer-form-field-wide">
                                <label for="sponsor-message">Message <span>optional</span></label>
                                <textarea id="sponsor-message" name="message" rows="4" maxlength="2000" placeholder="Add any details about your sponsorship">{{ old('message') }}</textarea>
                                @error('message')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="volunteer-honeypot" aria-hidden="true">
                            <label for="sponsor-website">Leave this field empty</label>
                            <input id="sponsor-website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <label class="volunteer-consent">
                            <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
                            <span>I agree that AkuaBa may use my contact details to follow up about this equipment sponsorship inquiry.</span>
                        </label>
                        @error('consent')<span class="volunteer-error">{{ $message }}</span>@enderror
                        <button class="button button-orange volunteer-submit" type="submit">Send sponsorship inquiry <span aria-hidden="true">&#8594;</span></button>
                    </form>
                </section>
            @endif
            @if ($pageSlug === 'volunteer')
                <section class="volunteer-registration" aria-labelledby="volunteer-registration-heading">
                    <h2 id="volunteer-registration-heading">Volunteer registration</h2>
                    <p>Share your contact details and interests so the AkuaBa team can follow up with you about volunteering.</p>
                    @if (session('status'))<p class="volunteer-status" role="status">{{ session('status') }}</p>@endif
                    <form action="{{ route('volunteer.register') }}" method="post" class="volunteer-registration-form">
                        @csrf
                        <div class="volunteer-form-fields">
                            <div class="volunteer-form-field">
                                <label for="volunteer-name">Full name</label>
                                <input id="volunteer-name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="150" required>
                                @error('name')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="volunteer-email">Email address</label>
                                <input id="volunteer-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required>
                                @error('email')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="volunteer-phone">Phone number</label>
                                <input id="volunteer-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" maxlength="40" required>
                                @error('phone')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="volunteer-availability">Availability <span>optional</span></label>
                                <input id="volunteer-availability" name="availability" value="{{ old('availability') }}" maxlength="300" placeholder="e.g. Weekends or school holidays">
                                @error('availability')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field volunteer-form-field-wide">
                                <label for="volunteer-interests">Skills or areas of interest <span>optional</span></label>
                                <textarea id="volunteer-interests" name="interests" rows="4" maxlength="2000" placeholder="Tell us how you would like to help">{{ old('interests') }}</textarea>
                                @error('interests')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="volunteer-honeypot" aria-hidden="true">
                            <label for="volunteer-website">Leave this field empty</label>
                            <input id="volunteer-website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <label class="volunteer-consent">
                            <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
                            <span>I agree that AkuaBa may use my contact details to follow up with me about volunteering opportunities.</span>
                        </label>
                        @error('consent')<span class="volunteer-error">{{ $message }}</span>@enderror
                        <button class="button button-orange volunteer-submit" type="submit">Register as a volunteer <span aria-hidden="true">&#8594;</span></button>
                    </form>
                </section>
            @endif
            @if ($pageSlug === 'partner')
                <section class="volunteer-registration" aria-labelledby="partnership-inquiry-heading">
                    <h2 id="partnership-inquiry-heading">Partnership inquiry</h2>
                    <p>Tell us about your organization and how you would like to work with AkuaBa. Our team will follow up using the contact details you provide.</p>
                    @if (session('status'))<p class="volunteer-status" role="status">{{ session('status') }}</p>@endif
                    <form action="{{ route('partnership-inquiries.store') }}" method="post" class="volunteer-registration-form">
                        @csrf
                        <div class="volunteer-form-fields">
                            <div class="volunteer-form-field">
                                <label for="partner-organization">Organization or school</label>
                                <input id="partner-organization" name="organization" value="{{ old('organization') }}" maxlength="180" required>
                                @error('organization')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="partner-contact-name">Your name</label>
                                <input id="partner-contact-name" name="contact_name" value="{{ old('contact_name') }}" autocomplete="name" maxlength="150" required>
                                @error('contact_name')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="partner-email">Email address</label>
                                <input id="partner-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required>
                                @error('email')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field">
                                <label for="partner-phone">Phone number</label>
                                <input id="partner-phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" maxlength="40" required>
                                @error('phone')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                            <div class="volunteer-form-field volunteer-form-field-wide">
                                <label for="partner-proposal">How would you like to partner?</label>
                                <textarea id="partner-proposal" name="proposal" rows="4" maxlength="3000" required>{{ old('proposal') }}</textarea>
                                @error('proposal')<span class="volunteer-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="volunteer-honeypot" aria-hidden="true">
                            <label for="partner-website">Leave this field empty</label>
                            <input id="partner-website" name="website" tabindex="-1" autocomplete="off">
                        </div>
                        <label class="volunteer-consent">
                            <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
                            <span>I agree that AkuaBa may use my contact details to respond to this partnership inquiry.</span>
                        </label>
                        @error('consent')<span class="volunteer-error">{{ $message }}</span>@enderror
                        <button class="button button-orange volunteer-submit" type="submit">Send partnership inquiry <span aria-hidden="true">&#8594;</span></button>
                    </form>
                </section>
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
            @if (isset($page['page_action']))
                <a class="button button-orange information-action" href="{{ $page['page_action']['href'] }}">
                    {{ $page['page_action']['label'] }} <span aria-hidden="true">&#8599;</span>
                </a>
            @else
                <a class="button button-orange information-action" href="{{ $pageSlug === 'support' ? 'tel:0207495972' : route('information.show', 'support') }}">
                    {{ $pageSlug === 'support' ? 'Call to confirm details' : 'Support the outreach' }} <span aria-hidden="true">&#8599;</span>
                </a>
            @endif
        </section>
    </main>
    <footer class="site-footer information-footer">
        <div class="footer-identity"><a class="brand footer-brand" href="{{ route('home') }}" aria-label="AkuaBa STEM Girls home"><span class="brand-icon"><img src="{{ asset('images/akuaba-logo.png') }}" alt=""></span><span class="brand-name">AkuaBa<small>STEM Girls</small></span></a><p>Our heritage. Our STEM future.</p></div>
        <span class="copyright">&copy; {{ date('Y') }} AkuaBa STEM Girls</span>
    </footer>
    <script>
        document.querySelector('[data-history-back]').addEventListener('click', (event) => {
            if (document.referrer && new URL(document.referrer, window.location.href).origin === window.location.origin) {
                event.preventDefault();
                window.history.back();
            }
        });
    </script>
</body>
</html>
