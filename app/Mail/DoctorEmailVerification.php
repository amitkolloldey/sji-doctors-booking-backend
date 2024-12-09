<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Doctor;

/**
 * Class DoctorEmailVerification
 *
 * This class is responsible for sending an email to a doctor for email verification.
 * It includes the doctor's name and a verification URL to be used in the email template.
 *
 * @package App\Mail
 */
class DoctorEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor; // Store the doctor model to access its properties.

    /**
     * Create a new message instance.
     *
     * The constructor accepts a Doctor model instance and stores it in the $doctor property.
     * This model will be used to access the doctor's details, such as the name and verification token.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return void
     */
    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor; // Store the doctor instance to access the properties later in the email.
    }

    /**
     * Build the message.
     *
     * This method sets the subject of the email, uses a Markdown view for the email content,
     * and passes the doctor's name and a dynamic verification URL to the view.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Email Verification for Your Account') // Set the email subject.
            ->markdown('emails.doctor_verification') // Specify the Markdown view for the email content.
            ->with([ // Pass dynamic data to the email view.
                'name' => $this->doctor->name, // Pass the doctor's name to the view.
                'verificationUrl' => route('doctors.verify.email', ['token' => $this->doctor->verification_token]), // Generate the verification URL.
            ]);
    }
}
