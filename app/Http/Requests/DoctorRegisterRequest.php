<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DoctorRegisterRequest
 *
 * Handles the validation logic for doctor registration.
 * Ensures that the required fields are provided, the email is unique, 
 * and the password meets security requirements.
 *
 * @package App\Http\Requests
 */
class DoctorRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user is authorized to register a doctor. 
     * By default, this returns true, allowing all users to register.
     * You can customize this based on your authorization logic (e.g., check for admin).
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
     * This method returns the validation rules that will be applied to 
     * the doctor's registration data. It ensures that:
     * - The name is required, a string, and has a maximum length of 255 characters.
     * - The email is required, must be a valid email format, and must be unique in the doctors table.
     * - The password is required, a string, at least 6 characters long, and must match the confirmed password.
     * - The specialization is required and must be a string with a maximum length of 255 characters.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',  // Name must be a string and cannot exceed 255 characters.
            'email' => 'required|email|unique:doctors,email',  // Email must be unique and valid.
            'password' => 'required|string|min:6|confirmed',  // Password must meet the minimum length and be confirmed.
            'specialization' => 'required|string|max:255',  // Specialization must be a string and cannot exceed 255 characters.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for each of the validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered.',  // Custom message for duplicate email.
            'password.confirmed' => 'The password confirmation does not match.',  // Custom message for password mismatch.
            'name.required' => 'The name is required.',  // Custom message for missing name.
            'email.required' => 'The email is required.',  // Custom message for missing email.
            'email.email' => 'The email must be a valid email address.',  // Custom message for invalid email format.
            'password.required' => 'The password is required.',  // Custom message for missing password.
            'password.min' => 'The password must be at least 6 characters.',  // Custom message for password length validation.
            'specialization.required' => 'The specialization is required.',  // Custom message for missing specialization.
            'specialization.string' => 'The specialization must be a string.',  // Custom message for invalid specialization type.
        ];
    }
}