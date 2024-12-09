<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class DoctorAppointment
 *
 * This class is responsible for sending an email notification to a doctor when a new appointment is booked.
 * It uses a Markdown email template to format the appointment details and sends it with the subject "New Appointment Booked".
 *
 * @package App\Mail
 */
class DoctorAppointment extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $appointment; // The appointment details will be passed to the email.

    /**
     * Create a new message instance.
     *
     * The constructor accepts the appointment details and stores them in a public property.
     *
     * @param $appointment
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment; // Store the appointment details in the public property for use in the email template.
    }

    /**
     * Build the message.
     *
     * This method sets the subject of the email and specifies the Markdown view for the email content.
     * It uses the 'emails.doctor_appointment_notification' view, which formats the appointment information.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Appointment Booked') // Set the email subject.
            ->markdown('emails.doctor_appointment_notification'); // Specify the Markdown view for the email content.
    }
}
