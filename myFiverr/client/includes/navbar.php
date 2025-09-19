<nav class="navbar navbar-expand-lg navbar-dark p-4" style="background-color: #023E8A;">
  <a class="navbar-brand" href="index.php">Client Panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <!-- dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Proposals
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- main -->
          <?php $categories = $categoryObj->getCategories(); ?>
          <?php foreach ($categories as $category): ?> <!-- main category -->
            <div class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle mainCat" href="proposalsByMainCat.php?mainCat=<?= $category['category_title'] ?>"><?= $category["category_title"] ?></a>
              <!-- submenu -->
              <div class="dropdown-menu">
                <?php $subcategories = $subcategoryObj->getSubcategories($category["category_id"]); ?>
                <?php foreach ($subcategories as $subcategory): ?> <!-- subcategory -->
                  <a class="dropdown-item subCat" href="proposalsBySubcat.php?subCat=<?= $subcategory['subcategory_title'] ?>"><?= $subcategory["subcategory_title"] ?></a>
                <?php endforeach ?>
              </div>
              <!-- /submenu -->
            </div>
          <?php endforeach ?>
          <!-- /main -->
        </div>
      </li>
      <!-- /dropdown -->
      <li class="nav-item">
        <a class="nav-link" href="project_offers_submitted.php">Project Offers Submitted </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="core/handleForms.php?logoutUserBtn=1">Logout</a>
      </li>
    </ul>
  </div>
</nav>

