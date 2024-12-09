<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DoctorResendVerificationEmailRequest
 *
 * Handles the validation logic for resending the doctor verification email.
 * Ensures that the provided email exists in the doctors table and is properly formatted.
 *
 * @package App\Http\Requests
 */
class DoctorResendVerificationEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method determines if the user has permission to make the request to resend the verification email.
     * You can add additional authorization logic as needed.
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
     * Validates the email to ensure it exists in the doctors' records and is a valid email address.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:doctors,email'  // Ensure email is required, valid, and exists in doctors' records.
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
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.exists' => 'No doctor account found with that email address.',
        ];
    }
}
