<?php
// connection.php
// Centralized database connection file for Mini Plant Store project

$host     = 'localhost';
$username = 'root';
$password = '';
$db_name  = 'carshowroom_db';

// Create connection
$conn = mysqli_connect($host, $username, $password, $db_name);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, 'utf8');

// Usage: include 'connection.php'; then use $conn for DB operations
