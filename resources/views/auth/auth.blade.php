<x-layout>
    <script src="{{ asset("scripts/auth.js") }}"></script>
    <link rel="stylesheet" href="{{ asset("styles/auth.css") }}">
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-switch">
                <p onclick="form.login();">Login</p><p onclick="form.register();">Register</p>
            </div>
            <div class="hr"></div>
            {{-- login --}}
            <div class="auth-login auth-form-wrapper">
                <p class="auth-form-title">Login</p>
                <form method="POST" action="/login">
                    @csrf
                    {{-- email --}}
                    <label for="email">E-mail:</label>
                    <input type="email" placeholder="E-mail" name="email">
                    {{-- password --}}
                    <label for="password">Password:</label>
                    <input type="password" placeholder="Password" name="password">
                    {{-- POST button --}}
                    <input type="submit" value="Login">
                </form>
            </div>
            {{-- register --}}
            <div class="auth-register auth-form-wrapper">
                <p class="auth-form-title">Register</p>
                <form method="POST" action="/register">
                    @csrf
                    {{-- username --}}
                    <label for="username">Username:</label>
                    <input type="text" placeholder="Username" name="username">
                    {{-- email --}}
                    <label for="email">E-mail:</label>
                    <input type="email" placeholder="E-mail" name="email">
                    {{-- password --}}
                    <label for="password">Password:</label>
                    <input type="password" placeholder="Password" name="password">
                    {{-- repeat password --}}
                    <label for="passwordR">Repeat Password:</label>
                    <input type="password" placeholder="Repeat Password" name="passwordR">
                    {{-- POST button --}}
                    <input type="submit" value="Register">
                </form>
            </div>
        </div>
    </div>


    {{-- set choice to the correct side --}}
    @if($method == "login")
    {{-- login --}}
    <script>
        form.login();
    </script> 
    @else
    {{-- register --}}
    <script>
        form.register();
    </script>
    @endif


</x-layout>