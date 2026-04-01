<?php
// --- DATA ARRAYS ---
$announcements = [
    [
        "title" => "Public Advisory",
        "subtitle" => "Official announcement from the Barangay Council.",
        "image" => "assets/lallana.jpg", 
        "description" => "Ipinababati sa lahat na <strong>WALANG TRANSAKSYON</strong> sa OPISINA ng BARANGAY LALLANA mula Marso 3 hanggang Marso 5 dahil sa Capacity Building Seminar. Magpapatuloy ang operasyon sa Marso 6."
    ],
    [
        "title" => "Community Health",
        "subtitle" => "Free Vaccination Drive",
        "image" => "assets/lallana.jpg",
        "description" => "Magkakaroon ng libreng bakuna para sa mga bata sa darating na Sabado, Marso 10, sa ganap na ika-8 ng umaga sa ating Health Center."
    ]
];

$services = [
    ["title" => "Document Request", "req" => "1 Valid ID", "desc" => "Request for Barangay Clearance, Certificate of Indigency, and Residency Certificates.", "color" => "#0a9396"],
    ["title" => "Barangay ID", "req" => "Proof of Residency", "desc" => "Apply for an official Barangay Resident ID for local identification purposes.", "color" => "#0a9396"],
    ["title" => "Emergency Rescue", "req" => "Priority: Immediate", "desc" => "Immediate request for emergency vehicle or security patrol assistance.", "color" => "#c62828"]
];

$officials = [
    ["name" => "JUAN DELA CRUZ", "pos" => "Punong Barangay", "img" => "assets/profile.png"],
    ["name" => "MARIA SANTOS", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "RICARDO REYES", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "ELIZA GOMEZ", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "ANTONIO LUNA", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "TERESA MAGBANUA", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "EMILIO JACINTO", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "GREGORIA DE JESUS", "pos" => "Barangay Kagawad", "img" => "assets/profile.png"],
    ["name" => "RAFAEL CASANGUAN", "pos" => "SK Chairperson", "img" => "assets/profile.png"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay LALLANA - Official Website</title>
    <style>
        :root {
            --footer-bg: #003d4d; /* Changed from black to Dark Teal */
            --accent-color: #0a9396;
            --text-light: #ffffff;
            --text-dim: #b0b0b0;
        }

        body { font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh; color: #333; background-color: #f4f7f6; scroll-behavior: smooth; }
        
        /* --- NAVBAR --- */
        .navbar { background: #fff; padding: 10px 60px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; }
        .logo { display: flex; align-items: center; gap: 12px; }
        .logo img { width: 50px; height: 50px; object-fit: cover; border-radius: 50%;}
        .logo span { font-weight: 800; color: #005f73; font-size: 20px; }
        
        .nav-links { list-style: none; display: flex; gap: 25px; margin: 0; padding: 0; align-items: center; }
        .nav-links a { text-decoration: none; color: #444; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .nav-links a:hover { color: #0a9396; }
        .nav-links li.active a { color: #0a9396; border-bottom: 2px solid #0a9396; padding-bottom: 5px; }

        .nav-actions { display: flex; align-items: center; gap: 20px; }
        .login-btn { background-color: #0a9396 !important; color: white !important; border: none; padding: 10px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; cursor: pointer; transition: 0.3s; }
        .login-btn:hover { background-color: #076d6f !important; }

        /* --- MAIN CONTENT --- */
        .main { flex: 1; padding: 50px 10%; background-image: linear-gradient(rgba(244, 247, 246, 0.92), rgba(244, 247, 246, 0.92)), url('assets/lallana.jpg'); background-size: cover; background-attachment: fixed; }

        .section-header { text-align: center; margin: 40px 0 30px; }
        .section-header h1 { color: #005f73; font-size: 32px; margin: 0; font-weight: 900; text-transform: uppercase; }
        .section-header p { color: #666; margin-top: 5px; }

        /* --- CARDS & SLIDESHOW --- */
        .card { background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-left: 10px solid #0a9396; max-width: 900px; margin: 0 auto 60px; position: relative; }
        .slideshow-container { position: relative; overflow: hidden; border-radius: 8px; background: #fafafa; }
        .slideshow-track { display: flex; transition: transform 0.5s ease-in-out; }
        .mySlides { min-width: 100%; text-align: center; }
        .mySlides img { width: 100%; height: auto; max-height: 400px; object-fit: contain; }
        
        /* Sliding Arrows */
        .prev, .next { cursor: pointer; position: absolute; top: 40%; width: auto; padding: 16px; margin-top: -22px; color: #0a9396; font-weight: bold; font-size: 24px; transition: 0.6s ease; border-radius: 0 3px 3px 0; user-select: none; background-color: rgba(255,255,255,0.8); border: none; z-index: 10; }
        .next { right: 0; border-radius: 3px 0 0 3px; }
        .prev { left: 0; }
        .prev:hover, .next:hover { background-color: #0a9396; color: white; }

        .content-paragraph { font-size: 17px; line-height: 1.6; color: #444; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; text-align: center; min-height: 60px; }

        /* --- GRIDS --- */
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; max-width: 1000px; margin: 0 auto; }
        .service-card { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #0a9396; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s; }
        
        .officials-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; max-width: 1100px; margin: 0 auto 60px; }
        .official-card { background: #fff; padding: 20px; border-radius: 15px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-bottom: 4px solid #0a9396; }
        .official-card img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 3px solid #f4f7f6; }

        /* --- CONTACT SECTION --- */
        .contact-section-container { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 30px; max-width: 1100px; margin: 0 auto; }
        .contact-info-box { background: #005f73; color: white; padding: 35px; border-radius: 15px; }
        .contact-form-box { background: #fff; padding: 35px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-top: 5px solid #0a9396; }

        .request-btn { background-color: #0a9396; color: white; border: none; padding: 12px; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 15px; width: 100%; display: block; text-align: center; text-decoration: none; }

        /* --- FOOTER --- */
        footer { background-color: var(--footer-bg); color: var(--text-light); padding: 60px 10% 20px; margin-top: 60px; }
        .footer-container { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.2fr; gap: 40px; margin-bottom: 40px; }
        .footer-links ul { list-style: none; padding: 0; }
        .footer-links a { color: var(--text-dim); text-decoration: none; font-size: 14px; transition: 0.3s; }
        .footer-links a:hover { color: var(--accent-color); padding-left: 5px; }
        .stats-card { background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 12px; text-align: center; border: 1px solid rgba(255, 255, 255, 0.1); }
        .footer-bottom { border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 20px; text-align: center; font-size: 13px; color: var(--text-dim); }
        .heart { color: #e63946; }

        .dot-container { text-align: center; margin-top: 15px; }
        .dot { height: 10px; width: 10px; margin: 0 5px; background-color: #bbb; border-radius: 50%; display: inline-block; cursor: pointer; }
        .dot.active { background-color: #0a9396; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <img src="assets/logo1.jpg" alt="Logo">
            <span>BARANGAY LALLANA</span>
        </div>
        <ul class="nav-links">
            <li class="active"><a href="#home">Home</a></li>
            <li><a href="about.php">Our Barangay</a></li> 
            <li><a href="announcement.php">Announcement</a></li>
            <li><a href="officials.php">Officials</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <a href="login.php" style="font-size: 14px; color: #666; text-decoration: none; font-weight: 600;">Dashboard</a>
            <a href="login.php" class="login-btn">Log In</a>
        </div>
    </nav>

    <main class="main" id="home">
        <div class="section-header">
            <h1 id="slide-title"><?php echo $announcements[0]['title']; ?></h1>
            <p id="slide-subtitle"><?php echo $announcements[0]['subtitle']; ?></p>
        </div>

        <div class="card">
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>

            <div class="slideshow-container">
                <div class="slideshow-track">
                    <?php foreach ($announcements as $item): ?>
                        <div class="mySlides">
                            <img src="<?php echo $item['image']; ?>" alt="Announcement">
                            <input type="hidden" class="data-title" value="<?php echo $item['title']; ?>">
                            <input type="hidden" class="data-subtitle" value="<?php echo $item['subtitle']; ?>">
                            <input type="hidden" class="data-desc" value="<?php echo htmlspecialchars($item['description']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="dot-container">
                <?php for ($i=0; $i < count($announcements); $i++): ?>
                    <span class="dot" onclick="currentSlide(<?php echo $i; ?>)"></span>
                <?php endfor; ?>
            </div>
            <p class="content-paragraph" id="slide-desc">
                <?php echo $announcements[0]['description']; ?>
            </p>
        </div>

        <div class="section-header">
            <h1>MGA SERBISYO</h1>
            <p>Select a service below to learn more or start an application.</p>
        </div>
        <div class="service-grid">
            <?php foreach ($services as $s): ?>
                <div class="service-card" style="border-left-color: <?php echo $s['color']; ?>;">
                    <div>
                        <span class="requirement-badge" style="background:#e0f2f1; color:#00695c; padding:4px 8px; border-radius:4px; font-size:10px; font-weight:bold;"><?php echo $s['req']; ?></span>
                        <h3 style="color: <?php echo $s['color']; ?>; margin: 10px 0;"><?php echo $s['title']; ?></h3>
                        <p style="font-size: 14px; color: #555;"><?php echo $s['desc']; ?></p>
                    </div>
                    <button class="request-btn" style="background-color: <?php echo $s['color']; ?>;" onclick="window.location.href='login.php'">
                        GET STARTED
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="section-header">
            <h1>BARANGAY OFFICIALS</h1>
            <p>Dedicated public servants of Barangay Lallana</p>
        </div>
        <div class="officials-grid">
            <?php foreach ($officials as $o): ?>
                <div class="official-card">
                    <img src="<?php echo $o['img']; ?>" alt="Official">
                    <h4><?php echo $o['name']; ?></h4>
                    <p><?php echo $o['pos']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="section-header" id="contact">
            <h1>CONTACT US</h1>
            <p>We are here to assist you. Reach out to us anytime.</p>
        </div>
        <div class="contact-section-container">
            <div class="contact-info-box">
                <h2 style="color: #94d2bd; margin-top:0;">Barangay Hall</h2>
                <div class="info-item" style="display:flex; gap:15px; margin-bottom:20px;">
                    <span>📍</span>
                    <div>
                        <h4 style="margin:0; color:#94d2bd; font-size:14px;">Address</h4>
                        <p style="margin:5px 0; font-size:14px; opacity:0.9;">Brgy. Lallana, Trece Martires City, Cavite</p>
                    </div>
                </div>
                <div class="info-item" style="display:flex; gap:15px; margin-bottom:20px;">
                    <span>📞</span>
                    <div>
                        <h4 style="margin:0; color:#94d2bd; font-size:14px;">Phone</h4>
                        <p style="margin:5px 0; font-size:14px; opacity:0.9;">(046) 123-4567</p>
                    </div>
                </div>
                <div class="map-wrapper" style="height: 200px; border-radius: 10px; overflow: hidden; margin-top: 15px;">
                    <iframe src="https://maps.google.com/maps?q=Barangay%20Lallana&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;"></iframe>
                </div>
            </div>

            <div class="contact-form-box">
                <h2 style="color: #005f73; margin-top:0;">Send a Message</h2>
                <form action="send_contact_public.php" method="POST">
                    <input type="text" name="name" placeholder="Full Name" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
                    <input type="email" name="email" placeholder="Email Address" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ddd; border-radius:5px; box-sizing:border-box;">
                    <textarea name="message" placeholder="Your Message" style="width:100%; padding:10px; height:100px; border:1px solid #ddd; border-radius:5px; margin-bottom:15px; box-sizing:border-box;"></textarea>
                    <button type="submit" class="request-btn">SUBMIT MESSAGE</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <div class="logo-group" style="display:flex; gap:10px; margin-bottom:15px;">
                    <img src="assets/logo1.jpg" alt="Logo" style="width:40px; height:40px; border-radius:50%;">
                </div>
                <h2>Barangay Lallana</h2>
                <p style="font-size:13px; color:var(--text-dim);">📍 Trece Martires City, Cavite</p>
                <p style="font-size:13px; color:var(--text-dim);">📞 (0997) 263 8289</p>
            </div>

            <div class="footer-links">
                <h3>Menu Links</h3>
                <ul>
                    <li><a href="officials.php">Officials</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="announcement.php">Announcements</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>Other Links</h3>
                <ul>
                    <li><a href="https://trecemartirescity.gov.ph/">Trece Martires City</a></li>
                    <li><a href="https://cavite.gov.ph/">Province of Cavite</a></li>
                    <li><a href="https://www.gov.ph/">GovPH</a></li>
                </ul>
            </div>

            <div class="footer-stats">
                <h3>Compliance</h3>
                <div class="stats-card">
                    <div style="margin-bottom:10px;">
                        <span style="font-size:11px; color:var(--text-dim);">TOTAL VISITORS</span>
                        <div style="font-size:20px; font-weight:bold; color:var(--accent-color);">3,131</div>
                    </div>
                    <div>
                        <span style="font-size:11px; color:var(--text-dim);">TODAY</span>
                        <div style="font-size:20px; font-weight:bold; color:#94d2bd;">11</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>Developed by DIT - CvSU Trece Martires</p>
            <p style="margin-top: 5px; font-size: 11px;">© <?php echo date("Y"); ?> Barangay Lallana. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        let slideIndex = 0;
        const track = document.querySelector('.slideshow-track');
        const slides = document.querySelectorAll('.mySlides');
        const dots = document.querySelectorAll('.dot');
        const titleEl = document.getElementById('slide-title');
        const subtitleEl = document.getElementById('slide-subtitle');
        const descEl = document.getElementById('slide-desc');

        function showSlides(n) {
            slideIndex = n;
            if (slideIndex >= slides.length) slideIndex = 0;
            if (slideIndex < 0) slideIndex = slides.length - 1;
            
            track.style.transform = `translateX(-${slideIndex * 100}%)`;
            const currentData = slides[slideIndex];
            titleEl.innerText = currentData.querySelector('.data-title').value;
            subtitleEl.innerText = currentData.querySelector('.data-subtitle').value;
            descEl.innerHTML = currentData.querySelector('.data-desc').value;
            
            dots.forEach(d => d.classList.remove('active'));
            dots[slideIndex].classList.add('active');
        }

        function plusSlides(n) {
            showSlides(slideIndex + n);
        }

        function currentSlide(n) {
            showSlides(n);
        }

        // Auto slide every 7 seconds
        let autoSlide = setInterval(() => plusSlides(1), 7000);

        // Reset timer on manual interaction
        function resetTimer() {
            clearInterval(autoSlide);
            autoSlide = setInterval(() => plusSlides(1), 7000);
        }
        
        document.querySelectorAll('.prev, .next, .dot').forEach(el => {
            el.addEventListener('click', resetTimer);
        });
    </script>
</body>
</html>