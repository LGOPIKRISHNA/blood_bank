<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db.php'; // Include the database connection

// Fetch user details including the image and blood donation count
$username = $_SESSION['username'];
$query = "SELECT email, user_image, blood_donated FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user data was fetched
if (!$user) {
    echo "User  not found.";
    exit();
}

// Initialize variables for the form
$email = $user['email'];
$user_image = $user['user_image'];
$blood_donated = $user['blood_donated'] ?? 0; // Default to 0 if not set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Profile of <?php echo htmlspecialchars($username); ?></h1>
        <a href="logout.php">Logout</a>
    </header>

    <main>
        <h2>Your Profile</h2>
        <div>
            <img src="<?php echo htmlspecialchars($user_image); ?>" alt="Profile Image" style="width:100px;height:100px;">
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <p>Blood Donated: <?php echo htmlspecialchars($blood_donated); ?> times</p>
        </div>

        <h2>Update Profile</h2>
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>

            <label for="password">New Password:</label>
            <input type="password" name="password" required>

            <label for="profile_image">Profile Image:</label>
            <input type="file" name="profile_image" accept="image/*">

            <label for="blood_donated">Blood Donated (times):</label>
            <input type="number" name="blood_donated" value="<?php echo htmlspecialchars($blood_donated); ?>" required>

            <input type="submit" value="Update Profile">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Blood Bank. All rights reserved.</p>
    </footer>
</body>
</html>