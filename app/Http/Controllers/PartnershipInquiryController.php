<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnershipInquiryRequest;
use App\Models\PartnershipInquiry;
use Illuminate\Http\RedirectResponse;

class PartnershipInquiryController extends Controller
{
    public function store(StorePartnershipInquiryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        PartnershipInquiry::updateOrCreate(
            ['email' => $data['email']],
            [
                'organization' => $data['organization'],
                'contact_name' => $data['contact_name'],
                'phone' => $data['phone'],
                'proposal' => $data['proposal'],
                'consented_at' => now(),
            ],
        );

        return redirect()
            ->route('information.show', 'partner')
            ->with('status', 'Thank you for your partnership inquiry. The AkuaBa team will follow up with you.');
    }

    public function destroy(PartnershipInquiry $partnershipInquiry): RedirectResponse
    {
        $partnershipInquiry->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'The partnership inquiry has been removed.');
    }
}
