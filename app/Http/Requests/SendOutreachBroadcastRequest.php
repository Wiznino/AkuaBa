<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendOutreachBroadcastRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:150', 'regex:/\A[^\r\n]+\z/u'],
            'body' => ['required', 'string', 'max:10000'],
        ];
    }
}
