<?php
session_start(); // Start a session for user authentication

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $upassword = $_POST['password'];

    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $database = "php_project";
    $conn = mysqli_connect($servername, $username,$password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize user input
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Fetch user record by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        // Verify the entered password against the stored hashed password
        if (password_verify($upassword, $hashedPassword)) {
            // Password is correct; log the user in
            $_SESSION['user_id'] = $row['id']; // Store user ID in the session
            header("Location: dashboard.php"); // Redirect to the dashboard or another page
            exit();
        } else {
            echo 'Invalid email or password12221.';
        }
    } else {
        echo 'Invalid email or password.';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
