<header>
   

  
</header>
<nav class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
     
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex flex-shrink-0 items-center">
    
        </div>
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Skapa din egna sida!</a>
            <a href="login.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Logga in</a>
            <a href="logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Logga ut</a>
            <a href="register.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Registera</a>
            <a href="view_pages.php" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">Kolla på andras sidor</a>
            
          </div>
        </div>
        
      </div>
    <p class="text-white">
      Logged in by <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>
    <p>
       

    
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->

</nav>

