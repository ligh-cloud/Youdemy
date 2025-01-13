CREATE DATABASE youdemy;
USE youdemy;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(200) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    ban ENUM('true', 'false') NOT NULL DEFAULT 'false',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE IF NOT EXISTS courses(
    id_course INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    content VARCHAR(200),
    teacher_id INT,
    categorie_id INT,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tags (
    id_tag INT AUTO_INCREMENT PRIMARY KEY,
    tag_name VARCHAR(150) NOT NULL
);


CREATE TABLE IF NOT EXISTS CourseTags(
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

CREATE TABLE IF NOT EXISTS Statistics(
    id_statistic INT AUTO_INCREMENT PRIMARY KEY,
    total_courses INT DEFAULT 0,
    total_students INT DEFAULT 0,
    top_course_id INT,
    top_teachers_ids JSON DEFAULT NULL,
    FOREIGN KEY (top_course_id) REFERENCES courses(id_course) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS courseTags (
    id_course INT,
    id_tag INT,
    PRIMARY KEY (id_course, id_tag),
    FOREIGN KEY (id_course) REFERENCES course(id_course)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS enrollenment (
    id_course INT,
    id_user INT,
    PRIMARY KEY (id_course, id_user),
    FOREIGN KEY (id_course) REFERENCES course(id_course)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_user) REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE role(
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('admin', 'teacher', 'student'),
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES users(id)
)