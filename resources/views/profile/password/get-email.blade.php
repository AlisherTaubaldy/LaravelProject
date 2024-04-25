<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<h1>Reset Password</h1>
<form method="POST" action="{{ route('password.request') }}">
    @csrf
    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Send Reset Link</button>
</form>
</body>
</html>
