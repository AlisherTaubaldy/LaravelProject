<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<p>Hello, {{ $user->name ?? '' }}</p>
<p>You are receiving this email because we received a request to reset your password for your account.</p>
<p>Click the button below to reset your password:</p>
<a href="{{ url('profile/password/reset', $token) }}">Reset Password</a>
<p>If you did not request a password reset, please ignore this email.</p>
</body>
</html>
