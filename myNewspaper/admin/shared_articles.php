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
            
          <?php $requests = $requestObj->getReceivedRequests($_SESSION['user_id']); ?>
          <?php if (count($requests) > 0): ?>
            <div class="card p-4">
                <div class="display-4">Edit Requests</div>
                <?php foreach ($requests as $request): ?>
                    <div class="card my-2">
                        <div class="card-body">
                            <p>From: <?= $request['username'] ?></p>
                            <p>For article: "<?= $request['article_title'] ?>"</p>
                            <p>Status: <?= $request['req_status'] ?></p>
                            <form action="core/handleForms.php" method="POST">  
                              <input type="hidden" name="req_id" value="<?= $request['req_id'] ?>">
                              <input type="hidden" name="collaborator_id" value="<?= $request['requestor_id'] ?>">
                              <input type="hidden" name="owner_id" value="<?= $request['responder_id'] ?>">
                              <input type="hidden" name="article_id" value="<?= $request['article_id'] ?>">
                              <select class="form-select" name="response">
                                <option value="" selected disabled>Select option...</option>
                                <option value="Approved">Approved</option>
                                <option value="Denied">Denied</option>
                              </select>
                              <input type="submit" class="btn btn-primary" name="respondToRequestForm">
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
          <?php endif ?>

          <?php $requests = $requestObj->getSentRequests($_SESSION['user_id']); ?>
          <?php if (count($requests) > 0): ?>
            <div class="card p-4">
                <div class="display-4">Requests Sent</div>
                <?php foreach ($requests as $request): ?>
                    <div class="card my-2">
                        <div class="card-body">
                            <p>To: <?= $request['username'] ?></p>
                            <p>For article: "<?= $request['article_title'] ?>"</p>
                            <p>Status: <?= $request['req_status'] ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
          <?php endif ?>


          <?php $articles = $articleObj->getSharedArticles($_SESSION['user_id']); ?>
          <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow articleCard">
            <img src="../uploads/<?php echo $article['bg_image']; ?>" alt="" class="card-img-top">
            <div class="card-body">
              <h1><?php echo $article['article_title']; ?></h1> 
              <h2 class="font-italic"><?php echo $article['category_title']; ?></h2> 
              <small><?php echo $article['owner_name'] ?> - <?php echo $article['created_at']; ?> </small>
              <?php if ($article['is_active'] == 0) { ?>
                <p class="text-danger">Status: PENDING</p>
              <?php } ?>
              <?php if ($article['is_active'] == 1) { ?>
                <p class="text-success">Status: ACTIVE</p>
              <?php } ?>
              <p><?php echo $article['content']; ?> </p>
              <form action="core/handleForms.php" method="POST" class="deleteArticleForm">
                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                <input type="submit" class="btn btn-danger float-right mb-4 deleteArticleBtn" value="Delete">
              </form>
              <div class="updateArticleForm d-none">
                <h4>Edit the article</h4>
                <form action="core/handleForms.php" method="POST">
                  <div class="form-group mt-4">
                    <input type="text" class="form-control" name="title" value="<?php echo $article['article_title']; ?>">
                  </div>
                  <div class="form-group">
                    <?php $categories = $categoryObj->getCategories(); ?>
                    <select name="article_category">
                      <option value="" selected disabled><?= $article['category_title'] ?></option>
                      <?php foreach ($categories as $category): ?>
                        <?php if ($category['category_title'] != $article['category_title']): ?>
                          <option value="<?= $category['category_title'] ?>"><?= $category['category_title'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <textarea name="description" id="" class="form-control"><?php echo $article['content']; ?></textarea>
                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                    <input type="submit" class="btn btn-primary float-right mt-4" name="editArticleBtn">
                  </div>
                </form>
              </div>
            </div>
          </div>  
          <?php } ?> 
        </div>
      </div>
    </div>
    <script>
      $('.articleCard').on('dblclick', function (event) {
        var updateArticleForm = $(this).find('.updateArticleForm');
        updateArticleForm.toggleClass('d-none');
      });

      $('.deleteArticleForm').on('submit', function (event) {
        event.preventDefault();
        var formData = {
          article_id: $(this).find('.article_id').val(),
          deleteArticleBtn: 1
        }
        if (confirm("Are you sure you want to delete this article?")) {
          $.ajax({
            type:"POST",
            url: "core/handleForms.php",
            data:formData,
            success: function (data) {
              if (data) {
                location.reload();
              }
              else{
                alert("Deletion failed");
              }
            }
          })
        }
      })
      
    </script>
  </body>
</html>