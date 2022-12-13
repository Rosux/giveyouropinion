<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GYO - Give Your Opinion</title>
    <link rel="stylesheet" href="{{ asset('styles/main.css') }}">
    <script defer src="{{ asset('scripts/main.js') }}"></script>
    <script src="{{ asset("scripts/DarkMode-min.js") }}"></script>
</head>
<body>
    {{-- mobile header --}}
    <div class="mobile-header">
        <div class="mobile-button">
            {{-- mobile menu close button --}}
            <svg viewBox="0 0 24 24"><path d="m12 16.495c1.242 0 2.25 1.008 2.25 2.25s-1.008 2.25-2.25 2.25-2.25-1.008-2.25-2.25 1.008-2.25 2.25-2.25zm0-6.75c1.242 0 2.25 1.008 2.25 2.25s-1.008 2.25-2.25 2.25-2.25-1.008-2.25-2.25 1.008-2.25 2.25-2.25zm0-6.75c1.242 0 2.25 1.008 2.25 2.25s-1.008 2.25-2.25 2.25-2.25-1.008-2.25-2.25 1.008-2.25 2.25-2.25z"/></svg>
        </div>
        <div class="mobile-title"><a href="/">GYO</a></div>
        <div class="mobile-inner-wrapper">
            <div class="mobile-header-links">
                {{-- mobile header links --}}
                <a dark-mode-switch><svg width="24" height="24" viewBox="0 0 24 24"><path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12zm2 0c0-5.514 4.486-10 10-10v20c-5.514 0-10-4.486-10-10z"/></svg></a>
                <a href="/register">Register</a>
                <a href="/login">Login</a>
            </div>
        </div>
    </div>
    {{-- normal header --}}
    <header>
        <a href="/">GYO</a>
        <div class="header-links">
            {{-- normal header links --}}
            <a dark-mode-switch><svg width="24" height="24" viewBox="0 0 24 24"><path d="M0 12c0 6.627 5.373 12 12 12s12-5.373 12-12-5.373-12-12-12-12 5.373-12 12zm2 0c0-5.514 4.486-10 10-10v20c-5.514 0-10-4.486-10-10z"/></svg></a>
            <a href="/register">Register</a>
            <a href="/login">Login</a>
        </div>
        <div class="header-links-mobile-button">
            {{-- mobile menu open button --}}
            <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m12 16.495c1.242 0 2.25 1.008 2.25 2.25s-1.008 2.25-2.25 2.25-2.25-1.008-2.25-2.25 1.008-2.25 2.25-2.25zm0 1.5c.414 0 .75.336.75.75s-.336.75-.75.75-.75-.336-.75-.75.336-.75.75-.75zm0-8.25c1.242 0 2.25 1.008 2.25 2.25s-1.008 2.25-2.25 2.25-2.25-1.008-2.25-2.25 1.008-2.25 2.25-2.25zm0 1.5c.414 0 .75.336.75.75s-.336.75-.75.75-.75-.336-.75-.75.336-.75.75-.75zm0-8.25c1.242 0 2.25 1.008 2.25 2.25s-1.008 2.25-2.25 2.25-2.25-1.008-2.25-2.25 1.008-2.25 2.25-2.25zm0 1.5c.414 0 .75.336.75.75s-.336.75-.75.75-.75-.336-.75-.75.336-.75.75-.75z"/></svg>
        </div>
    </header>
    {{-- main content --}}
    <main>
        {{ $slot }}
    </main>
</body>
</html>