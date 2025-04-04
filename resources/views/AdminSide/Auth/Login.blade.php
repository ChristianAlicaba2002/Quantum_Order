<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Quantum Order - Admin</title>
</head>

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
            margin-left: 30%;
            font-size: 15px;
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

<body>
    @auth('admin')
        @include('AdminSide.Layouts.Dashboard')
        @yield('Dashboard')
    @else
        @if (session('error'))
            <script>alert("{{session('error')}}")</script>
        @endif

        <div class="box">
            <h1>Admin</h1>
            <p>Welcome</p>
            <form action="{{ route('auth.adminlogin') }}" method="post" class="log">
                @csrf
                <div>
                    <input type="text" name="email" placeholder="Email">
                </div>
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Enter password" required>
                    <i class="toggle-password fas fa-eye-slash" onclick="togglePassword()"></i>
                </div><br>
                <button type="submit">Login</button>
                <a href="/">Switch to User</a>
            </form>
        </div>
    @endauth
</body>

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

</html>