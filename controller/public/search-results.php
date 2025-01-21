<?php


require_once "../../model/Course.php";
require_once "../../model/database.php";

$search = $_POST['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 9; // Number of items per page

try {
  
    $totalCourses = Course::getSearchCount($search);
    $totalPages = ceil($totalCourses / $perPage);
    

    $offset = ($page - 1) * $perPage;
    $courses = Course::searchCourses($search, $perPage, $offset);

  
    $coursesHtml = '';
    foreach ($courses as $course) {
        $coursesHtml .= generateCourseCard($course);
    }

    // Generate pagination HTML
    $paginationHtml = generatePagination($page, $totalPages, $search);

    // Return both course cards and pagination
    echo '<div id="results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 page-transition">' 
         . $coursesHtml . 
         '</div>' .
         '<div class="flex items-center justify-center space-x-2 mt-8">' 
         . $paginationHtml . 
         '</div>';

} catch (Exception $e) {
    echo '<div class="text-red-500">Error: ' . $e->getMessage() . '</div>';
}

function generateCourseCard($course) {
    return '
    <div class="course-card bg-white rounded-xl overflow-hidden">
        <img src="../../uploads/' . htmlspecialchars($course['image']) . '" 
             alt="' . htmlspecialchars($course['title']) . '"
             class="w-full h-48 object-cover">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">' . htmlspecialchars($course['title']) . '</h3>
            <p class="text-gray-600 mb-4">' . htmlspecialchars(substr($course['description'], 0, 100)) . '...</p>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-user mr-2"></i>' . htmlspecialchars($course['teacher_name']) . '
                </span>
                <form action="../../controller/student/enroll.php" method="POST">
                    <input type="hidden" name="id_course" value="' . htmlspecialchars($course['id_course']) . '">
                    <button type="submit" class="enroll-button bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">
                        Enroll
                    </button>
                </form>
            </div>
        </div>
    </div>';
}


function generatePagination($currentPage, $totalPages, $search) {
    $html = '';
    
    // disable the previous if the page is <= 1
    $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
    $html .= '<button ' . $prevDisabled . ' 
              class="pagination-button ' . $prevDisabled . '"
              hx-post="../../controller/public/search-results.php?page=' . ($currentPage - 1) . '"
              hx-target="#search-container">
              <i class="fas fa-chevron-left"></i>
              </button>';

   
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            $html .= '<button class="pagination-button active">' . $i . '</button>';
        } else {
            $html .= '<button class="pagination-button"
                      hx-post="../../controller/public/search-results.php?page=' . $i . '"
                      hx-target="#search-container">' . $i . '</button>';
        }
    }

  
    $nextDisabled = $currentPage >= $totalPages ? 'disabled' : '';
    $html .= '<button ' . $nextDisabled . '
              class="pagination-button ' . $nextDisabled . '"
              hx-post="../../controller/public/search-results.php?page=' . ($currentPage + 1) . '"
              hx-target="#search-container">
              <i class="fas fa-chevron-right"></i>
              </button>';

    return $html;
}