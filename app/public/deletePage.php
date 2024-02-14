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

?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;

    if ($pageId > 0) {
        $page = new Page(); // Create an instance of the Page class
        $deleted = $page->delete($pageId, $_SESSION['user_id']); // Call the delete method

        if ($deleted) {
            header("Location: view_pages.php");
            exit();
        } else {
            include "_includes/header.php";
            echo "Du kan inte radera denna sida då det inte är du som har skapat den.";
            exit();
        }
    }
}

header("Location: view_pages.php");
exit();
?>

</body>
</html>
