<?php

declare(strict_types=1);

session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";

// Set the correct timezone
date_default_timezone_set("Europe/Stockholm");

// Setup tables if not exists
setup_pages($pdo);
setup_user($pdo);
setup_images($pdo);

// Initialize variables
$page_name = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $page_name = trim($_POST['page_name']);
    $content = $_POST['content'];
    $date_created = date('Y-m-d H:i:s');

    // File upload handling
    $image_path = "";  // Variable to store the path of the uploaded image

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = "uploads/";  // Specify the directory where you want to store uploaded images
        $uploaded_file = $upload_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
            $image_path = $uploaded_file;
        } else {
            echo "Error uploading image.";
            // Handle the error accordingly
        }
    }

    if (strlen($page_name) >= 2) {
        // Save to the database
        $sql = "INSERT INTO pages (title, user_id, content, date_created, image_path)
                VALUES (:title, :user_id, :content, :date_created, :image_path)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $page_name);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date_created', $date_created);
            $stmt->bindParam(':image_path', $image_path);
            $stmt->execute();

            // Redirect to the view_page.php with the newly created page's ID
            $newPageId = $pdo->lastInsertId();
            header("Location: view_pages.php?id=$newPageId");

            exit();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }
}

// Fetch data from the database
$sql = "SELECT pages.*, `user`.username FROM pages JOIN `user` ON pages.user_id = `user`.id";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include "_includes/header.php";
    ?>
    <h1 class="Rubrik"><?= $title ?></h1>
    <div class="content">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

            <p>
                <label for="page_name">Page Name</label>
                <input type="text" name="page_name" id="page_name" required minlength="2" maxlength="25">
            </p>

            <p>
                <label for="content">Content</label>
                <textarea name="content" id="content" cols="30" rows="10"></textarea>
            </p>

            <p>
                <label for="image">Upload Image</label>
                <input type="file" name="image" id="image">
            </p>

            <p>
                <input type="submit" value="Save" class="button">
                <input type="reset" value="Reset" class="button">
            </p>

        </form>
    </div>

    <?php
    include "_includes/footer.php";
    ?>
</body>

</html>
