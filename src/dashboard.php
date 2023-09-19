<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$userID = $_SESSION['user_id'];

$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "php_project";
$conn = mysqli_connect($servername, $username,$password, $database);


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user details from the database using the user ID
$sql = "SELECT name, email, address, phone FROM users WHERE id = $userID";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row['name'];
    $userEmail = $row['email'];
    $userAddress = $row['address'];
    $userPhone = $row['phone'];
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // This is an AJAX request, don't echo anything
    } else {
        // This is a regular page load, echo the content
        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '    <meta charset="UTF-8">';
        echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '    <title>Dashboard</title>';
        echo '    <!-- Include Tailwind CSS -->';
  
       echo '<script src="https://cdn.tailwindcss.com"></script>
  <script src="../tailwind.js"></script>';
        echo '</head>';
        echo '<body class="bg-gray-100">';
        echo '    <div class="container px-8 py-10">';
        echo '        <h1 class="text-3xl font-bold mb-4">Welcome to the Dashboard, <?php echo $userName; ?></h1>';
        echo '        <div class="bg-white p-6 rounded-lg shadow-md">';
        echo '    <p class="mb-2"><b>Email:</b> ' . $userEmail . '</p>';
        echo '    <p class="mb-2"><b>Address:</b> ' . $userAddress . '</p>';
        echo '    <p class="mb-2"><b>Phone:</b> ' . $userPhone . '</p>';
         echo '       </div>';
      
        echo '    </div>';
        echo '       <a href="logout.php" class="ml-16 my-32 w-full text-white   focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-primary-600 hover:bg-primary-700 focus:ring-primary-800">Logout</a>';
        echo '</body>';
        echo '</html>';


        
    }
} else {
   echo 'Incorrect user id';
}

// Close the database connection
mysqli_close($conn);
?>



