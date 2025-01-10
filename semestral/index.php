<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/repository/recipeRepository.php';
use \repository\recipeRepository;

$pageNumber = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$pageSize = 3;
$offset = ($pageNumber - 1) * $pageSize;

$recipes = recipeRepository::getRecipePage($pageSize, $offset);

$totalRecipes = count(recipeRepository::getAllRecipes());
$totalPages = (int)ceil($totalRecipes / $pageSize);
?>

<main class="main-content">
    <section id="recipes-section" class="recipes">
        <?php foreach ($recipes as $recipe): ?>
            <a href="/page/recipe-view.php?id=<?= $recipe['recipe_id'] ?>" class="recipe-card-link">
                <div class="recipe-card">
                    <div class="recipe-image">
                        <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['recipe_name']) ?>">
                    </div>
                    <div class="recipe-details">
                        <h2><?= htmlspecialchars($recipe['recipe_name']) ?></h2>
                        <p><?= htmlspecialchars($recipe['description']) ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </section>
</main>

<?php
echo '<div class="pagination">';

if ($pageNumber > 1) {
    echo '<a href="?page=' . ($pageNumber - 1) . '">&laquo;</a>';
} else {
    echo '<span class="disabled">&laquo;</span>';
}

for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $pageNumber) {
        echo '<span class="active">' . $i . '</span>';
    } else {
        echo '<a href="?page=' . $i . '">' . $i . '</a>';
    }
}

if ($pageNumber < $totalPages) {
    echo '<a href="?page=' . ($pageNumber + 1) . '">&raquo;</a>';
} else {
    echo '<span class="disabled">&raquo;</span>';
}

echo '</div>';
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/footer.php';
?>
