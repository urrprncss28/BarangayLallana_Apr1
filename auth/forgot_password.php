<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Barangay Lallana</title>
    <style>
        /* Reuse your Login.php styles for consistency */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)), url('assets/lallana.jpg'); 
            background-size: cover; background-position: center; background-attachment: fixed;
            margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .auth-container {
            width: 100%; max-width: 500px; padding: 50px; 
            background: rgba(255, 255, 255, 0.98); border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4); text-align: center;
        }
        input { width: 100%; padding: 15px; margin: 10px 0; border-radius: 8px; border: 1px solid #ccc; font-size: 16px; box-sizing: border-box; }
        button { width: 100%; padding: 15px; background: #0a9396; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; transition: 0.3s; }
        button:disabled { background: #999; cursor: not-allowed; }
        .timer-text { font-size: 14px; color: #666; margin-top: 10px; display: none; }
        #codeSection { display: none; margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px; }
        .back-link { margin-top: 20px; display: block; color: #0a9396; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<div class="auth-container">
    <h2 style="color: #005f73;">Reset Password</h2>
    
    <div id="emailSection">
        <p style="font-size: 14px; color: #555;">Enter your registered email to receive a 6-digit verification code.</p>
        <input type="email" id="userEmail" placeholder="Email Address" required>
        <button id="sendBtn" onclick="requestLink()">SEND VERIFICATION CODE</button>
        <p id="timerMsg" class="timer-text">Resend code in <span id="seconds">59</span>s</p>
    </div>

    <div id="codeSection">
        <p style="font-size: 14px; color: #555;">We sent a code to your email. Please enter it below:</p>
        <input type="text" id="vCode" placeholder="6-Digit Code" maxlength="6" style="text-align: center; letter-spacing: 5px; font-size: 24px;">
        <button onclick="verifyCode()" style="background: #005f73;">VERIFY & PROCEED</button>
    </div>

    <a href="login.php" class="back-link">← Back to Login</a>
</div>

<script>
    let countdown;
    const sendBtn = document.getElementById('sendBtn');
    const timerMsg = document.getElementById('timerMsg');
    const secondsDisplay = document.getElementById('seconds');
    const codeSection = document.getElementById('codeSection');

    function requestLink() {
        const email = document.getElementById('userEmail').value;
        
        if(email === "") {
            alert("Please enter your email address.");
            return;
        }

        // Simulate sending email via AJAX/PHP
        alert("Sending code to " + email + "...");
        
        // Disable button and start timer
        sendBtn.disabled = true;
        sendBtn.innerText = "CODE SENT";
        timerMsg.style.display = "block";
        codeSection.style.display = "block"; // Show the code input field

        let timeLeft = 59;
        countdown = setInterval(() => {
            timeLeft--;
            secondsDisplay.innerText = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                sendBtn.disabled = false;
                sendBtn.innerText = "RESEND CODE";
                timerMsg.style.display = "none";
                secondsDisplay.innerText = 59;
            }
        }, 1000);
    }

    function verifyCode() {
        const code = document.getElementById('vCode').value;
        if(code.length < 6) {
            alert("Please enter the full 6-digit code.");
        } else {
            // Here you would redirect to a "reset_new_password.php" page
            alert("Code verified! Redirecting to password reset page...");
            window.location.href = "reset_new_password.php"; 
        }
    }
</script>

</body>
</html>