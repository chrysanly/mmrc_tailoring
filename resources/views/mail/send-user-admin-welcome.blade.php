<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
    <h1>Hi {{ $user->fullname }},</h1>
    <p>Your admin account has been successfully created. Below are your login details:</p>
    <p> Email: {{ $user->email }}</p>
    <p> Password: {{ $password }}</p>
    <p>Please log in and update your password for security.</p>
    <span> 🔗 Login Here: <a href="{{ route('login') }}">{{ route('login') }}</a></span>
    <p> If you have any questions, feel free to reach out.</p>
    <p>Best regards,</p>
    <span>{{ env('APP_NAME') }}</span>
</body>
</html>
