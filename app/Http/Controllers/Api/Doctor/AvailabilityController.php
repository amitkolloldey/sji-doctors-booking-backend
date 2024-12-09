<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DoctorManageAvailabilityRequest;
use App\Models\Doctor;
use App\Models\Availability;

/**
 * Class AvailabilityController
 *
 * This controller manages doctor availability, including creating, fetching, and deleting availability slots.
 *
 * @package App\Http\Controllers\Api\Doctor
 */
class AvailabilityController extends BaseController
{
    /**
     * Store availability slots for the authenticated doctor.
     *
     * @param DoctorManageAvailabilityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAvailability(DoctorManageAvailabilityRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();

        $createdSlots = [];
        foreach ($request->slots as $slot) {
            $createdSlots[] = $doctor->availabilities()->create([
                'date' => $request->date,
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
            ]);
        }

        return response()->json([
            'message' => 'Availability added successfully',
            'slots' => $createdSlots,
        ], 201);
    }

    /**
     * Delete an availability slot by ID for the authenticated doctor.
     *
     * @param int $id The ID of the availability slot to delete.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAvailability($id)
    {
        $doctor = $this->getAuthenticatedDoctor();

        $availability = Availability::findOrFail($id);

        // Check if the slot has any associated appointments
        if ($availability->appointments()->exists()) {
            return response()->json(['error' => 'This slot has appointments and cannot be deleted.'], 400);
        }

        $availability->delete();

        return response()->json(['message' => 'Availability deleted successfully.'], 200);
    }

    /**
     * Get availability and booked appointments for a doctor within a week.
     *
     * @param int $doctorId The ID of the doctor to fetch availability for.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailability($doctorId)
    {
        $patient = $this->getAuthenticatedPatient();

        $doctor = Doctor::with([
            'availabilities' => function ($query) {
                $query->whereDate('date', '>=', now())
                    ->whereDate('date', '<=', now()->addWeek())
                    ->orderBy('date')
                    ->orderBy('start_time');
            },
            'appointments' => function ($query) {
                $query->where('status', '!=', 'cancelled')
                    ->whereDate('date', '>=', now())
                    ->whereDate('date', '<=', now()->addWeek());
            }
        ])->find($doctorId);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        // Group availability slots and appointments by date
        $availabilityByDate = $doctor->availabilities->groupBy('date')->toArray();
        $bookedAppointments = $doctor->appointments->groupBy('date')->toArray();

        return response()->json([
            'doctor' => $doctor,
            'availability' => $availabilityByDate,
            'bookedAppointments' => $bookedAppointments
        ]);
    }
}
