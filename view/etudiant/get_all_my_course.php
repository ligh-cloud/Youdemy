<?php
session_start();
require_once "../../model/database.php";
require_once "../../model/Course.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$userId = $_SESSION['user_id'];

$courses = Course::getCourseByStudent($userId);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-blue-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow sticky top-0 z-50">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text">
                        Youdemy
                    </h1>
                    <nav class="hidden lg:flex space-x-4">
                        <a href="student_dashboard.php" 
                           class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            Dashboard
                        </a>
                        <a href="get_all_my_course.php" 
                           class="px-4 py-2 text-blue-600 bg-blue-50 rounded-lg font-semibold transition">
                            My Courses
                        </a>
                        <a href="search.php" 
                           class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            Course Catalog
                        </a>
                        <a href="#" 
                           class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition">
                            Progress
                        </a>
                    </nav>
                </div>
                <div class="lg:hidden">
                    <button id="mobile-menu-toggle" class="p-2 text-gray-500 hover:text-blue-600">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            <h1 class="text-center text-3xl font-extrabold text-gray-800 mb-6">My Courses</h1>

            <div id="results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($courses)): ?>
                    <div class="col-span-full text-center p-6 bg-white rounded-lg shadow">
                        <p class="text-gray-600">You are not enrolled in any courses yet.</p>
                        <a href="search.php" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                            Explore Courses
                        </a>
                    </div>
                <?php else: ?>
                    <?php foreach ($courses as $course): ?>
                        <article class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-transform">
                            <?php if (!empty($course['image'])): ?>
                                <img src="../../uploads/<?php echo htmlspecialchars($course['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                     class="w-full h-40 object-cover rounded-t-lg mb-4">
                            <?php endif; ?>

                            <div class="">
                                <h3 class="text-lg font-semibold text-blue-600 mb-2">
                                    <?php echo htmlspecialchars($course['title']); ?>
                                </h3>
                                <p class="text-gray-600 mb-2">
                                    <span class="font-medium">Teacher:</span> 
                                    <?php echo htmlspecialchars($course['teacher_firstname'] . ' ' . $course['teacher_name']); ?>
                                </p>
                                <?php if (!empty($course['category_name'])): ?>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-medium">Category:</span> 
                                        <?php echo htmlspecialchars($course['category_name']); ?>
                                    </p>
                                <?php endif; ?>
                                <p class="text-gray-700 mb-4 text-sm">
                                    <?php echo htmlspecialchars($course['description']); ?>
                                </p>
                                <button class="enroll-button px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    <a href="course_details.php?id_course=<?php echo $course['id_course'] ?>">View Details</a>
                                </button>
                                
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow py-4">
            <div class="container mx-auto text-center text-gray-600">
                &copy; <?php echo date('Y'); ?> Youdemy. All rights reserved.
            </div>
        </footer>
    </div>
</body>

<style>
:root {
    --primary-color: #4a90e2;
    --secondary-color: #f5f5f5;
    --text-color: #333;
    --border-color: #ddd;
    --shadow-color: rgba(0, 0, 0, 0.1);
}

body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    color: var(--text-color);
}

.enroll-button {
    transition: transform 0.3s ease;
}

.enroll-button:hover {
    transform: translateY(-3px);
}

/* Responsive Navigation */
#mobile-menu-toggle {
    display: none;
}

@media (max-width: 1024px) {
    nav {
        display: none;
    }

    #mobile-menu-toggle {
        display: block;
    }
}
</style>

</html>
