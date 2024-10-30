<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
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
    public function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tenants,email',
            'phone' => 'required|string|size:10|unique:tenants,phone',
            'accountNumber' => 'nullable|string|max:50|unique:tenants,account_number',
            'leaseStartDate' => 'required|date',
            'unit_id' => 'required|exists:units,id',
        ];
    }
    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstName.required' => 'The first name is required.',
            'lastName.required' => 'The last name is required.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'A tenant with this email already exists.',
            'phone.required' => 'The phone number is required.',
            'phone.size' => 'The phone number must be exactly 10 digits long.',
            'phone.regex' => 'The phone number must start with "07".',
            'leaseStartDate.required' => 'The lease start date is required.',
            'leaseStartDate.date' => 'The lease start date must be a valid date.',
            'unit_id.required' => 'A unit must be selected.',
            'unit_id.exists' => 'The selected unit does not exist.',
        ];
    }
}
