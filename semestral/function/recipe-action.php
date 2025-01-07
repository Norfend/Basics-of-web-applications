<?php
declare(strict_types=1);

namespace function;
require_once '../configuration/database_connection.php';
require_once '../function/validator.php';
require_once '../function/cookie.php';
use \configuration\database_connection;
use PDOException;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = validator::getInstance();
    $connection = database_connection::getInstance()->getConnection();

    $recipe = $validator->validateRecipePost($_POST['recipe-name'], $_POST['description'], $_POST['howto'],
        $_POST['ingredients'], $_POST['image']);

    if ($recipe === null) {
        $errors = $validator->getErrors();
    }
    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO recipe (recipe_name, description, howto, ingredients, image, author) VALUES (?, ?, ?, ?, ?, ?)");
        /*try {
            $stmt->execute([$account->getFirstName(), $account->getLastName(), $account->getUsername(),
                $account->getEmail(), $account->getPassword(), $account->getAvatar()]);
            $cookieData = [
                'username' => $account['username'],
                'avatar' => $account['avatar']
            ];
            cookie::set('username', $cookieData, 1);
            echo 'Success';
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }*/
    } else {
        foreach ($errors as $error) {
            echo $error . "\n";
        }
    }
}
