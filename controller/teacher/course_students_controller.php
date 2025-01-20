<?php
session_start();
require_once "../../model/statistics.php";

class CourseStudentsController {
    public function viewStudents($courseId = null) {
        try {
            if ($courseId) {
            
                $students = Statistics::getEnrolledStudentsForCourse($courseId);
                return [
                    'success' => true,
                    'students' => $students
                ];
            } else {
        
                $teacherId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
                $courses = Statistics::getAllCoursesWithStudents($teacherId);
                return [
                    'success' => true,
                    'courses' => $courses
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new CourseStudentsController();
    $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : null;
    $result = $controller->viewStudents($courseId);
    
    if (isset($_GET['api'])) {

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
?>