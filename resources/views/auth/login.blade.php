<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>

    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>

    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #2f363e;
        }

        .container {
            position: relative;
            max-width: 350px;
            min-height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #2f363e;
            box-shadow: 25px 25px 75px rgba(0,0,0,0.25),
                10px 10px 70px rgba(0,0,0,0.25),
                inset 5px 5px 10px rgba(0,0,0,0.5),
                inset 5px 5px 20px rgba(255,255,255,0.2),
                inset -5px -5px 15px rgba(0,0,0,0.75);
            border-radius: 30px;
            padding: 50px;
        }

        form {
            position: relative;
            width: 100%;
        }

        .container h3 {
            color: #fff;
            font-weight: 600;
            font-size: 2em;
            width: 100%;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .inputBox {
            position: relative;
            width: 100%;
            margin-bottom: 20px;
        }

        .inputBox span {
            display: inline-block;
            color: #fff;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75em;
            border-left: 4px solid #fff;
            padding-left: 4px;
            line-height: 1em;
        }

        .inputBox .box {
            display: flex;
        }

        .inputBox .box .icon {
            position: relative;
            min-width: 40px;
            height: 40px;
            background: #ff2c74;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            margin-right: 10px;
            color: #fff;
            font-size: 1.15em;
            box-shadow: 5px 5px 7px rgba(0,0,0,0.25),
                inset 2px 2px 5px rgba(255,255,255,0.25),
                inset -3px -3px 5px rgba(0,0,0,0.5);
        }

        .inputBox .box input {
            position: relative;
            width: 100%;
            border: none;
            outline: none;
            padding: 10px 20px;
            border-radius: 30px;
            letter-spacing: 1px;
            font-size: 0.85em;
            box-shadow: 5px 5px 7px rgba(0,0,0,0.25),
                inset 2px 2px 5px rgba(0,0,0,0.35),
                inset -3px -3px 5px rgba(0,0,0,0.5);
        }

        .inputBox .box input[type="submit"] {
            background: #1f83f2;
            box-shadow: 5px 5px 7px rgba(0,0,0,0.25),
                inset 2px 2px 5px rgba(255,255,255,0.25),
                inset -3px -3px 5px rgba(0,0,0,0.5);
            color: #fff;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            margin-top: 10px;
        }

        .inputBox .box input[type="submit"]:hover {
            filter: brightness(1.1);
        }

        label {
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85em;
            display: flex;
            align-items: center;
        }

        label input{
            margin-right: 5px;
        }

        .forgot {
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85em;
            text-decoration: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h3>Log In</h3>
            <div class="inputBox">
                <span>Username</span>
                <div class="box">
                    <div class="icon"><ion-icon name="person"></ion-icon></div>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="inputBox">
                <span>Password</span>
                <div class="box">
                    <div class="icon"><ion-icon name="lock-closed"></ion-icon></div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <label>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
            </label>
            <div class="inputBox">
                <div class="box">
                    <input type="submit" value="Log In">
                </div>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">{{ __('Forgot Password?') }}</a>
            @endif
            
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>