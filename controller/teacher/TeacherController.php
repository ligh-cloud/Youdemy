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
        
        $targetDir = "../../uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        function uploadFile($file) {
            $fileName = basename($file["name"]);
            $uniqueName = uniqid() . '_' . time() . '.' . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $targetFile =  $uniqueName;

            if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
                throw new Exception("Failed to move uploaded file");
            }

            return $targetFile;
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
            $course = new VideoCourse($title, $description, $videoPath, $teacherId, $categoryId);
            $course->addCourse();
            $_SESSION['success'] = "Video course added successfully";
        } else {
            $course = new DocumentImageCourse($title, $description, $documentPath, $imagePath, $teacherId, $categoryId);
            $course->addCourse();
            $_SESSION['success'] = "Document course added successfully";
        }

        header("Location: ../../view/ensaignant/teacher_dashboard.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        error_log($e->getMessage());  
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
</head>
<body>
<?php if(isset($_SESSION['error'])): ?>
    <div class="error"><?php echo $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="success"><?php echo $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label>Title</label>
    <input type="text" name="title" required>
    <label>Description</label>
    <textarea name="description" required></textarea>
    <label>Category</label>
    <input type="text" name="category" required>
    <label>Document</label>
    <input type="file" name="document">
    <label>Image</label>
    <input type="file" name="image">
    <label>Video</label>
    <input type="file" name="video">
    <button type="submit" name="add_course">Add Course</button>
</form>
</body>
</html>