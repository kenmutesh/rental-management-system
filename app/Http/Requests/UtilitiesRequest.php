<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UtilitiesRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|boolean',
            'fee_type' => 'required|in:one_time,renewable,monthly',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The utility name is required.',
            'price.required' => 'The utility price is required.',
            'price.numeric' => 'The utility price must be a number.',
            'status.boolean' => 'The requires reading field must be true or false.',
            'requires_reading.boolean' => 'The requires reading field must be true or false.',
            'fee_type.required' => 'The fee type is required.',
            'fee_type.in' => 'The fee type must be one of the following: one_time, renewable, monthly.',
        ];
    }
}
