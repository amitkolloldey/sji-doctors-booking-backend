<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function bookAppointment(AppointmentRequest $request)
    {
        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => auth()->id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'confirmed',
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment,
        ], 201);
    }
}