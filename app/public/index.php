<?php

declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";
$user = new User();
$page = new Page();
$image = new Image();


if (!isset($_SESSION['user_id'])) {
    // Användaren är inte inloggad, omdirigera till login.php
    header("Location: login.php");
    exit(); // Stoppa skriptet för att förhindra att sidan fortsätter laddas
}

date_default_timezone_set("Europe/Stockholm");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $page_name = trim($_POST['page_name']);
    $content = $_POST['content'];
    $date_created = date('Y-m-d H:i:s');

    // Assuming the user is logged in and their user_id is stored in the session
    $user_id = $_SESSION['user_id'];

    // Check if the page name, content, and image are provided
    if (empty($page_name) || empty($content) || empty($_FILES['image']['name'])) {
        echo "Please provide a page name, content, and upload an image.";
    } else {
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

        // Insert page data into the database only if page name, content, and image are provided
        if (!empty($page_name) && !empty($content) && $image_url) {
            $page_id = $page->create($page_name, $content, $date_created, $user_id);

            // Insert image data into the database if an image was uploaded and page_id is not null
            if ($page_id !== null) {
                $image_model = new Image();
                $image_model->create($image_url, $page_id); // Pass the page_id to the create method
            } else {
                echo "Failed to insert image data into the database. Page ID is null.";
            }
        }
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-blue-100">
    <?php include "_includes/header.php"; ?>
    <h1 class="Rubrik text-3xl text-center mt-8" >Create Your Own Page</h1>
    <div class="content max-w-md mx-auto mt-8 p-8 bg-slate-600 rounded-lg shadow-md">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="mb-4">
                <label for="page_name" class="block text-sm font-medium text-white">Page Name (at least two characters)</label>
                <input type="text" name="page_name" id="page_name" minlength="2" maxlength="25" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-white">Content</label>
                <textarea name="content" id="content" cols="30" rows="10" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-white">Upload Image</label>
                <input type="file" name="image" id="image" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="flex justify-between">
                <input type="submit" value="Save" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:bg-green-600 cursor-pointer">
                <input type="reset" value="Reset" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:bg-red-600 cursor-pointer">
            </div>
        </form>
    </div>
</body>

<!-- färgen på ingen fil har valts och om det bara är en sida som skapats -->
