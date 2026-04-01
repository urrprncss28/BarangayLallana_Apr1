<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Barangay LALLANA</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            margin: 0; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
            color: #333; 
            background-color: #f4f7f6; 
        }
        
        /* --- NAVBAR (Synchronized with front.php & announcement.php) --- */
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
        .logo img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%;}
        .logo span { font-weight: 800; color: #005f73; font-size: 20px; }
        
        .nav-links { list-style: none; display: flex; gap: 25px; margin: 0; padding: 0; align-items: center; }
        .nav-links a { text-decoration: none; color: #444; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .nav-links a:hover { color: #0a9396; }
        .nav-links li.active a { color: #0a9396; border-bottom: 2px solid #0a9396; padding-bottom: 5px; }

        .nav-actions { display: flex; align-items: center; gap: 20px; }
        .login-btn { 
            background-color: #0a9396 !important; 
            color: white !important; 
            border: none; 
            padding: 10px 28px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 14px; 
            cursor: pointer; 
            transition: 0.3s; 
        }
        .login-btn:hover { background-color: #076d6f !important; }

        /* --- MAIN CONTENT --- */
        .main { 
            flex: 1; 
            padding: 50px 10%; 
            background-image: linear-gradient(rgba(244, 247, 246, 0.92), rgba(244, 247, 246, 0.92)), url('assets/lallana.jpg'); 
            background-size: cover; 
            background-attachment: fixed; 
        }

        .header-section { text-align: center; margin-bottom: 40px; }
        .header-section h1 { color: #005f73; font-size: 36px; margin: 0; font-weight: 900; text-transform: uppercase; }
        .header-section p { color: #666; margin-top: 5px; font-size: 18px; }

        /* --- SERVICE GRID --- */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-left: 8px solid #0a9396; 
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease;
        }

        .service-card:hover { transform: translateY(-5px); }

        .service-card h3 { color: #0a9396; margin-top: 0; font-size: 22px; margin-bottom: 10px; }
        .service-card p { font-size: 15px; color: #444; line-height: 1.6; margin-bottom: 20px; }

        .requirement-badge {
            display: inline-block;
            background: #e0f2f1;
            color: #00695c;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .request-btn { 
            width: 100%; 
            padding: 12px; 
            font-size: 14px;
            background-color: #0a9396;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .request-btn:hover { background-color: #076d6f; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <img src="assets/logo1.jpg" alt="Logo">
            <span>BARANGAY LALLANA</span>
        </div>
        <ul class="nav-links">
            <li><a href="front.php">Home</a></li>
            <li><a href="about.php">Our Barangay</a></li>
            <li><a href="announcement.php">Announcement</a></li>
            <li><a href="officials.php">Officials</a></li>
            <li class="active"><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <a href="login.php" style="font-size: 14px; color: #666; text-decoration: none; font-weight: 600;">Dashboard</a>
            <a href="login.php" class="login-btn">Log In</a>
        </div>
    </nav>

    <main class="main">
        <div class="header-section">
            <h1>MGA SERBISYO</h1>
            <p>Select a service below to learn more or start an application.</p>
        </div>
        
        <div class="service-grid">
            <div class="service-card">
                <div>
                    <span class="requirement-badge">Requirement: 1 Valid ID</span>
                    <h3>Document Request</h3>
                    <p>Request for Barangay Clearance, Certificate of Indigency, and Residency Certificates.</p>
                </div>
                <button class="request-btn" onclick="window.location.href='login.php'">GET STARTED</button>
            </div>

            <div class="service-card">
                <div>
                    <span class="requirement-badge">Requirement: Proof of Residency</span>
                    <h3>Barangay ID</h3>
                    <p>Apply for an official Barangay Resident ID for local identification.</p>
                </div>
                <button class="request-btn" onclick="window.location.href='login.php'">APPLY NOW</button>
            </div>

            <div class="service-card">
                <div>
                    <span class="requirement-badge">Requirement: PhilHealth ID</span>
                    <h3>Health Center</h3>
                    <p>Book a slot for medical check-ups or vaccinations at the Health Center.</p>
                </div>
                <button class="request-btn" onclick="window.location.href='login.php'">BOOK APPOINTMENT</button>
            </div>

            <div class="service-card" style="border-left-color: #ee9b00;">
                <div>
                    <span class="requirement-badge" style="background: #fff3e0; color: #e65100;">Requirement: Written Complaint</span>
                    <h3>Mediation</h3>
                    <p>Schedule a mediation session for neighborhood disputes.</p>
                </div>
                <button class="request-btn" style="background-color: #ee9b00 !important;" onclick="window.location.href='login.php'">FILE COMPLAINT</button>
            </div>

            <div class="service-card">
                <div>
                    <span class="requirement-badge">Requirement: Address & Photo</span>
                    <h3>Waste Management</h3>
                    <p>Report uncollected garbage or request large waste disposal assistance.</p>
                </div>
                <button class="request-btn" onclick="window.location.href='login.php'">SUBMIT REPORT</button>
            </div>

            <div class="service-card" style="border-left-color: #c62828;">
                <div>
                    <span class="requirement-badge" style="background: #ffebee; color: #c62828;">Priority: Immediate</span>
                    <h3>Emergency Rescue</h3>
                    <p>Immediate request for emergency vehicle or security patrol assistance.</p>
                </div>
                <button class="request-btn" style="background: #c62828 !important;" onclick="window.location.href='login.php'">CALL FOR ASSISTANCE</button>
            </div>
        </div>
    </main>

</body>
</html>