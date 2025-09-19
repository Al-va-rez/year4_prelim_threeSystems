<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../client/index.php");
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
      <div class="display-4 text-center">Showing all proposals in the main category: <span class="text-success"><?= $_GET['mainCat'] ?></span></div>
      <div class="row">
        <div class="col-md-5">
          <div class="card mt-4 mb-4">
            <div class="card-body">
              <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <?php  
                  if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

                    if ($_SESSION['status'] == "200") {
                      echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
                    }

                    else {
                      echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>"; 
                    }

                  }
                  unset($_SESSION['message']);
                  unset($_SESSION['status']);
                  ?>
                  <h1 class="mb-4 mt-4">Add Proposal Here!</h1>
                  <!-- category -->
                  <div class="form-group">
                    <?php $categories = $categoryObj->getCategories(); ?>
                    <select id="main_category_title" name="category_title">
                      <option value="" selected disabled>Select a main category first. . . </option>
                      <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_title'] ?>"><?= $category['category_title'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <!-- subcategory -->
                  <div id="secondSelect" class="form-group d-none">
                     <select id="formSubcategories" name="subcategory_title">
                      <!-- append content -->
                     </select>
                  </div>
                  <!-- desc -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="text" class="form-control" name="description" required>
                  </div>
                  <!-- min price -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Minimum Price</label>
                    <input type="number" class="form-control" name="min_price" required>
                  </div>
                  <!-- max price -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Max Price</label>
                    <input type="number" class="form-control" name="max_price" required>
                  </div>
                  <!-- image -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Image</label>
                    <input type="file" class="form-control" name="image" required>
                    <input type="submit" class="btn btn-primary float-right mt-4" name="insertNewProposalBtn">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <?php $getProposals = $proposalObj->getProposalsByCategory($_GET['mainCat']); ?>
          <?php foreach ($getProposals as $proposal) { ?>
          <div class="card shadow mt-4 mb-4">
            <div class="card-body">
              <h2><a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>"><?php echo $proposal['username']; ?></a></h2>
              <img src="<?php echo '../images/' . $proposal['image']; ?>" alt="" class="card-img-top">
              <p class="mt-4"><i><?php echo $proposal['proposals_date_added']; ?></i></p>
              <p class="mt-4"><i><?php echo $proposal['category_title']; ?></i></p>
              <p class="mt-4"><i><?php echo $proposal['subcategory_title']; ?></i></p>
              <p class="mt-2"><?php echo $proposal['description']; ?></p>
              <h4><i><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?> PHP</i></h4>
              <div class="float-right">
                <a href="#">Check out services</a>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>


    <script>
      $('#main_category_title').on('change',
        function(event) {
          event.preventDefault();

          var formData = {
            main_category_title: $('#main_category_title').val(),
            filterReq: 1
          };

          $.ajax(
            {
              type: "POST",
              url: "core/handleForms.php",
              data: formData,
              success: function(data) {
                $("#secondSelect").removeClass("d-none");
                $("#formSubcategories").empty();

                $("#formSubcategories").append(`
                  <option selected disabled">Select subcategory next. . . </option>
                `);
                
                if (data.length > 0) {
                  data.forEach((row) => {
                    $("#formSubcategories").append(`
                      <option value="${row.subcategory_title}">${row.subcategory_title}</option>
                    `);
                  });
                } else {
                  $("#formSubcategories").append(`<option selected disabled>No records found</option>`);
                }
                  
              }
            }
          );
        }
      );

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