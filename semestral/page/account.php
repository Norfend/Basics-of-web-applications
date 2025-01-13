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
$isSuperUser = accountRepository::checkUserPrivileges($username);
$user_id = accountRepository::getUserIdByUsername($username);
if ($isSuperUser) {
    $accounts = accountRepository::getAllUsers();
    $recipes = recipeRepository::getAllRecipes();
}
else {
    $recipes = recipeRepository::getRecipesByAuthor(accountRepository::getUserIdByUsername($username));
}
require_once __DIR__ . '/../component/header.php';?>

<main class="main-content">
    <section class="account-top">
        <div class="account-image">
            <img src="<?= htmlspecialchars($user->getAvatar()) ?>" alt="User Avatar">
        </div>
        <div class="account-info">
            <h1 class="account-user-name" id="username"><?= htmlspecialchars($user->getUsername()) ?></h1>
            <p>First Name: <?= htmlspecialchars($user->getFirstName()) ?></p>
            <p>Last Name: <?= htmlspecialchars($user->getLastName()) ?></p>
            <p>E-mail: <?= htmlspecialchars($user->getEmail()) ?></p>
            <a href="<?= htmlspecialchars('page/account-edit.php?id=' . $user_id) ?>" class="account-edit-button">Edit Account</a>
        </div>
    </section>

    <?php if ($isSuperUser): ?>
        <section class="account-toggle">
            <button id="show-recipes">Show Recipe List</button>
            <button id="show-accounts">Show Account List</button>
        </section>
    <?php endif; ?>

    <section class="account-recipes" id="recipes-section">
        <h2>Recipes</h2>
        <?php if (!empty($recipes)): ?>
            <ul class="account-recipe-list">
                <?php foreach ($recipes as $recipe): ?>
                    <li class="account-recipe-item" data-id="<?= $recipe['recipe_id'] ?>">
                        <a href="page/recipe-view.php?id=<?=$recipe['recipe_id']?>" class="account-recipe-link">
                            <h3><?= htmlspecialchars($recipe['recipe_name']) ?></h3>
                        </a>
                        <div class="account-recipe-actions">
                            <a href="javascript:void(0);" class="recipe-edit-button" data-id="<?=$recipe['recipe_id']?>">Edit</a>
                            <a href="javascript:void(0);" class="recipe-delete-button" data-id="<?=$recipe['recipe_id']?>">Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>You haven't created any recipes yet. <a href="page/recipe.php">Create one now!</a></p>
        <?php endif; ?>
    </section>

    <?php if ($isSuperUser): ?>
        <section class="account-recipes" id="accounts-section" style="display: none;">
            <h2>Accounts</h2>
            <?php if (!empty($accounts)): ?>
                <ul class="account-recipe-list">
                    <?php foreach ($accounts as $account): ?>
                        <li class="account-recipe-item" data-id="<?= $account['user_id'] ?>">
                            <h3><?= htmlspecialchars($account['username']) ?></h3>
                            <div class="account-recipe-actions">
                                <a href="javascript:void(0);" class="account-edit-button" data-id="<?= $account['user_id'] ?>">Edit</a>
                                <a href="javascript:void(0);" class="account-delete-button" data-id="<?= $account['user_id'] ?>">Delete</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No accounts found.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</main>
<script type="module" src="script/account-action.js"></script>

<?php require_once __DIR__ . '/../component/footer.php';?>