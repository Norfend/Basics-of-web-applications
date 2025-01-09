<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/component/header.php';?>

<main class="main-content">
    <form id="sign-in-form" action="../function/sign-in-action.php" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Login into your account</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" autocomplete="on">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="on">
        <button type="submit" name="submit">Sign In</button>
        <span id="error"></span>
    </form>
</main>
<script type="module" src="../script/sign-in-action.js"></script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/component/footer.php';?>