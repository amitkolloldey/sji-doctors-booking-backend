<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

/**
 * Class DoctorManageAvailabilityRequest
 *
 * Handles the validation logic for managing doctor's availability.
 * Ensures the availability date is not in the past and the time slots are correctly defined.
 *
 * @package App\Http\Requests
 */
class DoctorManageAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * This method determines if the user has permission to make the availability request.
     * You can add additional authorization logic as needed.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // You can customize this based on your authorization logic.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Validates the doctor’s availability data, including date and time slots.
     * The date must not be in the past, and the time slots must have proper start and end times.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:' . Carbon::today()->toDateString()],
            'slots' => ['required', 'array'],
            'slots.*.start_time' => [
                'required',
                'date_format:H:i:s',
                function ($attribute, $value, $fail) {
                    $selectedDate = request('date');
                    $currentDateTime = Carbon::now();
                    $slotDateTime = Carbon::parse($selectedDate . ' ' . $value);

                    if ($slotDateTime->lt($currentDateTime)) {
                        $fail('The ' . $attribute . ' must be a future time.');
                    }
                }
            ],
            'slots.*.end_time' => ['required', 'date_format:H:i:s', 'after:slots.*.start_time'],
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * Provides custom error messages for the availability date and time slots.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date.required' => 'The date is required.',
            'date.date' => 'The date must be a valid date.',
            'slots.required' => 'Slots are required.',
            'slots.array' => 'Slots must be an array.',
            'slots.*.start_time.required' => 'The start time is required for each slot.',
            'slots.*.start_time.date_format' => 'The start time must be in the format HH:mm:ss.',
            'slots.*.end_time.required' => 'The end time is required for each slot.',
            'slots.*.end_time.date_format' => 'The end time must be in the format HH:mm:ss.',
            'slots.*.end_time.after' => 'The end time must be after the start time.',
            'date.after_or_equal' => 'The date must not be in the past.',
            'slots.*.start_time.future' => 'The start time must be a future time.',
        ];
    }
}
