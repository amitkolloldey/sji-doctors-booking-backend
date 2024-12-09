<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Doctor;

/**
 * Class ProfileController
 *
 * This controller handles the doctor's profile management, including retrieving specializations and updating profile details.
 *
 * @package App\Http\Controllers\Api\Doctor
 */
class ProfileController extends BaseController
{
    /**
     * Retrieve a list of available specializations for doctors.
     *
     * This method fetches all predefined specializations from the Doctor model and returns them as a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecializations()
    {
        // Fetch the list of specializations from the Doctor model
        $specializations = Doctor::getSpecializations();

        // Return the specializations as a JSON response
        return response()->json($specializations);
    }

    /**
     * Update the authenticated doctor's profile details.
     *
     * This method allows a doctor to update their name and specialization based on the provided validated data.
     *
     * @param DoctorUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DoctorUpdateRequest $request)
    {
        // Retrieve the currently authenticated doctor
        $doctor = $this->getAuthenticatedDoctor();

        // Validate and retrieve the data from the request
        $validatedData = $request->validated();

        // Update the doctor's name
        $doctor->name = $validatedData['name'];

        // Update specialization if provided
        if (isset($validatedData['specialization'])) {
            $doctor->specialization = $validatedData['specialization'];
        }

        // Save the updated profile details
        $doctor->save();

        // Return the updated doctor details as a JSON response
        return response()->json($doctor);
    }
}
