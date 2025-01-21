<?php
require_once "../../controller/teacher/course_students_controller.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$controller = new CourseStudentsController();
$result = $controller->viewStudents();
$courses = $result['success'] ? $result['courses'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-2xl font-bold tracking-wider">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Teacher Dashboard
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
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-users"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="get_my_courses.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-50 
                              transition-all duration-200 text-blue-600">
                        <i class="fas fa-book"></i>
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
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Course Enrollments</h1>
                <p class="text-sm text-gray-600 mt-1">View all students enrolled in your courses</p>
            </div>

            <!-- Courses List -->
            <div class="space-y-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    <?php echo htmlspecialchars($course['description']); ?>
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                <?php echo $course['student_count']; ?> Students
                            </span>
                        </div>

                        <?php if ($course['student_count'] > 0): ?>
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">Enrolled Students:</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php 
                                    $students = explode(',', $course['enrolled_students']);
                                    foreach ($students as $student): 
                                    ?>
                                        <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <span class="text-sm text-gray-700">
                                                <?php echo htmlspecialchars($student); ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 mt-4">No students enrolled yet.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Footer Info -->
            <div class="mt-6 text-right text-sm text-gray-500">
                <p>Current Time (UTC): <?php echo date('Y-m-d H:i:s'); ?></p>
                <p>User: <?php echo htmlspecialchars($_SESSION['login'] ?? 'unknown'); ?></p>
            </div>
        </div>
    </div>
</body>
</html>