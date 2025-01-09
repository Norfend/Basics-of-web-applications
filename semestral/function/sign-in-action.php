<?php
declare(strict_types=1);

namespace function;
require_once $_SERVER['DOCUMENT_ROOT'] . '/configuration/database_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/function/validator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/function/cookie.php';
use \configuration\database_connection;
use PDOException;

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
            }
            else echo 'Login or/and password are incorrect';
        }
        else echo 'Login or/and password are incorrect';
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}