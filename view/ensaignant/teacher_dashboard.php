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
    <!-- Teacher Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-xl font-bold text-purple-600">Teacher Dashboard</div>
                <div class="flex items-center gap-4">
                    <button class="bg-purple-600 text-white px-4 py-2 rounded-lg">
                        Add New Course
                    </button>
                    <div class="flex items-center gap-2">
                        <span>Teacher Name</span>
                        <img src="/api/placeholder/32/32" class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </nav>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
