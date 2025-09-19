<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
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
    <style>
      body {
        font-family: "Arial";
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
              <?php $categories = $categoryObj->getCategories(); ?>
              <select name="main_category_id">
                <option value="" selected disabled>Select a main category first. . . </option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['category_id'] ?>"><?= $category['category_title'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control mt-4" name="category_title" placeholder="Input category here">
            </div>
            <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertSubategoryBtn">
          </form>



          <form id="filterSubcategories" class="row">
              <select id="filterMainCategoryID">
                  <option value="" selected>All</option>
                  <?php foreach($categories as $category): ?>
                      <option value="<?= $category['category_id'] ?>"><?= $category['category_title'] ?></option>
                  <?php endforeach ?>
              </select>
          </form>
          <?php $subcategories = $subcategoryObj->getSubcategories(); ?>
          <div class="table table-striped table-hover">
            <table id="subcategories" class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Main Category</th>
                        <th>Subcategory</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <tr>
                            <td><?= $subcategory['category_title'] ?></td>
                            <td><?= $subcategory['subcategory_title'] ?></td>
                            <td><?= $subcategory['sub_created_at'] ?></td>
                        </tr>
                    <?php endforeach ?> 
                </tbody>
            </table>
          </div>


        </div>
      </div>
    </div>

    <script>
      $('#filterSubcategories').on('change',
        function(event) {
          event.preventDefault();

          var formData = {
            main_category_id: $('#filterMainCategoryID').val(),
            filterReq: 1
          };

          if (formData.main_category_id == "") {
            $.ajax(
              {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                  let tbody = $("#subcategories tbody");
                  tbody.empty(); // clear current rows

                  if (data.length > 0) {
                    data.forEach((row) => {
                      tbody.append(`
                        <tr>
                          <td>${row.category_title}</td>
                          <td>${row.subcategory_title}</td>
                          <td>${row.sub_created_at}</td>
                        </tr>
                      `);
                    });
                  } else {
                    tbody.append(`<tr><td colspan="7">No records found</td></tr>`);
                  }
                    
                }
              }
            );
          } else {
            $.ajax(
              {
                type: "POST",
                url: "core/handleForms.php",
                data: formData,
                success: function(data) {
                  let tbody = $("#subcategories tbody");
                  tbody.empty(); // clear current rows

                  if (data.length > 0) {
                    data.forEach((row) => {
                      tbody.append(`
                        <tr>
                          <td>${row.category_title}</td>
                          <td>${row.subcategory_title}</td>
                          <td>${row.sub_created_at}</td>
                        </tr>
                      `);
                    });
                  } else {
                    tbody.append(`<tr><td colspan="7">No records found</td></tr>`);
                  }
                    
                }
              }
            );
          }
        }
      );
    </script>
  </body>
</html>