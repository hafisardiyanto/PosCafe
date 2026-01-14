<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Cafe POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <h2>Login Cafe POS</h2>
        <p class="subtitle">Silakan login untuk melanjutkan</p>

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@example.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            {{-- LINK FORGOT PASSWORD --}}
    <div class="forgot-password">
        <a href="{{ route('password.request') }}">
            Lupa Password?
        </a>
    </div>

            <button type="submit" class="btn-login">
                Login
            </button>
        </form>

        <p class="footer-text">
            © {{ date('Y') }} Cafe POS
        </p>

    </div>
</div>

</body>
</html>
