CREATE TABLE fiverr_clone_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    password TEXT,
    is_client BOOLEAN,
    is_admin BOOLEAN,
    bio_description TEXT,
    display_picture TEXT,
    contact_number VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE proposals (
    proposal_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category_title VARCHAR(255) NOT NULL,
    subcategory_title VARCHAR(255) NOT NULL,
    description TEXT,
    image TEXT,
    min_price INT,
    max_price INT,
    view_count INT DEFAULT 0,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id)
);

CREATE TABLE offers (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    description TEXT,
    proposal_id INT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES fiverr_clone_users(user_id),
    FOREIGN KEY (proposal_id) REFERENCES proposals(proposal_id)
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE subcategories (
    subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
    main_category_id INT NOT NULL,
    subcategory_title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);