<?php
$host = 'localhost';
$db = 'blood_bank';
$user = 'root'; // Default XAMPP username
$pass = ''; // Default XAMPP password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
