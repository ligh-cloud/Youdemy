<?php
require "database.php";

class User {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $passwordHash;
    protected $role;
    protected $ban;
    protected $enseignant;

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getEnseignant() { return $this->enseignant; }

    public function __construct($id = null, $nom = null, $prenom = null, $email = null, $role = null, $password = null, $enseignant = 'waiting') {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->enseignant = $enseignant;
        if ($password !== null) {
            $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
        }
    }

    public function __toString() {
        return $this->nom . " " . $this->prenom;
    }
    
 
    public static function searchRole($email) {
        $user = User::findByEmail($email);
        if ($user !== null) {
            return $user->getRole();
        }
        return null;
    }

    public static function signup($nom, $prenom, $email, $role, $password, $enseignant = 'accepted') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long");
        }

        $nom = htmlspecialchars($nom);
        $prenom = htmlspecialchars($prenom);

        if (self::findByEmail($email)) {
            throw new Exception("Email is already registered");
        }

        $user = new User(null, $nom, $prenom, $email, $role, $password, $enseignant);
        return $user->save();
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            if ($this->id) {
                
                $stmt = $db->prepare("
                    UPDATE users 
                    SET nom = :nom, prenom = :prenom, email = :email, role_id = :role_id, enseignant = :enseignant
                    WHERE id = :id
                ");
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
                $stmt->bindParam(':enseignant', $this->enseignant, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                // Insert new user
                $stmt = $db->prepare("
                    INSERT INTO users (nom, prenom, email, password, role_id, enseignant) 
                    VALUES (:nom, :prenom, :email, :password, :role_id, :enseignant)
                ");
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
                $stmt->bindParam(':enseignant', $this->enseignant, PDO::PARAM_STR);
                $stmt->execute();
                $this->id = $db->lastInsertId(); 
            }
            return $this->id;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("An error occurred while saving the user.");
        }
    }

    public function setFromDatabase($data) {
        $this->id = $data['id'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->email = $data['email'];
        $this->passwordHash = $data['password'];
        $this->role = $data['role_id'];
        $this->ban = $data['ban'];
        $this->enseignant = $data['enseignant']; 
    }
    public static function signin($email, $password) {
        $user = self::findByEmail($email);
    
        if (!$user) {
            throw new Exception("Invalid email or password!");
        }
    
        if (!password_verify($password, $user->passwordHash)) {
            throw new Exception("Invalid email or password!");
        }
    
        if ($user->ban === 'true') {
            throw new Exception("This account has been banned!");
        }
    
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['role'] = $user->role;
        $_SESSION['nom'] = $user->nom;
        $_SESSION['prenom'] = $user->prenom;
    
        return $user;
    }

    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("
            SELECT * 
            FROM users 
            WHERE email = :email
        ");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new User();
        $user->setFromDatabase($data);
        return $user;
    }

    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $query = "
            SELECT * 
            FROM users 
            ORDER BY created_at DESC
        ";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public static function ban($id) {
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE users SET ban = 'true' WHERE id = ?";
        $stmt = $db->prepare($query);
        return $stmt->execute([$id]);
    }

    public static function unban($id) {
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE users SET ban = 'false' WHERE id = ?";
        $stmt = $db->prepare($query);
        return $stmt->execute([$id]);
    }

    public static function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header("Location: ../../index.php");
        exit();
    }
}


class Teacher extends User {
    protected $enseignant;

    public function __construct($id = null, $nom = null, $prenom = null, $email = null, $role = 2, $password = null, $enseignant = 'waiting') {
        parent::__construct($id, $nom, $prenom, $email, $role, $password);
        $this->enseignant = $enseignant;
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            if ($this->id) {

                $stmt = $db->prepare("
                    UPDATE users 
                    SET nom = :nom, prenom = :prenom, email = :email, role_id = :role_id, enseignant = :enseignant, ban = :ban
                    WHERE id = :id
                ");
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
                $stmt->bindParam(':enseignant', $this->enseignant, PDO::PARAM_STR);
                $stmt->bindParam(':ban', $this->ban, PDO::PARAM_STR);
                $stmt->execute();
            } else {
              
                $stmt = $db->prepare("
                    INSERT INTO users (nom, prenom, email, password, role_id, enseignant, ban) 
                    VALUES (:nom, :prenom, :email, :password, :role_id, :enseignant, :ban)
                ");
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
                $stmt->bindParam(':enseignant', $this->enseignant, PDO::PARAM_STR);
                $stmt->bindParam(':ban', $this->ban, PDO::PARAM_STR);
                $stmt->execute();
                $this->id = $db->lastInsertId(); 
            }
            return $this->id;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("An error occurred while saving the teacher.");
        }
    }
    public static function getTopTeachers() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT users.nom, COUNT(courses.id_course) as courses 
                              FROM users 
                              JOIN courses ON users.id = courses.teacher_id 
                              GROUP BY users.nom 
                              ORDER BY courses DESC 
                              LIMIT 3");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function setFromDatabase($data) {
        parent::setFromDatabase($data);
        $this->enseignant = $data['enseignant'];
    }
    public function isTeacherApproved() {
        return $this->role === 2 && $this->enseignant === 'accepted';
    }
    public static function updateEnseignantStatus($id, $status) {
        $db = Database::getInstance()->getConnection();
        $query = "UPDATE users SET enseignant = :status WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function getPendingEnseignants() {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM users WHERE role_id = 2 AND enseignant = 'waiting'";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
    
    

class Student extends User {
    public function __construct($id = null, $nom = null, $prenom = null, $email = null, $role = 3, $password = null) {
        parent::__construct($id, $nom, $prenom, $email, $role, $password);
    }

   
}
?>
