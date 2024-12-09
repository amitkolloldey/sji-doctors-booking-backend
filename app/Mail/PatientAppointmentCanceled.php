<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class PatientAppointmentCanceled
 *
 * This class is responsible for sending an email notification to the patient
 * when their appointment is canceled.
 * It includes the appointment details that will be used in the email content.
 *
 * @package App\Mail
 */
class PatientAppointmentCanceled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $appointment; // Store the appointment details.

    /**
     * Create a new message instance.
     *
     * The constructor accepts the appointment details to initialize the property.
     * This information will be used in the email content.
     *
     * @param $appointment The appointment details (such as doctor, time, etc.).
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment; // Store the appointment details for use in the email.
    }

    /**
     * Build the message.
     *
     * This method sets the subject of the email, uses a Markdown view for the email content,
     * and passes the appointment details to the view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Appointment Has Been Canceled') // Set the subject of the email.
            ->markdown('emails.appointment-canceled') // Specify the Markdown view for the email content.
            ->with([ // Pass dynamic data to the email view.
                'appointment' => $this->appointment, // Pass the appointment details.
            ]);
    }
}