<?php
session_start();
// Security Check: in a real app, you'd check if $_SESSION['role'] == 'admin'
if(!isset($_SESSION['loggedin'])){
    header("Location: login.php");
    exit;
}

// --- DATABASE CONNECTION ---
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "barangay_db";
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Fetch all residents for the table
$query = "SELECT id, firstname, lastname, email, contact, civil_status FROM users ORDER BY id DESC";
$residents = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Barangay Lallana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #005f73;
            --secondary: #0a9396;
            --dark: #001219;
            --light: #f8f9fa;
            --danger: #ae2012;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
            background-color: #f0f2f5;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--dark);
            color: white;
            position: fixed;
            padding: 20px;
        }

        .sidebar h2 {
            font-size: 18px;
            text-align: center;
            border-bottom: 1px solid #333;
            padding-bottom: 20px;
            color: var(--secondary);
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }

        .nav-links li {
            padding: 15px;
            transition: 0.3s;
            cursor: pointer;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .nav-links li:hover, .nav-links li.active {
            background: var(--primary);
        }

        .nav-links i { margin-right: 10px; width: 20px; }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 5px solid var(--secondary);
        }

        .stat-card h3 { margin: 0; font-size: 14px; color: #666; }
        .stat-card p { margin: 10px 0 0 0; font-size: 24px; font-weight: bold; color: var(--dark); }

        /* RESIDENT TABLE */
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            text-align: left;
            background: #f4f7f6;
            padding: 15px;
            color: #444;
            font-size: 14px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        /* ACTION BUTTONS */
        .btn-edit {
            background: #e9d8a6;
            color: #944403;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-msg {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 5px;
        }

        .btn-logout {
            background: var(--danger);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><i class="fas fa-landmark"></i> LALLANA ADMIN</h2>
    <ul class="nav-links">
        <li class="active"><i class="fas fa-users"></i> Residents</li>
        <li><i class="fas fa-file-invoice"></i> Document Requests</li>
        <li><i class="fas fa-bullhorn"></i> Announcements</li>
        <li><i class="fas fa-gavel"></i> Blotter Reports</li>
        <li><i class="fas fa-cog"></i> Settings</li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <h1>Resident Management</h1>
        <button class="btn-logout" onclick="window.location.href='logout.php'">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Residents</h3>
            <p><?php echo $residents->num_rows; ?></p>
        </div>
        <div class="stat-card" style="border-left-color: #ee9b00;">
            <h3>Pending Requests</h3>
            <p>12</p>
        </div>
        <div class="stat-card" style="border-left-color: #ae2012;">
            <h3>Active Blotters</h3>
            <p>3</p>
        </div>
    </div>

    <div class="table-container">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="margin:0; font-size:18px;">Registered Residents</h2>
            <input type="text" placeholder="Search resident..." style="padding:8px; border-radius:5px; border:1px solid #ccc;">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $residents->fetch_assoc()): ?>
                <tr>
                    <td><strong><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></strong></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td><span style="background:#d1e7dd; color:#0f5132; padding:4px 8px; border-radius:12px; font-size:12px;">Verified</span></td>
                    <td>
                        <button class="btn-edit" onclick="editUser(<?php echo $row['id']; ?>)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-msg" onclick="respondUser('<?php echo $row['email']; ?>')">
                            <i class="fas fa-reply"></i> Respond
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function editUser(id) {
        alert("Opening edit panel for Resident ID: " + id);
        // Here you would normally open a modal or redirect to edit_resident.php?id=id
    }

    function respondUser(email) {
        let message = prompt("Enter your response/message to " + email + ":");
        if(message) {
            alert("Response sent to " + email);
            // Here you would use AJAX to save the response to your 'notifications' table
        }
    }
</script>

</body>
</html>