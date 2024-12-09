<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg text-center">
            <h1 class="text-4xl font-semibold text-red-500 mb-4">{{ $message }}</h1>
            <p class="text-lg text-gray-700 mb-6">It seems there was an issue with the verification link. Please try again or contact support.</p>
            <a href="{{ config('app.front_url') }}/doctor/login" class="text-blue-500 hover:text-blue-700 font-semibold">Go to Login</a>
        </div>
    </div>

</body>
</html>
