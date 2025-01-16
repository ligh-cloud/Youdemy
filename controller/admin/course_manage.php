<?php
session_start();
require "../../model/Course.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { 
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        Course::deleteById(intval($_POST['id']));
        $_SESSION['success'] = "Course deleted successfully";
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    header("Location: ../../view/admin/manage_courses.php");
    exit();
}
?>