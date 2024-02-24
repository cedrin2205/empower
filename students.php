<?php
session_start();

// Check if user is logged in and is a student
if (!isset($_SESSION['user'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Check if the user is a student
if ($_SESSION['user']['role'] !== 'student') {
    header("Location: index.php");  // Redirect to home page or unauthorized page
    exit();
}

// Include the teacher's database connection file
include "databaseteach.php";

// Query for the images uploaded by teachers
$sql = "SELECT * FROM images ORDER BY id DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="path_to_your_bootstrap.css">
    <link rel="stylesheet" href="upload.css">
    <title>User Dashboard</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            margin-top: -500px; /* Adjust as needed for vertical positioning */
            position: fixed;
        }
        .contain {
            margin-top: -150px; /* Adjust as needed for vertical spacing */
            position: fixed;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .alb {
            position: relative;
            width: 200px;
            height: 200px;
            padding: 5px;
            margin-top: -50px;
            cursor: pointer; /* Added cursor to indicate clickability */
        }
        .alb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Add the new CSS for the image modal */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 800px;
            max-height: 80%;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Students</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
    <div class="gallery">
        <?php 
        if (mysqli_num_rows($res) > 0) {
            while ($images = mysqli_fetch_assoc($res)) { ?>
                <div class="alb">
                    <img src="uploads/<?=$images['image_url']?>" alt="Uploaded Image">
                </div>
            <?php }
        }
        ?>
    </div>
    
    <!-- Add the image modal at the bottom of the body section -->
    <div class="image-modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="expandedImg">
    </div>

    <script>
        // JavaScript for image enlarging
        const images = document.querySelectorAll('.alb img');
        const modal = document.querySelector('.image-modal');
        const modalImg = document.querySelector('.modal-content');

        images.forEach(img => {
            img.addEventListener('click', () => {
                modal.style.display = 'block';
                modalImg.src = img.src;
            });
        });

        document.querySelector('.close').addEventListener('click', function() {
            modal.style.display = 'none';
        });
    </script>
</body>
</html>
