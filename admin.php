<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$stmt = $conn->prepare("INSERT INTO site_views (view_date) VALUES (NOW())");
$stmt->execute();
// Fetch data for registered users, site views, and blood group info
// Registered Users
$result_users = $conn->query("SELECT COUNT(*) AS total_users FROM users");
$total_users = $result_users->fetch_assoc()['total_users'];

// Site Views in the Last Week
// Site Views in the Last Week
$last_week = date('Y-m-d', strtotime('-1 week'));
$result_views = $conn->query("SELECT COUNT(*) AS total_views FROM site_views WHERE view_date >= '$last_week'");
$total_views = $result_views->fetch_assoc()['total_views'];

// Blood Group Information
$result_blood_groups = $conn->query("SELECT blood_group, SUM(quantity) AS total_quantity FROM blood_groups GROUP BY blood_group");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        .logout-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .dashboard-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .dashboard-box:hover {
            transform: scale(1.05);
        }

        .dashboard-box h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .dashboard-box p {
            font-size: 18px;
            color: #555;
        }

        .dashboard-box .count {
            font-size: 32px;
            color: #007bff;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .dashboard-box button a {
    text-decoration: none;
    color: black;
}
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
</header>

<main>
    <div class="dashboard-container">
        <!-- Registered Users Box -->
        <div class="dashboard-box">
    <h3>Registered Users</h3>
    <p class="count"><?php echo $total_users; ?></p>
    <p>Total users who have signed up.</p>
    <button><a href="user_details.php">View Details</a></button>
</div>

        <!-- Site Views Box -->
        <div class="dashboard-box">
            <h3>Site Visited in the Last Week</h3>
            <p class="count"><?php echo $total_views; ?></p>
            <p>Total views from the last 7 days.</p>
        </div>

        <!-- Blood Group Information Box -->
        <div class="dashboard-box">
    <h3>Blood Group Information</h3>
    <?php if ($result_blood_groups->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result_blood_groups->fetch_assoc()): ?>
                <li><strong><?php echo $row['blood_group']; ?>:</strong> <?php echo $row['total_quantity']; ?> liters donated</li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No data available.</p>
    <?php endif; ?>
</div>
<div class="dashboard-box">
            <h3>Available Blood Groups</h3>
            <button><a href="blood_groups.php">Donors</a></button>
        </div>
    </div>
</main>

<footer class="footer">
    <p>&copy; 2024 Blood Bank. All rights reserved.</p>
</footer>

</body>
</html>
