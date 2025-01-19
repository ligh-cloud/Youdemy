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
$course = Course::getCourseDetail($courseId); 

if (!$course) {
    $_SESSION['error'] = "Course not found.";
    header("Location: get_my_courses.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $categoryId = htmlspecialchars($_POST['category']);
        $teacherId = $_SESSION['user_id'];

        $document = null;
        $image = null;
        $video = null;

     
        if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
            $document = $_FILES['document']['name'];
            move_uploaded_file($_FILES['document']['tmp_name'], "../../uploads/documents/" . $document);
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/images/" . $image);
        }

        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $video = $_FILES['video']['name'];
            move_uploaded_file($_FILES['video']['tmp_name'], "../../uploads/videos/" . $video);
        }


        $document = $document ?? $course['content'];
        $image = $image ?? $course['image'];
        $video = $video ?? $course['video'];

        if ($course['video']) {
            $courseObj = new VideoCourse($course['title'], $course['description'], $video, $teacherId, $categoryId);
        } else {
            $courseObj = new DocumentImageCourse($course['title'], $course['description'], $document, $image, $teacherId, $categoryId);
        }

        $courseObj->modifierCour($title, $description, $document, $image, $video);
        $_SESSION['success'] = "Course updated successfully.";
        header("Location: get_my_courses.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        error_log($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Course</h1>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label class="block mb-2">Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" class="border rounded w-full py-2 px-3 mb-4" required>
        
        <label class="block mb-2">Description</label>
        <textarea name="description" class="border rounded w-full py-2 px-3 mb-4" required><?php echo htmlspecialchars($course['description']); ?></textarea>
        
        <label class="block mb-2">Category</label>
        <input type="text" name="category" value="<?php echo htmlspecialchars($course['category_name']); ?>" class="border rounded w-full py-2 px-3 mb-4" required>
        
        <label class="block mb-2">Document <?php echo $course['content'] ? '(Current: '.$course['content'].')' : ''; ?></label>
        <input type="file" name="document" class="border rounded w-full py-2 px-3 mb-4">
        
        <label class="block mb-2">Image <?php echo $course['image'] ? '(Current: '.$course['image'].')' : ''; ?></label>
        <input type="file" name="image" class="border rounded w-full py-2 px-3 mb-4">
        
        <label class="block mb-2">Video <?php echo $course['video'] ? '(Current: '.$course['video'].')' : ''; ?></label>
        <input type="file" name="video" class="border rounded w-full py-2 px-3 mb-4">
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Course</button>
    </form>
</div>
</body>
</html>