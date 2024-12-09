<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Patient;

/**
 * Class PatientEmailVerification
 *
 * This class is responsible for sending an email verification link to the patient
 * to verify their email address after registration. The email contains a link
 * with a verification token that the patient can use to complete the verification process.
 *
 * @package App\Mail
 */
class PatientEmailVerification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $patient; // Store the patient details.

    /**
     * Create a new message instance.
     *
     * The constructor accepts a Patient model instance to initialize the property.
     * This information will be used to generate the verification email content.
     *
     * @param \App\Models\Patient $patient The patient whose email needs verification.
     */
    public function __construct(Patient $patient)
    {
        $this->patient = $patient; // Store the patient details for use in the email.
    }

    /**
     * Build the message.
     *
     * This method sets the subject of the email, uses a Markdown view for the email content,
     * and passes the patient's name and verification URL to the email view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Verification for Your Account') // Set the subject of the email.
            ->markdown('emails.patient_verification') // Specify the Markdown view for the email content.
            ->with([ // Pass dynamic data to the email view.
                'name' => $this->patient->name, // Pass the patient's name.
                'verificationUrl' => route('patients.verify.email', ['token' => $this->patient->verification_token]), // Pass the verification URL with the token.
            ]);
    }
}
