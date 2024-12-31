<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db.php'; // Include the database connection

// Fetch user details including the image
$username = $_SESSION['username'];

// Prepare the SQL query to fetch blood donation records for the user
$query1 = "SELECT blood_group, quantity, location FROM blood_groups WHERE username = ?"; // Ensure the column name matches your DB
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

// Initialize variables for user details
$user_image = htmlspecialchars($user['user_image'], ENT_QUOTES);
$email = htmlspecialchars($user['email'], ENT_QUOTES);

// Calculate the number of donations
$blood_donated = $result1->num_rows; // Count the number of rows returned

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic styles for the slider */
        .slider {
            position: relative;
            width: 100%;
            max-width: 600px;
            margin: auto;
            overflow: hidden;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .slides {
            display: flex;
            transition: transform 0.5s ease;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
            padding: 20px;
            text-align: center;
        }
        .slider-buttons {
            text-align: center;
            margin-top: 10px;
        }
        .slider-button {
            cursor: pointer;
            padding: 10px 20px;
            margin: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
        }
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
    <header>
        <img src="water.png" class="logo">
        <img src="nethaji.webp" class="freedom-fighter-image">
        <h1>Welcome, <?php echo htmlspecialchars($username, ENT_QUOTES); ?></h1>
        <p>Email: <?php echo $email; ?></p>

        <!-- Display user image -->
        <div>
            <img src="<?php echo $user_image; ?>" alt="User  Image" class="user-image">
        </div>

        <a href="logout.php">Logout</a>
    </header>

    <main>
        <h2>Donation Registration</h2>
        
        <div class="slider">
            <div class="slides" id="slides">
                <div class="slide">
                    <h1>User Profile Details</h1>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($username, ENT_QUOTES); ?></p>
                    <p><strong>Blood Donated (times):</strong> <?php echo $blood_donated; ?></p>
                    <div>
                        <strong>Profile Image:</strong><br>
                        <img src="<?php echo $user_image; ?>" alt="User  Image" style="max-width: 200px;">
                    </div>
                    
                    <h1>Blood Donation Records</h1>
                    <?php
                    if ($result1->num_rows > 0) {
                        echo "<table border='1'>
                                <tr>
                                    <th>Blood Group</th>
                                    <th>Quantity</th>
                                    <th>Location</th>
                                </tr>";
                        
                        // Fetch and display each record
                                                // Fetch and display each record
                                                while ($row = $result1->fetch_assoc()) {
                                                    echo "<tr>
                                                            <td>" . htmlspecialchars($row['blood_group'], ENT_QUOTES) . "</td>
                                                            <td>" . htmlspecialchars($row['quantity'], ENT_QUOTES) . "</td>
                                                            <td>" . htmlspecialchars($row['location'], ENT_QUOTES) . "</td>
                                                          </tr>";
                                                }
                                                echo "</table>";
                                            } else {
                                                echo "<h1>No blood donation records found.</h1>";
                                            }
                                            ?>
                                        </div>
                        
                                        <div class="slide">
                                            <h3>Update Image</h3>
                                            <form action="update_image.php" method="POST" enctype="multipart/form-data">
                                                <label for="user_image">Upload New Image:</label>
                                                <input type="file" name="user_image" id="user_image" required>
                                                <button type="submit">Update Image</button>
                                            </form>
                                        </div>
                                        <div class="slide">
                                            <h3>Update Password</h3>
                                            <form action="update_password.php" method="POST">
                                                <label for="new_password">New Password:</label>
                                                <input type="password" name="new_password" id="new_password" required>
                                                <button type="submit">Update Password</button>
                                            </form>
                                        </div>
                                        <div class="slide">
                                            <h3>Donate Blood</h3>
                                            <form action="add_blood_group.php" method="POST">
                                                <label for="username">User Name:</label>
                                                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>" readonly required>
                                                <label for="blood_group">Blood Group:</label>
                                                <select id="blood_group" name="blood_group" required>
                                                    <option value="">Select</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                </select>
                                                <label for="quantity">Quantity:</label>
                                                <input type="number" name="quantity" id="quantity" required>
                                                <label for="location">Location:</label>
                                                <input type="text" name="location" id="location" required>
                                                <button type="submit">Add Blood Group</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="slider-buttons">
                                    <button class="slider-button" onclick="changeSlide(-1)">Previous</button>
                                    <button class="slider-button" onclick="changeSlide(1)">Next</button>
                                </div>
                            </main>
                        
                            <footer>
                                <p>&copy; 2024 Blood Bank. All rights reserved.</p>
                            </footer>
                        
                            <script>
                                let currentSlide = 0;
                        
                                function changeSlide(direction) {
                                    const slides = document.getElementById('slides');
                                    const totalSlides = slides.children.length;
                        
                                    // Update the current slide index
                                    currentSlide += direction;
                        
                                    // Loop back to the first slide if at the end
                                    if (currentSlide < 0) {
                                        currentSlide = totalSlides - 1;
                                    } else if (currentSlide >= totalSlides) {
                                        currentSlide = 0;
                                    }
                        
                                    // Move the slides container to show the current slide
                                    const offset = -currentSlide * 100; // Each slide takes 100% width
                                    slides.style.transform = `translateX(${offset}%)`;
                                }
                            </script>
                        </body>
</html>