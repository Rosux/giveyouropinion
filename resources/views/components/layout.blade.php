<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GYO - Give Your Opinion</title>
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
</head>
<body>
    <header>
        <a href="/">GYO</a>
        <div class="header-links">
            <a href="/register">Register</a>
            <a href="/login">Login</a>
        </div>
    </header>
    <main>
        {{ $slot }}
    </main>
</body>
</html>