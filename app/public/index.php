<?php

declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

$page = new Page();

var_dump($_SESSION['user_id']);
date_default_timezone_set("Europe/Stockholm");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $page_name = trim($_POST['page_name']);
    $content = $_POST['content'];
    $date_created = date('Y-m-d H:i:s');

    // Assuming the user is logged in and their user_id is stored in the session
    $user_id = $_SESSION['user_id'];

    // Handle file upload
    $image_url = null;
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Directory where images will be stored
        $image_name = uniqid('image_') . '_' . $_FILES['image']['name']; // Generate a unique name for the image
        $image_path = $upload_dir . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image_url = $image_path;
        } else {
            echo "Failed to upload image.";
        }
    }

    // Insert page data into the database
    $page_id = $page->create($page_name, $content, $date_created, $user_id);

    // Insert image data into the database if an image was uploaded and page_id is not null
    if ($image_url && $page_id !== null) {
        $image_model = new Image();
        $image_model->create($image_url, $page_id); // Pass the page_id to the create method
    } else {
        echo "Failed to insert image data into the database. Page ID is null.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Own Page</title>
</head>

<body>
    <?php include "_includes/header.php"; ?>
    <h1 class="Rubrik">Create Your Own Page</h1>
    <div class="content">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <p>
                <label for="page_name">Page Name (at least two characters)</label>
                <input type="text" name="page_name" id="page_name" maxlength="25">
            </p>
            <p>
                <label for="content">Content</label>
                <textarea name="content" id="content" cols="30" rows="10"></textarea>
            </p>
            <!-- Add image upload fields here if needed -->

            <p>
                <label for="image">Lägg upp bild ></label>
                <input type="file" name="image" id="image">
            </p>
            <p>
                <input type="submit" value="Save" class="button">
                <input type="reset" value="Reset" class="button">
            </p>
        </form>
    </div>
    <?php include "_includes/footer.php"; ?>
</body>

</html>
