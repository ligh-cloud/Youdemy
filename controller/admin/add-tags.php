
<?php
require "../../model/Tag.php";
require "../../model/category.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tags'])) {
    $tags = $_POST['tags'];
    $tagsArray = array_unique(array_map('trim', explode(",", $tags)));
    $tag = new Tags($tagsArray);

    $tag->addTags();

    echo "<div class='p-4 bg-green-200 text-green-800 rounded-md'>Tags added successfully!</div>";
}





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category'])) {
    $categoryName = trim(htmlspecialchars($_POST['category']));
    $description = trim(htmlspecialchars($_POST['description']));

    $category = new Category($categoryName ,$description);
    $category->addCategory();

    echo "<div class='p-4 bg-green-200 text-green-800 rounded-md'>Category added successfully!</div>";
}
?>