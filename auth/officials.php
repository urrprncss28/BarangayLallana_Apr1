<?php
// --- OFFICIALS DATA ARRAY ---
$officials = [
    [
        "name" => "HON. JUAN DELA CRUZ",
        "position" => "Punong Barangay",
        "image" => "assets/profile.png",
        "color" => "#005f73" // Primary color for the Captain
    ],
    [
        "name" => "HON. MARIA SANTOS",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "HON. RICARDO REYES",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "HON. ELIZA GOMEZ",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "HON. ANTONIO LUNA",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "HON. TERESA MAGBANUA",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "HON. EMILIO JACINTO",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "HON. GREGORIA DE JESUS",
        "position" => "Barangay Kagawad",
        "image" => "assets/profile.png"
    ],
    [
        "name" => "RAFAEL CASANGUAN",
        "position" => "SK Chairperson",
        "image" => "assets/profile.png",
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Officials - Barangay Lallana</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        /* --- NAVBAR (Same as your Front.php) --- */
        .navbar {
            background: #fff;
            padding: 10px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .logo { display: flex; align-items: center; gap: 12px; }
        .logo img { width: 45px; height: 45px; border-radius: 50%; }
        .logo span { font-weight: 800; color: #005f73; font-size: 20px; }

        /* --- MAIN SECTION --- */
        .main {
            padding: 60px 10%;
            background-image: linear-gradient(rgba(244, 247, 246, 0.95), rgba(244, 247, 246, 0.95)), url('assets/lallana.jpg');
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .header-section {
            text-align: center;
            margin-bottom: 50px;
        }
        .header-section h1 {
            color: #005f73;
            font-size: 42px;
            font-weight: 900;
            margin: 0;
        }
        .header-section p {
            color: #666;
            font-size: 18px;
            margin-top: 10px;
        }

        /* --- OFFICIALS GRID --- */
        .officials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .official-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            border-bottom: 5px solid #0a9396; /* Matching your theme color */
        }
        .official-card:hover {
            transform: translateY(-10px);
        }

        /* Highlighting the Punong Barangay (First Card) */
        .captain-card {
            grid-column: 1 / -1; /* Makes the Captain take full width or be centered */
            max-width: 350px;
            margin: 0 auto 40px;
            border-bottom: 5px solid #005f73;
        }

        .img-container {
            padding: 20px 0;
            background: #fafafa;
        }
        .official-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .info {
            padding: 20px;
        }
        .info h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
            letter-spacing: 0.5px;
        }
        .info p {
            margin: 5px 0 0;
            color: #0a9396;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 13px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar { padding: 10px 20px; }
            .officials-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <img src="assets/logo1.jpg" alt="Logo">
            <span>BARANGAY LALLANA</span>
        </div>
        <div class="nav-actions">
            <a href="front.php" style="text-decoration: none; color: #0a9396; font-weight: bold;">← Back to Home</a>
        </div>
    </nav>

    <main class="main">
        <div class="header-section">
            <h1>Barangay Officials</h1>
            <p>Dedicated public servants of Barangay Lallana (2024 - 2026)</p>
        </div>

        <div class="officials-grid">
            <?php foreach ($officials as $index => $person): ?>
                <div class="official-card <?php echo ($index === 0) ? 'captain-card' : ''; ?>" 
                     style="<?php echo isset($person['color']) ? 'border-bottom-color: '.$person['color'] : ''; ?>">
                    
                    <div class="img-container">
                        <img src="<?php echo $person['image']; ?>" alt="<?php echo $person['name']; ?>">
                    </div>
                    
                    <div class="info">
                        <h3><?php echo $person['name']; ?></h3>
                        <p style="<?php echo isset($person['color']) ? 'color: '.$person['color'] : ''; ?>">
                            <?php echo $person['position']; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</body>
</html>