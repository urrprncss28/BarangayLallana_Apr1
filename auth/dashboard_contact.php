<?php
session_start();

// 1. SECURITY CHECK
if (!isset($_SESSION['user_fullname'])) {
    header("Location: login.php");
    exit();
}

// 2. USER DATA
$full_name = $_SESSION['user_fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Lallana - Contact Us</title>
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

        .login-btn, .send-btn {
            background-color: #0a9396 !important;
            color: white !important;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s;
        }
        .login-btn { padding: 8px 20px; }
        .login-btn:hover, .send-btn:hover { background-color: #076d6f !important; }

        /* --- CONTACT LAYOUT --- */
        .main-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
        }

        @media (max-width: 850px) {
            .main-container { grid-template-columns: 1fr; }
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,147,150, 0.1);
        }

        .info-card {
            background: #005f73;
            color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        /* --- FORM STYLING --- */
        h2 { color: #0a9396; margin-top: 0; margin-bottom: 20px; }
        .info-card h2 { color: #94d2bd; }

        label { display: block; margin-top: 15px; font-weight: 600; font-size: 14px; }
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            margin-top: 5px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box;
            font-family: inherit;
        }
        textarea { height: 120px; resize: vertical; }
        .send-btn { width: 100%; padding: 14px; margin-top: 20px; font-size: 16px; }

        /* --- INFO DETAILS --- */
        .info-item { margin-bottom: 25px; display: flex; align-items: flex-start; gap: 15px; }
        .info-icon { font-size: 20px; }
        .info-text h4 { margin: 0; color: #94d2bd; font-size: 16px; }
        .info-text p { margin: 5px 0 0; font-size: 14px; opacity: 0.9; }

        .emergency-box {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
            border-left: 4px solid #ee9b00;
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
        <li class="active"><a href="dashboard_contact.php">CONTACT</a></li>
    </ul>
    <button class="login-btn" onclick="window.location.href='logout.php'">LOGOUT</button>
</div>

<div class="main-container">
    
    <div class="contact-card">
        <h2>Get in Touch</h2>
        <p style="color: #666; margin-bottom: 30px;">Have a question or concern? Send us a message and our staff will get back to you as soon as possible.</p>
        
        <form action="send_message.php" method="POST">
            <label>FULL NAME</label>
            <input type="text" value="<?= htmlspecialchars($full_name) ?>" readonly style="background: #f9f9f9;">

            <label>SUBJECT</label>
            <input type="text" name="subject" placeholder="What is this about?" required>

            <label>MESSAGE</label>
            <textarea name="message" placeholder="Type your message here..." required></textarea>

            <button type="submit" class="send-btn">SEND MESSAGE</button>
        </form>
    </div>

    <div class="info-card">
        <h2>Contact Information</h2>
        
        <div class="info-item">
            <div class="info-icon">📍</div>
            <div class="info-text">
                <h4>Address</h4>
                <p>123 Lallana St., Barangay Lallana, <br>Trece Martires, Cavite, 4109</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">📞</div>
            <div class="info-text">
                <h4>Phone / Mobile</h4>
                <p>(046) 123-4567 <br> +63 912 345 6789</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">📧</div>
            <div class="info-text">
                <h4>Email</h4>
                <p>admin@barangaylallana.gov.ph <br> help@lallana.com</p>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">⏰</div>
            <div class="info-text">
                <h4>Operating Hours</h4>
                <p>Mon - Fri: 8:00 AM - 5:00 PM <br> Sat: 8:00 AM - 12:00 PM</p>
            </div>
        </div>

        <div class="emergency-box">
            <h4 style="margin: 0; color: #ee9b00;">EMERGENCY HOTLINE</h4>
            <p style="margin: 5px 0 0; font-size: 18px; font-weight: bold;">911 or (046) 999-0000</p>
        </div>
    </div>

</div>

</body>
</html>