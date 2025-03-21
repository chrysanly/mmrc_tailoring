<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_number' => 'required|numeric|digits:11',
            'referrence_number' => 'required|numeric',
            'type' => 'required|string',
            'account_name' => 'required|string|min:4',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ];
    }
}
