<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\BaseController;

/**
 * Class CalendarController
 *
 * This controller handles calendar data for doctors, including appointments and availability slots.
 *
 * @package App\Http\Controllers\Api\Doctor
 */
class CalendarController extends BaseController
{
    /**
     * Retrieve calendar data for the authenticated doctor.
     *
     * The response includes:
     * - Appointments: Details about the doctor's scheduled appointments with patient information.
     * - Availability: The doctor's available slots.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCalendarData()
    {
        // Get the authenticated doctor
        $doctor = $this->getAuthenticatedDoctor();

        // Fetch appointments with patient information
        $appointments = $doctor->appointments()->with('patient')->get();

        // Fetch the doctor's availability slots
        $availability = $doctor->availabilities()->get();

        // Return the calendar data as a JSON response
        return response()->json([
            'appointments' => $appointments,
            'availability' => $availability,
        ]);
    }
}
