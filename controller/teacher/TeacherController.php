<?php 
require "../../model/Course.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['add_course'])) {
    try {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $teacherId = $_SESSION['user_id'];
        $categoryId = htmlspecialchars($_POST['category']);
        $tagId = htmlspecialchars($_POST['tag']);
        
        $targetDir = "../../uploads";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        function uploadFile($file) {
            global $targetDir; 
            $fileName = basename($file["name"]);
            $uniqueName = uniqid() . '_' . time() . '.' . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $targetFile = $targetDir . $uniqueName; 
            
            if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
                throw new Exception("Failed to move uploaded file");
            }
            
            return $uniqueName; 
        }
        
        $documentPath = null;
        $imagePath = null;
        $videoPath = null;

        if (!empty($_FILES["document"]["name"])) {
            $documentPath = uploadFile($_FILES["document"]);
        }
        if (!empty($_FILES["image"]["name"])) {
            $imagePath = uploadFile($_FILES["image"]);

        }
        if (!empty($_FILES["video"]["name"])) {
            $videoPath = uploadFile($_FILES["video"]);
        }
        
        if ($videoPath) {
            $course = new VideoCourse($title, $description, $videoPath, $teacherId, $categoryId, $tagId);
            $course->addCourse();
            $_SESSION['success'] = "Video course added successfully";
            echo "coure added successfuly";
        } else {
            $course = new DocumentImageCourse($title, $description, $documentPath, $imagePath, $teacherId, $categoryId, $tagId);
            $course->addCourse();
            $_SESSION['success'] = "Document course added successfully";
            echo "course without a video added succesfully";
        }

        header("Location: ../../view/ensaignant/teacher_dashboard.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        error_log($e->getMessage());  
        header("Location: " . $_SERVER['PHP_SELF']);
        echo "can't add the course ". $e->getMessage();
        exit();
    }
}
?>

