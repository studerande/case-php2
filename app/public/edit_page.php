<?php

declare(strict_types=1);

session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";

// kollar om man är inloggad
if (!isset($_SESSION['user_id'])) {
//    om man inte är inloggad så går man till login.php
    header("Location: login.php");
    exit;
}

// skaffa id från url
$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch page data från database
$sql = "SELECT * FROM pages WHERE id = :pageId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
$stmt->execute();
$pageData = $stmt->fetch(PDO::FETCH_ASSOC);

// kollar om sidan finns
if (!$pageData) {
    
    echo "Page not found";
    exit;
}

// kollar om from är klart
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Retrieve form data
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // uppdatera databasen
    $sql = "UPDATE pages SET title = :title, content = :content WHERE id = :pageId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
    $stmt->execute();

   
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
    <title>Redigera Page</title>
</head>
<body>

    <?php include "_includes/header.php"; ?>

    <h1>Redigera page</h1>

    <form action="edit_page.php?id=<?= $pageId ?>" method="post">
        <label for="title">Tittle:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($pageData['title']) ?>"><br><br>

        <label for="content">Text:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"><?= htmlspecialchars($pageData['content']) ?></textarea><br><br>

        <input type="submit" value="Save">
    </form>

    <?php include "_includes/footer.php"; ?>

</body>

</html>
