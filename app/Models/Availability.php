<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Availability
 *
 * This model represents the availability slots of a doctor.
 * It contains the details such as the doctor ID, available date, start time, and end time for the availability.
 * It also establishes relationships with the Doctor and Appointment models.
 *
 * @package App\Models
 */
class Availability extends Model
{
    // Mass assignable attributes for the Availability model
    protected $fillable = [
        'doctor_id',  // ID of the doctor for whom the availability is set
        'date',  // The date when the doctor is available
        'start_time',  // The start time of the doctor's availability
        'end_time'  // The end time of the doctor's availability
    ];

    /**
     * Define the relationship with the Doctor model.
     *
     * Each availability record belongs to one doctor.
     * This method establishes a "belongs to" relationship between Availability and Doctor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class); // An availability record belongs to one doctor
    }

    /**
     * Define the relationship with the Appointment model.
     *
     * Each availability record may have many appointments scheduled during it.
     * This method establishes a "has many" relationship between Availability and Appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class); // An availability record can have many associated appointments
    }
}
