<?php


// se till att sessioner används på sidan
session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

$user = new User();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
</head>

<body>

    <?php
    include "_includes/header.php";
    ?>

    <h1>Register</h1>
    <form action="" method="post">
        <p>
            <label for="username">Användarnamn: </label>
            <input type="text" name="username" id="username">
        </p>
        <p>
            <label for="password">Lösenord: </label>
            <input type="password" name="password" id="password">
        </p>
        <button type="submit">Registrera</button>
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = $user->register($username, $password);

        if ($result) {
            if (is_numeric($result)) {
              header("Location: login.php");
            } else {
                echo $result;
            }
        }
    }

    ?>


    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>