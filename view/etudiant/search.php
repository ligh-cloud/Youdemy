    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Course Search</title>
        <script src="https://unpkg.com/htmx.org@1.9.10"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Add Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body class="bg-gray-50">
        <div class="min-h-screen">
            <div class="container mx-auto p-4">
                <!-- Enhanced Header -->
                <header class="mb-8">
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

                    <!-- Enhanced Search Section -->
                    <div class="max-w-3xl mx-auto text-center">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6">Find Your Next Course</h1>
                        <p class="text-gray-600 mb-8">Discover thousands of courses to start learning something new today</p>
                        <div class="search-wrapper relative">
                            <input type="text"
                                name="search"
                                placeholder="Search courses, teachers, or topics..."
                                hx-post="../../controller/public/search-results.php"
                                hx-trigger="input changed delay:500ms, load"
                                hx-target="#results"
                                hx-indicator=".htmx-indicator"
                                class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 shadow-sm">
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 flex items-center space-x-3">
                                <div class="htmx-indicator">
                                    <svg class="spinner w-6 h-6 text-blue-500" viewBox="0 0 50 50">
                                        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                                    </svg>
                                </div>
                                <i class="fas fa-search text-gray-400 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Enhanced Results Section -->
                <main class="max-w-7xl mx-auto">
                    <div id="results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Results will be loaded here -->
                    </div>
                </main>
            </div>
        </div>

        <style>
            /* Base Styles */
            :root {
                --primary-color: #3b82f6;
                --secondary-color: #f3f4f6;
                --text-color: #1f2937;
                --border-color: #e5e7eb;
                --shadow-color: rgba(0, 0, 0, 0.1);
            }

            body {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
                line-height: 1.6;
                color: var(--text-color);
            }

            /* Enhanced Animations */
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes rotate {
                100% { transform: rotate(360deg); }
            }

            @keyframes dash {
                0% { stroke-dasharray: 1, 150; stroke-dashoffset: 0; }
                50% { stroke-dasharray: 90, 150; stroke-dashoffset: -35; }
                100% { stroke-dasharray: 90, 150; stroke-dashoffset: -124; }
            }

            /* Enhanced Components */
            .search-wrapper {
                position: relative;
                max-width: 800px;
                margin: 0 auto;
            }

            .course-card {
                background: white;
                padding: 1.5rem;
                border-radius: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                transition: all 0.3s ease;
                animation: fadeIn 0.5s ease-out;
            }

            .course-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            .spinner {
                animation: rotate 2s linear infinite;
            }

            .path {
                stroke: var(--primary-color);
                stroke-linecap: round;
                animation: dash 1.5s ease-in-out infinite;
            }

            /* Enhanced Button Styles */
            .enroll-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 1.5rem;
                background: var(--primary-color);
                color: white;
                border-radius: 0.75rem;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .enroll-button:hover {
                background: #2563eb;
                transform: translateY(-2px);
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                .container { padding: 1rem; }
                .search-wrapper { padding: 0 1rem; }
                header h1 { font-size: 2rem; }
            }
        </style>

        <script>
            function enrollCourse(courseId) {
                window.location.href = `enroll_course.php?id=${courseId}`;
            }
        </script>
    </body>
    </html>