<?php

namespace App\Http\Requests;

use App\Models\EquipmentSponsorship;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Email;

class StoreEquipmentSponsorshipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function getRedirectUrl(): string
    {
        return route('information.show', 'sponsor-equipment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'lowercase', 'max:254', new Email],
            'phone' => ['required', 'string', 'max:40'],
            'equipment' => ['required', 'string', Rule::in(EquipmentSponsorship::EQUIPMENT_OPTIONS)],
            'message' => ['nullable', 'string', 'max:2000'],
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
