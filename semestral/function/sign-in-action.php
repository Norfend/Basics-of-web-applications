<?php
declare(strict_types=1);

namespace function;

require_once __DIR__ . '/../configuration/database_connection.php';
require_once __DIR__ . '/validator.php';
require_once __DIR__ . '/cookie.php';

use \configuration\database_connection;
use PDOException;

/**
 * Handles POST HTTP requests for user login authentication.
 *
 * This script processes user login requests by validating the provided username and password.
 * If the credentials are correct, it sets a cookie with the user's username and avatar.
 * In case of invalid credentials or errors, appropriate messages are displayed.
 *
 * @package function
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connection = database_connection::getInstance()->getConnection();

    $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
    $password = htmlspecialchars(stripslashes(trim($_POST['password'])));

    $stmt = $connection->prepare('SELECT * FROM user WHERE username = ?');
    try {
        $stmt->execute([$username]);
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch();
            $storedPassword = $user['password'];
            if (password_verify($password, $storedPassword)) {
                $cookieData = [
                    'user' => $user['username'],
                    'avatar' => $user['avatar']
                ];
                cookie::set('username', $cookieData, 1);
                echo 'Success';
            } else {
                echo 'Login or/and password are incorrect';
            }
        } else {
            echo 'Login or/and password are incorrect';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}