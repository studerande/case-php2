<?php

declare(strict_types=1);

session_start();

include_once "_includes/database-connection.php";
include_once "_includes/global-functions.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get the page ID from the form submission
    $pageId = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;

    // Validate the page ID (add additional checks if necessary)
    if ($pageId > 0) {
        // Perform the deletion
        $sql = "DELETE FROM pages WHERE id = :pageId AND user_id = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pageId', $pageId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);

        try {
            $stmt->execute();

            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                // Redirect to a success page or the main page
                header("Location: view_pages.php");
                exit();
            } else {
                // No rows affected, page not found or user unauthorized
                echo "Page not found or unauthorized access.";
                exit();
            }
        } catch (PDOException $error) {
            // Handle the error, e.g., display an error message
            echo "Error: " . $error->getMessage();
            exit();
        }
    }
}

// Redirect if the form was not submitted correctly
header("Location: view_pages.php");
exit();
?>
