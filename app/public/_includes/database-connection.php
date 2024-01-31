<?php


$servername = "mysql";
$database = "db_case_php";
$username = "db_user";
$password = "db_password";

// data source name
$dsn = "mysql:host=$servername;dbname=$database";

try {

    // connect to database
    $pdo = new PDO($dsn, $username, $password);

    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// funktion för att skapa tabellen pages 

function setup_pages(PDO $pdo)
{
    // Check if the image_path column exists before trying to create it
    $checkColumn = $pdo->query("SHOW COLUMNS FROM pages LIKE 'image_path'");
    
    if ($checkColumn->rowCount() == 0) {
        // Create the image_path column if it does not exist
        $sqlAlter = "ALTER TABLE pages ADD COLUMN image_path VARCHAR(255)";
        $pdo->exec($sqlAlter);
    }

    // Create the pages table
    $sql = "CREATE TABLE IF NOT EXISTS pages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        user_id INT NOT NULL,
        content TEXT,
        date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
        image_path VARCHAR(255), 
        FOREIGN KEY (user_id) REFERENCES user(user_id)
    );";

    $pdo->exec($sql);

    // Create the images table
    $sqlImages = "CREATE TABLE IF NOT EXISTS images (
        id INT AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(255) NOT NULL,
        page_id INT,
        FOREIGN KEY (page_id) REFERENCES pages(id)
    )";

    $pdo->exec($sqlImages);
}




// funktion för att skapa tabellen user
function setup_user($pdo)
{
    $sql = "CREATE TABLE IF NOT EXISTS `user` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(20) NOT NULL,
        `password` varchar(255) NOT NULL,
        PRIMARY KEY (`user_id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $pdo->exec($sql);
}

function setup_images($pdo)
{
    $sql = "CREATE TABLE IF NOT EXISTS image (
        id INT AUTO_INCREMENT PRIMARY KEY,
        url VARCHAR(255) NOT NULL,
        page_id INT,
        FOREIGN KEY (page_id) REFERENCES pages(id)
    )";

    $pdo->exec($sql);
}