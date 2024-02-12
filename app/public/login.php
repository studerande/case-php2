<?php
session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/User.php";
$user = new User();



?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
</head>

<body>

    <?php

    include "_includes/header.php";

    ?>

<h1>login</h1>
    <form action="" method="post">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">

        <label for="password">Password: </label>
        <input type="password" name="password" id="password">

        <button type="submit">Login</button>
    </form>

    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $user->login($username, $password);

    if ($result) {
        $_SESSION['username'] = $result['username'];
        header("Location: index.php");
    } else {
        echo "Login failed";
    }
}

?>
