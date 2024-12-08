<?php
require_once '../component/header.php';?>

<main class="main-content">
    <form action="../function/sign-up-action.php" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Create an Account</h1>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <label for="avatar">Avatar (Optional):</label>
        <input type="file" id="avatar" name="avatar" accept="image/*">
        <button type="submit" name="submit">Sign Up</button>
    </form>
</main>

<?php include '../component/footer.php';?>