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

// 3. FETCH USER DATA for Sidebar
$full_name = $_SESSION['user_fullname'];
$name_parts = explode(" ", $full_name);
$fname = $name_parts[0];
$lname = isset($name_parts[1]) ? $name_parts[1] : '';

// Fetching user details for the sidebar profile section
$user_display_name = $full_name;
$user_address = "Address not updated";

$stmt = $conn->prepare("SELECT firstname, lastname, civil_status FROM users WHERE firstname = ? AND lastname = ? LIMIT 1");
$stmt->bind_param("ss", $fname, $lname);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $user_display_name = strtoupper($user['firstname'] . " " . $user['lastname']);
    $user_address = "RESIDENT - " . strtoupper($user['civil_status']); 
}
$stmt->close();

// 4. DATA FETCHING (Logic for your requests table)
// This is where you would normally query your 'document_requests' table
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Documents - Barangay Lallana</title>
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
        .nav-links { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0;}
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

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 30px;
            border-left: 6px solid #0a9396;
        }

        h2 { color: #005f73; margin: 0; font-size: 22px; }
        p.subtitle { color: #666; font-size: 14px; margin: 5px 0 25px 0; }

        /* --- DOCUMENT TABLE --- */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 1px;
            padding: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        td { padding: 20px 15px; border-bottom: 1px solid #f8f8f8; vertical-align: middle; }

        .doc-name { font-weight: 600; color: #333; display: block; }
        .doc-meta { font-size: 12px; color: #999; }

        /* --- STATUS BADGES --- */
        .badge {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .badge-pending { background: #fff4e5; color: #b76e00; }
        .badge-ready { background: #e6fcf5; color: #087f5b; }
        .badge-denied { background: #fff5f5; color: #c92a2a; }

        /* --- ACTION BUTTONS --- */
        .btn-download {
            background: #0a9396;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-download:hover { background: #076d6f; }
        .btn-disabled { background: #eee; color: #aaa; cursor: not-allowed; pointer-events: none; }

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
            <li><a href="user_profile.php">User Profile</a></li>
            <li class="active"><a href="my_document.php">My Documents</a></li>
        </ul>
        <button class="logout" onclick="window.location.href='logout.php'">Log Out</button>
    </div>
    <div class="main">
        <div class="header-flex">
            <div>
                <h2>DIGITAL DOCUMENT VAULT</h2>
                <p class="subtitle">Track your certification requests and access your digital copies.</p>
            </div>
            <button class="logout-btn" onclick="window.location.href='dashboard_home.php'" style="background:#555;">+ NEW REQUEST</button>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Document Information</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                        <th>Control No.</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="doc-name">Barangay Clearance</span>
                            <span class="doc-meta">Purpose: Employment</span>
                        </td>
                        <td>Oct 28, 2026</td>
                        <td><span class="badge badge-ready">Ready for Pickup</span></td>
                        <td style="font-family: monospace; color: #666;">BC-2026-881</td>
                        <td><a href="#" class="btn-download">VIEW COPY</a></td>
                    </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>