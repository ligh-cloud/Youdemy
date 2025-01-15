<?php
require "database.php";

class Tags {
    private $tags;

    public function __construct($tags) {
        $this->tags = $tags;
    }

    public function addTags() {
        $db = Database::getInstance()->getConnection();

        foreach ($this->tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag)) {
                $stmt = $db->prepare("INSERT IGNORE INTO tags (tag_name) VALUES (:name)");
                $stmt->bindParam(':name', $tag);
                $stmt->execute();
            }
        }
    }

    public function getAllTags($offset, $limit) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM tags LIMIT :offset, :limit");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTagsCount() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT COUNT(*) as count FROM tags");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>