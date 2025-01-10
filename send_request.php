<?php
session_start();
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer autoloader for PHPMailer

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipientEmail = $_POST['email']; // Get the email from the form submission

    $mail = new PHPMailer(true); // Create a new PHPMailer instance

    try {
        // Server settings
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                               // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                       // Enable SMTP authentication
        $mail->Username = 'your-email@gmail.com';                     // SMTP username (your Gmail)
        $mail->Password = 'your-email-password';                      // SMTP password (your Gmail password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
        $mail->Port = 587;                                            // TCP port to connect to

        // Recipients
        $mail->setFrom('your-email@gmail.com', 'Admin'); // Sender's email
        $mail->addAddress($recipientEmail); // Recipient's email from the form

        // Content
        $mail->isHTML(true);                                          // Set email format to HTML
        $mail->Subject = 'Request for Blood Donation';
        $mail->Body    = 'Dear Donor, <br><br>This is a request for blood donation. We need your help.';

        // Send the email
        $mail->send();

        // Provide a success message
        echo 'Request sent successfully to ' . htmlspecialchars($recipientEmail);

        // Optionally, save a notification for the user in the database (to be checked on their login)
        $notification_query = "INSERT INTO notifications (user_email, message) VALUES ('$recipientEmail', 'Admin has sent a request for blood donation.')";
        $conn->query($notification_query);

    } catch (Exception $e) {
        // If sending fails, show an error message
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Request</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Send Blood Donation Request</h1>
    <form action="send_request.php" method="POST">
        <label for="email">Enter Recipient Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Request</button>
    </form>
</body>
</html>
