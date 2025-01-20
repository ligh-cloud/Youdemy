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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-2xl font-bold tracking-wider">
                    <i class="fas fa-book-open mr-2"></i>My Courses
                </div>

                <div class="flex items-center gap-6">
                    <div class="relative">
                        <input type="text" placeholder="Search courses..." 
                               class="px-4 py-2 bg-white/10 rounded-lg text-white placeholder-gray-300 
                                      focus:outline-none focus:ring-2 focus:ring-white/50 transition-all
                                      w-64">
                        <i class="fas fa-search absolute right-3 top-3 text-gray-300"></i>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-lg">
                        <i class="fas fa-user-circle text-xl"></i>
                        <span class="font-medium"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom']; ?></span>
                    </div>
                    <form method="POST" action="../../controller/public/AuthController.php">
                        <button name="logout" type="submit" 
                                class="px-4 py-2 bg-red-500 text-white font-semibold rounded-lg 
                                       hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 
                                       focus:ring-offset-2 transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-xl">
            <div class="p-6">
                <div class="space-y-1">
                    <a href="teacher_dashboard.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="get_my_courses.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-50 
                              transition-all duration-200 text-blue-600">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="#" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-users"></i>
                        <span>Students</span>
                    </a>
                    <a href="statistics.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Course Management</h1>
                    <p class="text-sm text-gray-600 mt-1">Manage and organize your courses</p>
                </div>
                <a href="add-course.php" 
                   class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg 
                          hover:bg-blue-700 transition-all duration-200">
                    <i class="fas fa-plus"></i>
                    Add New Course
                </a>
            </div>

            <!-- Alerts -->
            <?php if(isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span><?php echo $_SESSION['success']; ?></span>
                    </div>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span><?php echo $_SESSION['error']; ?></span>
                    </div>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Course Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($courses as $course): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="<?php echo !empty($course['image']) ? '../../uploads/' . $course['image'] : '../../resourses/videotitle.png' ?>" 
                                                 alt="Course">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($course['title']); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-md truncate">
                                        <?php echo htmlspecialchars($course['description']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?php echo htmlspecialchars($course['categorie_id']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="edit_course.php?id=<?php echo htmlspecialchars($course['id_course']); ?>" 
                                           class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <a href="../../controller/teacher/delete_course.php?id=<?php echo htmlspecialchars($course['id_course']); ?>" 
                                           class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

          
        </div>
    </div>

    <!-- Add subtle pattern to background -->
    <style>
        body {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</body>
</html>