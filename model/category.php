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

    public function getCategoriesCount() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) as count FROM categories");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>