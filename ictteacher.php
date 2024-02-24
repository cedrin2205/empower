<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Check if user has the 'ICTteacher' role before allowing access to the page
if ($_SESSION['user']['role'] !== 'ICTteacher') {
    header("Location: index.php");  // Redirect to home page or unauthorized page
    exit();
}

// Check if a specific image needs to be deleted
if (isset($_GET['delete_image'])) {
    $imageToDelete = $_GET['delete_image'];

    // Implement image deletion logic here (e.g., delete from the server and the database)
    include "ictdb.php";

    // Delete from the database (change 'images' to your actual table name)
    $deleteQuery = "DELETE FROM images WHERE image_url = '$imageToDelete'";
    if (mysqli_query($conn, $deleteQuery)) {
        // Successfully deleted from the database, now delete the file
        if (unlink("uploads/$imageToDelete")) {
            // File deleted, redirect to refresh the page
            header("Location: ictteacher.php");
            exit();
        } else {
            // Handle file deletion error
            echo "Failed to delete the file from the server.";
        }
    } else {
        // Handle database deletion error
        echo "Failed to delete the image from the database.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="upload.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            position: absolute;
            margin-top: -515px;
            position: fixed;
            width: 1500px;
        }
        .contain {
            margin-top: -500px;
            margin-right: -1090px;
            position: fixed;
            background-color: skyblue;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
        .gallery {
            margin-bottom: 100px;
            margin-left:400px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .alb {
            position: relative;
            width: 200px;
            height: 200px;
            padding: 5px;
            margin-top: 200px;
        }
        .alb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            color: white;
        }
        a {
            text-decoration: none;
            color: black;
        }
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
        .panel{
            height: 100vh;
            width: 400px;
            background-color:#2a52be;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            z-index:3;
        }
        .bar{
            position: absolute;
            margin-top:-495px;
            height: 200px;
            width: 1800px;
            padding: 50px;
            background-color: skyblue;
        }
    </style>
</head>
<body><div class="bar">
</div>
<div class="panel">
    <h2>ICT Students</h2>

    <?php
     include "database.php";
    // Assuming you have a database connection established and stored in $conn
    $role = 'ICT'; // The role you want to filter

    $sql = "SELECT id, full_name FROM users WHERE role = '$role'";
    $users_result = mysqli_query($conn, $sql) or die("Error in SQL query");

    if (mysqli_num_rows($users_result) > 0) {
        while ($user = mysqli_fetch_assoc($users_result)) {
            $full_name = $user['full_name'];
            echo "<p style='font-size: 20px;'>Name: $full_name</p>";

            // You can customize how the student information is displayed inside the panel
        }
    } else {
        echo "No ICT students found.";
    }
    ?>
</div>
    <div class="container">
        <h1>Welcome ICT Teacher</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
    <div class="contain">
        <form action="ictupload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="my_image">
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>
    <div class="gallery">
        <?php 
        include "ictdb.php";
        $limit = 5; 
        $sql = "SELECT * FROM images ORDER BY id DESC LIMIT $limit";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            while ($images = mysqli_fetch_assoc($res)) { ?>
                <div class="alb">
                    <img src="uploads/<?=$images['image_url']?>" alt="Uploaded Image">
                    <a class="delete-btn" href="ictteacher.php?delete_image=<?=$images['image_url']?>">X</a>
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
    document.addEventListener('click', function (e) {
        if (e.target && e.target.matches('.alb img')) {
            document.getElementById('expandedImg').src = e.target.src;
            document.querySelector('.image-modal').style.display = 'block';
        }
    });

    document.querySelector('.close').addEventListener('click', function() {
        document.querySelector('.image-modal').style.display = 'none';
    });
    </script>
<script>
        // JavaScript for image enlarging and marking as seen
        document.addEventListener('click', function (e) {
            if (e.target && e.target.matches('.alb img')) {
                // Get the image URL
                var imageUrl = e.target.src;

                // Update the 'seen' status in the database
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Reload the page after marking as seen
                        location.reload();
                    }
                };
                xhttp.open("GET", "ictteacher.php?mark_as_seen=" + encodeURIComponent(imageUrl), true);
                xhttp.send();

                // Display the image in the modal
                document.getElementById('expandedImg').src = imageUrl;
                document.querySelector('.image-modal').style.display = 'block';
            }
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.querySelector('.image-modal').style.display = 'none';
        });
    </script>
</body>
</html>