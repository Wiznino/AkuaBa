<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
</div>
<form class="newsletter-form" method="post" action="{{ route('outreach.subscribe') }}">
    @csrf
    <div class="newsletter-fields">
        <div class="newsletter-field"><label for="newsletter-first-name">First name</label><input id="newsletter-first-name" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" maxlength="100" required>@error('first_name')<span class="newsletter-error">{{ $message }}</span>@enderror</div>
        <div class="newsletter-field"><label for="newsletter-last-name">Last name</label><input id="newsletter-last-name" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" maxlength="100" required>@error('last_name')<span class="newsletter-error">{{ $message }}</span>@enderror</div>
        <div class="newsletter-field newsletter-email-field"><label for="newsletter-email">Email address</label><input id="newsletter-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required>@error('email')<span class="newsletter-error">{{ $message }}</span>@enderror</div>
    </div>
    <div class="newsletter-honeypot" aria-hidden="true"><label for="newsletter-website">Leave this field empty</label><input id="newsletter-website" name="website" tabindex="-1" autocomplete="off"></div>
    <label class="newsletter-consent"><input type="checkbox" name="consent" value="1" @checked(old('consent')) required><span>I agree to receive occasional AkuaBa outreach updates by email. I can contact AkuaBa to ask for my details to be removed.</span></label>
    @error('consent')<span class="newsletter-error">{{ $message }}</span>@enderror
    @if (session('status'))<p class="newsletter-status" role="status">{{ session('status') }}</p>@endif
    <button class="newsletter-submit" type="submit">Sign me up <span aria-hidden="true">&#8594;</span></button>
</form>
