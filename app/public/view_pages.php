<?php
declare(strict_types=1);

session_start();

include_once "_includes/global-functions.php";
include_once "_models/Database.php";
include_once "_models/Page.php";
include_once "_models/User.php";
include_once "_models/Image.php";

$page = new Page();

// Select all pages
$pages = $page->select_all();
$pageId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Default to 0 if id parameter is not set

// Get data for the selected page if an ID is provided
$pageData = null;
if ($pageId) {
    foreach ($pages as $p) {
        if ($p['id'] === $pageId) {
            $pageData = $p;
            break;
        }
    }
}

include "_includes/header.php";


// om en specefik sida är vald
if ($pageData) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title><?php echo htmlspecialchars($pageData['title']); ?></title>
     
    </head>
    <body>
        <h1><?php echo htmlspecialchars($pageData['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($pageData['content'])); ?></p>
        <img src="<?php echo htmlspecialchars($pageData['image_path']); ?>"  alt="Page Image">
    </body>
    </html>
    
    <?php
} 
// Display the list of all pages
?>

<div class="navbar">
<link rel="stylesheet" href="css/style.css">
    <h4>All Pages</h4>
    <ul>
        <?php foreach ($pages as $row) : ?>
            <li>
                <a href="view_pages.php?id=<?= $row['id'] ?>">
                    <strong><?= $row['title'] ?></strong><br>
                    <?= $row['content'] ?><br>
                    Created at: <?= $row['date_created'] ?><br>
                    Published by: <?= $row['username'] ?>

                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <form action="deletePage.php" method="post" style="display: inline;">
                            <input type="hidden" name="page_id" value="<?= $row['id'] ?>">
                            <button type="submit">delete</button>
                        </form>
                        <!-- Edit button -->
                        <form action="edit_page.php" method="get" style="display: inline;" >
                            <input type="hidden" name="id" value="<?= $row['id'] ?>" >
                            <button type="submit" >Redigera sida</button>
                        </form>
                    <?php endif; ?>

                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include "_includes/footer.php"; ?>


<div class="bg-white">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="sr-only">Products</h2>

    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
      <a href="#" class="group">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
          <img src="https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-01.jpg" alt="Tall slender porcelain bottle with natural clay textured body and cork stopper." class="h-full w-full object-cover object-center group-hover:opacity-75">
        </div>
        <h3 class="mt-4 text-sm text-gray-700">Earthen Bottle</h3>
        <p class="mt-1 text-lg font-medium text-gray-900">$48</p>
      </a>
      <a href="#" class="group">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
          <img src="https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-02.jpg" alt="Olive drab green insulated bottle with flared screw lid and flat top." class="h-full w-full object-cover object-center group-hover:opacity-75">
        </div>
        <h3 class="mt-4 text-sm text-gray-700">Nomad Tumbler</h3>
        <p class="mt-1 text-lg font-medium text-gray-900">$35</p>
      </a>
      <a href="#" class="group">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
          <img src="https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-03.jpg" alt="Person using a pen to cross a task off a productivity paper card." class="h-full w-full object-cover object-center group-hover:opacity-75">
        </div>
        <h3 class="mt-4 text-sm text-gray-700">Focus Paper Refill</h3>
        <p class="mt-1 text-lg font-medium text-gray-900">$89</p>
      </a>
      <a href="#" class="group">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
          <img src="https://tailwindui.com/img/ecommerce-images/category-page-04-image-card-04.jpg" alt="Hand holding black machined steel mechanical pencil with brass tip and top." class="h-full w-full object-cover object-center group-hover:opacity-75">
        </div>
        <h3 class="mt-4 text-sm text-gray-700">Machined Mechanical Pencil</h3>
        <p class="mt-1 text-lg font-medium text-gray-900">$35</p>
      </a>

      <!-- More products... -->
    </div>
  </div>
</div>
