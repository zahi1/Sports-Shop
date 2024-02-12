<?php
$servername = "localhost";
$username = "root";   // Default XAMPP username
$password = "";       // Default XAMPP has no password
$dbname = "stud";     // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
