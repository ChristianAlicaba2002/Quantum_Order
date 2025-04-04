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
        body{
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box{
            background-color: #ffffff;
            padding: 80px;
            width: 28%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        h1{
            color: orange;
            margin: 0;
        }
        p{
            margin: 10px 0 20px;
        }
        .log{
            display: flex;
            flex-direction: column;
        }
        input {
            padding: 15px;
            width: 90%;
            margin: 10px 0;
            border: 1px solid #cccccc;
            border-radius: 5px;
            background-color:rgb(218, 215, 215);
        }
        button{
            padding: 10px;
            width: 40%;
            background-color: orange;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        button:hover {
            background-color: #EC5228;
            transition: 0.3s;
        }
        a.create{
            color:blue;
            margin-bottom: 20px;
        }
        a{
            text-decoration: none;
            color: black;
        }
        a:hover{
            text-decoration: underline;
        }
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
        @include('UserSide.Layouts.HomePage')
    @else
    <div class="box">
        <h1>Quantum Order</h1>
        <p>Log in to continue</p>
        @if (session('error'))
            <label style="color: red" for="">{{session('error')}}</label>
        @endif
        @if(session('isEmpty'))
            <label style="color: red" for="">{{session('isEmpty')}}</label>
        @endif
        <form action="{{ route('auth.login') }}" method="post" class="log">
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
                <div>
                    <button type="submit">Login</button>
                </div>
            <a class="create" href="/Register">Create new account</a>
            

            <div>
                <a href="{{ route('AdminLogin') }}">Switch to Admin</a>
            </div>
        </form>
    </div>
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
