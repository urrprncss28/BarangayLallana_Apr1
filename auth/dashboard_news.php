<?php
session_start();

// 1. SECURITY CHECK: Ensure user is logged in
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

// 3. FETCH ANNOUNCEMENTS
$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");

// 4. GET FIRST NAME FOR AVATAR/GREETING
$full_name = $_SESSION['user_fullname'];
$name_parts = explode(" ", $full_name);
$fname = $name_parts[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay Lallana - News</title>
    <style>
        /* General Reset */
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
            /* Background Image with Light Overlay */
            background-image: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), 
                              url('assets/lallana.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* NAVBAR */
        .navbar {
            background: #fff;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .navbar .logo { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }

        .navbar .logo img { 
            width: 40px; 
        }

        .navbar .logo span { 
            font-weight: bold; 
            color: #005f73; 
            font-size: 20px; 
        }

        /* NAV LINKS */
        .nav-links { 
            list-style: none; 
            display: flex; 
            gap: 20px; 
            margin: 0; 
        }

        .nav-links a { 
            text-decoration: none; 
            color: #333; 
            font-weight: 500; 
        }

        .nav-links li.active a { 
            color: #0a9396; 
            font-weight: bold; 
        }

        /* BUTTONS */
        .login-btn {
            background-color: #0a9396 !important;
            color: white !important;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .login-btn:hover {
            background-color: #076d6f !important;
        }

        /* HERO SECTION */
        .hero {
            text-align: center;
            padding: 60px 20px;
            color: #005f73;
        }

        .hero h1 { 
            font-size: 45px; 
            margin: 0; 
            font-weight: 900; 
            line-height: 1.1; 
        }

        /* ANNOUNCEMENT CONTAINER & CARDS */
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 20px; 
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #0a9396; /* Signature Teal Accent */
        }

        .icon { 
            font-size: 30px; 
        }

        .content .meta { 
            font-size: 12px; 
            color: #777; 
            margin-bottom: 10px; 
        }

        .content p { 
            line-height: 1.6; 
            color: #333; 
            margin: 0; 
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
        <li class="active"><a href="dashboard_news.php">NEWS</a></li>
        <li><a href="dashboard_contact.php">CONTACT</a></li>
    </ul>

    <button class="login-btn" onclick="window.location.href='logout.php'">LOGOUT</button>
</div>

<div class="hero">
    <h1>BALITA AT<br>ANUNSYO</h1>
</div>

<div class="container">

<?php if($result && $result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
            <div class="icon">📢</div>
            <div class="content">
                <p class="meta">
                    © 2026 Barangay Lallana | Posted: <?= date('M d, Y', strtotime($row['created_at'])); ?>
                </p>
                <p>
                    <?= nl2br(htmlspecialchars($row['content'])); ?>
                </p>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="card">
        <div class="content">
            <p>Walang bagong anunsyo sa kasalukuyan.</p>
        </div>
    </div>
<?php endif; ?>

</div>

</body>
</html>