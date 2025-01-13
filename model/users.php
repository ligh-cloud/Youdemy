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
         
                $stmt = $db->prepare("UPDATE users SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id");
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->execute();

          
                $stmt = $db->prepare("UPDATE role SET role = :role WHERE id_user = :id_user");
                $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
                $stmt->bindParam(':id_user', $this->id, PDO::PARAM_INT);
                $stmt->execute();
            } else {
             
                $stmt = $db->prepare("INSERT INTO users (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)");
                $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $this->prenom, PDO::PARAM_STR);
                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
                $stmt->execute();
                $this->id = $db->lastInsertId(); 

               
                $stmt = $db->prepare("INSERT INTO role (role, id_user) VALUES (:role, :id_user)");
                $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
                $stmt->bindParam(':id_user', $this->id, PDO::PARAM_INT);
                $stmt->execute();
            }
            return $this->id;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("An error occurred while saving the user.");
        }
    }

    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT u.*, r.role as role FROM users u JOIN role r ON r.id_user = u.id WHERE u.email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $user = new User();
            $user->setFromDatabase($data);
            return $user;
        }

        error_log("User with email " . $email . " not found in database.");
        return null;
    }

    public function setFromDatabase($data) {
        $this->id = $data['id'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->email = $data['email'];
        $this->passwordHash = $data['password'];
        $this->role = $data['role'];
        $this->ban = $data['ban'];
    }

    public static function signin($email, $password) {
        session_start();
        $user = self::findByEmail($email);

        if (!$user) {
            $_SESSION['error'] = "User not found!";
            error_log("Signin failed: User not found for email " . $email);
            header("Location: ../view/signup.php");
           
        }

        if (!password_verify($password, $user->passwordHash)) {
            $_SESSION['error'] = "Invalid email or password!";
            header("Location: ../view/signup.php");
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['role'] = $user->role;
        $_SESSION['nom'] = $user->nom;
        $_SESSION['prenom'] = $user->prenom;

        header("Location: ../view/signup.php");
        exit();

        return $user;
    }
}
?>