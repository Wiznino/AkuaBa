<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOutreachBroadcastRequest;
use App\Mail\OutreachUpdateMail;
use App\Models\OutreachSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class AdminOutreachBroadcastController extends Controller
{
    public function store(SendOutreachBroadcastRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $recipientCount = OutreachSubscriber::query()->count();

        if ($recipientCount === 0) {
            return back()->withErrors([
                'recipients' => 'There are no opted-in subscribers to email yet.',
            ])->withInput();
        }

        foreach (OutreachSubscriber::query()->orderBy('id')->cursor() as $subscriber) {
            Mail::to($subscriber->email)->queue(new OutreachUpdateMail(
                $data['subject'],
                $data['body'],
            ));
        }

        return redirect()->route('admin.dashboard')->with(
            'status',
            "Your update has been queued for {$recipientCount} opted-in subscribers.",
        );
    }
}
