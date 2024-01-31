<header>
    Ett sidhuvud...

    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>

    <?php 
    print_r2($_SESSION);
    ?> 
</header>
<nav>
    <a href="/">Start</a> | 
    <a href="login.php">Logga in</a> | 
    <a href="logout.php">Logga ut</a> | 
    <a href="register.php">Registrera</a> | 
    <a href="pages.php">Skapa din egna sida</a> | 
</nav>
<hr>