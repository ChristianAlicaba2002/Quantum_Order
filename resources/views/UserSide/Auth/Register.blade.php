<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quantum Order</title>
</head>

<body>
    @if (session('error'))
        <script>alert("{{session('error')}}")</script>
    @endif
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account</p>
    <hr>
    <form action="{{ route('auth.register') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <input type="text" name="firstName" placeholder="Enter firstName" required><br>
        </div>
        <div>
            <input type="text" name="lastName" placeholder="Enter lastName" required><br>
        </div>
        <div>
            <label for="gender">Gender</label><br>
            <label for="male">
                <input type="radio" name="gender" value="Male" id="male" />
                Male
            </label>
            <label for="female">
                <input type="radio" name="gender" value="Female" id="female" />
                Female
            </label>
            <label for="other">
                <input type="radio" name="gender" value="Other" id="other" />
                Prefer not to say
            </label>
        </div>
        <div>
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

        <div>
            <input type="tel" name="phoneNumber" placeholder="Mobile Number" maxlength="11" required><br>
        </div>

        <div>
            <input type="text" name="username" placeholder="Username or Phone number" required><br>
        </div>

        <div>
            <input type="password" name="password" placeholder="Enter password" required><br>
        </div>

        <div>
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
</body>

</html>
