<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DoctorUpdateRequest
 *
 * Handles the validation logic for updating a doctor's information.
 * Ensures that the name and specialization fields are properly provided and are valid.
 *
 * @package App\Http\Requests
 */
class DoctorUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method checks if the user has permission to update the doctor's information.
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
     * Validates that the name and specialization fields are provided and are valid.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',  // Name is required, must be a string, and cannot exceed 255 characters.
            'specialization' => 'required|string|max:255', // Specialization is required, must be a string, and cannot exceed 255 characters.
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
            'name.required' => 'The name is required.',
            'specialization.required' => 'The specialization is required.',
        ];
    }
}
