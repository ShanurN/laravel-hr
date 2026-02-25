<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{1,14}$/'], // E.164
            'subject' => 'required|string|max:255',
            'text' => 'required|string',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');
            $phone = $this->input('phone');

            $exists = \App\Models\Ticket::whereHas('customer', function ($query) use ($email, $phone) {
                $query->where('email', $email)->orWhere('phone', $phone);
            })->where('created_at', '>=', now()->subDay())->exists();

            if ($exists) {
                $validator->errors()->add('email', 'You can only submit one ticket per day per email or phone number.');
            }
        });
    }
}
