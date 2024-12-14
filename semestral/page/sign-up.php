<?php
require_once '../component/header.php';?>

<main class="main-content">
    <form id="signup-form" action="" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Create an Account</h1>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" autocomplete="no">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" autocomplete="no">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" autocomplete="no">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" autocomplete="no">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="no">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" autocomplete="no">
        <label for="avatar">Avatar (Optional):</label>
        <input type="file" id="avatar" name="avatar" accept="image/*" autocomplete="no">
        <button type="submit" id="submit" name="submit">Sign Up</button>
        <span id="error"></span>
    </form>
</main>
<script type="module" src="../script/sign-up-action.js"></script>

<?php include '../component/footer.php';?>