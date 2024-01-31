<?php


declare(strict_types=1);

session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";

$sql = "SELECT pages.*, `user`.username FROM pages JOIN `user` ON pages.user_id = `user`.id";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

// Get page ID from the URL parameter
$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch page data from the database
$sql = "SELECT * FROM pages WHERE id = :pageId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
$stmt->execute();
$pageData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pageData) {
    // Handle case where the page is not found
    echo "Page not found";
    exit;
}

// Display the page content
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

    <?php
    include "_includes/header.php";
    ?>
    <h1><?php echo htmlspecialchars($pageData['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($pageData['content'])); ?></p>
    <img src="<?php echo htmlspecialchars($pageData['image_path']); ?>" alt="Page Image">

    <!-- Your side navigation bar code goes here -->
<!-- Navigation Bar -->
<div class="navbar">
    <h4>All Pages</h4>
    <ul>
    <?php
var_dump($rows);  // Add this line for debugging
foreach ($rows as $row) : ?>
   <li>
       <a href="view_page.php?id=<?= $row['id'] ?>">
           <strong><?= $row['title'] ?></strong><br>
           <?= $row['content'] ?><br>
           Created at: <?= $row['date_created'] ?><br>
           Published by: <?= $row['username'] ?>
       </a>
   </li>
<?php endforeach; ?>

    </ul>
</div>

    
    <?php
     
    include "_includes/footer.php";



    ?>
</body>
</html>