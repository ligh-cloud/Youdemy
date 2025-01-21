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

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        

        <div class="container mx-auto p-4">
            <header class="mb-6">
            <div class="bg-white shadow-lg rounded-xl p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 flex items-center">
                           
                                <h1 class="ml-3 text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text">
                                    Youdemy
                                </h1>
                            </div>
                            <nav class="hidden lg:flex lg:space-x-1">
                                <a href="student_dashboard.php" 
                                   class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 flex items-center">
                                    <i class="fas fa-home mr-2"></i> Dashboard
                                </a>
                                <a href="get_all_my_course.php" 
                                   class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 flex items-center">
                                    <i class="fas fa-book-open mr-2"></i> My Courses
                                </a>
                                <a href="search.php" 
                                   class="px-4 py-2 rounded-lg bg-blue-50 text-blue-600 font-medium flex items-center">
                                    <i class="fas fa-search mr-2"></i> Course Catalog
                                </a>
                                <a href="#" 
                                   class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 flex items-center">
                                    <i class="fas fa-chart-line mr-2"></i> Progress
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <h1 class="text-center text-3xl font-bold mt-4">My Courses</h1>
            </header>

            <main>
                <div id="results" class="results-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php if (empty($courses)): ?>
                    <div class="no-results col-span-full text-center">
                        <p class="text-gray-600">You are not enrolled in any courses yet.</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($courses as $course): ?>
                    <article class="course-card bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-transform duration-300">
                        <?php if (!empty($course['image'])): ?>
                        <div class="course-image mb-4">
                            <img src="../../uploads/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>"
                                class="w-full h-40 object-cover rounded-lg">
                            
                        </div>
                        <?php endif; ?>

                        <div class="course-content">
                            <h3 class="text-xl font-semibold text-blue-600 mb-2"><?php echo htmlspecialchars($course['title']); ?></h3>

                            <p class="teacher text-gray-600 mb-2">
                                <span class="font-semibold">Teacher:</span>
                                <?php echo htmlspecialchars($course['teacher_firstname'] . ' ' . $course['teacher_name']); ?>
                            </p>

                            <?php if (!empty($course['category_name'])): ?>
                            <p class="category text-gray-600 mb-2">
                                <span class="font-semibold">Category:</span>
                                <?php echo htmlspecialchars($course['category_name']); ?>
                            </p>
                            <?php endif; ?>

                            <p class="description text-gray-700 mb-4">
                                <?php echo htmlspecialchars($course['description']); ?>
                            </p>
                        </div>
                    </article>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
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

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: system-ui, -apple-system, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: #f8f9fa;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

header {
    text-align: center;
    margin-bottom: 3rem;
}

header h1 {
    color: var(--primary-color);
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.search-wrapper {
    position: relative;
    max-width: 600px;
    margin: 0 auto;
}

input[name="search"] {
    width: 100%;
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
    border: 2px solid var(--border-color);
    border-radius: 50px;
    transition: all 0.3s ease;
    background: white;
}

input[name="search"]:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
}

.results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.course-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    transition: transform 0.3s ease;
}

.course-card:hover {
    transform: translateY(-5px);
}

.course-card h3 {
    color: var(--primary-color);
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.teacher {
    margin-bottom: 1rem;
    color: #666;
}

.tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.tag {
    background: var(--secondary-color);
    padding: 0.3rem 0.8rem;
    border-radius: 50px;
    font-size: 0.9rem;
    color: #666;
}

.description {
    color: #555;
    font-size: 0.95rem;
}

.no-results {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 12px;
    color: #666;
}

/* Loading indicator */
.htmx-indicator {
    display: none;
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
}

.htmx-request .htmx-indicator {
    display: block;
}

.spinner {
    animation: rotate 2s linear infinite;
    width: 25px;
    height: 25px;
}

.path {
    stroke: var(--primary-color);
    stroke-linecap: round;
    animation: dash 1.5s ease-in-out infinite;
}

@keyframes rotate {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes dash {
    0% {
        stroke-dasharray: 1, 150;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 90, 150;
        stroke-dashoffset: -35;
    }
    100% {
        stroke-dasharray: 90, 150;
        stroke-dashoffset: -124;
    }
}

.enroll-button {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    margin-top: 1rem;
}

.enroll-button:hover {
    background-color: #357ab7;
    transform: translateY(-2px);
}

.enroll-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.4);
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
    
    .results-grid {
        grid-template-columns: 1fr;
    }
    
    header h1 {
        font-size: 2rem;
    }
}
</style>

</html>