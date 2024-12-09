@component('mail::message')
# Hello, {{ $name }}!

Thank you for registering awith us. To complete your registration, please verify your email address by clicking the button below.

@component('mail::button', ['url' => $verificationUrl])
Verify Your Email
@endcomponent

If you did not register, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
