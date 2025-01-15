<?php 
require "../model/Course.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if (isset($_POST['add_course'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $teacherId = $_SESSION['user_id'];
    $categoryId = htmlspecialchars($_POST['category']);
    $targetDir = "../uploads/";

    function uploadFile($file, $targetDir) {
        $targetFile = $targetDir . basename($file["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $validTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'pdf', 'doc', 'docx', 'txt'];
        if (!in_array($fileType, $validTypes)) {
            return "Invalid file type.";
        }

   
        if (file_exists($targetFile)) {
            $targetFile = $targetDir . time() . '_' . basename($file["name"]);
        }

        if ($file["size"] > 50000000) {
            return "File is too large.";
        }

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            return "There was an error uploading your file.";
        }
    }

    $documentPath = !empty($_FILES["document"]["name"]) ? uploadFile($_FILES["document"], $targetDir) : null;
    $imagePath = !empty($_FILES["image"]["name"]) ? uploadFile($_FILES["image"], $targetDir) : null;
    $videoPath = !empty($_FILES["video"]["name"]) ? uploadFile($_FILES["video"], $targetDir) : null;

    if ($videoPath === null) {
        $course = new DocumentImageCourse($title, $description, $documentPath, $imagePath, $teacherId, $categoryId);
        $course->addCourse();
       
        $_SESSION['success'] = "Course document added succesfully";
    } else {
        $course = new VideoCourse($title, $description, $videoPath, $teacherId, $categoryId);
        $course->addCourse();
       
        $_SESSION['success'] = "Course video added succesfully";
    }
    header("location: ../view/ensaignant/teacher_dashboard.php");
}
?>