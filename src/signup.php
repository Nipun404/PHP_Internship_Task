<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "php_project";
$conn = mysqli_connect($servername, $username,$password, $database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $upassword = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Validate user inputs
    if (empty($name) || empty($email) || empty($upassword)) {
        echo "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (strlen($upassword) < 8) {
        echo "Password must be at least 8 characters long.";
    } elseif (strlen($phone)!=10) {
        echo "Phone number must be of 10 digits.";
    } else {
        
        // Sanitize user inputs to prevent SQL injection
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $upassword = mysqli_real_escape_string($conn, $upassword);
        $address = mysqli_real_escape_string($conn, $address);
        $phone = mysqli_real_escape_string($conn, $phone);

        $hashedPassword = password_hash($upassword, PASSWORD_DEFAULT);
        // Insert data into the database
        $sql = "INSERT INTO `users` (`name`, `email`, `password`, `address`, `phone`) VALUES ('$name', '$email', '$hashedPassword', '$address', '$phone')";
        
        try {
            if (mysqli_query($conn, $sql)) {
                echo 'Registered Successfully!!! ';
            } else {
                echo"Not registered because of " . mysqli_error($conn);
            }
        } catch (mysqli_sql_exception $e) {
            // Check if it's a duplicate entry error
            if (strpos($e->getMessage(), "Duplicate entry") !== false) {
                echo "Email address already exists.";
            } else {
                echo "An error occurred: " . $e->getMessage();
            }
        }
    }
    }
?>
