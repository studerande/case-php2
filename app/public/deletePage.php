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
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  
    $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;

    if ($pageId > 0) {
        
        $sql = "DELETE FROM pages WHERE id = :pageId AND user_id = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
               
                header("Location: view_pages.php");
                exit();
            } else {
                
                include "_includes/header.php";
                echo "Du kan inte radera denna sida då det inte är du som har skappat den.";
                exit();
            }
        } catch (PDOException $error) {
         
            echo "Error: " . $error->getMessage();
            exit();
        }
    }
}

header("Location: view_pages.php");
exit();
?>
