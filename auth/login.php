<?php
session_start();

// --- DATABASE CONFIGURATION ---
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "barangay_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 1. We must select 'role' so the system knows if this is an admin
    $stmt = $conn->prepare("SELECT firstname, lastname, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $user = $result->fetch_assoc();
        
        // 2. Verify the hashed password (works for the 'admin123' you created)
        if(password_verify($password, $user['password'])){
            
            // 3. Set Session Variables
            $_SESSION['loggedin'] = true;
            $_SESSION['user_fullname'] = $user['firstname'] . " " . $user['lastname'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role']; 

            // 4. THE REDIRECTOR: Check if the role is 'admin'
            if($user['role'] === 'admin'){
                header("Location: admin .php");
            } else {
                header("Location: dashboard_home.php");
            }
            exit;
        } else {
            $message = "Invalid email or password!";
        }
    } else {
        $message = "Invalid email or password!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barangay Lallana</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)), url('assets/lallana.jpg'); 
            background-size: cover; background-position: center; background-attachment: fixed;
            margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .auth-container {
            width: 100%; max-width: 550px; padding: 60px; 
            background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);
            border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            text-align: center; box-sizing: border-box;
        }
        .logo { display: block; margin: 0 auto 25px auto; max-width: 130px; height: auto; }
        h2 { margin: 0 0 30px 0; color: #005f73; font-size: 32px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; }
        input { width: 100%; padding: 18px; margin: 12px 0; border-radius: 10px; border: 1px solid #ccc; font-size: 17px; box-sizing: border-box; background: #fdfdfd; }
        button { width: 100%; padding: 18px; margin-top: 15px; background: #0a9396; color: white; border: none; border-radius: 10px; cursor: pointer; font-size: 18px; font-weight: bold; text-transform: uppercase; transition: 0.3s; }
        button:hover { background: #005f73; transform: translateY(-2px); }
        
        .forgot-password { text-align: right; margin-top: -5px; margin-bottom: 15px; }
        .forgot-password a { font-size: 14px; color: #666; font-weight: normal; text-decoration: none; }
        .forgot-password a:hover { color: #0a9396; text-decoration: underline; }
        .message { font-size: 15px; margin-top: 20px; font-weight: bold; color: #c62828; background: #ffebee; padding: 15px; border-radius: 8px; border: 1px solid #ffcdd2; }
    </style>
</head>
<body>

<div class="auth-container">
    <img src="assets/logo_nobg.png" alt="Barangay Logo" class="logo">
    <h2>Login</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <div class="forgot-password">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>

        <button type="submit" name="login">SIGN IN</button>
    </form>

    <p style="margin-top: 25px;">New resident? <a href="sign_up.php" style="color: #0a9396; font-weight: bold; text-decoration: none;">Create an Account</a></p>

    <?php if($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</div>

</body>
</html>