<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientLoginRequest
 *
 * Handles the validation logic for a patient login request.
 * Ensures that the email and password are provided and meet the required criteria.
 *
 * @package App\Http\Requests
 */
class PatientLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * By default, this method returns true, meaning any user can attempt to log in.
     * You can customize this to add further authorization checks if necessary.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can customize this based on your authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validates that the provided email is a valid email address and that the password
     * is a string with a minimum length of 6 characters.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email',  // Ensure the email is required, a valid string, and a proper email format.
            'password' => 'required|string|min:6', // Ensure the password is required, a string, and at least 6 characters long.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for the login fields, including the email and password.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 6 characters.',
        ];
    }
}
