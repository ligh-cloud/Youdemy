<?php
session_start();
require "../../model/Course.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No course ID provided.";
    header("Location: get_my_courses.php");
    exit();
}

$courseId = $_GET['id'];

try {
    Course::deleteById($courseId);
    $_SESSION['success'] = "Course deleted successfully.";
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    error_log($e->getMessage());
}

header("Location: ../../view/ensaignant/get_my_courses.php ");
exit();
?>