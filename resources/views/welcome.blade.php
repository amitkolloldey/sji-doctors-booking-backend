<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SJI Doctor's Appointment Booking</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.125rem;
            color: #4a5568;
            line-height: 1.6;
        }

        a {
            color: #3182ce;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.875rem;
            color: #718096;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>SJI Doctor's Appointment Booking API</h1>
        <p>
            Welcome to the SJI Doctor's Appointment Booking API.
            <br>
            Go to the Portal: <a href="{{ env('FRONT_URL') }}">{{ env('FRONT_URL') }}</a>
        </p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} SJI Doctor's Appointment Booking</p>
        </div>
    </div>
</body>

</html>
