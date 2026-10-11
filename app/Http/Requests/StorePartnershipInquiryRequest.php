<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Email;

class StorePartnershipInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getRedirectUrl(): string
    {
        return route('information.show', 'partner');
    }

    public function rules(): array
    {
        return [
            'organization' => ['required', 'string', 'max:180'],
            'contact_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'lowercase', 'max:254', new Email],
            'phone' => ['required', 'string', 'max:40'],
            'proposal' => ['required', 'string', 'max:3000'],
            'consent' => ['accepted'],
            'website' => ['prohibited'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => mb_strtolower(trim((string) $this->input('email'))),
        ]);
    }
}
