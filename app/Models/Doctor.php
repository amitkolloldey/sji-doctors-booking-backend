<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Doctor
 *
 * This model represents a doctor in the system.
 * It handles the doctor's personal information, specialization, email verification,
 * and relationships with availability slots and appointments.
 *
 * @package App\Models
 */
class Doctor extends Authenticatable
{
    // Use the HasApiTokens trait to enable API token functionalities for this model
    use HasApiTokens;

    // Mass assignable attributes for the Doctor model
    protected $fillable = [
        'name',  // Doctor's name
        'email',  // Doctor's email address
        'password',  // Doctor's account password (hashed)
        'specialization',  // The medical field of expertise (e.g., Cardiology, Neurology)
        'verification_token',  // Token for email verification
        'email_verified_at',  // Timestamp when the email was verified
    ];

    /**
     * Get a list of valid specializations for a doctor.
     *
     * This static method provides a predefined list of specializations
     * that a doctor can have in the system. It returns an array of strings
     * representing various medical fields.
     *
     * @return array
     */
    public static function getSpecializations()
    {
        return [
            'Cardiology',      // Heart-related medical care
            'Neurology',       // Brain and nervous system
            'Pediatrics',      // Children's health
            'Orthopedics',     // Bone and joint health
            'Dermatology',     // Skin care
            'General Medicine',// General healthcare
            'Gynecology',      // Female reproductive health
            'Psychiatry'       // Mental health care
        ];
    }

    /**
     * Define the relationship with the Availability model.
     *
     * A doctor can have many availability slots.
     * This method establishes a "has many" relationship between Doctor and Availability.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities()
    {
        return $this->hasMany(Availability::class); // A doctor has many availability records
    }

    /**
     * Define the relationship with the Appointment model.
     *
     * A doctor can have many appointments scheduled with patients.
     * This method establishes a "has many" relationship between Doctor and Appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class); // A doctor has many appointments
    }
}
