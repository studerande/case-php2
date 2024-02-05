<?php

session_start();

$title = "About PHP";

include_once("_includes/database-connection.php");
include_once("_includes/global-functions.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>

<body>

    <h1>Ladda upp en fil</h1>

    <form action="handleUpload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="fileToUpload" />
        <button type="submit">Upload</button>
    </form>

</form>
    <?php
    include "_includes/header.php";
    ?>

 

    <?php
    include "_includes/footer.php";
    ?>


</body>

</html>


<!-- fråga om hur man gör för att lada upp bilden, om man ska se vem som laddat up den i php admin -->
<!-- måste det vara olika tabler av image -->
<!-- måste fixa navbar -->
<!--  fixa att man se sidorna även om man inte är inloggad -->
<!-- fixa med att kunna redigera eller skapa ny sida -->

<!-- ska fixa så att alla sidor som finns syns i navbaren -->
<!-- ska göra så att man se från vilken tabel det är från -->

<!-- måste göra att man kan ladd upp flera bilder  -->
<!-- att bilderna hamnar i image tabelen  -->
<!-- länka image tabel till pages tabellen det börjar med j  -->
<!-- är man inte inloggad kan man kolla på andra sidor -->