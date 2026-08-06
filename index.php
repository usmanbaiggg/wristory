<?php
session_start();
include 'db.php';

// ================= Contact Form Backend Logic =================
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['other']) && !isset($_POST['phone']))
{ 
    $name =  $_POST['name'];
    $email =  $_POST['email'];
    $other =  $_POST['other'];

    $sql = "INSERT INTO contactus.contact (name, email, other, date) VALUES ('$name', '$email', '$other', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['contact_insert'] = true;
        header("Location: index.php#contact");
        exit();
    } else {
        $contact_error = "Error submitting message. Please try again.";
    }
}

// =================== REG form backend logic ====================
if (isset($_POST['phone']) && isset($_POST['age']) && isset($_POST['email']) && isset($_POST['name']) && !isset($_POST['other']))
{ 
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $sql = "INSERT INTO registration.reg (name, age, email, phone, date) VALUES ('$name', '$age', '$email', '$phone', current_timestamp())";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['reg_insert'] = true;
        header("Location: index.php#registration");
        exit();
    } else {
        $reg_error = "Error submitting registration. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wristory - Luxury Timepieces</title>
    <!-- Google Fonts for Professional Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Professional Hero Header Banner -->
    <header class="hero-banner">
        <div class="header-overlay">
            <span class="brand-tag">Elegance in Every Second</span>
            <h1>WRISTORY</h1>
            <p>Discover our handcrafted collection of luxury timepieces.</p>
            <a href="#home" class="hero-btn">Explore Collection</a>
        </div>
    </header>
 
    <!-- Modern Sticky Navbar -->
    <nav>
        <div class="nav-container">
            <a href="#home" class="logo">Wristory</a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#about">About Us</a>
                <a href="#contact">Contact</a>
                <a href="#registration">Register</a>
                <a href="#cart" class="cart-link">Cart 🛒</a>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="main-wrapper">

        <!-- 1. HOME / PRODUCTS SECTION -->
        <section id="home" class="page-section">
            <div class="section-title-box">
                <h2>Featured Masterpieces</h2>
                <p class="subtitle">Explore our exclusive collection of premium watches</p>
            </div>
            
            <div class="watch-grid">
                <?php
                $query = "SELECT * FROM products";
                $result = mysqli_query($conn, $query);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="watch-card">
                            <div class="card-img-wrapper">
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            </div>
                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                <p class="price">Rs. <?php echo number_format($row['price']); ?></p>
                                <button class="card-btn">View Details</button>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                    echo "<div class='empty-notice'><p>No products found in database right now.</p></div>";
                }
                ?>
            </div>
        </section>

        <!-- 2. ABOUT SECTION -->
        <section id="about" class="page-section alt-bg">
            <div class="section-title-box">
                <h2>About Wristory</h2>
                <p class="subtitle">Crafting elegance and precision for every second of your life.</p>
            </div>
            <div class="about-content">
                <p>Welcome to Wristory, your premier destination for luxury and reliable wristwatches. We are dedicated to delivering the absolute finest timepieces, combining timeless design with modern dependability and exceptional customer service.</p>
                <p>Founded in 2026, our brand has evolved through an uncompromised passion for premium accessories, meticulous market research, and a vision to redefine sophistication in every single tick.</p>
            </div>
        </section>

        <!-- 3. CONTACT SECTION -->
        <section id="contact" class="page-section">
            <div class="section-title-box">
                <h2>Get In Touch</h2>
                <p class="subtitle">Have any questions? Drop us a message below.</p>
            </div>
            
            <div class="form-card">
                <?php
                if (isset($_SESSION['contact_insert']) && $_SESSION['contact_insert'] == true) {
                    echo "<div class='alert-success'>✓ Thank you! Your message has been sent successfully.</div>";
                    unset($_SESSION['contact_insert']); 
                }
                if (isset($contact_error)) {
                    echo "<div class='alert-error'>$contact_error</div>";
                }
                ?>

                <form action="index.php#contact" method="post">
                    <div class="input-group">
                        <input type="text" name="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="input-group">
                        <textarea name="other" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>
        </section>
           
        <!-- 4. REGISTRATION SECTION -->
        <section id="registration" class="page-section alt-bg">
            <div class="section-title-box">
                <h2>Client Registration</h2>
                <p class="subtitle">Enter your details and submit for account confirmation</p>
            </div>

            <div class="form-card">
                <?php
                if (isset($_SESSION['reg_insert']) && $_SESSION['reg_insert'] == true) {
                    echo "<div class='alert-success'>✓ Thank you! Your registration was submitted successfully.</div>";
                    unset($_SESSION['reg_insert']); 
                }
                if (isset($reg_error)) {
                    echo "<div class='alert-error'>$reg_error</div>";
                }
                ?>

                <form action="index.php#registration" method="post">
                    <div class="input-group">
                        <input type="text" name="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="input-group">
                        <input type="text" name="age" placeholder="Enter your age" required>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your Email address" required>
                    </div>
                    <div class="input-group">
                        <input type="text" name="phone" placeholder="Enter your phone number" required>
                    </div>
                    <button type="submit" class="btn">Complete Registration</button>
                </form>
            </div>
        </section>

        <!-- 5. CART SECTION -->
        <section id="cart" class="page-section">
            <div class="section-title-box">
                <h2>Your Shopping Cart</h2>
                <p class="subtitle">Review your selected timepieces before checkout.</p>
            </div>
            <div class="empty-cart-container">
                <div class="cart-icon">🛒</div>
                <p class="empty-cart-msg">Your cart is currently empty.</p>
                <a href="#home" class="btn outline-btn">Continue Shopping</a>
            </div>
        </section>

    </main>

    <!-- Professional Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-brand">
                <h3>WRISTORY</h3>
                <p>Timeless elegance for modern individuals.</p>
            </div>
            <div class="footer-links">
                <a href="https://instagram.com/usmanbaiggg" target="_blank">Instagram</a>
                <a href="mailto:baig11430@gmail.com">Email Us</a>
                <a href="#contact">Support</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Wristory PK. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>