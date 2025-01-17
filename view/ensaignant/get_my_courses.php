<?php 
session_start();
require "../../model/Course.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$courses = Course::getallCourse($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex">
    <div class="w-64 bg-white shadow-lg">
        <div class="p-4">
            <div class="space-y-2">
                <a href="teacher_dashboard.php" class="block px-4 py-2 rounded hover:bg-purple-50">Dashboard</a>
                <a href="get_my_courses.php" class="block px-4 py-2 rounded hover:bg-purple-50">My Courses</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Students</a>
                <a href="statistics.php" class="block px-4 py-2 rounded hover:bg-purple-50">Analytics</a>
            </div>
        </div>
    </div>
    <div class="flex-1 p-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-6">My Courses</h1>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-md rounded-lg">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Description</th>
                            <th class="py-2 px-4 border-b">Category</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['title']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['description']); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($course['categorie_id']); ?></td>
                                <td class="py-2 px-4 border-b">
                                    <a href="edit_course.php?id=<?php echo htmlspecialchars($course['id_course']); ?>" class="text-blue-500 hover:text-blue-700">Edit</a>
                                    <a href="../../controller/teacher/delete_course.php?id=<?php echo htmlspecialchars($course['id_course']); ?>" class="text-red-500 hover:text-red-700 ml-2">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>