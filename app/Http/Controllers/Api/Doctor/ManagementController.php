<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\BaseController;
use App\Models\Doctor;

/**
 * Class ManagementController
 *
 * This controller handles administrative tasks for managing doctor-related data.
 *
 * @package App\Http\Controllers\Api\Doctor
 */
class ManagementController extends BaseController
{
    /**
     * Retrieve a list of all registered doctors.
     *
     * This method fetches all the doctor records from the database and returns them in JSON format.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all doctors from the database
        $doctors = Doctor::all();

        // Return the list of doctors as a JSON response
        return response()->json($doctors);
    }
}
