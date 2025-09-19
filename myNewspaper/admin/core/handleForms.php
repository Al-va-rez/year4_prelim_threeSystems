<?php  
require_once '../classloader.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = htmlspecialchars(trim($_POST['username']));
	$email = htmlspecialchars(trim($_POST['email']));
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			if (!$userObj->usernameExists($username) && !$userObj->emailExists($email)) {

				if ($userObj->registerUser($username, $email, $password)) {
					header("Location: ../login.php");
				}

				else {
					$_SESSION['message'] = "An error occured with the query!";
					$_SESSION['status'] = '400';
					header("Location: ../register.php");
				}
			}

			else {
				$_SESSION['message'] = $username . " as username is already taken";
				$_SESSION['status'] = '400';
				header("Location: ../register.php");
			}
		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}
	}
	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	if (!empty($email) && !empty($password)) {

		if ($userObj->loginUser($email, $password)) {
			header("Location: ../index.php");
		}
		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}

}

if (isset($_GET['logoutUserBtn'])) {
	$userObj->logout();
	header("Location: ../index.php");
}

if (isset($_POST['insertAdminArticleBtn'])) {
	$category_title = $_POST['article_category'];
    $article_title = $_POST['title'];
    $description = $_POST['description'];
    $author_id = $_SESSION['user_id'];

    if (isset($_FILES["uploadfile"]) && $_FILES["uploadfile"]["error"] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES["uploadfile"]["name"]);
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "../../uploads/" . $filename;

        if (move_uploaded_file($tempname, $folder)) {
            if ($articleObj->createArticle($filename, $category_title, $article_title, $description, $author_id)) {
                header("Location: ../index.php");
                exit;
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . $_FILES["uploadfile"]["error"];
    }
}

if (isset($_POST['editArticleBtn'])) {
    $category_title = $_POST['article_category'];
	$article_title = $_POST['title'];
	$description = $_POST['description'];
	$article_id = $_POST['article_id'];
	if ($articleObj->updateArticle($article_id, $category_title, $article_title, $description)) {
		header("Location: ../articles_submitted.php");
	}
}

if (isset($_POST['deleteArticleBtn'])) {
	$article_id = $_POST['article_id'];
	$articleObj->deleteArticle($article_id);
	header("Location: ../index.php");
}

if (isset($_POST['updateArticleVisibility'])) {
	$article_id = $_POST['article_id'];
	$status = $_POST['status'];
	echo $articleObj->updateArticleVisibility($article_id,$status);
}

if (isset($_POST['requestEditAccessBtn'])) {
	$requestor_id = $_POST['requestor_id'];
	$responder_id = $_POST['responder_id'];
	$article_id = $_POST['article_id'];

	if ($requestObj->sendRequest($requestor_id, $responder_id, $article_id)) {
		header("Location: ../index.php");
	}
}

if (isset($_POST['respondToRequestForm'])) {
	$req_id = $_POST['req_id'];
	$response = $_POST['response'];
	$collaborator_id = $_POST['collaborator_id'];
	$owner_id = $_POST['owner_id'];
	$article_id = $_POST['article_id'];

	switch ($response) {
		case 'Approved':
			if ($requestObj->approveRequest($req_id)) {
				if ($articleObj->shareArticle($article_id, $owner_id, $collaborator_id)) {
					header("Location: ../shared_articles.php");
				}
			}
			break;
		
		case 'Denied':
			if ($requestObj->denyRequest($req_id)) {
				header("Location: ../shared_articles.php");
			}
			break;
		
		default:
			var_dump($req_id, $response);
			break;
	}
}

if (isset($_POST['insertCategoryBtn'])) {
	$category_title = $_POST["category_title"];

	$result = $categoryObj->createCategory($category_title);

	if ($result) {
		header("Location: ../categories.php");
	}
}

?>