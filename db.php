<?php
$servername = "localhost"; // Assuming your database is on the same machine
$username = "root";        // Your MySQL username (default is "root" for XAMPP)
$password = "";            // Your MySQL password (default is blank for XAMPP)
$dbname = "empoweredu"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
