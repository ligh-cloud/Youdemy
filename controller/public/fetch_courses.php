<?php
require "../../model/database.php";
require "../../model/Course.php";
require "../../model/category.php";

$categories = Category::getAll();
$courses = Course::getAll();


$filteredCourses = $courses;


if (isset($_GET['category']) && $_GET['category'] !== 'all') {
    $filteredCourses = array_filter($courses, function($course) {
        return $course['categorie_id'] == $_GET['category']; 
    });
}


if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = strtolower($_GET['search']);
    $filteredCourses = array_filter($filteredCourses, function($course) use ($search) {
        return strpos(strtolower($course['title']), $search) !== false ||
               strpos(strtolower($course['description']), $search) !== false;
    });
}


if (isset($_GET['type']) && $_GET['type'] === 'categories') {
   
    echo '<button class="category-filter active px-4 py-2 rounded-full text-sm" 
            data-category="all" 
            hx-get="controller/public/fetch_courses.php?category=all" 
            hx-trigger="click" 
            hx-target="#courses-grid" 
            hx-swap="innerHTML">
            Tous
          </button>';
    
    foreach ($categories as $category) {
        echo '<button class="category-filter px-4 py-2 rounded-full text-sm" 
                data-category="' . htmlspecialchars($category['id']) . '" 
                hx-get="controller/public/fetch_courses.php?category=' . urlencode($category['id']) . '" 
                hx-trigger="click" 
                hx-target="#courses-grid" 
                hx-swap="innerHTML">';
        echo htmlspecialchars($category['nom']);
        echo '</button>';
    }
} else {

    if (empty($filteredCourses)) {
        echo '<div class="col-span-full text-center py-8">
                <div class="text-gray-500">
                    <i class="fas fa-search text-4xl mb-4"></i>
                    <p>Aucun cours trouvé</p>
                </div>
              </div>';
        exit;
    }

    
    foreach ($filteredCourses as $course) {
       
        $categoryName = '';
        foreach ($categories as $category) {
            if ($category['id'] == $course['categorie_id']) {
                $categoryName = $category['nom'];
                break;
            }
        }

        echo '<div class="course-card bg-white rounded-lg shadow-md overflow-hidden" data-aos="fade-up">';
        
        if (!empty($course['image'])) {
            echo '<img src="uploads/' . htmlspecialchars($course['image']) . '" 
                      alt="' . htmlspecialchars($course['title']) . '" 
                      class="w-full h-48 object-cover">';
        } else {
            echo '<img src="/api/placeholder/400/200" 
                      alt="Course placeholder" 
                      class="w-full h-48 object-cover">';
        }
        
        echo '<div class="p-6">';

        echo '<div class="flex items-center justify-between mb-2">';
        echo '<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">' . 
             htmlspecialchars($categoryName) . '</span>';
        echo '<div class="flex items-center">';
        echo '<i class="fas fa-star text-yellow-400"></i>';
        echo '<span class="ml-1 text-gray-600">' . 
             htmlspecialchars($course['rating'] ?? 'N/A') . '</span>';
        echo '</div>';
        echo '</div>';
        
      
        echo '<h3 class="text-xl font-semibold mb-2">' . 
             htmlspecialchars($course['title']) . '</h3>';
        echo '<p class="text-gray-600 mb-4">' . 
             htmlspecialchars(substr($course['description'], 0, 150)) . '...</p>';
        
       
        echo '<div class="flex items-center justify-between">';
        echo '<div class="flex items-center">';
        echo '<img src="/api/placeholder/32/32" alt="Teacher" class="w-8 h-8 rounded-full">';
        echo '<span class="ml-2 text-sm text-gray-600">' . 
             htmlspecialchars($course['teacher_name'] ?? 'Instructeur') . '</span>';
        echo '</div>';
        echo '<span class="text-lg font-bold text-blue-600">' . 
             htmlspecialchars($course['price'] ?? 'Free') . '€</span>';
        echo '</div>';
        
     
        echo '<button onclick="previewCourse(' . htmlspecialchars($course['id_course']) . ')" 
                      class="mt-4 w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Voir le détail
              </button>';
        echo '<button onclick="enrollCourse(' . htmlspecialchars($course['id_course']) . ')" 
                      class="mt-2 w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                S\'inscrire
              </button>';
        
        echo '</div>';
        echo '</div>';
    }
}
?>