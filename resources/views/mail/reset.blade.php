<h1>Reset Your Password</h1>
<p>We received a request to reset your password. Click the link below to set a new password:</p>
<a href="{{ url('/profile/password/reset/' . $token) }}">Reset Password</a>
<p>This link will expire in 60 minutes.</p>

<p>If you did not request a password reset, please ignore this email.</p>
