<?php
declare(strict_types=1);

namespace function;

require_once __DIR__ . '/../configuration/database_connection.php';
require_once __DIR__ . '/validator.php';
require_once __DIR__ . '/cookie.php';
require_once __DIR__ . '/../repository/accountRepository.php';
require_once __DIR__ . '/../repository/recipeRepository.php';

use \configuration\database_connection;
use \repository\accountRepository;
use PDOException;
use repository\recipeRepository;
use RuntimeException;

/**
 * Handles POST and DELETE HTTP requests for managing recipes.
 *
 * This script processes requests for creating and deleting recipes.
 * It validates input data and interacts with the database to insert or remove recipes.
 * In POST requests, it validates the recipe data and saves it to the database. In DELETE requests, it checks user privileges
 * and deletes a specified recipe if the user is authorized.
 *
 * @package function
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = validator::getInstance();
    $connection = database_connection::getInstance()->getConnection();

    $recipe = $validator->validateRecipePost(
        $_POST['recipe-name'],
        $_POST['description'],
        $_POST['howto'],
        $_POST['ingredients'],
        $_FILES['image']
    );

    if ($recipe === null) {
        $errors = $validator->getErrors();
    }

    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO recipe (recipe_name, description, howto, ingredients, image, author) VALUES (?, ?, ?, ?, ?, ?)");
        try {
            $cookieData = json_decode($_COOKIE['username'], true);
            $username = accountRepository::getUserIdByUsername($cookieData['user']);
            if ($username === -1) {
                throw new RuntimeException("Your username is not valid! Log in again");
            }

            $stmt->execute([
                $recipe->getRecipeName(),
                $recipe->getDescription(),
                $recipe->getHowto(),
                $recipe->getIngredients(),
                $recipe->getImage(),
                $username
            ]);

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
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);

    $userId = accountRepository::getUserIdByUsername($input['username']);
    $userPrivileges = accountRepository::checkUserPrivileges($input['username']);
    $recipeAuthor = recipeRepository::getAuthorById($userId);

    if ($userId === $recipeAuthor) {
        recipeRepository::deleteRecipeById((int)$input['recipe_id']);
        echo 'Success';
    } elseif ($userPrivileges === true) {
        recipeRepository::deleteRecipeById((int)$input['recipe_id']);
        echo 'Success';
    } else {
        echo 'Restricted';
    }
}