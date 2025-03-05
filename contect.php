<?php
// Database connection
$host = "localhost";
$username = "root"; // Update if different
$password = "";     // Update if set
$database = "shop_product";

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
$name = $email = $message_text = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $message_text = $conn->real_escape_string($_POST["message"]);

    // Insert the form data into the database
    $sql = "INSERT INTO contact_messages (name, email, message) 
            VALUES ('$name', '$email', '$message_text')";

    if ($conn->query($sql) === TRUE) {
        $message = "Thank you for contacting us!";
        $name = $email = $message_text = ""; // Clear the form fields
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Quick Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
 

<div class="navbar">
        <div class="logo">

        </div>
        
        <div class="top">

            <a href="index.php">Home</a>
            <a href="about.html">About</a>
        </div>
       
        
        
    </div>

    <div class="container">
        <h2>Contact Us</h2>
        <p>Have questions or need assistance? Feel free to reach out to us.</p>

        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="contect.php" method="POST">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="4" required><?php echo htmlspecialchars($message_text); ?></textarea>

            <button type="submit">Submit</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Quick Cart. All Rights Reserved.</p>
    </footer>
</body>
</html>
