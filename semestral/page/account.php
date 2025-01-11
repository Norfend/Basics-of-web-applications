<?php
require_once __DIR__ . '/../repository/accountRepository.php';
require_once __DIR__ . '/../repository/recipeRepository.php';
use \repository\accountRepository;
use \repository\recipeRepository;

$cookieData = null;
$username = null;
if (isset($_COOKIE['username'])) {
    $cookieData = json_decode($_COOKIE['username'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $username = htmlspecialchars($cookieData['user']);
    }
}

$user = accountRepository::getAccountByUsername($username);
$recipes = recipeRepository::getRecipesByAuthor(accountRepository::getUserIdByUsername($username));
require_once __DIR__ . '/../component/header.php';?>

<main class="main-content">
    <section class="account-top">
        <div class="account-image">
            <img src="<?= htmlspecialchars($user->getAvatar()) ?>" alt="User Avatar">
        </div>
        <div class="account-info">
            <h1 class="account-user-name"><?= htmlspecialchars($user->getUsername()) ?></h1>
            <p>First Name: <?= htmlspecialchars($user->getFirstName()) ?></p>
            <p>Last Name: <?= htmlspecialchars($user->getLastName()) ?></p>
            <p>E-mail: <?= htmlspecialchars($user->getEmail()) ?></p>
            <a href="page/sign-up.php" class="account-edit-button">Edit Account</a>
        </div>
    </section>
    <section class="account-recipes">
        <h2>Your Recipes</h2>
        <?php if (!empty($recipes)): ?>
            <ul class="account-recipe-list">
                <?php foreach ($recipes as $recipe): ?>
                    <li class="account-recipe-item">
                        <a href="page/recipe-view.php?id=<?= $recipe['recipe_id'] ?>" class="account-recipe-link">
                            <h3><?= htmlspecialchars($recipe['recipe_name']) ?></h3>
                        </a>
                        <div class="account-recipe-actions">
                            <a href="page/recipe-view.php?id=<?= $recipe['recipe_id'] ?>" class="account-edit-button">Edit</a>
                            <form action="function/delete-recipe.php" method="POST" class="account-delete-form">
                                <input type="hidden" name="recipe_id" value="<?= $recipe['recipe_id'] ?>">
                                <button type="submit" class="account-delete-button">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You haven't created any recipes yet. <a href="page/recipe.php">Create one now!</a></p>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/../component/footer.php';?>