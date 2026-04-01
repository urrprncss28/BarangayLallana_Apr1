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

// 3. FETCH USER DATA
$full_name = $_SESSION['user_fullname'];
$name_parts = explode(" ", $full_name);
$fname = $name_parts[0];
$lname = isset($name_parts[1]) ? $name_parts[1] : '';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Dashboard - Home</title>
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
        .nav-links li.active a { color: #0a9396; font-weight: bold; }

        /* --- BUTTONS --- */
        .login-btn, .logout, .submit-btn {
            background-color: #0a9396 !important;
            color: white !important;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
            border-radius: 5px;
        }
        .login-btn { padding: 8px 20px; }
        .login-btn:hover, .logout:hover, .submit-btn:hover {
            background-color: #076d6f !important;
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

        .menu { list-style: none; padding: 0; flex: 1; }
        .menu li { padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; cursor: pointer; color: #555; transition: 0.2s; }
        .menu li a { text-decoration: none; color: inherit; display: block; width: 100%; }
        .menu li.active { background: #0a9396; color: white; }
        .menu li:hover:not(.active) { background: #f0f0f0; }
        .logout { padding: 12px; width: 100%; margin-top: 10px; }

        /* --- MAIN CONTENT & BACKGROUND --- */
        .main {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-image: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)), 
                              url('assets/lallana.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .topbar { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
        .topbar h2 { margin: 0; font-weight: 800; font-size: 24px; letter-spacing: 1px; }

        /* --- PROFESSIONAL FORM CARDS --- */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border-left: 6px solid #0a9396; /* Fixed Lining Thickness */
        }
        
        .card h2 { margin: 0; color: #0a9396; font-size: 22px; font-weight: 700; }
        .card p.subtitle { font-size: 13px; color: #666; margin: 5px 0 20px 0; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { display: flex; flex-direction: column; }
        .full-width { grid-column: span 2; }

        label { margin-bottom: 6px; font-weight: 600; font-size: 13px; color: #444; }
        input, select { 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            font-size: 14px;
            background: #fff;
            transition: all 0.3s;
            height: 45px; /* Consistent Size */
            box-sizing: border-box;
        }
        input:focus, select:focus { outline: none; border-color: #0a9396; box-shadow: 0 0 5px rgba(10,147,150,0.2); }

        .upload-section {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px dashed #ccc;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }

        .submit-area {
            margin-top: 25px;
            display: flex;
            justify-content: flex-end;
        }

        .submit-btn {
            padding: 0 40px;
            height: 45px;
            font-size: 14px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Specific style for Blotter Card accent */
        .blotter-card { border-left-color: #c62828; }
        .blotter-card h2 { color: #c62828; }
        .blotter-card .submit-btn { background-color: #c62828 !important; }
        .blotter-card .submit-btn:hover { background-color: #a52222 !important; }

    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <img src="assets/logo_nobg.png" alt="logo">
        <span>BARANGAY LALLANA</span>
    </div>

    <ul class="nav-links">
        <li class="active"><a href="dashboard_home.php">HOME</a></li>
        <li><a href="dashboard_service.php">SERVICE</a></li>
        <li><a href="dashboard_news.php">NEWS</a></li>
        <li><a href="dashboard_contact.php">CONTACT</a></li>
    </ul>

    <button class="login-btn" onclick="window.location.href='logout.php'">LOGOUT</button>
</div>

<div class="container">

    <div class="sidebar">
        <div class="profile">
            <div class="avatar"></div>
            <h3><?= htmlspecialchars($user_display_name) ?></h3>
            <p><?= htmlspecialchars($user_address) ?></p>
        </div>

        <ul class="menu">
            <li class="active"><a href="dashboard_home.php">Dashboard</a></li>
            <li><a href="blotter_log.php">Blotter Log</a></li>
            <li><a href="user_profile.php">User Profile</a></li>
            <li><a href="my_document.php">My Documents</a></li>
        </ul>

        <button class="logout" onclick="window.location.href='logout.php'">Log Out</button>
    </div>

    <div class="main">
        <div class="topbar">
            <img src="assets/logo_nobg.png" alt="logo" style="width: 50px;">
            <h2 style="color: #000304;">BARANGAY LALLANA</h2>
        </div>

        <div class="card">
            <h2>E-CERTIFICATION PORTAL</h2>
            <p class="subtitle">Official portal for requesting Barangay clearances and certificates.</p>
            
            <form action="submit_request.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label>DOCUMENT TYPE</label>
                        <select name="doc_type" required>
                            <option value="">-- Select Certificate --</option>
                            <option>Barangay Clearance</option>
                            <option>Certificate of Indigency</option>
                            <option>Certificate of Residency</option>
                            <option>First Time Job Seeker</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>PURPOSE OF REQUEST</label>
                        <input type="text" name="purpose" placeholder="e.g. Employment, Scholarship" required>
                    </div>

                    <div class="form-group full-width">
                        <label>ATTACH VALID IDENTIFICATION (PDF/JPG)</label>
                        <div class="upload-section">
                            <input type="file" name="valid_id" required>
                        </div>
                    </div>
                </div>

                <div class="submit-area">
                    <button type="submit" class="submit-btn">PROCEED TO REQUEST</button>
                </div>
            </form>
        </div>

        <div class="card blotter-card">
            <h2>INCIDENT REPORTING (BLOTTER)</h2>
            <p class="subtitle">Securely file incident reports for mediation with the Barangay Lallana.</p>
            
            <form action="submit_blotter.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>RESPONDENT NAME</label>
                        <input type="text" name="respondent" placeholder="Name of individual involved" required>
                    </div>

                    <div class="form-group">
                        <label>NATURE OF INCIDENT</label>
                        <select name="incident_type" required>
                            <option value="">-- Select Complaint Type --</option>
                            <option>Physical Altercation</option>
                            <option>Noise Complaint</option>
                            <option>Property Dispute</option>
                            <option>Theft/Robbery</option>
                            <option>Others</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>DETAILED DESCRIPTION</label>
                        <input type="text" name="description" placeholder="Summary of the incident" required>
                    </div>
                </div>

                <div class="submit-area">
                    <button type="submit" class="submit-btn">SUBMIT OFFICIAL REPORT</button>
                </div>
            </form>
        </div>

    </div>
</div>

</body>
</html>