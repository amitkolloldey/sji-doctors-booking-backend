<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class DoctorResetPassword
 *
 * This class is responsible for sending a password reset email to a doctor.
 * It includes a reset URL and the doctor's name to be used in the email template.
 *
 * @package App\Mail
 */
class DoctorResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $resetUrl; // Store the password reset URL.
    public $name; // Store the doctor's name.

    /**
     * Create a new message instance.
     *
     * The constructor accepts the reset URL and doctor's name to initialize the properties.
     * These values will be used in the email content.
     *
     * @param string $resetUrl The password reset URL.
     * @param string $name The name of the doctor.
     */
    public function __construct($resetUrl, $name)
    {
        $this->resetUrl = $resetUrl; // Store the reset URL for use in the email.
        $this->name = $name; // Store the doctor's name for use in the email.
    }

    /**
     * Build the message.
     *
     * This method sets the subject of the email, uses a Markdown view for the email content,
     * and passes the reset URL and doctor's name to the view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Your Password') // Set the subject of the email.
            ->markdown('emails.doctor_reset_password') // Specify the Markdown view for the email content.
            ->with([ // Pass dynamic data to the email view.
                'resetUrl' => $this->resetUrl, // Pass the reset URL.
                'name' => $this->name, // Pass the doctor's name.
            ]);
    }
}