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

// 3. USER DATA
$full_name = $_SESSION['user_fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Lallana - Services</title>
    <style>
        /* --- SHARED STYLES --- */
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
            background-image: linear-gradient(rgba(255, 255, 255, 0.85), rgba(255, 255, 255, 0.85)), 
                              url('assets/lallana.jpg'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

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
        .nav-links li.active a { color: #0a9396; font-weight: bold; }

        .login-btn, .request-btn {
            background-color: #0a9396 !important;
            color: white !important;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s;
        }
        .login-btn { padding: 8px 20px; }
        .login-btn:hover, .request-btn:hover { background-color: #076d6f !important; }

        /* --- MAIN CONTENT AREA --- */
        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .header-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .header-section h1 {
            color: #005f73;
            font-size: 45px; /* Matched news font size */
            margin: 0;
            font-weight: 900;
            line-height: 1.1;
        }

        .header-section p {
            color: #555;
            font-size: 18px;
            margin-top: 10px;
        }

        /* --- SERVICE GRID --- */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding-bottom: 50px;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            /* --- THE LINING FIX --- */
            border-left: 5px solid #0a9396; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-card h3 { 
            color: #0a9396; 
            margin-top: 0; 
            font-size: 22px;
            padding-bottom: 5px;
        }

        .service-card p { 
            font-size: 15px; 
            color: #444; 
            line-height: 1.6; 
            margin: 10px 0 20px 0;
        }

        .requirement-badge {
            display: inline-block;
            background: #e0f2f1;
            color: #00695c;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .request-btn { 
            width: 100%; 
            padding: 12px; 
            font-size: 14px;
            letter-spacing: 1px;
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
        <li class="active"><a href="dashboard_service.php">SERVICE</a></li>
        <li><a href="dashboard_news.php">NEWS</a></li>
        <li><a href="dashboard_contact.php">CONTACT</a></li>
    </ul>
    <button class="login-btn" onclick="window.location.href='logout.php'">LOGOUT</button>
</div>

<div class="main-container">
    <div class="header-section">
        <h1>MGA SERBISYO</h1>
        <p>Select a service below to start your application or request.</p>
    </div>
    
    <div class="service-grid">
        
        <div class="service-card">
            <div>
                <h3>Document Request</h3>
                <span class="requirement-badge">Requirement: 1 Valid ID</span>
                <p>Request for Barangay Clearance, Certificate of Indigency, and Residency Certificates.</p>
            </div>
            <button class="request-btn" onclick="window.location.href='dashboard_home.php'">GO TO REQUEST FORM</button>
        </div>

        <div class="service-card">
            <div>
                <h3>Barangay ID</h3>
                <span class="requirement-badge">Requirement: Proof of Residency</span>
                <p>Apply for an official Barangay Resident ID for local identification.</p>
            </div>
            <button class="request-btn">APPLY NOW</button>
        </div>

        <div class="service-card">
            <div>
                <h3>Health Center</h3>
                <span class="requirement-badge">Requirement: PhilHealth ID</span>
                <p>Book a slot for medical check-ups or vaccinations at the Health Center.</p>
            </div>
            <button class="request-btn">BOOK APPOINTMENT</button>
        </div>

        <div class="service-card" style="border-left-color: #ee9b00;">
            <div>
                <h3>Mediation</h3>
                <span class="requirement-badge" style="background: #fff3e0; color: #e65100;">Requirement: Written Complaint</span>
                <p>Schedule a mediation session for neighborhood disputes.</p>
            </div>
            <button class="request-btn" style="background-color: #ee9b00 !important;">FILE COMPLAINT</button>
        </div>

        <div class="service-card">
            <div>
                <h3>Waste Management</h3>
                <span class="requirement-badge">Requirement: Address & Photo</span>
                <p>Report uncollected garbage or request large waste disposal assistance.</p>
            </div>
            <button class="request-btn">SUBMIT REPORT</button>
        </div>

        <div class="service-card" style="border-left-color: #c62828;">
            <div>
                <h3>Emergency Rescue</h3>
                <span class="requirement-badge" style="background: #ffebee; color: #c62828;">Priority: Immediate</span>
                <p>Immediate request for emergency vehicle or security patrol assistance.</p>
            </div>
            <button class="request-btn" style="background: #c62828 !important;">CALL FOR ASSISTANCE</button>
        </div>

    </div>
</div>

</body>
</html>