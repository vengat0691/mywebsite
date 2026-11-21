<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "mywebsite_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$name = "Vengadesh";
$email = "vengadesh@example.com";
$password_hash = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $password_hash);

if ($stmt->execute()) {
    echo "User added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>