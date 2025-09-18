<?php
require_once 'Database.php';
require_once 'User.php';
?>

<?php

class Edit_Request extends Database {
    public function sendRequest($requestor_id, $responder_id, $article_id) {
        $sql = "INSERT INTO edit_requests (requestor_id, responder_id, article_id) VALUES (?, ?, ?)";
        return $this->executeNonQuery($sql, [$requestor_id, $responder_id, $article_id]);
    }

    // requests received
    public function getReceivedRequests($own_id) {
        $sql = "SELECT * FROM edit_requests
                JOIN articles ON articles.article_id = edit_requests.article_id
                JOIN school_publication_users ON school_publication_users.user_id = edit_requests.requestor_id
                WHERE responder_id = ?
                ORDER BY requested_at DESC";
        return $this->executeQuery($sql, [$own_id]);
    }

    // requests sent
    public function getSentRequests($own_id) {
        $sql = "SELECT * FROM edit_requests
                JOIN articles ON articles.article_id = edit_requests.article_id
                JOIN school_publication_users ON school_publication_users.user_id = edit_requests.responder_id
                WHERE requestor_id = ?
                ORDER BY requested_at DESC";
        return $this->executeQuery($sql, [$own_id]);
    }


    public function approveRequest($req_id) {
        $sql = "UPDATE edit_requests SET req_status = 'Approved' WHERE req_id = ?";
        return $this->executeNonQuery($sql, [$req_id]);
    }

    public function denyRequest($req_id) {
        $sql = "UPDATE edit_requests SET req_status = 'Denied' WHERE req_id = ?";
        return $this->executeNonQuery($sql, [$req_id]);
    }
}

?>