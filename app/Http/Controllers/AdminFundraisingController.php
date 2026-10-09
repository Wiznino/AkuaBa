<?php

namespace App\Http\Controllers;

use App\Models\FundraisingProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminFundraisingController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount_raised' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
        ]);

        $progress = FundraisingProgress::query()->find(1) ?? new FundraisingProgress;
        $progress->id = 1;
        $progress->fill([
            'amount_raised' => $data['amount_raised'] ?? null,
            'confirmed_at' => ($data['amount_raised'] ?? null) === null ? null : now(),
        ]);
        $progress->save();

        return redirect()->route('admin.dashboard')->with('status', 'Fundraising progress has been updated.');
    }
}
