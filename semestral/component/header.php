<?php
$cookieData = null;
$username = null;
$avatar = null;
if (isset($_COOKIE['username'])) {
    $cookieData = json_decode($_COOKIE['username'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $username = htmlspecialchars($cookieData['user']);
        $avatar = htmlspecialchars($cookieData['avatar']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooking Recipes</title>
    <link rel="stylesheet" href="/style/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
<header class="header">
    <div class="header-container">
        <div class="logo">
            <div class="logo-left">
                <?php if ($avatar): ?>
                    <img src="<?= $avatar ?>" alt="User Avatar" class="user-avatar">
                <?php else: ?>
                    <img src="../upload/default-logo.png" alt="Site Logo" class="site-logo">
                <?php endif; ?>
            </div>
            <div class="logo-right">
                <?php if ($username): ?>
                    Welcome back, <?= $username ?>!
                    <div class="user-nav">
                        <a href="../page/account.php">Account</a>
                        <a href="../function/logout.php">Logout</a>
                    </div>
                <?php else: ?>
                    Welcome to my cooking site!
                    <div class="user-nav">
                        <a href="../page/sign-up.php">Sign Up</a>
                        <a href="../page/sign-in.php">Sign In</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <nav class="nav" aria-label="Main navigation">
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../page/recipe.php">Create Recipes</a></li>
                <li><a href="../page/sign-in.php">Find Recipes</a></li>
            </ul>
        </nav>
    </div>
</header>
