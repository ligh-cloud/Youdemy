<?php
require '../model/users.php';
if (isset($_POST['create_acc'])) {
    $nom = $_POST['Fname'];
    $prenom = $_POST['Lname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];


    if ($password !== $confirm_pass) {
        echo "Passwords do not match!";
    } else {
        try {
            $userId = User::signup($nom, $prenom, $email, $role,$password);
            $_SESSION['success'] = true;
            header("location: ../view/signup.php");
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            header("location: ../view/signup.php");
        }
    }
}

if (isset($_POST['signin'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $user = User::signin($email,$password);
    var_dump($_SESSION['role']);
    header("location: ../view/signup.php"); 
}
?>