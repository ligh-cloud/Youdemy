<?php
require_once "database.php";

class Statistics {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getCourseEnrollments($courseId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as enrollment_count 
            FROM enrollenment 
            WHERE id_course = :courseId
        ");
        $stmt->bindParam(':courseId', $courseId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['enrollment_count'];
    }

    public function getTeacherTotalStudents($teacherId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(DISTINCT e.id_user) as total_students
            FROM courses c
            JOIN enrollenment e ON c.id_course = e.id_course
            WHERE c.teacher_id = :teacherId
        ");
        $stmt->bindParam(':teacherId', $teacherId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_students'];
    }

    public function getTopPerformingCourses($teacherId, $limit = 5) {
        $stmt = $this->db->prepare("
            SELECT c.id_course, c.title, COUNT(e.id_user) as enrollment_count
            FROM courses c
            LEFT JOIN enrollenment e ON c.id_course = e.id_course
            WHERE c.teacher_id = :teacherId
            GROUP BY c.id_course
            ORDER BY enrollment_count DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':teacherId', $teacherId);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyEnrollments($teacherId) {
        $stmt = $this->db->prepare("
            SELECT 
                DATE_FORMAT(u.created_at, '%Y-%m') as month,
                COUNT(e.id_user) as enrollment_count
            FROM courses c
            JOIN enrollenment e ON c.id_course = e.id_course
            JOIN users u ON e.id_user = u.id
            WHERE c.teacher_id = :teacherId
            GROUP BY DATE_FORMAT(u.created_at, '%Y-%m')
            ORDER BY month DESC
            LIMIT 12
        ");
        $stmt->bindParam(':teacherId', $teacherId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentProgress($courseId, $studentId) {
        // This would require additional tables for tracking progress
        // For now, returning a placeholder implementation
        return [
            'completed' => 75,
            'total_time' => '12:30:00',
            'last_access' => '2024-01-15'
        ];
    }

    public function updateStatistics() {
        $stmt = $this->db->prepare("
            UPDATE Statistics SET
                total_courses = (SELECT COUNT(*) FROM courses),
                total_students = (SELECT COUNT(DISTINCT id_user) FROM enrollenment),
                top_course_id = (
                    SELECT id_course
                    FROM (
                        SELECT id_course, COUNT(*) as count
                        FROM enrollenment
                        GROUP BY id_course
                        ORDER BY count DESC
                        LIMIT 1
                    ) as top
                )
        ");
        $stmt->execute();
    }
}
?>