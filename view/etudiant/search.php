<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Search</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
<div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="space-y-2">
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Dashboard</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">My Courses</a>
                    <a href="search.php" class="block px-4 py-2 rounded hover:bg-purple-50">Course Catalog</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Progress</a>
                </div>
            </div>
        </div>

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
            <h1 class="text-center text-3xl font-bold mt-4">Course Search</h1>
            <div class="search-wrapper relative max-w-lg mx-auto mt-6">
                <input type="text" 
                       name="search" 
                       placeholder="Search courses, teachers, tags..."
                       hx-post="../../controller/public/search-results.php"
                       hx-trigger="input changed delay:500ms, load"
                       hx-target="#results"
                       hx-indicator=".htmx-indicator"
                       class="w-full px-4 py-2 border-2 border-gray-300 rounded-full focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <div class="htmx-indicator absolute right-4 top-1/2 transform -translate-y-1/2">
                    <svg class="spinner w-5 h-5 text-blue-500" viewBox="0 0 50 50">
                        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                    </svg>
                </div>
            </div>
        </header>
        
        <main>
            <div id="results" class="results-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Example of a course card -->
               
                <!-- Add more course cards here -->
            </div>
        </main>
    </div>
    </div>
    <script>
        function enrollCourse(courseId) {
            window.location.href = `enroll_course.php?id=${courseId}`;
        }
    </script>
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