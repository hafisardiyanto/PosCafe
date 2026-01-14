<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password | Cafe POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <h2>Lupa Password</h2>
        <p class="subtitle">
            Masukkan email yang terdaftar untuk reset password
        </p>

        {{-- Status sukses --}}
        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- Error --}}
        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="email@example.com" required>
            </div>

            <button type="submit" class="btn-login">
                Kirim Link Reset
            </button>
        </form>

        <p class="footer-text">
            <a href="{{ route('login') }}">← Kembali ke Login</a>
        </p>

    </div>
</div>

</body>
</html>
