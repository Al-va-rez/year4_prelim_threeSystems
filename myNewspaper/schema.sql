CREATE TABLE school_publication_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE articles (
    article_id INT AUTO_INCREMENT PRIMARY KEY,
    bg_image VARCHAR(100) NOT NULL,
    category_title VARCHAR(255) NOT NULL,
    article_title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES school_publication_users(user_id) ON DELETE CASCADE
);


CREATE TABLE edit_requests (
    req_id INT AUTO_INCREMENT PRIMARY KEY,
    requestor_id INT NOT NULL,
    responder_id INT NOT NULL,
    article_id INT NOT NULL,
    req_status ENUM('Approved', 'Denied', 'PENDING') DEFAULT 'PENDING',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE shared_articles (
    share_id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    owner_id INT NOT NULL,
    collaborator_id INT NOT NULL,
    shared_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);