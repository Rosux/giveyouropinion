<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GYO - Give Your Opinion</title>
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
    <script defer src="{{ asset('scripts/main.js') }}"></script>
</head>
<body>
    <div class="mobile-header" style="display: none;">
        <div class="mobile-button">
            {{-- mobile close button --}}
            X
        </div>
        <div class="mobile-title"><a href="/">GYO</a></div>
        <div class="mobile-inner-wrapper">
            <div class="mobile-header-links">
                <a href="/register">Register</a>
                <a href="/login">Login</a>
            </div>
        </div>
    </div>
    <header>
        <a href="/">GYO</a>
        <div class="header-links">
            <a href="/register">Register</a>
            <a href="/login">Login</a>
        </div>
        <div class="header-links-mobile-button">
            {{-- mobile open button --}}
            X
        </div>
    </header>
    <main>
        {{ $slot }}
    </main>
</body>
</html>