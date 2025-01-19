<?php 
session_start();
require '../../model/tag.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['tag_id']) && is_numeric($_POST['tag_id'])) {
        $tag_id = filter_var($_POST['tag_id'], FILTER_SANITIZE_NUMBER_INT);
        
       

        if(Tags::deleteTag($tag_id)) {
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