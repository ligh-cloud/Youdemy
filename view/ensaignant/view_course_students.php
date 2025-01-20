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
                    <i class="fas fa-users mr-2"></i>Course Students
                </div>
                <!-- ... rest of the header ... -->
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-xl">
            <!-- ... sidebar content ... -->
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