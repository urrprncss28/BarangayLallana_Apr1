<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "barangay_db";
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

$firstname = "System";
$lastname = "Admin";
$email = "admin@lallana.com";
$password = password_hash("admin123", PASSWORD_DEFAULT); // Secure hashing
$role = "admin";

$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $role);

if($stmt->execute()){
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>