<?php


declare(strict_types=1);

session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";

$sql = "SELECT pages.*, `user`.username FROM pages JOIN `user` ON pages.user_id = `user`.id";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

$pageId = isset($_GET['id']) ? (int)$_GET['id'] : ($rows[0]['id'] ?? 0); // Set default value to the first page ID


$sql = "SELECT * FROM pages WHERE id = :pageId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
$stmt->execute();
$pageData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pageData) {
  
    echo "Page not found";
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

    <?php
    include "_includes/header.php";
    ?>
    <h1><?php echo htmlspecialchars($pageData['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($pageData['content'])); ?></p>
    <img src="<?php echo htmlspecialchars($pageData['image_path']); ?>" alt="Page Image">

<div class="navbar">
    <h4>All Pages</h4>
    <ul>
    <?php

foreach ($rows as $row) : ?>
   <li>
       <a href="view_pages.php?id=<?= $row['id'] ?>">
           <strong><?= $row['title'] ?></strong><br>
           <?= $row['content'] ?><br>
           Created at: <?= $row['date_created'] ?><br>
           Published by: <?= $row['username'] ?>


           <?php if(isset($_SESSION['user_id'])) : ?>

            <form action="deletePage.php" method="post" style="display: inline;">
        
            <input type="hidden" name="page_id" value=" <?= $row['id'] ?>" >
            <button type="submit" >delete</button>
        </form>

        <?php endif; ?>
           
           ?>
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