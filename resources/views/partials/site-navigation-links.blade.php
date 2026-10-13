<a href="{{ route('information.show', 'about') }}" @if (request()->route('page') === 'about') aria-current="page" @endif>About AkuaBa</a>
<a href="{{ route('information.show', 'founder') }}" @if (request()->route('page') === 'founder') aria-current="page" @endif>Our founder</a>
<a href="{{ route('information.show', 'mission') }}" @if (request()->route('page') === 'mission') aria-current="page" @endif>Our mission</a>
<a href="{{ route('information.show', 'programs') }}" @if (request()->route('page') === 'programs') aria-current="page" @endif>What we do</a>
<a href="{{ route('information.show', 'vision') }}" @if (request()->route('page') === 'vision') aria-current="page" @endif>Our vision</a>
<a href="{{ route('information.show', 'impact') }}" @if (request()->route('page') === 'impact') aria-current="page" @endif>Our impact</a>
<a href="{{ route('information.show', 'support') }}" @if (request()->route('page') === 'support') aria-current="page" @endif>Donate</a>
<a href="{{ route('outreach.signup') }}" @if (request()->routeIs('outreach.signup')) aria-current="page" @endif>Email updates</a>
<a class="admin-menu-link" href="{{ route('admin.login') }}">Admin sign in</a>
