<?php

declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit;
}

// Get the page ID from the URL parameter
$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch page data from the database
$sql = "SELECT * FROM pages WHERE id = :pageId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
$stmt->execute();
$pageData = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if page exists
if (!$pageData) {
    // Redirect or show error message
    echo "Page not found";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Retrieve form data
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // File upload handling
    $image_path = $pageData['image_path'];  // Initialize with current image path

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // Specify the directory where you want to store uploaded images
        $upload_dir = "uploads/";
        $uploaded_file = $upload_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
            // If image upload is successful, update image path
            $image_path = $uploaded_file;
        } else {
            echo "Error uploading image.";
            // Handle the error accordingly
        }
    }

    // Update the page in the database
    $sql = "UPDATE pages SET title = :title, content = :content, image_path = :image_path WHERE id = :pageId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
    $stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the view page
    header("Location: view_pages.php?id=$pageId");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>

<body>

    <?php include "_includes/header.php"; ?>

    <h1>Edit Page</h1>

    <form action="edit_page.php?id=<?= $pageId ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($pageData['title']) ?>"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"><?= htmlspecialchars($pageData['content']) ?></textarea><br><br>

        <label for="image">Image:</label><br>
        <!-- <img src="<?= htmlspecialchars($pageData['image_path']) ?>" alt="Current Image" style="max-width: 200px;"><br> -->
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Save">
    </form>

    <?php include "_includes/footer.php"; ?>

</body>

</html>
