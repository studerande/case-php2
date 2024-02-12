<?php
declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

if (!isset($_SESSION['user_id'])) {
   
    header("Location: login.php");
    exit;
}

$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$page = new Page();

$pageData = $page->findById($pageId);

if (!$pageData) {
   
    echo "Page not found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
 
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

  // File upload handling
$image_path = $pageData['image_path'];  // Initialize with current image path

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    // Specify the directory where you want to store uploaded images
    $upload_dir = "uploads/";
    $uploaded_file = $upload_dir . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaded_file)) {
        // If image upload is successful, store the image path in the image table
        $ImageModel = new Image();
        $ImageModel->storeImagePath($uploaded_file, $pageId);

        // Update $image_path if needed for display purposes
        $image_path = $uploaded_file;
    } else {
        echo "Error uploading image.";
        // Handle the error accordingly
    }
}

$success = $page->update($pageId, $title, $content);

    if ($success) {
       
        header("Location: view_pages.php?id=$pageId");
        exit;
    } else {
        echo "Failed to update page.";
    }
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
        <input type="text" id="title" name="title" value="<?= isset($pageData['title']) ? htmlspecialchars($pageData['title']) : '' ?>"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"><?= htmlspecialchars($pageData['content']) ?></textarea><br><br>

        <label for="image">Image:</label><br>
      
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Save">
    </form>

    <?php include "_includes/footer.php"; ?>

</body>

</html>
