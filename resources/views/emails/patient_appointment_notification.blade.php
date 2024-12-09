@component('mail::message')

Dear **{{ $appointment->patient->name }}**,

Your appointment has been successfully booked with the following details:

@component('mail::table')
| **Detail**       | **Information**          |
|-------------------|--------------------------|
| **Doctor**       | {{ $appointment->doctor->name }} |
| **Date**         | {{ $appointment->date }} |
| **Time**         | {{ $appointment->start_time }} - {{ $appointment->end_time }} |
@endcomponent

Thank you for using our service!

Thanks,<br>
{{ config('app.name') }}
@endcomponent