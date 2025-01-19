<?php 
require '../../model/category.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $category_id = htmlspecialchars($_POST['category_id']);
    Category::deleteCategory($category_id);
    header('location: ../../view/admin/tags_category.php');
}

?>