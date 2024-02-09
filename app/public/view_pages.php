<?php
declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

$page = new Page();

$pages = $page->select_all();

$pageId = isset($_GET['id']) ? (int)$_GET['id'] : ($pages[0]['id'] ?? 0); 

$pageData = null;
foreach ($pages as $p) {
    if ($p['id'] === $pageId) {
        $pageData = $p;
        break;
    }
}

if (!$pageData) {
    include "_includes/header.php";
    echo "Det finns inga färdiga sidor att visa. Skapa först en sida sedan hamnar den här";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageData['title']); ?></title>
</head>

<body>

    <?php include "_includes/header.php"; ?>
    <h1><?php echo htmlspecialchars($pageData['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($pageData['content'])); ?></p>
    <img src="<?php echo htmlspecialchars($pageData['image_path']); ?>"  alt="Page Image">

    <div class="navbar">
        <h4>All Pages</h4>
        <ul>
            <?php
            // print_r2($pages);
            foreach ($pages as $row) : ?>
                <li>
                    <a href="view_pages.php?id=<?= $row['id'] ?>">
                        <strong><?= $row['title'] ?></strong><br>
                        <?= $row['content'] ?><br>
                        Created at: <?= $row['date_created'] ?><br>
                        Published by: <?= $row['username'] ?>


                        <?php if (isset($_SESSION['user_id'])) : ?>

                            <form action="deletePage.php" method="post" style="display: inline;">
                                <input type="hidden" name="page_id" value="<?= $row['id'] ?>">
                                <button type="submit">delete</button>
                            </form>

                            <!-- Edit button -->
                            <form action="edit_page.php" method="get" style="display: inline;" >
                                <input type="hidden" name="id" value="<?= $row['id'] ?>" >
                                <button type="submit" >Redigera sida</button>
                            </form>

                        <?php endif; ?>

                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php include "_includes/footer.php"; ?>
</body>

</html>
