<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeToOutreachRequest;
use App\Mail\OutreachUpdateMail;
use App\Models\OutreachSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class OutreachSubscriptionController extends Controller
{
    public function store(SubscribeToOutreachRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $subscriber = OutreachSubscriber::updateOrCreate(
            ['email' => $data['email']],
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
            ],
        );

        if ($subscriber->wasRecentlyCreated) {
            Mail::to($subscriber->email)->send(new OutreachUpdateMail(
                'Welcome to AkuaBa outreach updates',
                "Hello {$subscriber->first_name},\n\nThank you for signing up to receive occasional AkuaBa STEM Girls outreach updates. We will share news about our activities, upcoming outreach, and ways to get involved.\n\nYou can contact AkuaBa if you would like your details removed from this list.",
            ));

            return redirect()->route('outreach.signup')->with('status', 'Thanks for signing up. A welcome email has been sent to your inbox.');
        }

        return redirect()->route('outreach.signup')->with('status', 'You are already signed up for AkuaBa outreach updates.');
    }
}
