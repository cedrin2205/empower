<?php
session_start();

function loginUser($email, $password, $conn) {
    $sql = "SELECT id, password, role FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if ($prepareStmt = mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $userId, $hashedPassword, $userRole);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $hashedPassword)) {
            // Login successful, store user details in session
            $_SESSION['user'] = [
                'id' => $userId,
                'role' => $userRole,
            ];
            // Redirect to the desired page after login
            header("Location: index.php");
            exit();
        } else {
            // Invalid login credentials
            return "Invalid email or password";
        }
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once "database.php";

    $loginError = loginUser($email, $password, $conn);

    if ($loginError) {
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo 'document.querySelector(".wrapper").classList.add("active-popup");';
        echo '});';
        echo '</script>';
    }
}
?>
