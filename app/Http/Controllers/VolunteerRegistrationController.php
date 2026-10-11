<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVolunteerRegistrationRequest;
use App\Models\VolunteerRegistration;
use Illuminate\Http\RedirectResponse;

class VolunteerRegistrationController extends Controller
{
    public function store(StoreVolunteerRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        VolunteerRegistration::updateOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'interests' => $data['interests'] ?? null,
                'availability' => $data['availability'] ?? null,
                'consented_at' => now(),
            ],
        );

        return redirect()
            ->route('information.show', 'volunteer')
            ->with('status', 'Thank you for registering your interest in volunteering with AkuaBa.');
    }

    public function destroy(VolunteerRegistration $volunteerRegistration): RedirectResponse
    {
        $volunteerRegistration->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'The volunteer registration has been removed.');
    }
}
