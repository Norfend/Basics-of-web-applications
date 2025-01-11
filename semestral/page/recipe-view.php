<?php
require_once __DIR__ . '/../repository/recipeRepository.php';
use \repository\recipeRepository;

$recipeId = (int)$_GET['id'];

$recipe = recipeRepository::getRecipeById($recipeId);

require_once __DIR__ . '/../component/header.php';
?>

<main class="main-content">
    <section id="recipe-details" class="recipe-view">
        <div class="recipe-image">
            <img src="<?= htmlspecialchars($recipe->getImage()) ?>" alt="<?= htmlspecialchars($recipe->getRecipeName()) ?>">
        </div>
        <div class="recipe-details">
            <h1><?= htmlspecialchars($recipe->getRecipeName()) ?></h1>
            <p><?= nl2br(htmlspecialchars($recipe->getDescription())) ?></p>
            <p><strong>Ingredients: </strong></p>
            <p><?= htmlspecialchars($recipe->getIngredients()) ?></p>
            <p><strong>How to Prepare:</strong></p>
            <p><?= nl2br(htmlspecialchars($recipe->getHowto())) ?></p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../component/footer.php'; ?>