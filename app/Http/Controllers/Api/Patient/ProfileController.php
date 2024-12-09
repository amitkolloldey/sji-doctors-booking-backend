<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PatientUpdateRequest;

/**
 * Class ProfileController
 *
 * Handles patient profile management, including updating profile details.
 *
 * @package App\Http\Controllers\Api\Patient
 */
class ProfileController extends BaseController
{
    /**
     * Update the authenticated patient's profile information.
     *
     * @param PatientUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PatientUpdateRequest $request)
    { 
        // Retrieve the authenticated patient
        $patient = $this->getAuthenticatedPatient();
 
        // Validate the incoming data
        $validatedData = $request->validated();
 
        // Update the patient's name and phone number
        $patient->name = $validatedData['name'];
        $patient->phone_no = $validatedData['phone_no'];
 
        // Save the changes to the database
        $patient->save();
 
        // Return the updated patient data as JSON
        return response()->json($patient);
    }
}
