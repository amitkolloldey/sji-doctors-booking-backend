<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientUpdateRequest
 *
 * Handles the validation logic for updating a patient's information.
 * Ensures that the required fields like name are provided, and the phone number is valid if provided.
 *
 * @package App\Http\Requests
 */
class PatientUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * By default, this method returns true, meaning any user can attempt to update their information.
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
     * Ensures that the name is a required string with a maximum length of 255 characters.
     * Also checks that the phone number is a string and at least 11 characters long if provided.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255', // Name is required, must be a string, and cannot exceed 255 characters.
            'phone_no' => 'nullable|string|min:11' // Phone number is optional, but if provided, it must be at least 11 characters long.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for the name and phone number fields.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',  // Error message if the name is missing.
            'phone_no.min' => 'Phone number must be at least 11 characters.' // Error message if the phone number is too short.
        ];
    }
}
