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
        

        $targetDir = dirname(dirname(__DIR__)) . "/uploads/";
        
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                throw new Exception("Failed to create uploads directory");
            }
        }

        function uploadFile($file, $targetDir) {
      
            $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            
         
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'mp4', 'mov'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Invalid file type");
            }

          
            $uniqueName = uniqid() . '_' . time() . '.' . $fileExtension;
            $targetFile = $targetDir . $uniqueName;
            
          
            if (!is_uploaded_file($file["tmp_name"])) {
                throw new Exception("File was not uploaded via HTTP POST");
            }

   
            if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
                throw new Exception("Failed to move uploaded file: " . error_get_last()['message']);
            }
            
            return $uniqueName;
        }
        
        $documentPath = null;
        $imagePath = null;
        $videoPath = null;


        if (!empty($_FILES["document"]["name"])) {
            $documentPath = uploadFile($_FILES["document"], $targetDir);
        }
        
        if (!empty($_FILES["image"]["name"])) {
            $imagePath = uploadFile($_FILES["image"], $targetDir);
        }
        
        if (!empty($_FILES["video"]["name"])) {
            $videoPath = uploadFile($_FILES["video"], $targetDir);
        }
        

        if ($videoPath) {
            $course = new VideoCourse($title, $description, $videoPath, $teacherId, $categoryId, $tagId);
            $courseId = $course->addCourse();
            $_SESSION['success'] = "Video course added successfully";
        } else {
            $course = new DocumentImageCourse($title, $description, $documentPath, $imagePath, $teacherId, $categoryId, $tagId);
            $courseId = $course->addCourse();
            $_SESSION['success'] = "Document course added successfully";
        }

        if ($courseId) {
 
            error_log("Course added successfully. ID: " . $courseId);
            header("Location: ../../view/ensaignant/teacher_dashboard.php");
            exit();
        } else {
            throw new Exception("Failed to add course to database");
        }

    } catch (Exception $e) {

        error_log("Error adding course: " . $e->getMessage());
        $_SESSION['error'] = "Failed to add course: " . $e->getMessage();
        

        if (isset($documentPath) && file_exists($targetDir . $documentPath)) {
            unlink($targetDir . $documentPath);
        }
        if (isset($imagePath) && file_exists($targetDir . $imagePath)) {
            unlink($targetDir . $imagePath);
        }
        if (isset($videoPath) && file_exists($targetDir . $videoPath)) {
            unlink($targetDir . $videoPath);
        }
        
        header("Location: ../../view/ensaignant/add_course.php");
        exit();
    }
}
?>