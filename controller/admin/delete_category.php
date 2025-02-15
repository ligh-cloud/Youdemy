<?php 
session_start();
require '../../model/category.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['category_id']) && is_numeric($_POST['category_id'])) {
        $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
        
       

        if(Category::deleteCategory($category_id)) {
            $_SESSION['success'] = "Category deleted successfully";
        } else {
            $_SESSION['error'] = "Failed to delete category";
        }
    } else {
        $_SESSION['error'] = "Invalid category ID";
    }
    
    header('location: ../../view/admin/tags_category.php');
    exit();
}

header('location: ../../view/admin/tags_category.php');
exit();
?>