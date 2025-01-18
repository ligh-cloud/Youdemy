<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">


<!-- Student Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <form method="POST" action="../../controller/public/AuthController.php" class="flex justify-center items-center p-4 bg-gray-100 rounded-lg shadow-md">
                    <button
                        name="logout"
                        type="submit"
                        class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all">
                        Log out
                    </button>
                </form>
                <div class="text-xl font-bold text-purple-600">Student Dashboard</div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Search courses..."
                            class="px-4 py-2 border rounded-lg">
                    </div>
                    <div class="flex items-center gap-2">
                        <span><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom'] ?></span>
                        <img src="/api/placeholder/32/32" class="w-8 h-8 rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php



//  success message

if (isset($_SESSION['success'])) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">' . $_SESSION['success'] . '</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a.5.5 0 0 1 0 .707L10.707 10l3.641 3.641a.5.5 0 1 1-.707.707L10 10.707l-3.641 3.641a.5.5 0 0 1-.707-.707L9.293 10 5.652 6.359a.5.5 0 1 1 .707-.707L10 9.293l3.641-3.641a.5.5 0 0 1 .707 0z"/></svg>
            </span>
          </div>';
    unset($_SESSION['success']); 
}

// error message
if (isset($_SESSION['error'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">' . $_SESSION['error'] . '</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a.5.5 0 0 1 0 .707L10.707 10l3.641 3.641a.5.5 0 1 1-.707.707L10 10.707l-3.641 3.641a.5.5 0 0 1-.707-.707L9.293 10 5.652 6.359a.5.5 0 1 1 .707-.707L10 9.293l3.641-3.641a.5.5 0 0 1 .707 0z"/></svg>
            </span>
          </div>';
    unset($_SESSION['error']); 
}
?>      

    <div class="flex min-h-screen">

        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <div class="space-y-2">
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Dashboard</a>
                    <a href="get_all_my_course.php" class="block px-4 py-2 rounded hover:bg-purple-50">My Courses</a>
                    <a href="search.php" class="block px-4 py-2 rounded hover:bg-purple-50">Course Catalog</a>
                    <a href="#" class="block px-4 py-2 rounded hover:bg-purple-50">Progress</a>
                </div>
            </div>
        </div>


        <div class="flex-1 p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Enrolled Courses</h3>
                    <p class="text-3xl font-bold">5</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Completed Courses</h3>
                    <p class="text-3xl font-bold">3</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Hours Learned</h3>
                    <p class="text-3xl font-bold">42</p>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">My Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="border rounded-lg overflow-hidden">
                            <img src="/api/placeholder/400/200" alt="Course" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold">Web Development Bootcamp</h3>
                                <p class="text-gray-600 text-sm mb-2">Progress: 60%</p>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: 60%"></div>
                                </div>
                                <button class="w-full bg-purple-600 text-white py-2 rounded-lg">
                                    Continue Learning
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>