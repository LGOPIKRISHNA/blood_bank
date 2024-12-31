<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = $_POST['blood_group'];
    // Here you can add logic to save the donation details to the database
    echo "Thank you, " . $_SESSION['username'] . "! Your donation of blood group " . $blood_group . " has been registered.";
}
?>