<?php
session_start();
require '../../model/users.php';


if (isset($_POST['create_acc'])) {
    try {
       
        $requiredFields = ['Fname', 'Lname', 'email', 'role', 'password', 'confirm_pass'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                throw new Exception("All fields are required");
            }
        }

        $nom = htmlspecialchars($_POST['Fname']);
        $prenom = htmlspecialchars($_POST['Lname']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $role = filter_var($_POST['role'], FILTER_VALIDATE_INT);
        $password = $_POST['password'];
        $confirm_pass = $_POST['confirm_pass'];

        // Validate role
        if (!in_array($role, [2, 3])) {
            throw new Exception("Invalid role selected");
        }

        // Password validation
        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long");
        }

        if ($password !== $confirm_pass) {
            throw new Exception("Passwords do not match!");
        }

       
        $userId = ($role === 2) 
            ? Teacher::signup($nom, $prenom, $email, $role, $password, 'waiting')
            : Student::signup($nom, $prenom, $email, $role, $password);

        $_SESSION['success'] = "Account created successfully!";
        header("Location: ../../view/signup.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../../view/signup.php");
        exit();
    }
}


if (isset($_POST['signin'])) {
    try {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            throw new Exception("Email and password are required");
        }

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        $userRole = User::searchRole($email);
        
        if ($userRole === null) {
            throw new Exception("Invalid email or password!");
        }

        switch ($userRole) {
            case 3: // Student
                $user = Student::signin($email, $password);
                header('Location: ../../view/etudiant/student_dashboard.php');
                break;
                
                case 2: // Teacher
                    $user = Teacher::signin($email, $password);
                    if ($user->getEnseignant() === 'waiting') {
                        header('Location: ../../view/ensaignant/waiting_aprove.php');
                    } elseif ($user->getEnseignant() === 'accepted') {
                        header('Location: ../../view/ensaignant/teacher_dashboard.php');
                    } else {
                        $_SESSION['error'] = "Your account has been banned";
                        header('Location: ../../view/signup.php');
                    }
                    exit();
                    break;
            case 1: // Admin
                $user = User::signin($email, $password);
                header('Location: ../../view/admin/admin_dashboard.php');
                break;
                
            default:
                throw new Exception("Invalid role");
        }
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: ../../view/signup.php");
        exit();
    }
}

// Logout 
if (isset($_POST['logout'])) {
    User::logout();
}
?>