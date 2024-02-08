<header>
    inloggad av 

    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>

    <!-- <?php 
    print_r2($_SESSION);
    ?>  -->
</header>
<nav>
    <a href="/">Skapa din egna sida</a> | 
    <a href="login.php">Logga in</a> | 
    <a href="logout.php">Logga ut</a> | 
    <a href="register.php">Registrera</a> | 
    <a href="view_pages.php">Kolla på andras sidor</a> | 
</nav>
<hr>
