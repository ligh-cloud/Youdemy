<?php
require "database.php";

class Category {
    private $category;
    private $description;

    public function __construct($category, $description) {
        $this->category = $category;
        $this->description = $description;
    }

    public function addCategory() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO categories (nom, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $this->category);
        $stmt->bindParam(':description', $this->description);
        $stmt->execute();
    }

    public function getAllCategories($offset, $limit) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM categories LIMIT :offset, :limit");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getAll(){
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM categories");
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoriesCount() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) as count FROM categories");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
    public static function deleteCategory($categoryId) {
        try {
            $db = Database::getInstance()->getConnection();
            
            $db->beginTransaction();
            

            $checkStmt = $db->prepare("SELECT * FROM categories WHERE id = :id");
            $checkStmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
            $checkStmt->execute();


            $stmt = $db->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
            $result = $stmt->execute();

            $db->commit();
            
            return $result;
        } catch (PDOException $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Error deleting category: " . $e->getMessage());
            return false;
        }
    }
}
?>