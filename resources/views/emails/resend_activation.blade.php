<!-- resources/views/emails/resend_activation.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Activate Your Account</title>
</head>
<body>
    <h1>Hello, {{ $name }}</h1>
    <p>Please click the button below to activate your account:</p>
    <a href="{{ $activationUrl }}" style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">Activate Account</a>
    <p>This link will expire in 5 minutes.</p>
</body>
</html>
