@component('mail::message') 

Dear {{ $appointment->patient->name }},

We regret to inform you that your appointment has been canceled. Below are the details of the appointment:

- **Date:** {{ $appointment->date }}
- **Start Time:** {{ $appointment->start_time }}
- **End Time:** {{ $appointment->end_time }}
- **Doctor:** Dr. {{ $appointment->doctor->name }}

If you have any questions or concerns, please don't hesitate to contact us. 

Thank you,  
{{ config('app.name') }}
@endcomponent