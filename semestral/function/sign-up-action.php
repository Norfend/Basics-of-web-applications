<?php
declare(strict_types=1);

namespace function;
include "../configuration/DatabaseConnection.php";
use \configuration\DatabaseConnection;

require_once '../configuration/DatabaseConnection.php';
require_once '../function/Validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = Validator::getInstance();
    $connection = DatabaseConnection::getInstance()->getConnection();

    $account = $validator->validateAccountPost($_POST['first_name'], $_POST['last_name'], $_POST['username'],
        $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_FILES['avatar']);

    if ($account === null) {
        $errors = $validator->getErrors();
    }
    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, username, email, password, avatar) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$account->getFirstName(), $account->getLastName(), $account->getUsername(), $account->getEmail(),
            $account->getPassword(), $account->getAvatar()])) {
            echo "Account successfully created!";
        } else {
            echo "Failed to create account. Please try again.";
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
