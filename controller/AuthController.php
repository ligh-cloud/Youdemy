<?php

session_start(); 

require '../model/users.php';

if (isset($_POST['create_acc'])) {
    $nom = htmlspecialchars($_POST['Fname']);
    $prenom = htmlspecialchars($_POST['Lname']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];

    if ($password !== $confirm_pass) {
        $_SESSION['error'] = "Passwords do not match!";
        header("location: ../view/signup.php");
        exit();
    }

    try {
        $userId = User::signup($nom, $prenom, $email, $role, $password);
        $_SESSION['success'] = "Account created successfully!";
        header("location: ../view/signup.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("location: ../view/signup.php");
        exit();
    }
}

if (isset($_POST['signin'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password']; 
    
    try {
        $user = User::signin($email, $password);
        
     
        switch($_SESSION['role']) {
            case 3:
                header('location: ../view/etudiant/student_dashboard.php');
                break;
            case 2:
                header('location: ../view/ensaignant/teacher_dashboard.php');
                break;
            case 1:
                header('location: ../view/admin/admin_dashboard.php');
                break;
            default:
                throw new Exception("Invalid role");
        }
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("location: ../view/signup.php");
        exit();
    }


}
if (isset($_POST['logout'])) {
    User::logout();
}