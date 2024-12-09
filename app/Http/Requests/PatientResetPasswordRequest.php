<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientResetPasswordRequest
 *
 * Handles the validation logic for patient password reset.
 * Ensures that the token, email, and password fields are properly provided and valid.
 *
 * @package App\Http\Requests
 */
class PatientResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to request a password reset.
     * By default, it returns true, meaning any user can initiate a password reset request.
     * You can add additional logic for more fine-grained control over authorization.
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
     * This method specifies the validation rules for the password reset request:
     * - `token`: A required string that should be the password reset token.
     * - `email`: A required email field, which must exist in the `patients` table.
     * - `password`: A required string, must be at least 8 characters, and must match the password confirmation field.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string',  // Ensure the reset token is provided.
            'email' => 'required|email|exists:patients,email',  // Validate the email and check if it exists in the records.
            'password' => 'required|min:8|confirmed',  // Password must meet length and confirmation requirements.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for the token, email, and password fields.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'token.required' => 'The password reset token is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.exists' => 'This email does not exist in our records.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}