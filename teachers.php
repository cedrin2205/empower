<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Check if user has the 'teacher' role before allowing access to the teacher page
if ($_SESSION['user']['role'] !== 'teacher') {
    header("Location: index.php");  // Redirect to home page or unauthorized page
    exit();
}

// Check if a specific image needs to be deleted
if (isset($_GET['delete_image'])) {
    $imageToDelete = $_GET['delete_image'];

    // Implement image deletion logic here (e.g., delete from the server and the database)
    include "databaseteach.php";

    // Delete from the database (change 'images' to your actual table name)
    $deleteQuery = "DELETE FROM images WHERE image_url = '$imageToDelete'";
    if (mysqli_query($conn, $deleteQuery)) {
        // Successfully deleted from the database, now delete the file
        if (unlink("uploads/$imageToDelete")) {
            // File deleted, redirect to refresh the page
            header("Location: teachers.php");
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
        <h1>Welcome Teachers</h1>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
    <div class="contain">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="my_image">
            <input type="submit" name="submit" value="Upload">
        </form>
    </div>
    <div class="gallery">
        <?php 
        include "databaseteach.php";
        $sql = "SELECT * FROM images ORDER BY id DESC";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            while ($images = mysqli_fetch_assoc($res)) { ?>
                <div class="alb">
                    <img src="uploads/<?=$images['image_url']?>" alt="Uploaded Image">
                    <a class="delete-btn" href="teachers.php?delete_image=<?=$images['image_url']?>">X</a>
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
</body>
</html>
