<?php
declare(strict_types=1);

namespace function;
include "../configuration/database_connection.php";
use \configuration\database_connection;
use entities\accountDTO;
use PDOException;

require_once '../configuration/database_connection.php';
require_once '../function/validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connection = database_connection::getInstance()->getConnection();

    $username = htmlspecialchars(stripslashes(trim($_GET['username'])));
    $password = htmlspecialchars(stripslashes(trim($_GET['password'])));

    $stmt = $connection->prepare('SELECT * FROM user WHERE username = ?');
    try {
        $stmt->execute([$username]);
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch();
            $storedPassword = $user['password']->getPassword();
            if (password_verify($password, $storedPassword)) {
                setcookie('username', $user['username'], time() + (24 * 60 * 60 * 1000), "/");
                echo 'HELLO';
            }
            else echo 'NOPE';
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}