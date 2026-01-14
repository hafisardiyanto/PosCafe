<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Cafe POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <h2>Reset Password</h2>
        <p class="subtitle">
            Buat password baru anda
        </p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ request()->email }}" readonly>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-login">
                Reset Password
            </button>
        </form>

    </div>
</div>

</body>
</html>
