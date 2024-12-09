@component('mail::message')

Dear **{{ $appointment->doctor->name }}**,

An appointment has been booked with the following details:

@component('mail::table')
| **Detail**       | **Information**          |
|-------------------|--------------------------|
| **Date**         | {{ $appointment->date }} |
| **Time**         | {{ $appointment->start_time }} - {{ $appointment->end_time }} |
| **Patient Name** | {{ $appointment->patient->name }} |
| **Patient Email**| {{ $appointment->patient->email }} |
@endcomponent

Please log in to your dashboard for more information.

Thanks,<br>
{{ config('app.name') }}
@endcomponent