<?php
require_once 'component/header.php';

$recipesJson = include 'configuration/recipes.php';
$recipes = json_decode($recipesJson, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Failed to decode recipes JSON: " . json_last_error_msg());
}
?>

<main class="main-content">
    <section id="recipes-section" class="recipes">
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <div class="recipe-image">
                    <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['name']) ?>">
                </div>
                <div class="recipe-details">
                    <h2><?= htmlspecialchars($recipe['name']) ?></h2>
                    <p><?= htmlspecialchars($recipe['description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php
require_once 'component/footer.php';
?>