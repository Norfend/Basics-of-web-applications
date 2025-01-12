<?php

use repository\recipeRepository;

require_once __DIR__ . '/../component/header.php';
require_once __DIR__ . '/../repository/recipeRepository.php';

$recipeId = (int)$_GET['id'];
$recipe = recipeRepository::getRecipeById($recipeId);
$isUpdate = false;

$cookieData = null;
$username = null;
$isUpdate = isset($_GET['edit']) && $_GET['edit'] === 'true';
?>

<main class="main-content">
    <form id="recipe-form" action="" method="POST" enctype="multipart/form-data" class="recipe-view">
        <?php if ($isUpdate): ?>
            <h1>Edit Recipe</h1>
            <label for="recipe-name">Recipe Name:</label>
            <input type="text" id="recipe-name" name="recipe-name" value="<?= htmlspecialchars($recipe->getRecipeName()) ?>" autocomplete="no">
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= htmlspecialchars($recipe->getDescription()) ?></textarea>
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients"><?= htmlspecialchars($recipe->getIngredients()) ?></textarea>
            <label for="howto">How to Prepare:</label>
            <textarea id="howto" name="howto"><?= htmlspecialchars($recipe->getHowto()) ?></textarea>
            <button type="submit" id="submit-edit" name="submit">Update Recipe</button>
        <?php else: ?>
            <h1>View Recipe</h1>
            <div class="recipe-image">
                <img src="<?= htmlspecialchars($recipe->getImage()) ?>" alt="<?= htmlspecialchars($recipe->getRecipeName()) ?>">
            </div>
            <div class="recipe-details">
                <h2><?= htmlspecialchars($recipe->getRecipeName()) ?></h2>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($recipe->getDescription())) ?></p>
                <p><strong>Ingredients:</strong> <?= htmlspecialchars($recipe->getIngredients()) ?></p>
                <p><strong>How to Prepare:</strong> <?= nl2br(htmlspecialchars($recipe->getHowto())) ?></p>
            </div>
        <?php endif; ?>
        <span id="error"></span>
    </form>
</main>

<script type="module" src="script/recipe-action.js"></script>
<?php require_once __DIR__ . '/../component/footer.php'; ?>