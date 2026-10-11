<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Email;

class StoreVolunteerRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getRedirectUrl(): string
    {
        return route('information.show', 'volunteer');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'lowercase', 'max:254', new Email],
            'phone' => ['required', 'string', 'max:40'],
            'interests' => ['nullable', 'string', 'max:2000'],
            'availability' => ['nullable', 'string', 'max:300'],
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
