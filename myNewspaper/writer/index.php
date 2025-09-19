<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
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
      <div class="display-4 text-center">Hello there and welcome! <span class="text-success"><?php echo $_SESSION['username']; ?></span>. Here are all the articles</div>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- CREATE ARTICLE -->
          <?php $categories = $categoryObj->getCategories(); ?>
          <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="text" class="form-control mt-4" name="title" placeholder="Input title here">
            </div>
            <div class="form-group">
              <select name="article_category">
                <option value="" selected disabled>Select article category. . . </option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['category_title'] ?>"><?= $category['category_title'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <textarea name="description" class="form-control mt-4" placeholder="Submit an article!"></textarea>
            </div>
            <div class="form-group">
              <input type="file" name="uploadfile" value="">
            </div>
            <input type="submit" class="btn btn-primary form-control float-right mt-4 mb-4" name="insertArticleBtn">
          </form>
          <!-- /CREATE ARTICLE -->

          <!-- SHOW APPROVED ARTICLES -->
          <?php $articles = $articleObj->getActiveArticles(); ?>
          <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow">
            <img src="../uploads/<?php echo $article['bg_image']; ?>" alt="" class="card-img-top">
            <div class="card-body">
              <h1><?php echo $article['article_title']; ?></h1> 
              <h2 class="font-italic"><?php echo $article['category_title']; ?></h2> 
              <?php if ($article['is_admin'] == 1) { ?>
                <p><small class="bg-primary text-white p-1">  
                  Message From Admin
                </small></p>
              <?php } ?>
              <small><strong><?php echo $article['username'] ?></strong> - <?php echo $article['created_at']; ?> </small>
              <p><?php echo $article['content']; ?> </p>
              <!-- show edit access request if user is not author of current article -->
              <?php if ($article['author_id'] != $_SESSION['user_id']): ?>
                <form action="core/handleForms.php" method="POST" class="requestEditAccessForm">
                  <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                  <input type="hidden" name="responder_id" value="<?php echo $article['author_id']; ?>" class="responder_id">
                  <input type="hidden" name="requestor_id" value="<?php echo $_SESSION['user_id']; ?>" class="requestor_id">
                  <input type="submit" class="btn btn-secondary float-right mb-4 requestEditAccessBtn" value="Request Edit Access" name="requestEditAccessBtn">
                </form>
              <?php endif ?>
            </div>
          </div>  
          <?php } ?> 
          <!-- /SHOW APPROVED ARTICLES -->
        </div>
      </div>
    </div>
  </body>
</html>