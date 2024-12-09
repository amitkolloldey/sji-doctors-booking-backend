<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DoctorForgotPasswordRequest
 *
 * Handles the validation logic for the doctor forgot password request.
 * Validates the email address entered for password reset.
 *
 * @package App\Http\Requests
 */
class DoctorForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to request a password reset.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // You can add authorization logic here if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Defines the rules for validating the email field.
     * Ensures the email is in a valid format and exists in the doctors' table.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:doctors,email', // Ensures the email is required, valid, and exists in the doctors table
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom validation messages for the email field.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required to reset your password.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'This email does not exist in our records.',
        ];
    }
}
