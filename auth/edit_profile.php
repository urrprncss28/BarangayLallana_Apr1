<?php
session_start();

// 1. SECURITY CHECK
if (!isset($_SESSION['user_fullname'])) {
    header("Location: login.php");
    exit();
}

// 2. DATABASE CONNECTION
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "barangay_db";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. FETCH CURRENT DATA
$full_name = $_SESSION['user_fullname'];
$name_parts = explode(" ", $full_name);
$fname = $name_parts[0];
$lname = isset($name_parts[1]) ? $name_parts[1] : '';

$stmt = $conn->prepare("SELECT * FROM users WHERE firstname = ? AND lastname = ? LIMIT 1");
$stmt->bind_param("ss", $fname, $lname);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$user_id = $user['id']; // Assuming your table has an 'id' column

// 4. HANDLE FORM SUBMISSION
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];
    $new_address = $_POST['address'];
    $new_status = $_POST['civil_status'];

    $update_stmt = $conn->prepare("UPDATE users SET email = ?, phone = ?, address = ?, civil_status = ? WHERE id = ?");
    $update_stmt->bind_param("ssssi", $new_email, $new_phone, $new_address, $new_status, $user_id);

    if ($update_stmt->execute()) {
        $message = "<div class='alert success'>Profile updated successfully!</div>";
        // Refresh local data
        $email = $new_email;
        $phone = $new_phone;
        $permanent_address = $new_address;
        $civil_status = $new_status;
    } else {
        $message = "<div class='alert error'>Error updating profile.</div>";
    }
    $update_stmt->close();
} else {
    // Initial load values
    $civil_status = $user['civil_status'] ?? '';
    $email = $user['email'] ?? '';
    $phone = $user['phone'] ?? '';
    $permanent_address = $user['address'] ?? '';
}

$user_display_name = strtoupper(($user['firstname'] ?? $fname) . " " . ($user['lastname'] ?? $lname));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Barangay Lallana</title>
    <style>
        /* Reuse your existing styles */
        body { font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; display: flex; flex-direction: column; height: 100vh; color: #333; overflow: hidden; }
        .navbar { background: #fff; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 100; }
        .navbar .logo span { font-weight: bold; color: #005f73; font-size: 20px; }
        .container { display: flex; flex: 1; overflow: hidden; }
        
        /* Sidebar Styles */
        .sidebar { width: 260px; background: #fff; border-right: 1px solid #ddd; padding: 20px; box-sizing: border-box; }
        .avatar { background-color: #0a9396; display: flex; align-items: center; justify-content: center; color: white; width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 10px; font-size: 24px; font-weight: bold; }
        .menu { list-style: none; padding: 0; }
        .menu li { padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; }
        .menu li a { text-decoration: none; color: #555; display: block; }
        .menu li.active { background: #0a9396; }
        .menu li.active a { color: white; }

        /* Main Content & Form */
        .main { flex: 1; padding: 30px; overflow-y: auto; background: #f4f7f6; }
        .profile-card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 800px; margin: 0 auto; border-left: 6px solid #0a9396; }
        .profile-header { padding: 20px 40px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .profile-body { padding: 40px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: bold; color: #888; margin-bottom: 5px; text-transform: uppercase; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 15px; box-sizing: border-box; }
        
        .btn-container { display: flex; gap: 10px; margin-top: 20px; }
        .save-btn { background: #0a9396; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; cursor: pointer; }
        .cancel-btn { background: #eee; color: #333; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-weight: bold; font-size: 13px; }
        
        .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; }
        .success { background: #d1e7dd; color: #0f5132; }
        .error { background: #f8d7da; color: #842029; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo"><span>BARANGAY LALLANA</span></div>
</div>

<div class="container">
    <div class="sidebar">
        <div class="avatar"><?= substr($fname, 0, 1) ?></div>
        <ul class="menu">
            <li><a href="dashboard_home.php">Dashboard</a></li>
            <li class="active"><a href="user_profile.php">User Profile</a></li>
        </ul>
    </div>
    
    <div class="main">
        <div class="profile-card">
            <div class="profile-header">
                <h2>Edit Profile Details</h2>
                <a href="user_profile.php" style="color: #0a9396; text-decoration: none; font-weight: bold;">← Back</a>
            </div>
            
            <div class="profile-body">
                <?= $message ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>Civil Status</label>
                        <select name="civil_status">
                            <option value="Single" <?= $civil_status == 'Single' ? 'selected' : '' ?>>Single</option>
                            <option value="Married" <?= $civil_status == 'Married' ? 'selected' : '' ?>>Married</option>
                            <option value="Widowed" <?= $civil_status == 'Widowed' ? 'selected' : '' ?>>Widowed</option>
                            <option value="Separated" <?= $civil_status == 'Separated' ? 'selected' : '' ?>>Separated</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Permanent Address</label>
                        <input type="text" name="address" value="<?= htmlspecialchars($permanent_address) ?>" required>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="save-btn">SAVE CHANGES</button>
                        <a href="user_profile.php" class="cancel-btn">CANCEL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>