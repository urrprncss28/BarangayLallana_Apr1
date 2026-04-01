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

// 3. FETCH FULL USER DATA
$full_name = $_SESSION['user_fullname'];
$name_parts = explode(" ", $full_name);
$fname = $name_parts[0];
$lname = isset($name_parts[1]) ? $name_parts[1] : '';

// Fetching extended details for the profile page
$stmt = $conn->prepare("SELECT * FROM users WHERE firstname = ? AND lastname = ? LIMIT 1");
$stmt->bind_param("ss", $fname, $lname);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Dashboard Logic for Sidebar
$user_display_name = strtoupper(($user['firstname'] ?? $fname) . " " . ($user['lastname'] ?? $lname));
$user_address = isset($user['civil_status']) ? "RESIDENT - " . strtoupper($user['civil_status']) : "Address not updated";

// Fallback values for Profile Body
$civil_status = $user['civil_status'] ?? 'Not Specified';
$email = $user['email'] ?? 'No email linked';
$phone = $user['phone'] ?? 'N/A';
$permanent_address = $user['address'] ?? 'Brgy. Lallana, Cavite';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - Barangay Lallana</title>
    <style>
        /* --- GENERAL RESET --- */
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            color: #333;
            overflow: hidden;
        }

        /* --- NAVBAR --- */
        .navbar {
            background: #fff;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .navbar .logo { display: flex; align-items: center; gap: 10px; }
        .navbar .logo img { width: 40px; }
        .navbar .logo span { font-weight: bold; color: #005f73; font-size: 20px; }
        .nav-links { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
        .nav-links a { text-decoration: none; color: #333; font-weight: 500; }
        
        .logout-btn {
            background-color: #0a9396;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        /* --- LAYOUT --- */
        .container { display: flex; flex: 1; overflow: hidden; }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background: #fff;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }
        .profile { text-align: center; margin-bottom: 30px; }
        .avatar {
            background-color: #0a9396;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 24px;
            width: 60px; height: 60px;
            border-radius: 50%;
            margin: 0 auto 10px;
        }
        .avatar::after { content: "<?= substr($fname, 0, 1) ?>"; }
        .profile h3 { font-size: 16px; margin: 5px 0; color: #333; }
        .profile p { font-size: 11px; color: #777; margin: 0; text-transform: uppercase; }

        .menu { list-style: none; padding: 0; flex: 1; }
        .menu li { padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; cursor: pointer; color: #555; transition: 0.2s; }
        .menu li a { text-decoration: none; color: inherit; display: block; width: 100%; }
        .menu li.active { background: #0a9396; color: white; }
        .menu li:hover:not(.active) { background: #f0f0f0; }
        
        .logout { 
            padding: 12px; width: 100%; margin-top: 10px; 
            background-color: #0a9396; color: white; border: none; 
            border-radius: 5px; font-weight: bold; cursor: pointer; 
        }

        /* --- MAIN CONTENT --- */
        .main {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                              url('assets/lallana.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* --- PROFILE CARD --- */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            border-left: 6px solid #0a9396;
        }

        .profile-header {
            background: #f8fbfb;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 30px;
            border-bottom: 1px solid #eee;
        }

        .large-avatar {
            width: 100px; height: 100px;
            background: #0a9396;
            color: white;
            font-size: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header-info h1 { margin: 0; font-size: 28px; color: #005f73; }
        .header-info p { margin: 5px 0 0; color: #666; font-weight: 500; }

        .profile-body { padding: 40px; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .info-section h3 {
            font-size: 14px;
            color: #0a9396;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .info-item { margin-bottom: 15px; }
        .info-item label {
            display: block;
            font-size: 12px;
            color: #888;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .info-item span {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .edit-btn {
            background: transparent;
            border: 1px solid #0a9396;
            color: #0a9396;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .edit-btn:hover { background: #0a9396; color: white; }

        .footer-actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <img src="assets/logo_nobg.png" alt="logo">
        <span>BARANGAY LALLANA</span>
    </div>
    <ul class="nav-links">
        <li><a href="dashboard_home.php">HOME</a></li>
        <li><a href="dashboard_service.php">SERVICE</a></li>
        <li><a href="dashboard_news.php">NEWS</a></li>
        <li><a href="dashboard_contact.php">CONTACT</a></li>
    </ul>
    <button class="logout-btn" onclick="window.location.href='logout.php'">LOGOUT</button>
</div>

<div class="container">
    <div class="sidebar">
        <div class="profile">
            <div class="avatar"></div>
            <h3><?= htmlspecialchars($user_display_name) ?></h3>
            <p><?= htmlspecialchars($user_address) ?></p>
        </div>
        <ul class="menu">
            <li><a href="dashboard_home.php">Dashboard</a></li>
            <li><a href="blotter_log.php">Blotter Log</a></li>
            <li class="active"><a href="user_profile.php">User Profile</a></li>
            <li><a href="my_document.php">My Documents</a></li>
        </ul>
        <button class="logout" onclick="window.location.href='logout.php'">Log Out</button>
    </div>
    <div class="main">
        <div class="profile-card">
            <div class="profile-header">
                <div class="large-avatar"><?= substr($fname, 0, 1) ?></div>
                <div class="header-info">
                    <h1><?= $user_display_name ?></h1>
                    <p>Verified Resident • Barangay Lallana</p>
                </div>
            </div>

            <div class="profile-body">
                <div class="info-grid">
                    <div class="info-section">
                        <h3>Personal Information</h3>
                        <div class="info-item">
                            <label>CIVIL STATUS</label>
                            <span><?= htmlspecialchars($civil_status) ?></span>
                        </div>
                        <div class="info-item">
                            <label>PERMANENT ADDRESS</label>
                            <span><?= htmlspecialchars($permanent_address) ?></span>
                        </div>
                    </div>

                    <div class="info-section">
                        <h3>Contact Details</h3>
                        <div class="info-item">
                            <label>EMAIL ADDRESS</label>
                            <span><?= htmlspecialchars($email) ?></span>
                        </div>
                        <div class="info-item">
                            <label>MOBILE NUMBER</label>
                            <span><?= htmlspecialchars($phone) ?></span>
                        </div>
                    </div>
                </div>

                <div class="footer-actions">
                    <button class="edit-btn" onclick="window.location.href='edit_profile.php'">EDIT PROFILE DETAILS</button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>