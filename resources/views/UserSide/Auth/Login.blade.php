<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Quantum Order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .password-container {
            position: relative;
            display: inline-block;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    @auth

        @include('UserSide.Layouts.MainPage')
        
    @else
        <h1>Quantum Order</h1>
        <p>Log into Quantum Order</p>
        @if (session('error'))
            <label style="color: red" for="">{{session('error')}}</label>
        @endif
        @if(session('isEmpty'))
            <label style="color: red" for="">{{session('isEmpty')}}</label>
        @endif
        <form action="{{ route('auth.login') }}" method="post">
            @csrf

            <div>
                <input type="text" name="username" placeholder="Username or Phone number"><br>
                @if (session('isUsernameEmpty'))
                    <label style="color: red" for="">{{session('isUsernameEmpty')}}</label>
                @endif
            </div>

            <div class="password-container">
                <input type="password" name="password" id="password" placeholder="Enter password">
                <i class="toggle-password fas fa-eye-slash" onclick="togglePassword()"></i>
            </div><br>
            @if (session('isPasswordEmpty'))
                <label style="color: red" for="">{{session('isPasswordEmpty')}}</label>
            @endif

            <a href="/Register">Create new account</a>
            <div>
                <button type="submit">Login</button>
            </div>

            <div>
                <a href="{{ route('AdminLogin') }}">Switch to Admin</a>
            </div>
        </form>
    @endauth

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>

</html>
