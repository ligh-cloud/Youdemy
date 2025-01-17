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
$course = Course::getAll()[$courseId];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $categoryId = htmlspecialchars($_POST['category']);
        $teacherId = $_SESSION['user_id'];

        $document = isset($_FILES['document']['name']) ? $_FILES['document']['name'] : null;
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
        $video = isset($_FILES['video']['name']) ? $_FILES['video']['name'] : null;

        if ($video) {
            $course = new VideoCourse($title, $description, $video, $teacherId, $categoryId);
        } else {
            $course = new DocumentImageCourse($title, $description, $document, $image, $teacherId, $categoryId);
        }
        
        $course->modifierCour($title, $description, $document, $image);
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
        <input type="text" name="category" value="<?php echo htmlspecialchars($course['categorie_id']); ?>" class="border rounded w-full py-2 px-3 mb-4" required>
        
        <label class="block mb-2">Document</label>
        <input type="file" name="document" class="border rounded w-full py-2 px-3 mb-4">
        
        <label class="block mb-2">Image</label>
        <input type="file" name="image" class="border rounded w-full py-2 px-3 mb-4">
        
        <label class="block mb-2">Video</label>
        <input type="file" name="video" class="border rounded w-full py-2 px-3 mb-4">
        
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Course</button>
    </form>
</div>
</body>
</html>