<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Quantum Order - Admin</title>
</head>

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

<body>

    @auth
        @include('AdminSide.Pages.Dashboard')
        @yield('Dashboard')
    @else

        @if (session('error'))
            <script>alert("{{session('error')}}")</script>
        @endif

        <div>
            <h1>Admin</h1>
            <p>Welcome</p>
            <form action="{{ route('auth.adminlogin') }}" method="post">
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
    </body>

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


</html>
