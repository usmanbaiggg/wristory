<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wristory_db";

// Using MySQLi with proper error reporting
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    // In production, log this error instead of displaying it raw
    die("<div style='font-family: Arial; padding: 20px; color: red;'>Database Connection Failed: " . mysqli_connect_error() . "</div>");
}

// Set charset to utf8mb4 for safety
mysqli_set_charset($conn, "utf8mb4");
?>