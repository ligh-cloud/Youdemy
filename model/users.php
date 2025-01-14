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

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }

    public function __construct($id = null, $nom = null, $prenom = null, $email = null, $role = null, $password = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        if ($password !== null) {
            $this->passwordHash = password_hash($password, PASSWORD_BCRYPT);
        }
    }

    public function __toString() {
        return $this->nom . " " . $this->prenom;
    }

    public static function signup($nom, $prenom, $email, $role, $password) {
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

        $user = new User(null, $nom, $prenom, $email, $role, $password);
        return $user->save();
    }

    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            if ($this->id) {
                // Update existing user
                $stmt = $db->prepare("
                    UPDATE users 
                    SET nom = :nom, prenom = :prenom, email = :email, role_id = :role_id 
                    WHERE id = :id
                ");
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                // Insert new user
                $stmt = $db->prepare("
                    INSERT INTO users (nom, prenom, email, password, role_id) 
                    VALUES (:nom, :prenom, :email, :password, :role_id)
                ");
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
                $stmt->bindParam(':role_id', $this->role, PDO::PARAM_INT);
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

        header("Location: ../index.php");
        exit();
    }
}
?>