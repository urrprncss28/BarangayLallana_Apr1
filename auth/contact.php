<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Barangay LALLANA</title>
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
        
        /* --- NAVBAR (Synchronized) --- */
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

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
        }

        @media (max-width: 900px) {
            .main-container { grid-template-columns: 1fr; }
        }

        .contact-card {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-top: 5px solid #0a9396;
        }

        .info-card {
            background: #005f73;
            color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* --- FORM STYLING --- */
        h2 { color: #005f73; margin-top: 0; font-size: 28px; font-weight: 800; }
        .info-card h2 { color: #94d2bd; }

        label { display: block; margin-top: 15px; font-weight: 600; font-size: 13px; color: #555; text-transform: uppercase; }
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            margin-top: 5px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box;
            font-family: inherit;
            background: #fdfdfd;
        }
        textarea { height: 120px; resize: vertical; }
        
        .send-btn { 
            width: 100%; 
            padding: 14px; 
            margin-top: 25px; 
            font-size: 15px; 
            background-color: #0a9396;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .send-btn:hover { background-color: #076d6f; }

        /* --- INFO DETAILS --- */
        .info-item { display: flex; align-items: flex-start; gap: 15px; }
        .info-icon { font-size: 22px; }
        .info-text h4 { margin: 0; color: #94d2bd; font-size: 16px; text-transform: uppercase; }
        .info-text p { margin: 5px 0 0; font-size: 14px; line-height: 1.5; opacity: 0.9; }

        .emergency-box {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 8px;
            margin-top: 10px;
            border-left: 5px solid #ee9b00;
        }

        /* --- MAP CONTAINER --- */
        .map-container {
            margin-top: 30px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #ddd;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 300px;
        }
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
            <li><a href="services.php">Services</a></li>
            <li class="active"><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <a href="login.php" style="font-size: 14px; color: #666; text-decoration: none; font-weight: 600;">Dashboard</a>
            <a href="login.php" class="login-btn">Log In</a>
        </div>
    </nav>

    <main class="main">
        <div class="main-container">
            
            <div class="contact-card">
                <h2>Get in Touch</h2>
                <p style="color: #666; margin-bottom: 25px;">Send us a message for inquiries, concerns, or feedback. Our barangay staff will respond to you shortly.</p>
                
                <form action="send_message_public.php" method="POST">
                    <label>Your Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter your name" required>

                    <label>Email Address / Phone Number</label>
                    <input type="text" name="contact_info" placeholder="How can we reach you?" required>

                    <label>Subject</label>
                    <input type="text" name="subject" placeholder="What is this regarding?" required>

                    <label>Message</label>
                    <textarea name="message" placeholder="Type your message here..." required></textarea>

                    <button type="submit" class="send-btn">SUBMIT MESSAGE</button>
                </form>
            </div>

            <div class="info-card">
                <h2>Contact Details</h2>
                
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <h4>Location</h4>
                        <p>Brgy. Lallana, Trece Martires City, <br>Cavite, Philippines 4109</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div class="info-text">
                        <h4>Contact Numbers</h4>
                        <p>Landline: (046) 123-4567 <br> Mobile: +63 912 345 6789</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📧</div>
                    <div class="info-text">
                        <h4>Email Us</h4>
                        <p>info@barangaylallana.gov.ph</p>
                    </div>
                </div>

                <div class="emergency-box">
                    <h4 style="margin: 0; color: #ee9b00; font-size: 13px;">EMERGENCY HOTLINE</h4>
                    <p style="margin: 5px 0 0; font-size: 20px; font-weight: 900; letter-spacing: 1px;">(046) 419-0000</p>
                </div>

                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15467.432857500583!2d120.85505756306048!3d14.28589928372652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd78bc900693a7%3A0x762080a983416b0b!2sTrece%20Martires%2C%20Cavite!5e0!3m2!1sen!2sph!4v1700000000000!5m2!1sen!2sph" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

        </div>
    </main>

</body>
</html>