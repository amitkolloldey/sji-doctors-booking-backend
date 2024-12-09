<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientRegisterRequest
 *
 * Handles the validation logic for patient registration requests.
 * Ensures that the required fields (name, email, password, phone number) are properly validated.
 *
 * @package App\Http\Requests
 */
class PatientRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to perform the registration action.
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
     * Validates the name, email, password, and phone number fields.
     * Ensures they meet the necessary criteria for a valid registration.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Name is required, a string, and cannot exceed 255 characters
            'email' => 'required|string|email|unique:patients,email', // Email is required, must be a valid email, and unique in the patients table
            'password' => 'required|string|min:6|confirmed', // Password is required, must be at least 6 characters long, and must match the confirmation
            'password_confirmation' => 'required|string|min:6', // Ensures the confirmation password is provided
            'phone_no' => 'nullable|string|min:11', // Phone number is optional, must be a string, and at least 11 characters long
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
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 6 characters long.',
            'phone_no.min' => 'Phone number must be at least 11 characters.',
        ];
    }
}
