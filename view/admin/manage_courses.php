<?php
session_start();
require "../../model/Course.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { // Assuming role 1 is for admin
    header("Location: ../signup.php");
    exit();
}

$courses = Course::getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <header class="bg-purple-600 text-white py-4 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="text-xl font-bold">Admin Dashboard</div>
            <form method="POST" action="../../controller/public/AuthController.php" class="flex justify-center items-center">
                <button
                    name="logout"
                    type="submit"
                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all">
                    Log out
                </button>
            </form>
        </div>
    </header>

    <div class="flex min-h-screen">
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="space-y-2">
                    <a href="manage_users.php" class="block px-4 py-2 rounded hover:bg-purple-50">Manage Users</a>
                    <a href="manage_courses.php" class="block px-4 py-2 rounded hover:bg-purple-50">Manage Courses</a>
                </div>
            </div>
        </div>

        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">All Courses</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2"><?php echo $course['title']; ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo $course['description']; ?></p>
                        <div class="flex justify-between items-center">
                            <form method="post" action="../../controller/admin/course_manage.php">
                                <input type="hidden" name="id" value="<?php echo $course['id_course']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>