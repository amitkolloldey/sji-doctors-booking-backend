<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientForgotPasswordRequest
 *
 * Handles the validation logic for requesting a password reset for a patient.
 * Ensures that the provided email exists in the patients table and is properly formatted.
 *
 * @package App\Http\Requests
 */
class PatientForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user has permission to request a password reset.
     * You can implement any additional authorization logic as necessary.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Customize as per your authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validates the email to ensure it exists in the patients' records and is a valid email address.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:patients,email', // Ensures email is required, valid, and exists in the patients table
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for the email field validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.exists' => 'This email does not exist in our records.',
        ];
    }
}
