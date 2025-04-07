<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Quantum Order - Admin</title>
</head>


<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-box">
                <div class="logo">
                    <img src="assets/logo.jpg" alt="Quantum Order Logo">
                </div>
                <p style="text-align: center;">Please enter your credentials to access the <br> admin dashboard.</p>

                @if (session('error'))
                    <div class="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('auth.adminlogin') }}" method="post" class="log">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email address" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Enter password" required>
                        <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                    </div>
                    <button type="submit">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </button>
                </form>

                <div class="switch-link">
                    <a href="/">
                        <i class="fas fa-exchange-alt"></i>
                        Switch to User Login
                    </a>
                </div>
            </div>
        </div>
        <div class="login-right">
            <!-- Background image will be applied via CSS -->
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
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            }
        });
    </script>
</body>

</html>