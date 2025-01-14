<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-purple-600 text-white py-4 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="text-xl font-bold">Teacher Dashboard</div>
            <div class="flex items-center gap-2">
                        <span><?php  echo "HELLO" . " " . $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></span>
                        
                    </div>
            <form method="POST" action="../../controller/AuthController.php" class="flex justify-center items-center">
                <button 
                    name="logout" 
                    type="submit" 
                    class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all"
                >
                    Log out
                </button>
            </form>
        </div>
    </header>

    <div class="flex min-h-screen">
        <!-- Teacher Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="space-y-2">
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Dashboard</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">My Courses</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Students</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Analytics</a>
                </div>
            </div>
        </div>

        <!-- Teacher Main Content -->
        <div class="flex-1 p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Students</h3>
                    <p class="text-3xl font-bold">256</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Active Courses</h3>
                    <p class="text-3xl font-bold">8</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Average Rating</h3>
                    <p class="text-3xl font-bold">4.8</p>
                </div>
            </div>

            <!-- Course List -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">My Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="border rounded-lg overflow-hidden">
                            <img src="/api/placeholder/400/200" alt="Course" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold">Web Development Basics</h3>
                                <p class="text-gray-600 text-sm mb-2">Students: 45</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-yellow-500">★ 4.9</span>
                                    <button class="text-purple-600">Edit</button>
                                </div>
                            </div>
                        </div>
                        <!-- Add more courses here -->
                    </div>
                </div>
            </div>

            <!-- Add New Course Button -->
            <div class="flex justify-end">
                <a href="add-course.php" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Add New Course</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-purple-600 text-white py-4 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            © 2025 Teacher Dashboard. All rights reserved.
        </div>
    </footer>
</body>
</html>