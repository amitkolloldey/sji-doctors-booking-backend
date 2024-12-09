<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 *
 * This model represents an appointment between a doctor and a patient.
 * It contains the appointment details such as doctor, patient, date, start time, end time, and status.
 *
 * @package App\Models
 */
class Appointment extends Model
{
    // Mass assignable attributes for the Appointment model
    protected $fillable = [
        'doctor_id',  // ID of the doctor associated with the appointment
        'patient_id',  // ID of the patient associated with the appointment
        'date',  // The date of the appointment
        'start_time',  // The start time of the appointment
        'end_time',  // The end time of the appointment
        'status'  // The status of the appointment (e.g., pending, scheduled, completed)
    ];

    /**
     * Define the relationship with the Doctor model.
     *
     * Each appointment belongs to one doctor.
     * This method establishes a "belongs to" relationship between Appointment and Doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class); // An appointment belongs to one doctor
    }

    /**
     * Define the relationship with the Patient model.
     *
     * Each appointment belongs to one patient.
     * This method establishes a "belongs to" relationship between Appointment and Patient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class); // An appointment belongs to one patient
    }

    /**
     * Define the relationship with the Availability model.
     *
     * Each appointment may be associated with a doctor's availability.
     * This method establishes a "belongs to" relationship between Appointment and Availability.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function availability()
    {
        return $this->belongsTo(Availability::class); // An appointment can be linked to availability
    }
}