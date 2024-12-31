<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO blood_groups (username, blood_group, quantity, location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $username, $blood_group, $quantity, $location);

    if ($stmt->execute()) {
        echo "Blood group added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
