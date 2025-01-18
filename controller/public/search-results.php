<?php
require_once "../../model/search.php";

$searchTerm = $_POST['search'] ?? '';
$results = Search::searchCourses($searchTerm);

if (empty($results)): ?>




<div class="no-results">
    <p>No courses found. Try a different search term.</p>
</div>

<?php else: ?>
<?php foreach ($results as $course): ?>
<article class="course-card">
    <?php if (!empty($course['image'])): ?>
    <div class="course-image">
        <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>"
            loading="lazy">
    </div>
    <?php endif; ?>

    
    <div class="course-content">
        <h3><?php echo htmlspecialchars($course['title']); ?></h3>

        <p class="teacher">
            <span class="label">Teacher:</span>
            <?php echo htmlspecialchars($course['teacher_firstname'] . ' ' . $course['teacher_name']); ?>
        </p>

        <?php if (!empty($course['category_name'])): ?>
        <p class="category">
            <span class="label">Category:</span>
            <?php echo htmlspecialchars($course['category_name']); ?>
        </p>
        <?php endif; ?>

        <?php if (!empty($course['tags'])): ?>
        <div class="tags">
            <?php foreach (explode(',', $course['tags']) as $tag): ?>
            <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <p class="description">
            <?php echo htmlspecialchars($course['description']); ?>
        </p>
        <form action="../../controller/student/enroll.php" method="POST">
            <input type="hidden" name="id_course" value="<?php echo htmlspecialchars($course['id_course']); ?>">
            <button type="submit" class="enroll-button bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">Enroll</button>
        </form>
        <form action="../../view/etudiant/course_details.php" method="GET">
            <input type="hidden" name="id_course" value="<?php echo htmlspecialchars($course['id_course']); ?>">
            <button type="submit" class="enroll-button bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700">Preview Course  </button>
        </form>

        <?php if (!empty($course['video'])): ?>
        <div class="course-preview">
            <a href="#" class="preview-link" data-video="<?php echo htmlspecialchars($course['video']); ?>">
                Watch Preview
            </a>
        </div>
        <?php endif; ?>
    </div>
    </div>
</article>
<?php endforeach; ?>
<?php endif; ?>