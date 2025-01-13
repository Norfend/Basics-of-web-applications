<?php

use repository\accountRepository;

require_once __DIR__ . '/../component/header.php';
require_once __DIR__ . '/../repository/accountRepository.php';

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $user = accountRepository::getAccountById($userId);
}
else $user = null;
?>

<main class="main-content">
    <form id="signup-form" action="" method="POST" enctype="multipart/form-data" class="signup-form">
        <h1>Update Account</h1>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user ? $user->getFirstName() ?? '' : '')?>" autocomplete="no">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user ? $user->getLastName() ?? '' : '')?>" autocomplete="no">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user ? $user->getUsername() ?? '' : '')?>" autocomplete="no" disabled>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user ? $user->getEmail() ?? '' : '')?>" autocomplete="no">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" autocomplete="no">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" autocomplete="no">
        <button type="submit" id="submit-edit" name="submit">Update Account</button>
        <span id="error"></span>
    </form>
</main>

<script type="module" src="script/account-edit-action.js"></script>
<?php require_once __DIR__ . '/../component/footer.php'; ?>