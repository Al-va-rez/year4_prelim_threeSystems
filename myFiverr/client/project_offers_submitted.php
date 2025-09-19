<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
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
      <div class="display-4 text-center">Hello there and welcome! Here are all the submitted project offers!</div>
      <div class="row justify-content-center">
        <div class="col-md-12">
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