<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/UserLogin.css') }}">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Quantum Order</title>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
        </div>
        <div class="login-right">
            <div class="login-box">
                <div class="logo">
                    <img src="assets/logo.jpg" alt="Quantum Order Logo">
                </div>
                <p style="text-align: center;">Log in your account to continue</p>

                <form action="{{ route('auth.login') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="username" id="username" placeholder="Username or Phone number">
                        <i class="fas fa-user"></i>
                        @if (session('isUsernameEmpty'))
                        <span style="color: red; font-size: .80rem">{{ session('isUsernameEmpty') }}</span>
                        @endif
                        @if (session('error'))
                        <span style="color: red; font-size: .80rem">{{ session('error') }}</span>
                        @endif
                        @if(session('isEmpty'))
                        <span style="color: red; font-size: .80rem">{{ session('isEmpty') }}</span>
                        @endif
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Enter password">
                        <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                        @if (session('isPasswordEmpty'))
                        <span style="color: red; font-size: .80rem">{{ session('isPasswordEmpty') }}</span>
                        @endif
                        @if(session('isEmpty'))
                        <span style="color: red; font-size: .80rem">{{ session('isEmpty') }}</span>
                        @endif
                    </div>

                    <button type="submit">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </button>

                    <div class="links">
                        <a href="/Register">
                            <i class="fas fa-user-plus"></i>
                            Create new account
                        </a>
                        <a href="{{ route('AdminLogin') }}">
                            <i class="fas fa-exchange-alt"></i>
                            Switch to Admin
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

        // Auto-hide alert after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>

</html>