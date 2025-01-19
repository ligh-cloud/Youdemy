<?php
require "database.php";
abstract class Course {
    protected $title;
    protected $description;
    protected $students = [];
    protected $db;
    protected $teacherId;

    public function __construct($title, $description, $teacherId) {
        $this->title = $title;
        $this->description = $description;
        $this->teacherId = $teacherId;
        $this->db = Database::getInstance()->getConnection();
    }

    abstract public function addCourse();
    abstract public function showCourse();

    public function ajouterCour() {
        $stmt = $this->db->prepare("INSERT INTO courses (title, description) VALUES (:title, :description)");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->execute();
        echo "ajouterCour: Course added.\n";
    }

    public function afficheCours() {
        echo "afficheCours: Displaying course details.\n";
        $this->showCourse();
    }

    public function rechercheCour($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE title LIKE :keyword OR description LIKE :keyword");
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($courses) {
            echo "rechercheCour: Course found.\n";
            foreach ($courses as $course) {
                echo "Title: " . $course['title'] . "\n";
                echo "Description: " . $course['description'] . "\n";
            }
        } else {
            echo "rechercheCour: Course not found.\n";
        }
    }

    public function inscriptionCour($studentId) {
        if (!in_array($studentId, $this->students)) {
            $this->students[] = $studentId;
            $stmt = $this->db->prepare("INSERT INTO enrollenment (id_course, id_user) VALUES (:id_course, :id_user)");
            $stmt->bindParam(':id_course', $this->getCourseId());
            $stmt->bindParam(':id_user', $studentId);
            $stmt->execute();
            echo "inscriptionCour: Student {$studentId} enrolled in the course.\n";
        } else {
            echo "inscriptionCour: Student {$studentId} is already enrolled.\n";
        }
    }

    public function suprimerCour() {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE title = :title AND description = :description");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->execute();
        echo "suprimerCour: Course deleted.\n";
        $this->title = null;
        $this->description = null;
        $this->students = [];
    }
  
    public function modifierCour($newTitle = null, $newDescription = null, $newContent = null, $newImage = null, $newVideo = null) {
        $courseId = $this->getCourseId();
        if ($courseId) {
            $stmt = $this->db->prepare("UPDATE courses SET title = :newTitle, description = :newDescription, content = :newContent, image = :newImage, video = :newVideo WHERE id_course = :id_course");
            $stmt->bindParam(':newTitle', $newTitle);
            $stmt->bindParam(':newDescription', $newDescription);
            $stmt->bindParam(':newContent', $newContent);
            $stmt->bindParam(':newImage', $newImage);
            $stmt->bindParam(':newVideo', $newVideo);
            $stmt->bindParam(':id_course', $courseId);
            $stmt->execute();
            $this->title = $newTitle;
            $this->description = $newDescription;
            echo "modifierCour: Course details updated.\n";
        } else {
            echo "modifierCour: Course not found.\n";
        }
    }

    protected function getCourseId() {
        $stmt = $this->db->prepare("SELECT id_course FROM courses WHERE title = :title AND description = :description");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->execute();
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        return $course ? $course['id_course'] : null;
    }
    public static function getallCourse($teacherId){
        $db = Database::getInstance()->getConnection();
        $stm = $db->prepare("SELECT *FROM courses WHERE teacher_id = :teacher_id");
        $stm->bindParam(':teacher_id', $teacherId);
        $stm->execute();
        $allCourses = $stm->fetchall(PDO::FETCH_ASSOC);
        return $allCourses;
    }
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM courses");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM courses WHERE id_course = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public static function getTotalCourses() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM courses");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public static function getCoursesByCategory() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT categories.nom, COUNT(courses.id_course) as total 
                              FROM courses 
                              JOIN categories ON courses.categorie_id = categories.id 
                              GROUP BY categories.nom");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCourseWithMostStudents() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT courses.title, COUNT(enrollenment.id_user) as students 
                              FROM enrollenment 
                              JOIN courses ON enrollenment.id_course = courses.id_course 
                              GROUP BY courses.title 
                              ORDER BY students DESC 
                              LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function getCourseByStudent($userId){
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT courses.id_course, courses.title, courses.description, courses.image, users.nom AS teacher_firstname, users.prenom AS teacher_name, categories.nom AS category_name 
                                  FROM enrollenment 
                                  JOIN courses ON enrollenment.id_course = courses.id_course 
                                  JOIN users ON courses.teacher_id = users.id 
                                  JOIN categories ON courses.categorie_id = categories.id 
                                  WHERE enrollenment.id_user = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
    public static function getCourseDetail($courseId) {
        try {
            $db = Database::getInstance()->getConnection();

            $stmt = $db->prepare("SELECT courses.id_course, courses.title, courses.description, courses.image, courses.content, courses.video, 
                                         users.nom AS teacher_firstname, users.prenom AS teacher_name, categories.nom AS category_name 
                                  FROM courses 
                                  JOIN users ON courses.teacher_id = users.id 
                                  JOIN categories ON courses.categorie_id = categories.id 
                                  WHERE courses.id_course = :course_id");
            $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
            $stmt->execute();
            $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$course) {
                return null;  
            }
    
   
            $stmt = $db->prepare("SELECT COUNT(*) AS enrollment_count FROM enrollenment WHERE id_course = :course_id");
            $stmt->bindParam(':course_id', $courseId, PDO::PARAM_INT);
            $stmt->execute();
            $enrollment = $stmt->fetch(PDO::FETCH_ASSOC);

            $course['enrollment_count'] = $enrollment['enrollment_count'];
            
            return $course;
    
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


class DocumentImageCourse extends Course {
    private $document;
    private $image;
    private $categoryId;

    public function __construct($title, $description, $document, $image, $teacherId , $categoryId) {
        parent::__construct($title, $description, $teacherId);
        $this->document = $document;
        $this->image = $image;
        $this->categoryId = $categoryId;
    }

    public function addCourse() {
        $stmt = $this->db->prepare("INSERT INTO courses (title, description, content, image, teacher_id, categorie_id) VALUES (:title, :description, :document, :image, :teacher_id, :category_id)");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':document', $this->document);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':teacher_id', $this->teacherId);
        $stmt->bindParam(':category_id', $this->categoryId);
        $stmt->execute();
        echo "Course added with document and image.\n";
    }
    public function showCourse() {
        echo "Title: {$this->title}\n";
        echo "Description: {$this->description}\n";
        echo "Document: {$this->document}\n";
        echo "Image: {$this->image}\n";
    }

    public function modifierCour($newTitle = null, $newDescription = null, $newContent = null, $newImage = null, $newVideo = null) {
        parent::modifierCour($newTitle, $newDescription, $newContent, $newImage, $newVideo);
        if ($newContent !== null || $newImage !== null) {
            $courseId = $this->getCourseId();
            if ($courseId) {
                $stmt = $this->db->prepare("UPDATE courses SET content = :newContent, image = :newImage WHERE id_course = :id_course");
                $stmt->bindParam(':newContent', $newContent);
                $stmt->bindParam(':newImage', $newImage);
                $stmt->bindParam(':id_course', $courseId);
                $stmt->execute();
                $this->document = $newContent;
                $this->image = $newImage;
                echo "modifierCour: Course details updated with new document and image.\n";
            } else {
                echo "modifierCour: Course not found.\n";
            }
        }
    }
    
}

class VideoCourse extends Course {
    private $video;
    private $categoryId;
    public function __construct($title, $description, $video, $teacherId, $categoryId) {
        parent::__construct($title, $description, $teacherId);
        $this->video = $video;
        $this->categoryId = $categoryId;
    }

    public function addCourse() {
        $stmt = $this->db->prepare("INSERT INTO courses (title, description, video, teacher_id, categorie_id) VALUES (:title, :description, :video, :teacher_id, :category_id)");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':video', $this->video);
        $stmt->bindParam(':teacher_id', $this->teacherId);
        $stmt->bindParam(':category_id', $this->categoryId);
        $stmt->execute();
        echo "Course added with video.\n";
    }

    public function showCourse() {
        echo "Title: {$this->title}\n";
        echo "Description: {$this->description}\n";
        echo "Video: {$this->video}\n";
    }

    public function modifierCour($newTitle = null, $newDescription = null, $newContent = null, $newImage = null, $newVideo = null) {
        parent::modifierCour($newTitle, $newDescription, $newContent, $newImage, $newVideo);
        if ($newVideo !== null) {
            $courseId = $this->getCourseId();
            if ($courseId) {
                $stmt = $this->db->prepare("UPDATE courses SET video = :newVideo WHERE id_course = :id_course");
                $stmt->bindParam(':newVideo', $newVideo);
                $stmt->bindParam(':id_course', $courseId);
                $stmt->execute();
                $this->video = $newVideo;
                echo "modifierCour: Course details updated with new video.\n";
            } else {
                echo "modifierCour: Course not found.\n";
            }
        }
    }
}
?>