<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Patient
 *
 * This model represents a patient in the system.
 * It handles the patient's personal information, account details,
 * email verification, and phone number.
 *
 * @package App\Models
 */
class Patient extends Authenticatable
{
    // Use the HasApiTokens trait to enable API token functionalities for this model
    use HasApiTokens;

    // Mass assignable attributes for the Patient model
    protected $fillable = [
        'name',              // Patient's full name
        'email',             // Patient's email address
        'password',          // Patient's password (hashed)
        'verification_token',// Token used for email verification
        'email_verified_at', // Timestamp when the email was verified
        'phone_no'           // Patient's phone number
    ];
}
