<header>
    Ett sidhuvud...

    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>
</header>
<nav>
    <a href="/">Start</a> | 
    <a href="login.php">Logga in</a> | 
    <a href="logout.php">Logga ut</a> | 
    <a href="register.php">Registrera</a> | 
    <a href="pages.php">Test language (test.php)</a> | 
</nav>
<hr>