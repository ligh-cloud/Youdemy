<?php
require "../../model/database.php";
require "../../model/Course.php";
require "../../model/category.php";

$categories = Category::getAll();
$courses = Course::getAll();

if (isset($_GET['category']) && $_GET['category'] !== 'all') {
    $filteredCourses = array_filter($courses, function($course) {
        return $course['categorie_id'] == $_GET['category']; 
    });
} else {
    $filteredCourses = $courses;
}

if (isset($_GET['type']) && $_GET['type'] === 'categories') {
    foreach ($categories as $category) {
        echo '<button class="category-filter px-4 py-2 rounded-full text-sm" data-category="' . htmlspecialchars($category['id']) . '" hx-get="controller/public/fetch_courses.php?category=' . urlencode($category['id']) . '" hx-trigger="click" hx-target="#courses-grid" hx-swap="innerHTML">';
        echo htmlspecialchars($category['nom']);
        echo '</button>';
    }
} else {
    foreach ($filteredCourses as $course) {
        echo '<div class="course-card bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up">';
        echo '<img src="' . htmlspecialchars($course['image']) . '" alt="' . htmlspecialchars($course['title']) . '" class="w-full h-48 object-cover">';
        echo '<div class="p-6">';
        echo '<div class="flex items-center justify-between mb-2">';
        echo '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">' . htmlspecialchars($course['category_name']) . '</span>';
        echo '<div class="flex items-center">';
        echo '<i class="fas fa-star text-yellow-400"></i>';
        echo '<span class="ml-1 text-gray-600">' . htmlspecialchars($course['rating'] ?? 'N/A') . '</span>';
        echo '</div>';
        echo '</div>';
        echo '<h3 class="text-xl font-semibold mb-2">' . htmlspecialchars($course['title']) . '</h3>';
        echo '<p class="text-gray-600 mb-4">' . htmlspecialchars($course['description']) . '</p>';
        echo '<div class="flex items-center justify-between">';
        echo '<div class="flex items-center">';
        echo '<img src="/api/placeholder/32/32" alt="Teacher" class="w-8 h-8 rounded-full">';
        echo '<span class="ml-2 text-sm text-gray-600">' . htmlspecialchars($course['teacher_name']) . '</span>';
        echo '</div>';
        echo '<span class="text-lg font-bold text-blue-600">' . htmlspecialchars($course['price'] ?? 'Free') . '€</span>';
        echo '</div>';
        echo '<button onclick="previewCourse(' . htmlspecialchars($course['id_course']) . ')" class="mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">Voir le détail</button>';
        echo '<button onclick="enrollCourse(' . htmlspecialchars($course['id_course']) . ')" class="mt-4 w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">S\'inscrire</button>';
        echo '</div>';
        echo '</div>';
    }
}
?>