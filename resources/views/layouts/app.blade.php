<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="{{ asset('css/user-form.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed
    @auth
        role-{{ Auth::user()->role }}
    @endauth
">

@include('layouts.navbar')

<div id="layoutSidenav">
    @include('layouts.sidebar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </main>

        @include('layouts.footer')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

@stack('scripts')
</body>
</html>
