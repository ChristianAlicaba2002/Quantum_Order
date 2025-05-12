<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/UserRegister.css') }}">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Quantum Order</title>
</head>

<body>
    <div id="loader" style="display: none;">
        <div class="spinner"></div>
    </div>
    <div class="register-container">
        <div class="register-left">
            <!-- Background image will be applied via CSS -->
        </div>
        <div class="register-right">
            <div class="register-box">
                <div class="logo">
                    <img src="assets/logo.jpg" alt="Quantum Order Logo">
                </div>
                <p style="text-align:center">Please fill in this form to create an account</p>

                @if(session('error'))
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if(session('lengthError'))
                <div class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('lengthError') }}</span>
                </div>
                @endif


                <form class="form-controller" action="{{ route('auth.register') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <div class="input-group">
                            <input type="text" name="firstName" id="firstName" placeholder="Enter first name" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <div class="input-group">
                            <input type="text" name="lastName" id="lastName" placeholder="Enter last name" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="gender" value="Male" required>
                                <i class="fas fa-male"></i>
                                Male
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="gender" value="Female" required>
                                <i class="fas fa-female"></i>
                                Female
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="gender" value="Other" required>
                                <i class="fas fa-user"></i>
                                Prefer not to say
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <div class="input-group">
                            <input type="text" name="address" id="address" list="addressList" placeholder="Choose Address" required>
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <datalist id="addressList">
                            <option value="Alcantara, Cebu">Alcantara, Cebu</option>
                            <option value="Alcoy, Cebu">Alcoy, Cebu</option>
                            <option value="Alegria, Cebu">Alegria, Cebu</option>
                            <option value="Argao, Cebu">Argao, Cebu</option>
                            <option value="Asturias, Cebu">Asturias, Cebu</option>
                            <option value="Badian, Cebu">Badian, Cebu</option>
                            <option value="Balamban, Cebu">Balamban, Cebu</option>
                            <option value="Bantayan, Cebu">Bantayan, Cebu</option>
                            <option value="Barili, Cebu">Barili, Cebu</option>
                            <option value="Bogo, Cebu">Bogo, Cebu</option>
                            <option value="Boljoon, Cebu">Boljoon, Cebu</option>
                            <option value="Borbon, Cebu">Borbon, Cebu</option>
                            <option value="Carcar, Cebu">Carcar, Cebu</option>
                            <option value="Carmen, Cebu">Carmen, Cebu</option>
                            <option value="Catmon, Cebu">Catmon, Cebu</option>
                            <option value="Cebu City, Cebu">Cebu City, Cebu</option>
                            <option value="Compostela, Cebu">Compostela, Cebu</option>
                            <option value="Consolacion, Cebu">Consolacion, Cebu</option>
                            <option value="Cordova, Cebu">Cordova, Cebu</option>
                            <option value="Dalaguete, Cebu">Dalaguete, Cebu</option>
                            <option value="Danao, Cebu">Danao, Cebu</option>
                            <option value="Dumanjug, Cebu">Dumanjug, Cebu</option>
                            <option value="Ginatilan, Cebu">Ginatilan, Cebu</option>
                            <option value="Liloan, Cebu">Liloan, Cebu</option>
                            <option value="Lapu-Lapu, City">Lapu-Lapu, City</option>
                            <option value="Madridejos, Cebu">Madridejos, Cebu</option>
                            <option value="Mandaue, Cebu City">Mandaue, Cebu City</option>
                            <option value="Minglanilla, Cebu">Minglanilla, Cebu</option>
                            <option value="Moalboal, Cebu">Moalboal, Cebu</option>
                            <option value="Oslob, Cebu">Oslob, Cebu</option>
                            <option value="Pilar, Cebu">Pilar, Cebu</option>
                            <option value="Pinamungahan, Cebu">Pinamungahan, Cebu</option>
                            <option value="Poro, Cebu">Poro, Cebu</option>
                            <option value="Ronda, Cebu">Ronda, Cebu</option>
                            <option value="San Fernando, Cebu">San Fernando, Cebu</option>
                            <option value="San Francisco, Cebu">San Francisco, Cebu</option>
                            <option value="San Remigio, Cebu">San Remigio, Cebu</option>
                            <option value="Santa Fe, Cebu">Santa Fe, Cebu</option>
                            <option value="Santander, Cebu">Santander, Cebu</option>
                            <option value="Sibonga, Cebu">Sibonga, Cebu</option>
                            <option value="Sogod, Cebu">Sogod, Cebu</option>
                            <option value="Tabogon, Cebu">Tabogon, Cebu</option>
                            <option value="Tabuelan, Cebu">Tabuelan, Cebu</option>
                            <option value="Talisay, Cebu">Talisay, Cebu</option>
                            <option value="Toledo, Cebu">Toledo, Cebu</option>
                            <option value="Tuburan, Cebu">Tuburan, Cebu</option>
                            <option value="Tudela, Cebu">Tudela, Cebu</option>
                            <option value="Tugbong, Cebu">Tugbong, Cebu</option>
                            <option value="Ulat, Cebu">Ulat, Cebu</option>
                            <option value="Umas, Cebu">Umas, Cebu</option>
                            <option value="Ubay, Cebu">Ubay, Cebu</option>
                            <option value="Valencia, Cebu">Valencia, Cebu</option>
                            <option value="Valladolid, Cebu">Valladolid, Cebu</option>
                            <option value="Zambujal, Cebu">Zambujal, Cebu</option>
                        </datalist>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Mobile Number</label>
                        <div class="input-group">
                            <input type="tel" name="phoneNumber" id="phoneNumber" placeholder="Mobile Number" maxlength="11" required>
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <input type="text" name="username" id="username" placeholder="Username or Phone number" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" placeholder="Enter password" required>
                            <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('password')"></i>
                            @if(session('PassNotMatch'))
                            <div class="alert">
                                <!-- <i class="fas fa-exclamation-circle"></i> -->
                                <span>{{ session('PassNotMatch') }}</span>
                                <script>
                                    alert("{{session('PassNotMatch')}}")
                                </script>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
                            <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('confirmPassword')"></i>
                        </div>
                    </div>

                    <input type="file" name="image" hidden id="image">

                    <button type="submit">
                        <i class="fas fa-user-plus"></i>
                        Register
                    </button>

                    <div class="links">
                        <a href="/">
                            <i class="fas fa-sign-in-alt"></i>
                            Already have an account?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = passwordInput.nextElementSibling;

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
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });


        document.querySelector('.form-controller').addEventListener('submit', function() {
            document.getElementById('loader').style.display = 'flex';
        });
    </script>
</body>

</html>