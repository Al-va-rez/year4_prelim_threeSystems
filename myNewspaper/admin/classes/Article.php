<?php  

require_once 'Database.php';
require_once 'User.php';
/**
 * Class for handling Article-related operations.
 * Inherits CRUD methods from the Database class.
 */
class Article extends Database {
    /**
     * Creates a new article.
     * @param string $title The article title.
     * @param string $content The article content.
     * @param int $author_id The ID of the author.
     * @return int The ID of the newly created article.
     */
    public function createArticle($bg_image, $category_title, $article_title, $content, $author_id) {
        $sql = "INSERT INTO articles (bg_image, category_title, article_title, content, author_id, is_active) VALUES (?, ?, ?, ?, ?, 0)";
        return $this->executeNonQuery($sql, [$bg_image, $category_title, $article_title, $content, $author_id]);
    }

    /**
     * Retrieves articles from the database.
     * @param int|null $id The article ID to retrieve, or null for all articles.
     * @return array
     */
    public function getArticles($id = null) {
        if ($id) {
            $sql = "SELECT * FROM articles WHERE article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM articles 
                JOIN school_publication_users ON 
                articles.author_id = school_publication_users.user_id 
                ORDER BY articles.created_at DESC";

        return $this->executeQuery($sql);
    }

    public function getActiveArticles($id = null) {
        if ($id) {
            $sql = "SELECT * FROM articles WHERE article_id = ?";
            return $this->executeQuerySingle($sql, [$id]);
        }
        $sql = "SELECT * FROM articles 
                JOIN school_publication_users ON 
                articles.author_id = school_publication_users.user_id 
                WHERE is_active = 1 ORDER BY articles.created_at DESC";
                
        return $this->executeQuery($sql);
    }


    public function getArticlesByUserID($user_id) {
        $sql = "SELECT * FROM articles 
                JOIN school_publication_users ON 
                articles.author_id = school_publication_users.user_id
                WHERE author_id = ? ORDER BY articles.created_at DESC";
        return $this->executeQuery($sql, [$user_id]);
    }

    public function getSharedArticles($own_id) {
        $sql = "SELECT shared_articles.*, 
                    articles.*, 
                    owner.username AS owner_name, 
                    collaborator.username AS collaborator_name
                FROM shared_articles
                LEFT JOIN articles 
                    ON articles.article_id = shared_articles.article_id
                LEFT JOIN school_publication_users AS owner 
                    ON owner.user_id = shared_articles.owner_id
                LEFT JOIN school_publication_users AS collaborator 
                    ON collaborator.user_id = shared_articles.collaborator_id
                WHERE shared_articles.owner_id = ? 
                    OR shared_articles.collaborator_id = ?";
         return $this->executeQuery($sql, [$own_id, $own_id]);
    }

    public function shareArticle($article_id, $owner_id, $collaborator_id) {
        $sql = "INSERT INTO shared_articles (article_id, owner_id, collaborator_id) VALUES (?, ?, ?)";
        return $this->executeNonQuery($sql, [$article_id, $owner_id, $collaborator_id]);
    }

    /**
     * Updates an article.
     * @param int $id The article ID to update.
     * @param string $title The new title.
     * @param string $content The new content.
     * @return int The number of affected rows.
     */
    public function updateArticle($id, $category_title, $article_title, $content) {
        $sql = "UPDATE articles SET category_title = ?, article_title = ?, content = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$category_title, $article_title, $content, $id]);
    }
    
    /**
     * Toggles the visibility (is_active status) of an article.
     * This operation is restricted to admin users only.
     * @param int $id The article ID to update.
     * @param bool $is_active The new visibility status.
     * @return int The number of affected rows.
     */
    public function updateArticleVisibility($id, $is_active) {
        $sql = "UPDATE articles SET is_active = ? WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$is_active, $id]);
    }


    /**
     * Deletes an article.
     * @param int $id The article ID to delete.
     * @return int The number of affected rows.
     */
    public function deleteArticle($id) {
        $sql = "DELETE FROM articles WHERE article_id = ?";
        return $this->executeNonQuery($sql, [$id]);
    }
}
?>