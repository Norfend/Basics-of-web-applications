<?php
require_once '../component/header.php';?>

<main class="main-content">
    <form id="sign-in-form" action="../function/sign-in-action.php" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Login into your account</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="submit">Sign In</button>
    </form>
</main>
    <script src="../script/sign-in-action.js"></script>

<?php include '../component/footer.php';?>