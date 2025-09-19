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
      
    </script>
  </body>
</html>