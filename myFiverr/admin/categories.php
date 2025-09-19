<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
      body {
        font-family: "Arial";
      }

      /* Custom styles for submenu */
      .dropdown-submenu {
        position: relative;
      }

      .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;  /* make it appear on the right */
        margin-top: -1px;
      }
    </style>
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
      <div class="display-4 text-center">Hello there and welcome to the admin side, <span style="color: #F9C70C;"><?php echo $_SESSION['username']; ?></span>!</div>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form action="core/handleForms.php" method="POST">
            <div class="form-group">
              <input type="text" class="form-control mt-4" name="category_title" placeholder="Input category here">
            </div>
            <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertCategoryBtn">
          </form>
          <?php $categories = $categoryObj->getCategories(); ?>
          <div class="table table-striped table-hover">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['category_id'] ?></td>
                            <td><?= $category['category_title'] ?></td>
                            <td><?= $category['created_at'] ?></td>
                        </tr>
                    <?php endforeach ?> 
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(document).on('mouseenter', '.dropdown-submenu a.mainCat', function (event) {
        event.stopPropagation();

        // hide other submenus first
        $('.dropdown-submenu .dropdown-menu').hide();

        // show the hovered submenu
        $(this).next('.dropdown-menu').show();
      });

      // Hide submenu when leaving the parent
      $(document).on('mouseleave', '.dropdown-submenu', function () {
        $(this).find('.dropdown-menu').hide();
      });
    </script>
  </body>
</html>