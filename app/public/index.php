<?php

declare(strict_types=1);

session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";

// if (!isset($_SESSION['user_id'])) {
//     // Redirect to the login page or display an error message
//     header("Location: login.php");
//     exit();
// }

if(!isset($_SESSION['user_id'])){
    
    header("Location: login.php");

    exit();
}

date_default_timezone_set("Europe/Stockholm");

setup_pages($pdo);
setup_user($pdo);
setup_images($pdo);


$page_name = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $page_name = trim($_POST['page_name']);
    $content = $_POST['content'];
    $date_created = date('Y-m-d H:i:s');

    $image_paths = [];  

    for ($i = 0; $i < 5; $i++) {
        $fileInputName = "image{$i}";

        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === 0) {
            $upload_dir = "uploads/";  
            $uploaded_file = $upload_dir . basename($_FILES[$fileInputName]['name']);

            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $uploaded_file)) {
                $image_paths[] = $uploaded_file; 
            } else {
                echo "Error uploading image.";
               
            }
        }
    }

    if (strlen($page_name) >= 2) {
      
        $sql = "INSERT INTO pages (title, user_id, content, date_created, image_path)
                VALUES (:title, :user_id, :content, :date_created, :image_path)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $page_name);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date_created', $date_created);

            $image_path = implode(',', $image_paths);
            $stmt->bindParam(':image_path', $image_path);

            $stmt->execute();

            $newPageId = $pdo->lastInsertId();
            header("Location: view_pages.php?id=$newPageId");

            exit();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }
}

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
    <h1 class="Rubrik">Gör din egna sida</h1>
    <div class="content">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

            <p>
                <label for="page_name">Sidan namn minst två tecken</label>
                <input type="text" name="page_name" id="page_name" maxlength="25">
            </p>

            <p>
                <label for="content">Text</label>
                <textarea name="content" id="content" cols="30" rows="10"></textarea>
            </p>

            <?php for ($i = 0; $i < 5; $i++) : ?>
                <p>
                    <label for="image<?= $i ?>">Lägg upp bild <?= $i + 1 ?></label>
                    <input type="file" name="image<?= $i ?>" id="image<?= $i ?>">
                </p>
            <?php endfor; ?>
    
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
