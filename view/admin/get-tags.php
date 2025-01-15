<?php
require "../../model/tag.php";


$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;


$tags = new Tags([]);
$allTags = $tags->getAllTags($offset, $itemsPerPage);
$totalTags = $tags->getTagsCount();
$totalPages = ceil($totalTags / $itemsPerPage);

?>

<div>
    <ul>
        <?php foreach ($allTags as $tag): ?>
            <li><?php echo htmlspecialchars($tag['tag_name']); ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="pagination mt-4">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <button class="px-2 py-1 border" onclick="loadTags(<?php echo $i; ?>)"><?php echo $i; ?></button>
        <?php endfor; ?>
    </div>
</div>