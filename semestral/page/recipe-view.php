<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/repository/recipeRepository.php';
use \repository\recipeRepository;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /page/not-found.php');
    exit();
}

$recipeId = (int)$_GET['id'];

$recipe = recipeRepository::getRecipeById($recipeId);

require_once $_SERVER['DOCUMENT_ROOT'] . '/component/header.php';
?>

<main class="main-content">
    <section class="recipe-view">
        <div class="recipe-image">
            <img src="<?= htmlspecialchars($recipe->getImage()) ?>" alt="<?= htmlspecialchars($recipe->getRecipeName()) ?>">
        </div>
        <div class="recipe-details">
            <h1><?= htmlspecialchars($recipe->getRecipeName()) ?></h1>
            <p>Description: <?= nl2br(htmlspecialchars($recipe->getDescription())) ?></p>
            <p><strong>Ingredients: </strong></p>
            <p><?= htmlspecialchars($recipe->getIngredients()) ?></p>
            <p><strong>How to Prepare:</strong></p>
            <p><?= nl2br(htmlspecialchars($recipe->getHowto())) ?></p>
        </div>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/component/footer.php'; ?>