CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    username VARCHAR(255) NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    year_level INT NOT NULL,
    password text
);


CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    password text
);


CREATE TABLE Courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    units INT NOT NULL
);


CREATE TABLE enrollment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_username VARCHAR(255) NOT NULL,
    course_title VARCHAR(255) NOT NULL,
    date_enrolled TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Attendances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_username VARCHAR(255) NOT NULL,
    year_level INT NOT NULL,
    course_title VARCHAR(255) NOT NULL,
    attendance_Status ENUM('Present', 'Absent') NOT NULL,
    remarks ENUM('On Time', 'Late') NOT NULL,
    date_filed TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE excuse_letters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_username VARCHAR(255) NOT NULL,
    course_title VARCHAR(255) NOT NULL,
    letter TEXT NOT NULL,
    status ENUM('Approved', 'Denied', 'PENDING') DEFAULT 'PENDING',
    date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);