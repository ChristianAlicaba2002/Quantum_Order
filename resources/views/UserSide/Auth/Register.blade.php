<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quantum Order</title>
</head>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        min-height: 100vh;
        color: #333;
    }
    .box{
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 400px;
        padding: 40px;
        text-align: center;
    }
    h1{
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 24px;
        font-weight: 600;
    }
    p{
        color: #666;
        margin-bottom: 25px;
        font-size: 14px;
    }
    hr{
        border-top: 1px solid #eee;
        margin: 0 0 20px 0;
    }
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }
    .form-group input:focus {
        outline: none;
        border-color: #3498db;
        }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
        font-size: 14px;
    }
    .radio-group {
        margin: 10px 0;
    }
    .radio-option {
        display: inline-block;
        margin-right: 15px;
        font-size: 14px;
    }
    .radio-option input {
        margin-right: 5px;
    }
    .gender-label {
        display: inline; /* Inline display for radio buttons */
        margin-right: 10px; /* Spacing between options */
    }
    button {
        background-color: #FF8C00; /* Orange background for the button */
        color: white; /* White text */
        padding: 10px 20px; /* Button padding */
        border: none; /* No border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor on hover */
        margin-top: 20px; /* Space above button */
        transition: 0.3s; /* Smooth background color transition */
    }

    button:hover {
        background-color: #e07e00; /* Darken button on hover */
    }
    a {
        color: #007BFF; /* Blue link color */
        display: block; /* Make link a block level element */
        margin-top: 20px; /* Space above the link */
        text-decoration: none; /* Remove underline */
    }

    a:hover {
        text-decoration: underline; /* Underline link on hover */
    }
</style>
<body>
<div class="box">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account</p>
    <hr>
    <form action="{{ route('auth.register') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" name="firstName" placeholder="Enter firstName" required><br>
        </div>
        <div class="form-group">
            <input type="text" name="lastName" placeholder="Enter lastName" required><br>
        </div>
        <div class="form-group">
            <div class="radio-group">
                <label class="gender" for="gender">Gender</label><br>
                    <label for="male" class="radio-option">
                        <input type="radio" name="gender" value="Male" id="male" />
                        Male
                    </label>
                    <label for="female"class="radio-option">
                        <input type="radio" name="gender" value="Female" id="female" />
                        Female
                    </label>
                    <label for="other"class="radio-option">
                        <input type="radio" name="gender" value="Other" id="other" />
                        Prefer not to say
                    </label>
            </div>
        </div>
        <div class="form-group">
            <label for="">Address</label><br>
            <input type="text" name="address" list="addressList" placeholder="Choose Address" required><br>
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
            <input type="tel" name="phoneNumber"  placeholder="Mobile Number" maxlength="11" required><br>
            @if(session('error'))
                <script>alert("{{session('error')}}")</script>
            @endif
            @if(session('lengthError'))
                <script>alert("{{session('lengthError')}}")</script>
            @endif
        </div>

        <div class="form-group">
            <input type="text" name="username" placeholder="Username or Phone number" required><br>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Enter password" required><br>
            @if(session('passwordError'))
                <script>alert("{{session('passwordError')}}")</script>
            @endif
        </div>

        <div class="form-group">
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br>
        </div>

        <input type="file" name="image" hidden id="image">

        <div>
            <a href="/"> Already have an account ?</a>
        </div>

        <div>
            <button type="submit">Register</button>
        </div>

    </form>
</div>
</body>

</html>
