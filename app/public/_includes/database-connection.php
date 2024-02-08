<?php


$servername = "mysql";
$database = "db_case_php";
$username = "db_user";
$password = "db_password";

$dsn = "mysql:host=$servername;dbname=$database";

try {

    $pdo = new PDO($dsn, $username, $password);

    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    echo "<div class='absolute bottom-4 right-4 p-4 text-green-400 bg-green-100 inline-block rounded-md font-bold'  > Connected successfully. </div> ";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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

