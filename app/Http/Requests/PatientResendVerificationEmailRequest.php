<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientResendVerificationEmailRequest
 *
 * Handles the validation logic for resending the verification email to a patient.
 * Ensures that the email is valid, required, and exists in the patient's records.
 *
 * @package App\Http\Requests
 */
class PatientResendVerificationEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to make the request to resend the verification email.
     * By default, it returns true, meaning any user can make this request. You can add additional 
     * authorization logic based on your requirements.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // You can customize this based on your authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * This method specifies the validation rules for the `email` field:
     * - `required`: Ensures the email field is provided.
     * - `string`: Ensures the email is a string.
     * - `email`: Ensures the email is in a valid email format.
     * - `exists:patients,email`: Ensures the provided email exists in the `patients` table's `email` column.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:patients,email'  // Ensure email is required, valid, and exists in patients' records.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for each of the validation rules applied to the `email` field.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email address is required to resend the verification email.',
            'email.email' => 'The email address must be in a valid email format.',
            'email.exists' => 'The email address provided does not exist in our records. Please check and try again.',
        ];
    }
}
