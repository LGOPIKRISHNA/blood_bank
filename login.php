<?php
session_start();
include 'db.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered username and password are "admin"
    if ($username === 'admin' && $password === 'admin') {
        // Set session variables for admin
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = true;
        $_SESSION['role'] = 'admin'; // Set the role to 'admin'

        // Redirect to the admin page
        header("Location: admin.php");
        exit();
    } else {
        // Query to check if the user exists and password is correct for regular users
        $query = "SELECT id, username, password, is_admin FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password using password_verify for regular users
            if (password_verify($password, $user['password'])) {
                // Set session variables for regular user
                $_SESSION['username'] = $user['username'];

                // Check if the user is an admin and set the role accordingly
                if ($user['is_admin'] == 1) {
                    $_SESSION['role'] = 'admin'; // Set the role to 'admin'
                    header("Location: admin.php"); // Redirect to the admin page
                } else {
                    $_SESSION['role'] = 'user'; // Set the role to 'user'
                    header("Location: user.php"); // Redirect to the user dashboard
                }
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> <!-- Keep your existing CSS -->
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <main>
        <div id="loginForm">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Login</button>
                <p>
                    <a href="forgot_password.php" class="forgot-password-link">Forgot Password?</a>
                </p>
            </form>
        </div>

        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </main>

    <footer>
        <p>&copy; 2024 Blood Bank. All rights reserved.</p>
    </footer>
</body>
</html>
