<!-- admin.html -->
<!DOCTYPE html>
<?php session_start() ?>
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

    <!-- Admin Navigation -->
    <nav class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-xl font-bold">Admin Dashboard</div>

                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="px-4 py-2 bg-gray-700 rounded-lg text-white">
                    </div>
                    <div class="flex items-center gap-2">
                        <span><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></span>
                       
                    </div>
                    <form method="POST" action="../../controller/public/AuthController.php" class="flex justify-center items-center p-4 bg-gray-100 rounded-lg shadow-md">
                        <button
                            name="logout"
                            type="submit"
                            class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Admin Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="space-y-2">
                    <a href="admin_dashboard.php" class="block px-4 py-2 rounded hover:bg-purple-50">Dashboard</a>
                    <a href="teacher_accept.php" class="block px-4 py-2 rounded hover:bg-purple-50">Teacher Validation</a>
                    <a href="manage_users.php" class="block px-4 py-2 rounded hover:bg-purple-50">User Management</a>
                    <a href="manage_courses.php" class="block px-4 py-2 rounded hover:bg-purple-50">Course Management</a>
                    
                    <a href="tags_category.php" class="block px-4 py-2 rounded hover:bg-purple-50">Add categories & Tags</a>
                </div>
            </div>
        </div>

        <!-- Admin Main Content -->
        <?php include "admin_stats.php"; ?>
</body>

</html>