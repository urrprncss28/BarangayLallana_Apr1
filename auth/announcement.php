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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - Barangay LALLANA</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh; color: #333; background-color: #f4f7f6; }
        
        /* --- NAVBAR (Exact match to fixed front.php) --- */
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
        .section-header h1 { color: #005f73; font-size: 36px; margin: 0; font-weight: 900; text-transform: uppercase; }
        .section-header p { color: #666; margin-top: 5px; }

        .card { background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-left: 10px solid #0a9396; max-width: 900px; margin: 0 auto 60px; }
        .slideshow-container { position: relative; overflow: hidden; border-radius: 8px; background: #fafafa; }
        .slideshow-track { display: flex; transition: transform 0.5s ease-in-out; }
        .mySlides { min-width: 100%; text-align: center; }
        .mySlides img { width: 100%; height: auto; max-height: 450px; object-fit: contain; }
        
        .prev, .next { cursor: pointer; position: absolute; top: 50%; padding: 16px; color: white; background: rgba(0,0,0,0.3); font-weight: bold; border-radius: 3px; user-select: none; margin-top: -22px; transition: 0.3s; }
        .next { right: 0; }
        
        .content-paragraph { font-size: 18px; line-height: 1.8; color: #444; margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px; text-align: center; }

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
            <li><a href="front.php">Home</a></li>
            <li><a href="about.php">Our Barangay</a></li>
            <li class="active"><a href="announcement.php">Announcement</a></li>
            <li><a href="officials.php">Officials</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <a href="login.php" style="font-size: 14px; color: #666; text-decoration: none; font-weight: 600;">Dashboard</a>
            <a href="login.php" class="login-btn">Log In</a>
        </div>
    </nav>

    <main class="main">
        <div class="section-header">
            <h1 id="slide-title"><?php echo $announcements[0]['title']; ?></h1>
            <p id="slide-subtitle"><?php echo $announcements[0]['subtitle']; ?></p>
        </div>

        <div class="card">
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
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
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
    </main>

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
            const currentSlideData = slides[slideIndex];
            titleEl.innerText = currentSlideData.querySelector('.data-title').value;
            subtitleEl.innerText = currentSlideData.querySelector('.data-subtitle').value;
            descEl.innerHTML = currentSlideData.querySelector('.data-desc').value;
            dots.forEach(d => d.classList.remove('active'));
            dots[slideIndex].classList.add('active');
        }

        function plusSlides(n) { showSlides(slideIndex + n); }
        function currentSlide(n) { showSlides(n); }

        showSlides(0);
        setInterval(() => plusSlides(1), 8000);
    </script>
</body>
</html>