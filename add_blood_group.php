<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO blood_groups (username, blood_group, quantity, location,email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $username, $blood_group, $quantity, $location, $email);

    if ($stmt->execute()) {
        echo "Blood group added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
