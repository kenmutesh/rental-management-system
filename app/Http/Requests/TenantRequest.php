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
            'id_number' => 'required|string|unique:tenants,id_number',
            'kraPin' => 'nullable|string|regex:/^[A-Z]{1}\d{9}[A-Z]{1}$/',
            'employerName' => 'nullable|string|max:255',
            'jobTitle' => 'nullable|string|max:255',
            'monthlyIncome' => 'nullable|numeric|min:0',
            'property_id' => 'required|exists:properties,id',
            'unit_id' => 'required|exists:units,id',
            'lease_start_date' => 'required|date',
            'rentAmount' => 'required|numeric|min:0',
            'securityDeposit' => 'required|numeric|min:0',
            'paymentMethod' => 'required|in:bank,mpesa,cheque,cash',
            'applyDiscount' => 'boolean',
            'discountType' => 'nullable|required_if:applyDiscount,true|in:percentage,fixed',
            'discountValue' => 'nullable|required_if:applyDiscount,true|numeric|min:0',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
            'idCopy' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kraPinCopy' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'employmentLetter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'payslips.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bankStatements.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'references.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'accountNumber' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:-18 years',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'city' => 'nullable|string|max:100',
            'county' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
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
