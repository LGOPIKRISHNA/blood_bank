<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Home</title>
    <link rel="stylesheet" href="styles.css">
    <script>
            function toggleForms(formType) {
                document.getElementById('loginForm').style.display = formType === 'login' ? 'block' : 'none';
                document.getElementById('signupForm').style.display = formType === 'signup' ? 'block' : 'none';
            }
        </script>
</head>
<body>
    <header>
        <img src="water.png" class="logo">
        <img src="nethaji.webp" class="freedom-fighter-image ">
        <h1>Welcome to BloodBridge</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#" onclick="toggleForms('login')">Login</a></li>
                <li><a href="#" onclick="toggleForms('signup')">Signup</a></li>
                <li><a href="#donors">Donors</a></li>
            </ul>
        </nav>
        <!-- <div class="scrolling-info">
            <p>Did you know? Every donation can save up to three lives! Join us in our upcoming blood donation drive on March 15th at the Community Center.</p>
        </div> -->
        
    </header>
    <div id="loginForm" style="display:none;">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>

    <div id="signupForm" style="display:none;">
    <h2>Signup</h2>
    <form action="signup.php" method="POST" enctype="multipart/form-data">
        <label for="new_username">Username:</label>
        <input type="text" id="new_username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="new_password">Password:</label>
        <input type="password" id="new_password" name="password" required>
        <label for="user_image">Upload Image:</label>
        <input type="file" id="user_image" name="user_image" accept="image/*" required>
        <button type="submit">Signup</button>
    </form>
</div>
    <main>
        <section class="hero">
            <h2>Donate Blood, Save Lives</h2>
            <p>Your contribution can make a difference!</p>
        </section>
        
        <section id="about">
            <h2>About Us</h2>
            <p>
                Welcome to our Blood Bank, a dedicated platform committed to saving lives through the power of blood donation. Every year, millions of people require blood transfusions due to medical emergencies, surgeries, and chronic illnesses. Our mission is to ensure that safe and sufficient blood is available for those in need.
            </p>
            <p>
                At our Blood Bank, we believe that every drop counts. We strive to create a community of compassionate individuals who understand the importance of donating blood. By joining our network, you become a vital part of a life-saving mission that can make a significant difference in the lives of patients and their families.
            </p>
        </section>

        <section class="importance">
            <h2>The Importance of Blood Donation</h2>
            <p>
                Blood donation is a selfless act that can save lives. It is essential for:
            </p>
            <ul>
                <li><strong>Emergency Situations:</strong> Blood is often needed in emergencies, such as accidents or natural disasters.</li>
                <li><strong>Medical Treatments:</strong> Patients undergoing surgeries, cancer treatments, or those with chronic illnesses often require blood transfusions.</li>
                <li><strong>Community Health:</strong> Regular blood donations help maintain a stable blood supply for hospitals and clinics in your area.</li>
            </ul>
        </section>

        <section class="features">
            <h2>Why Choose Our Blood Bank?</h2>
            <p>
                Our website offers a user-friendly experience for both donors and recipients. Here are some of the features that make us stand out:
            </p>
            <ul>
                <li><strong>Easy Registration:</strong> Sign up quickly and easily to become a donor or recipient.</li>
                <li><strong>Find Donation Drives:</strong> Stay updated on upcoming blood donation drives in your area.</li>
                <li><strong>Track Your Donations:</strong> Keep a record of your donations and see the impact you are making.</li>
                <li><strong>Community Support:</strong> Join a community of like-minded individuals who are passionate about saving lives.</li>
            </ul>
        </section>

        <section class="call-to-action">
            <h2>Join Us Today!</h2>
            <p>
                Your contribution can save lives. Whether you are a first-time donor or a regular contributor, we welcome you to join our mission. Sign up today and be a part of something greater. Together, we can make a difference!
            </p>
            <a href="#" onclick="toggleForms('signup')" class="btn">Sign Up Now</a>
        </section>

       
        <section id="donors">
            <h2>Our Valued Donors</h2>
            <p>We are grateful to the following individuals for their generous contributions:</p>
            <ul>
                <li>John Doe</li>
                <li>Jane Smith</li>
                <li>Michael Johnson</li>
                <li>Emily Davis</li>
                <li>David Brown</li>
                <li>Sarah Wilson</li>
                <li>Chris Lee</li>
                <li>Jessica Taylor</li>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Blood Bank. All rights reserved.</p>
    </footer>
</body>
</html>