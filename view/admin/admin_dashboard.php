<!-- admin.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body class="bg-gray-100">
<form method="POST" action="../../controller/AuthController.php" class="flex justify-center items-center p-4 bg-gray-100 rounded-lg shadow-md">
    <button 
        name="logout" 
        type="submit" 
        class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all"
    >
        Log out
    </button>
</form>
    <!-- Admin Navigation -->
    <nav class="bg-dark-800 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-xl font-bold">Admin Dashboard</div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="px-4 py-2 bg-gray-700 rounded-lg text-white">
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Admin Name</span>
                        <img src="/api/placeholder/32/32" class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Admin Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="space-y-2">
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Dashboard</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Teacher Validation</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">User Management</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Course Management</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Statistics</a>
                </div>
            </div>
        </div>

        <!-- Admin Main Content -->
        <div class="flex-1 p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Users</h3>
                    <p class="text-3xl font-bold">1,234</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Total Courses</h3>
                    <p class="text-3xl font-bold">86</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Pending Approvals</h3>
                    <p class="text-3xl font-bold">12</p>
                </div>
            </div>

            <!-- Teacher Approval Section -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Pending Teacher Approvals</h2>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">Subject</th>
                                <th class="p-3 text-left">Date</th>
                                <th class="p-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="p-3">John Doe</td>
                                <td class="p-3">Web Development</td>
                                <td class="p-3">2024-01-13</td>
                                <td class="p-3">
                                    <button class="bg-green-500 text-white px-3 py-1 rounded mr-2">Approve</button>
                                    <button class="bg-red-500 text-white px-3 py-1 rounded">Reject</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>