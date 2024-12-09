<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DoctorLoginRequest
 *
 * Handles the validation logic for doctor login requests.
 * Ensures the provided email and password are valid.
 *
 * @package App\Http\Requests
 */
class DoctorLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to make the login request.
     * You can add custom authorization logic here if needed.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // If you want to add any authorization logic, return false if unauthorized.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Defines the rules for validating the email and password fields.
     * The email must be a valid email address, and the password must be a string with a minimum length.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email', // The email must be a valid string and email format
            'password' => 'required|string|min:6', // The password must be at least 6 characters
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom validation messages for email and password fields.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is required to log in.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'Password is required to log in.',
            'password.min' => 'Password must be at least 6 characters long.',
        ];
    }
}
