<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentSponsorshipRequest;
use App\Models\EquipmentSponsorship;
use Illuminate\Http\RedirectResponse;

class EquipmentSponsorshipController extends Controller
{
    public function store(StoreEquipmentSponsorshipRequest $request): RedirectResponse
    {
        $data = $request->validated();

        EquipmentSponsorship::create([
            'contact_name' => $data['contact_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'equipment' => $data['equipment'],
            'message' => $data['message'] ?? null,
            'consented_at' => now(),
        ]);

        return redirect()
            ->route('information.show', 'sponsor-equipment')
            ->with('status', 'Thank you for your equipment sponsorship interest. The AkuaBa team will follow up with you.');
    }

    public function destroy(EquipmentSponsorship $equipmentSponsorship): RedirectResponse
    {
        $equipmentSponsorship->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('status', 'The equipment sponsorship inquiry has been removed.');
    }
}
