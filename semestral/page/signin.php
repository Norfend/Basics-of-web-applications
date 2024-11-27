<?php
require_once '../component/header.php';?>

<main class="main-content">
    <form action="signup.php" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Login into your account</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" name="submit">Sign Up</button>
    </form>
</main>

<?php include '../component/footer.php';?>