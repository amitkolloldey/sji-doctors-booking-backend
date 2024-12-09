<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class PatientResetPassword
 *
 * This class is responsible for sending a password reset email to the patient.
 * The email contains a link to reset the patient's password, which includes a reset URL.
 *
 * @package App\Mail
 */
class PatientResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $resetUrl; // Store the reset URL.
    public $name; // Store the patient's name.

    /**
     * Create a new message instance.
     *
     * The constructor accepts a reset URL and patient's name to initialize the properties.
     * These values will be passed to the email view for dynamic content.
     *
     * @param string $resetUrl The URL for resetting the password.
     * @param string $name The name of the patient.
     */
    public function __construct($resetUrl, $name)
    {
        $this->resetUrl = $resetUrl; // Store the reset URL.
        $this->name = $name; // Store the patient's name.
    }

    /**
     * Build the message.
     *
     * This method sets the subject of the email, uses a Markdown view for the email content,
     * and passes the reset URL and the patient's name to the email view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Your Password') // Set the subject of the email.
            ->markdown('emails.patient_reset_password') // Specify the Markdown view for the email body.
            ->with([ // Pass dynamic data to the email view.
                'resetUrl' => $this->resetUrl, // Pass the reset URL to the email.
                'name' => $this->name, // Pass the patient's name to the email.
            ]);
    }
}