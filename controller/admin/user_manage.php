<?php
session_start();
require "../../model/users.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { 
    header("Location: ../../view/signup.php");
    exit();
}

if (isset($_POST['action']) && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);
    $action = $_POST['action'];

    try {
        if ($action === 'ban') {
            User::ban($userId);
            $_SESSION['success'] = "User banned successfully";
        } elseif ($action === 'unban') {
            User::unban($userId);
            $_SESSION['success'] = "User unbanned successfully";
        } else {
            throw new Exception("Invalid action");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: ../../view/admin/manage_users.php");
    exit();
}
?>