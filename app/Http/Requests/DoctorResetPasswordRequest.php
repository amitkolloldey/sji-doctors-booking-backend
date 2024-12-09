<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DoctorResetPasswordRequest
 *
 * Handles the validation logic for resetting a doctor's password.
 * Ensures that the provided token, email, and password are valid.
 *
 * @package App\Http\Requests
 */
class DoctorResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user has permission to reset the password.
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
     * Validates that the reset token, email, and password are properly provided.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required|string',  // The reset token is required and must be a string.
            'email' => 'required|email|exists:doctors,email',  // Email is required, must be valid, and must exist in doctors table.
            'password' => 'required|min:8|confirmed',  // Password is required, must be at least 8 characters, and must match the confirmation.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for each of the validation rules.
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
