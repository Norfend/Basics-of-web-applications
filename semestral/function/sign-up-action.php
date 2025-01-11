<?php
declare(strict_types=1);

namespace function;

require_once __DIR__ . '/../configuration/database_connection.php';
require_once __DIR__ . '/validator.php';
require_once __DIR__ . '/cookie.php';
require_once __DIR__ . '/../repository/accountRepository.php';

use \configuration\database_connection;
use PDOException;
use repository\accountRepository;

/**
 * Handles POST and PUT HTTP requests for user account management.
 *
 * This script handles user registration and account updates. In POST requests, it validates the user input for
 * registration and inserts the account details into the database. In PUT requests, it updates the account details
 * based on the provided input data.
 *
 * @package function
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = validator::getInstance();
    $connection = database_connection::getInstance()->getConnection();

    $account = $validator->validateAccountPost(
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['username'],
        $_POST['email'],
        $_POST['password'],
        $_POST['confirm_password'],
        $_FILES['avatar']
    );

    if ($account === null) {
        $errors = $validator->getErrors();
    }

    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO user (first_name, last_name, username, email, password, avatar) VALUES (?, ?, ?, ?, ?, ?)");
        try {
            $stmt->execute([
                $account->getFirstName(),
                $account->getLastName(),
                $account->getUsername(),
                $account->getEmail(),
                $account->getPassword(),
                $account->getAvatar()
            ]);
            $cookieData = [
                'user' => $account->getUsername(),
                'avatar' => $account->getAvatar()
            ];
            cookie::set('username', $cookieData, 1);
            echo 'Success';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "\n";
        }
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);
    accountRepository::updateAccount($input);
    echo 'Success';
}