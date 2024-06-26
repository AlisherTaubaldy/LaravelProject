<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<h1>Reset Password</h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ __($error) }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">
    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="password-confirm">Confirm Password:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required>
    <button type="submit">Reset Password</button>
</form>
</body>
</html>
