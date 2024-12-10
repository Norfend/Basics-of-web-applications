<?php
declare(strict_types=1);

namespace function;
include "../configuration/database_connection.php";
use \configuration\database_connection;
use PDOException;

require_once '../configuration/database_connection.php';
require_once '../function/validator.php';

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
                setcookie('username', json_encode($cookieData), time() + (24 * 60 * 60 * 1000), "/");
                echo 'HELLO';
            }
            else echo 'Login or/and password are incorrect';
        }
        else echo 'Login or/and password are incorrect';
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}