<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrderReadyMadeRequest extends FormRequest
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
        // dd(request()->all());
        return [
            'form_type' => 'required|string',
            
            'school' => 'required_if:form_type,false',
            'top' => [
                Rule::requiredIf(function () {
                    return request('form_type') === "false" && empty(request('bottom'));
                }),
            ],
            'bottom' => [
                Rule::requiredIf(function () {
                    return request('form_type') === "false" && empty(request('top'));
                }),
            ],
            'set' => 'required_if:form_type,false',
            'size' => 'required_if:form_type,false',
            'quantity' => 'required_if:form_type,false',


            'file' => 'required_if:form_type,true',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'file_school' => 'required_if:form_type,true',
            'file_quantity' => 'required_if:form_type,true',
            'file_size' => 'required_if:form_type,true',
            'file_top' => [
                Rule::requiredIf(function () {
                    return request('form_type') === "true" && empty(request('file_bottom'));
                }),
            ],
            'file_bottom' => [
                Rule::requiredIf(function () {
                    return request('form_type') === "true" && empty(request('file_top'));
                }),
            ],
          
            'additional_threads' => 'nullable',
            'additional_zipper' => 'nullable',
            'additional_school_seal' => 'nullable',
            'additional_buttons' => 'nullable',
            'additional_hook_eye' => 'nullable',
            'additional_tela' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'top.required' => 'Top is required when the bottom is empty.',
            'bottom.required' => 'Bottom is required when the top is empty.',
            'set.required_if' => 'Set is required.',
            'size.required_if' => 'Size is required.',
            'school.required_if' => 'School is required.',
            'quantity.required_if' => 'Quantity is required.',

            'file.required_if' => 'File is required.',
            'file_school.required_if' => 'School is required.',
            'file_size.required_if' => 'Size is required.',
            'file_quantity.required_if' => 'Quantity is required.',
            'file_top.required' => 'Top is required when the bottom is empty.',
            'file_bottom.required' => 'Bottom is required when the top is empty.',
        ];
    }
}
