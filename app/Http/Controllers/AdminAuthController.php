<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MediaItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function setup(): View|RedirectResponse
    {
        if (User::where('is_admin', true)->exists()) {
            return redirect()->route('admin.login');
        }

        return view('admin.setup');
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        if (User::where('is_admin', true)->exists()) {
            return redirect()->route('admin.login');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        $admin = User::create([
            'name' => $data['name'],
            'email' => Str::lower($data['email']),
            'password' => $data['password'],
        ]);
        $admin->forceFill(['is_admin' => true])->save();

        foreach ([
            ['title' => 'Girls building what comes next', 'path' => 'images/akuaba-stem-hero.png', 'mime' => 'image/png', 'caption' => 'Imagine it. Build it.', 'order' => 0],
            ['title' => 'AkuaBa mission poster', 'path' => 'images/akuaba-mission.jpg', 'mime' => 'image/jpeg', 'caption' => 'Inspire. Empower. Equip.', 'order' => 10],
            ['title' => 'AkuaBa vision poster', 'path' => 'images/akuaba-vision.jpg', 'mime' => 'image/jpeg', 'caption' => 'Our heritage. Our STEM future.', 'order' => 20],
            ['title' => 'AkuaBa outreach fundraiser', 'path' => 'images/akuaba-fundraiser.jpg', 'mime' => 'image/jpeg', 'caption' => 'Help equip hands-on STEM outreach.', 'order' => 30],
        ] as $starterSlide) {
            MediaItem::create([
                'created_by' => $admin->id,
                'title' => $starterSlide['title'],
                'file_path' => $starterSlide['path'],
                'mime_type' => $starterSlide['mime'],
                'media_type' => 'image',
                'caption' => $starterSlide['caption'],
                'is_published' => true,
                'sort_order' => $starterSlide['order'],
            ]);
        }

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('status', 'Your admin account is ready.');
    }

    public function login(Request $request): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login', [
            'setupAvailable' => ! User::where('is_admin', true)->exists(),
        ]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = Str::transliterate(Str::lower($credentials['email']).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many sign-in attempts. Please try again in '.RateLimiter::availableIn($key).' seconds.',
            ]);
        }

        if (! Auth::attempt([
            'email' => Str::lower($credentials['email']),
            'password' => $credentials['password'],
            'is_admin' => true,
        ])) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'Those sign-in details did not match an AkuaBa admin account.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'You have been signed out.');
    }
}
