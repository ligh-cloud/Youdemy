<?php
session_start();
require "../../model/Course.php";
require "../../model/Category.php"; // Add this line

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No course ID provided.";
    header("Location: get_my_courses.php");
    exit();
}

$courseId = $_GET['id'];
$course = Course::getCourseDetail($courseId);
$categories = Category::getAll(); // Get all categories

if (!$course) {
    $_SESSION['error'] = "Course not found.";
    header("Location: get_my_courses.php");
    exit();
}

// ... rest of your PHP logic ...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-2xl font-bold tracking-wider">
                    <i class="fas fa-edit mr-2"></i>Edit Course
                </div>
                <div class="flex items-center gap-3 bg-white/10 px-4 py-2 rounded-lg">
                    <i class="fas fa-user-circle text-xl"></i>
                    <span class="font-medium"><?php echo $_SESSION['nom'] . " " . $_SESSION['prenom']; ?></span>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-xl">
            <div class="p-6">
                <div class="space-y-1">
                    <a href="teacher_dashboard.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-50 
                              transition-all duration-200 text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="get_my_courses.php" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-50 
                              transition-all duration-200 text-blue-600">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <!-- ... other sidebar items ... -->
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-3xl mx-auto">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-600 mb-6">
                    <a href="get_my_courses.php" class="hover:text-blue-600">My Courses</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-400">Edit Course</span>
                </div>

                <!-- Alert Messages -->
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span><?php echo $_SESSION['error']; ?></span>
                        </div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Edit Form -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <form method="post" enctype="multipart/form-data" class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Course Title
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="<?php echo htmlspecialchars($course['title']); ?>" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                   required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" 
                                      rows="4" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                      required><?php echo htmlspecialchars($course['description']); ?></textarea>
                        </div>

                        <!-- Category Select -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Category
                            </label>
                            <div class="relative">
                                <select name="category" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                        required>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" 
                                                >
                                            <?php echo htmlspecialchars($category['nom']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>

                        <!-- File Uploads -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Document Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Document
                                    <?php if($course['content']): ?>
                                        <span class="text-xs text-gray-500 block">Current: <?php echo $course['content']; ?></span>
                                    <?php endif; ?>
                                </label>
                                <input type="file" 
                                       name="document" 
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Image
                                    <?php if($course['image']): ?>
                                        <span class="text-xs text-gray-500 block">Current: <?php echo $course['image']; ?></span>
                                    <?php endif; ?>
                                </label>
                                <input type="file" 
                                       name="image" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                            </div>

                            <!-- Video Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Video
                                    <?php if($course['video']): ?>
                                        <span class="text-xs text-gray-500 block">Current: <?php echo $course['video']; ?></span>
                                    <?php endif; ?>
                                </label>
                                <input type="file" 
                                       name="video" 
                                       accept="video/*"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100">
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="get_my_courses.php" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Course
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <style>
        
        input[type="text"], 
        textarea, 
        select {
            border: 1px solid #e2e8f0;
        }

        input[type="text"]:focus, 
        textarea:focus, 
        select:focus {
            border-color: #3b82f6;
            ring: 2px;
            ring-color: #3b82f6;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
    </style>
</body>
</html>