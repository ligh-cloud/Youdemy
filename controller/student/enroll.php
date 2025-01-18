<?php
session_start();
include '../../model/enrolement.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != '3') {
    header('Location: ../../view/signup.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_course'])) {
    $courseId = $_POST['id_course'];
    $userId = $_SESSION['user_id'];

    $enrollment = new Enrollment();
    $message = $enrollment->addEnrollment($courseId, $userId);

    if($message){
        $_SESSION['success'] = "Enrollement success";
    }
    else{
        $_SESSION["error"] = "You can't enroll in this course";
    }
    header('Location: ../../view/etudiant/student_dashboard.php');
    exit();
}
?>