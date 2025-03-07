<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{ Auth::user()->firstName }} Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #ff6b00;
            --light-orange: #fff0e6;
            --dark-orange: #cc5500;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #fcfcfc;
            margin: 0;
            padding: 24px;
            color: #2c2c2c;
            line-height: 1.5;
        }

        .back-link {
            color: var(--primary-orange);
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .user-info-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        .OrderSummary {
            max-width: 900px;
            margin: 0 auto;
            background: rgb(243, 243, 243);
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        }

        h2 {
            font-size: 20px;
            margin-bottom: 32px;
            color: var(--primary-orange);
            border-bottom: 2px solid var(--light-orange);
            padding-bottom: 12px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .info-group {
            margin-bottom: 0;
        }

        label {
            font-size: 13px;
            color: #666;
            margin-bottom: 4px;
            display: block;
        }

        p {
            font-size: 15px;
            color: #2c2c2c;
            background: #fafafa;
            padding: 10px 12px;
            margin: 0 0 4px 0;
            border-radius: 6px;
            border-left: 2px solid var(--primary-orange);
        }

        .info-message {
            font-size: 11px;
            color: #888;
            margin-top: 4px;
            font-style: italic;
        }

        button {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        button:hover {
            background: var(--dark-orange);
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(2px);
            padding-top: 5rem;
        }

        .modal-content {
            background: white;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 12px;
            position: relative;
        }

        .edit-form {
            display: grid;
            gap: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        input[type="text"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 8px 0;
            border: none;
            border-bottom: 1px solid #ddd;
            border-radius: 0;
            font-size: 14px;
            background: transparent;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        select:focus {
            outline: none;
            border-bottom-color: var(--primary-orange);
        }

        .close-modal {
            position: absolute;
            right: 16px;
            top: 16px;
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 4px;
        }

        #previewImage {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .full-width {
            grid-column: 1 / -1;
            /* margin-left: 19rem; */
        }

        .image-upload-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        .btn-cancel {
            background-color: white;
            color: black;
            border: 1px solid black;
        }

        .btn-cancel:hover {
            background-color: var(--primary-orange);
            color: rgb(255, 255, 255);
            border: 1px solid transparent;
        }

        .profile-section {
            display: flex;
            gap: 24px;
            margin-bottom: 32px;
            padding: 20px;
            background: var(--light-orange);
            border-radius: 12px;
            align-items: center;
        }

        .profile-image {
            flex-shrink: 0;
        }

        .profile-names {
            display: flex;
            flex-direction: row;
            gap: 24px;
            flex: 1;
        }

        .profile-names .info-group {
            flex: 1;
            min-width: 0;
        }

        .info-layout {
            display: flex;
            gap: 32px;
            margin-top: 24px;
        }

        .profile-side {
            flex: 1;
            min-width: 300px;
        }

        .details-side {
            flex: 2;
            background: var(--light-gray);
            padding: 20px;
            border-radius: 12px;
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding: 20px;
            background: rgba(223, 223, 223, 0.297);
            border-radius: 12px;
        }

        .profile-image {
            text-align: center;
        }

        .profile-names {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .edit-icon {
            color: var(--primary-orange);
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .edit-icon:hover {
            color: var(--dark-orange);
        }
    </style>
</head>

<body>

    @foreach ($users as $user)
        <div>
            <div>
                <a href="{{ route('login') }}" class="back-link">Back to Home</a>
            </div>
            <div class="user-info-container">
                <h2>User Information</h2>


                <div class="info-layout">
                    <div class="profile-side">
                        <div class="profile-section">
                            <div class="profile-image">
                                <img src="{{ asset('/images/' . $user->image) }}"
                                    alt="{{ $user->firstName }}'s profile picture"
                                    style="width: 120px; height: 100px; object-fit: cover; border-radius: 50%;">
                            </div>
                            <div class="profile-names">
                                <div class="info-group">
                                    <label>Full Name</label>
                                    <p>{{ $user->firstName }} {{ $user->lastName }}</p>
                                    <span class="info-message">Your complete name as it appears on official
                                        documents</span>
                                </div>
                            </div>
                        </div>

                        <?php
                        $UserOrders = DB::table('orders')
                            ->where('userId', Auth::user()->userId)
                            ->get();
                        
                        $CancelledOrder = DB::table('orders')
                            ->where('userId', Auth::user()->userId)
                            ->where('orderStatus', 'Declined')
                            ->get();
                        
                        $DeliveredOrder = DB::table('orders')
                            ->where('userId', Auth::user()->userId)
                            ->where('orderStatus', 'Delivered')
                            ->get();
                        
                        ?>
                        <div class="OrderSummary">
                            @if ($UserOrders->count() > 0)
                                <label style="font-weight: bolder; font-size:1.2rem;">Order Summary</label>
                                <label for="">Total Orders: {{ $UserOrders->count() }}</label>
                            @endif
                            @if ($CancelledOrder->count() > 0)
                                <label for="">Cancelled: {{ $CancelledOrder->count() }}</label>
                            @endif
                            @if ($DeliveredOrder->count() > 0)
                                <label for="">Delivered: {{ $DeliveredOrder->count() }}</label>
                            @endif
                        </div>


                    </div>



                    <div class="details-side">
                        <div class="info-grid">
                            <div class="info-group">
                                <label>Gender</label>
                                <p>{{ $user->gender }}</p>
                                <span class="info-message">Your identified gender for demographic purposes</span>
                            </div>

                            <div class="info-group">
                                <label>Phone number</label>
                                <p>{{ $user->PhoneNumber }}</p>
                                <span class="info-message">Primary contact number for account verification and
                                    updates</span>
                            </div>

                            <div class="info-group">
                                <label>Username</label>
                                <p>{{ $user->username }}</p>
                                <span class="info-message">Your unique identifier for logging into the system</span>
                            </div>

                            <div class="info-group">
                                <label>Password</label>
                                <p>********</p>
                                <span class="info-message">Your secret key for accessing your account</span>
                            </div>

                            <div class="info-group">
                                <label>Address</label>
                                <p>{{ $user->address }}</p>
                                <span class="info-message">Your current residential address for delivery and
                                    contact</span>
                            </div>

                        </div>

                    </div>
                    <div class="full-width">
                        <i class="fas fa-edit edit-icon"
                            onclick="EditInformation('{{ $user->userId }}','{{ $user->firstName }}','{{ $user->lastName }}','{{ $user->gender }}','{{ $user->address }}','{{ $user->PhoneNumber }}','{{ $user->username }}','{{ $user->image }}')"></i>
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    @if (session('error'))
        <script>
            alert("{{ session('error') }}")
        </script>
    @endif

    @if (session('success'))
        <script>
            alert("{{ session('success') }}")
        </script>
    @endif


    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeEditForm()">&times;</span>
            <form id="EditUserForm" action="" method="post" enctype="multipart/form-data" class="edit-form">
                @csrf
                @method('PUT')
                <input type="text" id="EditUserId" name="userId" hidden>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="EditFirstname">First name</label>
                        <input type="text" id="EditFirstname" name="firstName" required>
                    </div>

                    <div class="form-group">
                        <label for="EditLastname">Last name</label>
                        <input type="text" id="EditLastname" name="lastName" required>
                    </div>

                    <div class="form-group">
                        <label for="EditGender">Gender</label>
                        <select name="gender" id="EditGender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="EditPhoneNumber">Phone number</label>
                        <input type="tel" name="phoneNumber" maxlength="11" id="EditPhoneNumber" pattern="[0-9]{11}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="EditUsername">Username</label>
                        <input type="text" name="username" id="EditUsername" readonly disabled>
                    </div>

                    <div class="form-group">
                        <label for="EditAddress">Address</label>
                        <input type="text" name="address" list="addressList" id="EditAddress"
                            placeholder="Choose Address" required>
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
                </div>

                <div class="form-group full-width">
                    <label for="imageUpload">Profile Picture</label>
                    <div class="image-upload-container">
                        <img id="previewImage" src="{{ asset('/images/default.jpg') }}" alt="Profile preview">
                        <input type="file" id="imageUpload" name="image" accept="image/*"
                            class="form-control">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Save Changes</button>
                    <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const previewImage = document.getElementById("previewImage");

        document.querySelector('input[type="file"]').addEventListener("change", function(event) {
            if (this.files && this.files[0]) {
                const file = this.files[0];

                const objectUrl = URL.createObjectURL(file);

                // Update preview image
                previewImage.onload = () => {
                    URL.revokeObjectURL(objectUrl);
                };
                previewImage.src = objectUrl;

                // Store filename if needed
                const filename = file.name;
                console.log(filename);
            }
        });


        function EditInformation(userId, firstName, lastName, gender, address, phoneNumber, username, image) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('EditUserForm').action = `/UpdateInformationUser/${userId}`;
            document.getElementById('EditUserId').value = userId;
            document.getElementById('EditFirstname').value = firstName;
            document.getElementById('EditLastname').value = lastName;
            document.getElementById('EditGender').value = gender;
            document.getElementById('EditAddress').value = address;
            document.getElementById('EditPhoneNumber').value = phoneNumber;
            document.getElementById('EditUsername').value = username;
            document.getElementById('previewImage').src = "{{ asset('/images/') }}/" + image;
            document.getElementById('previewImage').alt = `${firstName}'s picture`;
        }

        function closeEditForm() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditForm();
            }
        }
    </script>
</body>

</html>
