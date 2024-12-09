<?php

namespace App\Http\Controllers;

/**
 * Class BaseController
 *
 * Provides common functionality for handling authenticated users, such as retrieving
 * authenticated doctors or patients. Acts as a base controller for other controllers.
 *
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * Get the currently authenticated doctor.
     *
     * This method retrieves the authenticated doctor from the `doctor` guard.
     * If no authenticated doctor is found, it aborts the request with a 403 response.
     *
     * @return \App\Models\Doctor
     */
    protected function getAuthenticatedDoctor()
    {
        $doctor = auth('doctor')->user();

        if (!$doctor) {
            abort(response()->json(['error' => 'Unauthorized or invalid user.'], 403));
        }

        return $doctor;
    }

    /**
     * Get the currently authenticated patient.
     *
     * This method retrieves the authenticated patient from the `patient` guard.
     * If no authenticated patient is found, it aborts the request with a 403 response.
     *
     * @return \App\Models\Patient
     */
    protected function getAuthenticatedPatient()
    {
        $patient = auth('patient')->user();

        if (!$patient) {
            abort(response()->json(['error' => 'Unauthorized or invalid user.'], 403));
        }

        return $patient;
    }
}
