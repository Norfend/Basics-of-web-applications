<?php
declare(strict_types=1);

namespace function;
require_once '../configuration/database_connection.php';
require_once '../function/validator.php';
require_once '../function/cookie.php';
require_once '../repository/accountRepository.php';
use \configuration\database_connection;
use \repository\accountRepository;
use PDOException;
use RuntimeException;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = validator::getInstance();
    $connection = database_connection::getInstance()->getConnection();

    $recipe = $validator->validateRecipePost($_POST['recipe-name'], $_POST['description'], $_POST['howto'],
        $_POST['ingredients'], $_FILES['image']);

    if ($recipe === null) {
        $errors = $validator->getErrors();
    }
    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO recipe (recipe_name, description, howto, ingredients, image, author) VALUES (?, ?, ?, ?, ?, ?)");
        try {
            $cookieData = json_decode($_COOKIE['username'], true);
            $username = accountRepository::getAccountByUsername($cookieData['user']);
            if ($username === -1) {
                throw new RuntimeException("Your username is not valid! Log in again");
            }
            $stmt->execute([$recipe->getRecipeName(), $recipe->getDescription(), $recipe->getHowto(),
                $recipe->getIngredients(), $recipe->getImage(), $username]);
            echo 'Success';
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "\n";
        }
    }
}
