<?php
require "../../model/category.php";


$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$category = new Category('', '');
$allCategories = $category->getAllCategories($offset, $itemsPerPage);
$totalCategories = $category->getCategoriesCount();
$totalPages = ceil($totalCategories / $itemsPerPage);

?>

<div>
    <ul>
        <?php foreach ($allCategories as $cat): ?>
            <li><?php echo htmlspecialchars($cat['nom']); ?> - <?php echo htmlspecialchars($cat['description']); ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="pagination mt-4">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <button class="px-2 py-1 border" onclick="loadCategories(<?php echo $i; ?>)"><?php echo $i; ?></button>
        <?php endfor; ?>
    </div>
</div>