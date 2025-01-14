CREATE DATABASE youdemy;
USE youdemy;

-- Create role table first
CREATE TABLE IF NOT EXISTS role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('admin', 'teacher', 'student') NOT NULL
);

-- Create users table with role_id
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    ban ENUM('true', 'false') NOT NULL DEFAULT 'false',
    role_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES role(id_role) ON DELETE SET NULL
);

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    id_course INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(150),
    video VARCHAR(150),
    content VARCHAR(200),
    teacher_id INT,
    categorie_id INT,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Create tags table
CREATE TABLE IF NOT EXISTS tags (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(150) NOT NULL
);

-- Create CourseTags table
CREATE TABLE IF NOT EXISTS CourseTags (
    id_course INT,
    id_tag INT,
    PRIMARY KEY (id_course, id_tag),
    FOREIGN KEY (id_course) REFERENCES courses(id_course)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Create Statistics table
CREATE TABLE IF NOT EXISTS Statistics (
    id_statistic INT AUTO_INCREMENT PRIMARY KEY,
    total_courses INT DEFAULT 0,
    total_students INT DEFAULT 0,
    top_course_id INT,
    top_teachers_ids JSON DEFAULT NULL,
    FOREIGN KEY (top_course_id) REFERENCES courses(id_course) ON DELETE CASCADE
);

-- Create enrollenment table
CREATE TABLE IF NOT EXISTS enrollenment (
    id_course INT,
    id_user INT,
    PRIMARY KEY (id_course, id_user),
    FOREIGN KEY (id_course) REFERENCES courses(id_course)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);