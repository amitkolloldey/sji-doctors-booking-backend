<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg text-center">
            <h1 class="text-4xl font-semibold text-green-500 mb-4">{{ $message }}</h1>
            <p class="text-lg text-gray-700 mb-6">Thank you for verifying your email address. You can now <a href="{{ config('app.front_url') }}/patient/login" class="text-blue-500 hover:text-blue-700 font-semibold">log in</a> to your account.</p>
            <p class="text-sm text-gray-500">If you did not receive the email, please check your spam folder.</p>
        </div>
    </div> 
</body>
</html>
