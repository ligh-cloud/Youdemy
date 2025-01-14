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

    public function modifierCour($newTitle = null, $newDescription = null, $newContent = null, $newMedia = null) {
        $courseId = $this->getCourseId();
        if ($courseId) {
            $stmt = $this->db->prepare("UPDATE courses SET title = :newTitle, description = :newDescription, content = :newContent, image = :newMedia, video = :newMedia WHERE id_course = :id_course");
            $stmt->bindParam(':newTitle', $newTitle);
            $stmt->bindParam(':newDescription', $newDescription);
            $stmt->bindParam(':newContent', $newContent);
            $stmt->bindParam(':newMedia', $newMedia);
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
}

class DocumentImageCourse extends Course {
    private $document;
    private $image;

    public function __construct($title, $description, $document, $image, $teacherId) {
        parent::__construct($title, $description, $teacherId);
        $this->document = $document;
        $this->image = $image;
    }

    public function addCourse() {
        $stmt = $this->db->prepare("INSERT INTO courses (title, description, content, image, teacher_id) VALUES (:title, :description, :document, :image, :teacher_id)");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':document', $this->document);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':teacher_id', $this->teacherId);
        $stmt->execute();
        echo "Course added with document and image.\n";
    }

    public function showCourse() {
        echo "Title: {$this->title}\n";
        echo "Description: {$this->description}\n";
        echo "Document: {$this->document}\n";
        echo "Image: {$this->image}\n";
    }

    public function modifierCour($newTitle = null, $newDescription = null, $newDocument = null, $newImage = null) {
        parent::modifierCour($newTitle, $newDescription, $newDocument, $newImage);
        if ($newDocument !== null || $newImage !== null) {
            $courseId = $this->getCourseId();
            if ($courseId) {
                $stmt = $this->db->prepare("UPDATE courses SET content = :newDocument, image = :newImage WHERE id_course = :id_course");
                $stmt->bindParam(':newDocument', $newDocument);
                $stmt->bindParam(':newImage', $newImage);
                $stmt->bindParam(':id_course', $courseId);
                $stmt->execute();
                $this->document = $newDocument;
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

    public function __construct($title, $description, $video, $teacherId) {
        parent::__construct($title, $description, $teacherId);
        $this->video = $video;
    }

    public function addCourse() {
        $stmt = $this->db->prepare("INSERT INTO courses (title, description, video, teacher_id) VALUES (:title, :description, :video, :teacher_id)");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':video', $this->video);
        $stmt->bindParam(':teacher_id', $this->teacherId);
        $stmt->execute();
        echo "Course added with video.\n";
    }

    public function showCourse() {
        echo "Title: {$this->title}\n";
        echo "Description: {$this->description}\n";
        echo "Video: {$this->video}\n";
    }

    public function modifierCour($newTitle = null, $newDescription = null, $newContent = null, $newVideo = null) {
        parent::modifierCour($newTitle, $newDescription, $newContent, $newVideo);
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