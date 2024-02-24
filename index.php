
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to SJaCS'S Aleph Project</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
</body>
</html>





<?php
session_start();

if (!isset($_SESSION["user"])) {
   header("Location: login.php");
   exit();
}

// Check if the role is set in the session user array
if (!isset($_SESSION["user"]["role"])) {
    // Redirect to default page if role is not set
    header("Location: index.php");
    exit();
}

// Check the user's role
$role = $_SESSION["user"]["role"];

// Redirect based on the role
if ($role === "admin") {
    header("Location: admin.php");
    exit();
} elseif ($role === "teacher") {
    header("Location: teachers.php");
    exit();
} elseif ($role === "student") {
    header("Location: students.php");
    exit();
} elseif ($role === "ICTteacher") {
    header("Location: ictteacher.php");
    exit();
} elseif ($role === "STEMteacher") {
    header("Location: stemteacher.php");
    exit();
} elseif ($role === "GASteacher") {
    header("Location: gasteacher.php");
    exit();
} elseif ($role === "ABMteacher") {
    header("Location: abmteacher.php");
    exit();
} elseif ($role === "HUMMSteacher") {
    header("Location: hummsteacher.php");
    exit();
} elseif ($role === "ICT") {
    header("Location: ictstudent.php");
    exit();
} elseif ($role === "STEM") {
    header("Location: stemstudent.php");
    exit();
} elseif ($role === "GAS") {
    header("Location: gasstudent.php");
    exit();
} elseif ($role === "ABM") {
    header("Location: abmstudent.php");
    exit();
} elseif ($role === "Humms") {
    header("Location: hummsstudent.php");
    exit();
}

// Default redirect if the role is not recognized
header("Location: index.php");
exit();
?>
