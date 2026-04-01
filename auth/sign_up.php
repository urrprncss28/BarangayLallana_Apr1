<?php
session_start();

// --- DATABASE CONFIGURATION ---
$host = "localhost";
$db_user = "root";      // Default XAMPP user
$db_pass = "";          // Default XAMPP password
$db_name = "barangay_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if(isset($_POST['signup'])){
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $suffix = $_POST['suffix'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $civil_status = $_POST['civil_status'];
    $birthday = $_POST['birthday'];
    $sex = $_POST['sex'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password !== $confirm_password){
        $message = "Error: Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $message = "Error: Email is already registered!";
        } else {
            // Secure Password Hashing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert = $conn->prepare("INSERT INTO users (firstname, middlename, lastname, suffix, email, contact, civil_status, birthday, sex, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("ssssssssss", $firstname, $middlename, $lastname, $suffix, $email, $contact, $civil_status, $birthday, $sex, $hashed_password);

            if($insert->execute()){
                $message = "Account created successfully! Redirecting to login...";
                header("refresh:2; url=login.php");
            } else {
                $message = "Error: Something went wrong. Please try again.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barangay Lallana</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Consistent Background Image */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                              url('assets/lallana.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .auth-container {
            max-width: 900px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }

        .header-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .barangay-logo {
            width: 70px;
            height: auto;
        }

        h2 {
            margin: 0;
            font-size: 26px;
            color: #005f73;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* GRID LAYOUT */
        .grid-4, .grid-3, .grid-2 { display: grid; gap: 20px; margin-bottom: 15px; }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }

        @media (max-width: 768px) {
            .grid-4, .grid-3, .grid-2 { grid-template-columns: 1fr; }
            .auth-container { padding: 25px; }
        }

        label {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 5px;
            display: block;
            color: #444;
            text-transform: uppercase;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            background: #fff;
            transition: 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #0a9396;
            box-shadow: 0 0 5px rgba(10, 147, 150, 0.2);
        }

        .radio-group { display: flex; gap: 20px; padding-top: 5px; }

        .terms-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        button[name="signup"] {
            background: #0a9396;
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
        }

        button[name="signup"]:hover { 
            background: #005f73; 
            transform: translateY(-2px);
        }

        .login-link { text-align: center; margin-top: 20px; font-size: 15px; }
        .login-link a { color: #0a9396; text-decoration: none; font-weight: bold; }

        .status-msg {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }

        /* MODAL STYLES */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal { background: white; padding: 30px; width: 90%; max-width: 600px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    </style>

    <script>
        function openTerms(){ document.getElementById("termsModal").style.display = "flex"; }
        function closeTerms(){ document.getElementById("termsModal").style.display = "none"; }
        
        function validateForm(){
            if(!document.getElementById("agree").checked){
                alert("Please agree to the Terms and Conditions.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="auth-container">
    <div class="header-section">
        <img src="assets/logo_nobg.png" alt="Barangay Logo" class="barangay-logo">
        <h2>Resident Registration</h2>
    </div>

    <?php if($message): ?>
        <div class="status-msg" style="background: <?php echo strpos($message, 'successfully') !== false ? '#d4edda; color: #155724;' : '#f8d7da; color: #721c24;'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm()">
        <div class="grid-4">
            <div><label>First name</label><input type="text" name="firstname" placeholder="Juan" required></div>
            <div><label>Middle name</label><input type="text" placeholder="Santos" name="middlename"></div>
            <div><label>Last name</label><input type="text" placeholder="Dela Cruz" name="lastname" required></div>
            <div><label>Suffix</label><input type="text" placeholder="Jr / III" name="suffix"></div>
        </div>

        <div class="grid-2">
            <div><label>Email Address</label><input type="email" placeholder="example@mail.com" name="email" required></div>
            <div><label>Contact number</label><input type="text" placeholder="09XXXXXXXXX" name="contact" required></div>
        </div>

        <div class="grid-3">
            <div>
                <label>Civil Status</label>
                <select name="civil_status" required>
                    <option value="">Select Status</option>
                    <option>Single</option>
                    <option>Married</option>
                    <option>Widowed</option>
                    <option>Separated</option>
                </select>
            </div>
            <div><label>Birthday</label><input type="date" name="birthday" required></div>
            <div>
                <label>Sex</label>
                <div class="radio-group">
                    <label style="font-weight:normal;"><input type="radio" name="sex" value="Male" required> Male</label>
                    <label style="font-weight:normal;"><input type="radio" name="sex" value="Female"> Female</label>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div>
                <label>Password</label>
                <input type="password" name="password" placeholder="Create Password" required>
            </div>
            <div>
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Repeat Password" required>
            </div>
        </div>

        <div class="terms-row">
            <div style="font-size: 14px; color: #444;">
                <input type="checkbox" id="agree" style="width:auto; cursor: pointer;"> 
                I agree to the <a href="javascript:void(0)" onclick="openTerms()">Terms and Conditions</a>
            </div>
            <button type="submit" name="signup">Register</button>
        </div>
    </form>

    <p class="login-link">Already have an Account? <a href="login.php">Log in here</a></p>
</div>

<div class="modal-overlay" id="termsModal">
    <div class="modal">
        <div style="display:flex; justify-content:space-between; font-weight:bold; margin-bottom:15px; color: #005f73; font-size: 18px;">
            <span>Terms and Conditions</span>
            <span onclick="closeTerms()" style="cursor:pointer">✖</span>
        </div>
        <p style="font-size: 14px; color: #333; line-height: 1.6;">
            I hereby certify that the above information is true and correct to the best of my knowledge. 
            I understand that for the Barangay to carry out its mandate pursuant to Section 394 (d)(6) 
            of the Local Government Code of 1991, they must necessarily process my personal information 
            for easy identification of inhabitants. Therefore, I grant my consent subject to the provision 
            of the Philippine Data Privacy Act of 2012.
        </p>
        <button onclick="closeTerms()" style="background:#666; color:white; border:none; padding:10px 20px; cursor:pointer; border-radius:6px; margin-top:10px;">Close</button>
    </div>
</div>

</body>
</html>