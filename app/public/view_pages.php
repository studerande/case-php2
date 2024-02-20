<?php

declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

$page = new Page();

// Select all pages
$pages = $page->select_all();
$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Default to 0 if id parameter is not set

// Get data for the selected page if an ID is provided
$pageData = null;
if ($pageId) {
    foreach ($pages as $p) {
        if ($p['id'] === $pageId) {
            $pageData = $p;
            break;
        }
    }
}

include "_includes/header.php";

// Om en specifik sida är vald
if ($pageData) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title><?php echo htmlspecialchars($pageData['title']); ?></title>

    </head>

    <body class="bg-blue-100">

        <div class="container mx-auto p-10">
            <img src="<?php echo htmlspecialchars($pageData['image_path']); ?>" alt="Page Image" class="max-w-full rounded-lg pb-10">
            <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($pageData['title']); ?></h1>
            <p class="text-lg text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($pageData['content'])); ?></p>
        </div>

    </body>

    </html>

<?php
}
// Display the list of all pages
?>
<link rel="stylesheet" href="css/style.css">
<div class="bg-slate-50 w-full">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <div>
            <div class="navbar">
                <h2 class="text-2xl font-semibold ">All Pages</h2>
                <br>
                <ul class="flex gap-4 w-full ">
                    <?php foreach ($pages as $row) : ?>
                        <li class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                            <a href="view_pages.php?id=<?= $row['id'] ?>" class="group">
                                <div class="h-44 bg-center bg-cover w-full " style="background-image: url('<?php echo htmlspecialchars($row['image_path']) ?>');">

                                </div>
                                <div class="p-4">
                                    <h2 class="text-2xl font-semibold "><?= $row['title'] ?></h2>
                                    <div class="text-xs text-slate-600">
                                        Created <?= $row['date_created'] ?> by <?= $row['username'] ?>
                                    </div>
                                </div>
                                <!-- Edit button -->
                                <form action="edit_page.php" method="get" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>"><br>
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">Redigera sida</button>

                                </form>
                                <?php if (isset($_SESSION['user_id']) && $row['user_id'] === $_SESSION['user_id']) : ?>
                                    <form action="deletePage.php" method="post" style="display: inline;">
                                        <input type="hidden" name="page_id" value="<?= $row['id'] ?>">
                                        <br>
                                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                    </form>

                                <?php endif; ?>





                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include "_includes/footer.php"; ?>