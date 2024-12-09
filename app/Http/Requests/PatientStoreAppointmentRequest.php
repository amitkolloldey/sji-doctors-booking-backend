<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PatientStoreAppointmentRequest
 *
 * Handles the validation logic for storing a patient's appointment.
 * Ensures that the necessary fields are present and valid, such as doctor ID, patient ID, appointment date, time, and status.
 *
 * @package App\Http\Requests
 */
class PatientStoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * By default, this method returns true, meaning all users are authorized to create an appointment.
     * You can customize this logic to restrict access if needed.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Customize this based on your authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validates the data required for storing an appointment, including:
     * - `doctor_id`: Must exist in the doctors' table.
     * - `patient_id`: Must exist in the patients' table.
     * - `date`: Must be a valid date.
     * - `start_time` and `end_time`: Must be valid times in the HH:MM:SS format.
     * - `status`: Must be one of the predefined values (`pending`, `scheduled`, `passed`, or `canceled`).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',           // Ensure doctor ID exists in the doctors table.
            'patient_id' => 'required|exists:patients,id',         // Ensure patient ID exists in the patients table.
            'date' => 'required|date',                             // Ensure the appointment date is valid.
            'start_time' => 'required|date_format:H:i:s',          // Ensure start time is in HH:MM:SS format.
            'end_time' => 'required|date_format:H:i:s',            // Ensure end time is in HH:MM:SS format.
            'status' => 'required|in:pending,scheduled,passed,canceled', // Ensure the status is one of the allowed values.
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for the appointment fields such as doctor, patient, date, time, and status.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Doctor is required.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'patient_id.required' => 'Patient is required.',
            'patient_id.exists' => 'The selected patient does not exist.',
            'date.required' => 'Appointment date is required.',
            'date.date' => 'Please provide a valid date.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in the format HH:MM:SS.',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'End time must be in the format HH:MM:SS.',
            'status.required' => 'Appointment status is required.',
            'status.in' => 'Status must be one of the following: pending, scheduled, passed, or canceled.',
        ];
    }
}
