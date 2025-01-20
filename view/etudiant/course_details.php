<?php
session_start();
require_once "../../model/database.php";
require_once "../../model/Course.php";
require_once "../../model/enrolement.php";

if (!isset($_GET['id_course'])) {
    echo "Course ID is required.";
    exit();
}

$courseId = $_GET['id_course'];


$course = Course::getCourseDetail($courseId);
$enrollments = new Enrollment;
$enrollment = $enrollments->getNumberEnrollmentsByUser($courseId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <header class="mb-6">
            <div class="flex items-center p-4 bg-white shadow-md rounded-lg">
                <div class="flex-shrink-0 flex items-center">
                    <img src="/api/placeholder/40/40" alt="Logo" class="h-10 w-10 rounded-lg mr-2">
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 text-transparent bg-clip-text">Youdemy</h1>
                </div>
                <nav class="hidden lg:flex lg:space-x-8 ml-10">
                    <a href="student_dashboard.php" class="nav-link active text-blue-600 hover:underline" data-section="home">Accueil</a>
                    <a href="#" class="nav-link text-gray-600 hover:underline" data-section="courses">Cours</a>
                    <a href="#" class="nav-link student-only hidden text-gray-600 hover:underline" data-section="my-courses">Mes Cours</a>
                    <a href="#" class="nav-link teacher-only hidden text-gray-600 hover:underline" data-section="manage">Gérer</a>
                    <a href="#" class="nav-link teacher-only hidden text-gray-600 hover:underline" data-section="stats">Statistiques</a>
                </nav>
            </div>
        </header>

        <main>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <?php if (!empty($course['image'])): ?>
                    <div class="course-image mb-4">
                        <img src="../../uploads/<?php echo htmlspecialchars($course['image']);   ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" class="w-full h-60 object-cover rounded-lg">
                    </div>
                <?php endif; ?>

                <div class="course-content">
                    <h2 class="text-3xl font-bold text-blue-600 mb-4"><?php echo htmlspecialchars($course['title']); ?></h2>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($course['description']); ?></p>

                    <p class="text-gray-600 mb-2">
                        <span class="font-semibold">Teacher:</span> 
                        <?php echo htmlspecialchars($course['teacher_firstname'] . ' ' . $course['teacher_name']); ?>
                    </p>

                    <?php if (!empty($course['category_name'])): ?>
                        <p class="text-gray-600 mb-2">
                            <span class="font-semibold">Category:</span> 
                            <?php echo htmlspecialchars($course['category_name']); ?>
                        </p>
                    <?php endif; ?>

                    <p class="text-gray-600 mb-2">
                        <span class="font-semibold">Enrollment Count:</span> 
                        <?php echo htmlspecialchars($enrollment['enrollment_count']); ?>
                    </p>
  

                    <?php if (!empty($course['content'])): ?>
                        <div class="course-content mb-4">
                            <h3 class="text-xl font-semibold text-blue-500 mb-2">Course Content</h3>
                            <p class="text-gray-700"><?php echo htmlspecialchars($course['content']); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($course['video'])): ?>
                        <div class="course-video mb-4">
                            <h3 class="text-xl font-semibold text-blue-500 mb-2">Course Video</h3>
                            <video controls class="w-full rounded-lg">
                                <source src="../../uploads/<?php echo htmlspecialchars($course['video']); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
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