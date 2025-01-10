<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db.php'; // Include the database connection

$username = $_SESSION['username'];

// Prepare the SQL query to fetch blood donation records for the user
$query1 = "SELECT blood_group, quantity, location FROM blood_groups WHERE username = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $username);
$stmt1->execute();
$result1 = $stmt1->get_result();

// Prepare the SQL query to fetch user details
$query = "SELECT email, user_image FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$email = htmlspecialchars($user['email'], ENT_QUOTES);

// Start output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blood Donation Report</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .report-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #007BFF;
        }
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
        .download-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="report-card">
    <h1>Blood Donation Report for <?php echo htmlspecialchars($username, ENT_QUOTES); ?></h1>
    <p>Email: <?php echo $email; ?></p>
    <p>This report summarizes your blood donation history. Thank you for your contributions!</p>

    <?php if ($result1->num_rows > 0): ?>
        <table>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Location</th>
            </tr>
            <?php while ($row = $result1->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['blood_group'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars($row['location'], ENT_QUOTES); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No blood donation records found.</p>
        <?php endif; ?>

<p>Thank you for your generosity in donating blood. Your contributions help save lives!</p>

<form action="download_report.php" method="POST">
    <input type="hidden" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES); ?>">
    <button type="submit" class="download-button">Download Report</button>
</form>
</div>

</body>
</html>

<?php
// End output buffering and flush the output
ob_end_flush();
?>