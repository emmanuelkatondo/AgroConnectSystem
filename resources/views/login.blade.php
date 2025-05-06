<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agro Market - Login & Register</title>
    <!-- Bootstrap -->
    <link href="/build/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/build/assets/icon/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: url('/build/assets/picha/bac.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            max-width: 700px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .form-header {
            background: #1d3557;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .form-slider {
            display: flex;
            width: 200%;
            transition: transform 0.5s ease-in-out;
        }
        .form-box {
            width: 50%;
            padding: 30px;
            background: rgba(0, 0, 0, 0.7);
        }
        .form-box h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
            font-weight: bold;
        }
        .form-box .form-control {
            margin-bottom: 15px;
            border: none;
            border-bottom: 2px solid #1d3557;
            border-radius: 0;
            background: transparent;
            color: #fff;
            font-size: 1rem;
        }
        .form-box .form-control::placeholder {
            color: #fff;
            font-size: 1.1rem;
        }
        .form-box .form-control:focus {
            box-shadow: none;
            border-bottom: 2px solid #457b9d;
        }
        .form-box .btn {
            margin-top: 10px;
            border-radius: 8px;
            font-weight: bold;
            padding: 10px 15px;
        }
        .form-box .btn-primary {
            background: #1d3557;
            border: none;
        }
        .form-box .btn-primary:hover {
            background: #457b9d;
        }
        .form-box .btn-success {
            background: #28a745;
            border: none;
        }
        .form-box .btn-success:hover {
            background: #218838;
        }
        .form-switch {
            text-align: center;
            margin-top: 15px;
        }
        .form-switch button {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .form-switch button:hover {
            text-decoration: underline;
        }
        .form-control-icon {
            position: relative;
        }
        .form-control-icon input {
            padding-left: 40px;
        }
        .form-control-icon i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: rgb(50, 212, 42);
        }
        button {
            color: #fff;
        }
        #region,#district,#ward{
            background-color:  #1d3557;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        Welcome to Agro Market
    </div>
    <div id="formSlider" class="form-slider">
        <!-- Login Form -->
        <div class="form-box">
            <h3>Login</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-control-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-control-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>
            <div class="form-switch">
                <p>Don't have an account? <button type="button" onclick="slideToRegister()">Register</button></p>
            </div>
            <button class="btn btn-primary text-center"><a href="{{ route('home') }}" style="color: #fff; text-decoration: none;">Backhome</a></button>
        </div>

        <!-- Register Form -->
        <div class="form-box">
            <h3>Register</h3>
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input name="first_name" id="first_name" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col-md-6">
                        <input name="last_name" id="last_name" class="form-control" placeholder="Last Name" required>
                    </div>
                </div>
                <input name="email" id="email" type="email" class="form-control" placeholder="Email (Gmail only)" required>
                <input name="phone" id="phone" type="text" class="form-control" placeholder="Phone Number (Tanzania only)" required>
                <div>
                    <label for="password" class="password-format" onclick="showPasswordFormat()">Password Format</label>
                    <input name="password" id="password" type="password" class="form-control" placeholder="Password" required>
                </div>
                <div>
                    <label>Select Region</label>
                    <select name="region_id" id="region" class="form-control" required>
                        <option value="">-- Choose Region --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Select District</label>
                    <select name="district_id" id="district" class="form-control" required disabled>
                        <option value="">-- Choose District --</option>
                    </select>
                </div>
                <div>
                    <label>Select Ward</label>
                    <select name="ward_id" id="ward" class="form-control" required disabled>
                        <option value="">-- Choose Ward --</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            <div class="form-switch">
                <p>Already have an account? <button type="button" onclick="slideToLogin()">Login</button></p>
            </div>
        </div>
    </div>
</div>

<script>
    const formSlider = document.getElementById('formSlider');

    function slideToRegister() {
        formSlider.style.transform = 'translateX(-50%)';
    }

    function slideToLogin() {
        formSlider.style.transform = 'translateX(0)';
    }

    // Show password format requirements
    function showPasswordFormat() {
        alert("Password must be at least 4 characters long and include:\n- Uppercase letters\n- Lowercase letters\n- Numbers\n- Special characters");
    }

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const password = document.getElementById('password').value.trim();

        // Name validation
        const nameRegex = /^[A-Za-z]{3,20}$/;
        if (!nameRegex.test(firstName) || !nameRegex.test(lastName)) {
            alert("Names must contain only letters and be between 3 and 20 characters.");
            e.preventDefault();
            return;
        }

        // Email validation
        const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
        if (!emailRegex.test(email)) {
            alert("Email must be a valid Gmail address.");
            e.preventDefault();
            return;
        }

        // Phone number validation
        const phoneRegex = /^(?:\+255|0)(6|7)\d{8}$/;
        if (!phoneRegex.test(phone)) {
            alert("Phone number must be valid and from Vodacom, Airtel, Tigo, or Halotel.");
            e.preventDefault();
            return;
        }

        // Password validation
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{4,}$/;
        if (!passwordRegex.test(password)) {
            alert("Password must be at least 4 characters long and include uppercase, lowercase, numbers, and special characters.");
            e.preventDefault();
            return;
        }
    });

    // Fetch districts and wards dynamically
    document.addEventListener('DOMContentLoaded', function () {
        const regionSelect = document.getElementById('region');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        regionSelect.addEventListener('change', function () {
            const regionId = this.value;
            districtSelect.innerHTML = '<option value="">-- Choose District --</option>';
            wardSelect.innerHTML = '<option value="">-- Choose Ward --</option>';
            districtSelect.disabled = true;
            wardSelect.disabled = true;

            if (regionId) {
                fetch(`/districts/${regionId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(district => {
                            districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                        });
                        districtSelect.disabled = false;
                    });
            }
        });

        districtSelect.addEventListener('change', function () {
            const districtId = this.value;
            wardSelect.innerHTML = '<option value="">-- Choose Ward --</option>';
            wardSelect.disabled = true;

            if (districtId) {
                fetch(`/wards/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(ward => {
                            wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                        });
                        wardSelect.disabled = false;
                    });
            }
        });
    });
</script>

</body>
</html>