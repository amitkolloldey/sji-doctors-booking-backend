<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AppointmentRequest
 *
 * Handles the validation logic for appointment requests.
 * Validates the doctor ID, appointment date, and appointment time.
 *
 * @package App\Http\Requests
 */
class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method determines if the authenticated user has permission
     * to make the appointment request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // You can add logic here to check user authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Defines the rules for validating the doctor_id, appointment_date, 
     * and appointment_time fields.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom validation messages for each rule.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Doctor is required for the appointment.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'appointment_date.required' => 'Appointment date is required.',
            'appointment_date.date' => 'Appointment date must be a valid date.',
            'appointment_date.after_or_equal' => 'Appointment date must be today or in the future.',
            'appointment_time.required' => 'Appointment time is required.',
            'appointment_time.date_format' => 'Appointment time must be in the format HH:mm.',
        ];
    }
}
