<?php
session_start();
require "../../model/users.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { 
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['action']) && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);
    $action = $_POST['action'];

    try {
        if ($action === 'accept') {
            Teacher::updateEnseignantStatus($userId, 'accepted');
            $_SESSION['success'] = "Enseignant accepted successfully";
        } elseif ($action === 'refuse') {
            Teacher::updateEnseignantStatus($userId, 'refused');
            $_SESSION['success'] = "Enseignant refused successfully";
        } else {
            throw new Exception("Invalid action");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: ../../view/admin/teacher_accept.php");
    exit();
}
?>