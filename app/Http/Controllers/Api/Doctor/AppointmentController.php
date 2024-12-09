<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PatientStoreAppointmentRequest;
use App\Mail\DoctorAppointment;
use App\Mail\PatientAppointment;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\PatientAppointmentCanceled;

/**
 * Class AppointmentController
 *
 * This controller handles appointment-related operations for doctors and patients.
 *
 * @package App\Http\Controllers\Api\Doctor
 */
class AppointmentController extends BaseController
{
    /**
     * Get all appointments for the authenticated doctor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppointments()
    {
        $doctor = $this->getAuthenticatedDoctor();

        $appointments = $doctor->appointments()
            ->select('id', 'date', 'start_time', 'end_time')
            ->get();

        return response()->json($appointments);
    }

    /**
     * Store a new appointment for a patient.
     *
     * @param PatientStoreAppointmentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAppointments(PatientStoreAppointmentRequest $request)
    {
        $patient = $this->getAuthenticatedPatient();

        $validated = $request->validated();

        $appointment = Appointment::create($validated);

        $appointment->load(['doctor', 'patient']);

        // Notify the doctor via email about the new appointment
        Mail::to($appointment->doctor->email)->queue(new DoctorAppointment($appointment));

        // Notify the patient via email about the new appointment
        Mail::to($appointment->patient->email)->queue(new PatientAppointment($appointment));

        return response()->json($appointment, 201);
    }

    /**
     * Cancel an appointment by the authenticated doctor.
     *
     * @param int $id The ID of the appointment to cancel.
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelAppointment($id)
    {
        $doctor = $this->getAuthenticatedDoctor();

        $appointment = $doctor->appointments()->where('id', $id)->with('patient')->first();

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        if ($appointment->status === 'canceled') {
            return response()->json(['error' => 'Appointment is already canceled'], 400);
        }

        // Update the appointment status to 'canceled'
        $appointment->update([
            'status' => 'canceled',
        ]);

        // Notify the patient about the cancellation
        try {
            Mail::to($appointment->patient->email)->queue(new PatientAppointmentCanceled($appointment));
        } catch (\Exception $e) {
            \Log::error('Failed to send cancellation email: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Appointment has been canceled successfully']);
    }

    /**
     * Get all appointments for the authenticated patient.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppointmentsForPatient()
    {
        $patient = $this->getAuthenticatedPatient();

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor')
            ->get();

        return response()->json($appointments);
    }
}
