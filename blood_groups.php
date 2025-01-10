<?php
session_start(); // Start the session

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    echo "You must be an admin to view this page.";
    exit(); // Stop execution if the user is not an admin
}

include 'db.php'; // Include the database connection

// Fetch blood groups from the database including the email field
$query = "SELECT blood_group, quantity, location, email FROM blood_groups";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Groups</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        h1 {
            margin-top: 20px;
            color: #333;
        }

        /* Download Button Styles */
        .download-button {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .download-button:hover {
            background-color: #218838;
        }

        /* Request Button Styles */
        .request-button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .request-button:hover {
            background-color: #0056b3;
        }

        /* Notification Styles */
        .notification {
            background-color: #ffcc00;
            color: black;
            padding: 10px;
            margin: 20px 0;
            border: 1px solid #e7b100;
        }
    </style>
</head>
<body>
    <!-- Display Download Button only for Admin -->
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <a href="download_report.php" class="download-button">Download Report</a>
    <?php endif; ?>

    <h1>Available Blood Groups</h1>
    <table>
        <thead>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['blood_group'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['location'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES); ?></td>
                    <td>
                        <form action="send_request.php" method="POST">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES); ?>">
                            <button type="submit" class="request-button">Request</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
