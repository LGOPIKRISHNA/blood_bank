<?php
include 'db.php'; // Include the database connection

// Fetch blood groups from the database
$query = "SELECT * FROM blood_groups";
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
    border-collapse: collapse; /* Merge borders */
    margin-top: 20px; /* Space above the table */
}

th, td {
    padding: 12px; /* Space inside cells */
    text-align: left; /* Align text to the left */
    border: 1px solid #ddd; /* Light gray border */
}

th {
    background-color: #007BFF; /* Blue background for header */
    color: white; /* White text for header */
}

tr:nth-child(even) {
    background-color: #f2f2f2; /* Light gray for even rows */
}

tr:hover {
    background-color: #ddd; /* Darker gray on hover */
}

h1 {
    margin-top: 20px; /* Space above the heading */
    color: #333; /* Dark gray color for headings */
}
    </style>
</head>
<body>
    <h1>Available Blood Groups</h1>
    <table>
        <thead>
            <tr>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['blood_group']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
