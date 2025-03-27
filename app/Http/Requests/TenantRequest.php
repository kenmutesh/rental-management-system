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
            'email' => 'required|email|unique:tenants,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'lease_start_date' => 'required|date',
            'lease_end_date' => 'nullable|date|after_or_equal:lease_start_date',
            'account_number' => 'nullable|string|max:50',
            'id_number' => 'required|string|unique:tenants,id_number',
            'kra_pin' => 'nullable|string|regex:/^[A-Z]{1}\d{9}[A-Z]{1}$/',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:-18 years',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'city' => 'nullable|string|max:100',
            'county' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_relationship' => 'nullable|string|max:100',
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
