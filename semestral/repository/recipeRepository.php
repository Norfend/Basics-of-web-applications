<?php

declare(strict_types=1);

namespace repository;

use entities\recipe;
use PDO;
require_once __DIR__ . '/../configuration/database_connection.php';
require_once __DIR__ . '/../entities/recipe.php';
use \configuration\database_connection;

/**
 * Recipe Repository class responsible for database interactions related to recipes.
 *
 * This class handles operations like fetching recipes with pagination, retrieving all recipes,
 * fetching recipes by author, and deleting recipes by ID.
 *
 * @package repository
 */
class recipeRepository
{
    /**
     * @var PDO|null Database connection instance, initialized lazily.
     */
    private static ?PDO $databaseConnection = null;

    /**
     * Initializes the database connection if it's not already initialized.
     *
     * This method ensures a single connection instance is used throughout the class.
     */
    private static function initConnection(): void
    {
        if (self::$databaseConnection === null) {
            self::$databaseConnection = database_connection::getInstance()->getConnection();
        }
    }

    /**
     * Retrieves a page of recipes from the database.
     *
     * This method fetches a specified number of recipes (page size) starting from a given offset.
     *
     * @param int $pageSize The number of recipes to fetch.
     * @param int $offset The offset from which to start fetching.
     *
     * @return array An array of recipes for the current page.
     */
    public static function getRecipePage(int $pageSize, int $offset): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves all recipes from the database.
     *
     * This method fetches all the recipes from the database without pagination.
     *
     * @return array An array of all recipes.
     */
    public static function getAllRecipes(): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves all recipes by a specific author.
     *
     * This method fetches recipes associated with a given author ID.
     *
     * @param int $author The ID of the author whose recipes to fetch.
     *
     * @return array An array of recipes by the specified author.
     */
    public static function getRecipesByAuthor(int $author): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe WHERE author = ?');

        $stmt->execute([$author]);
        return $stmt->fetchAll();
    }

    /**
     * Retrieves a recipe by its ID.
     *
     * This method fetches a recipe's details based on the provided recipe ID.
     * It returns a `recipe` object populated with the recipe's data.
     *
     * @param int $id The ID of the recipe to retrieve.
     *
     * @return recipe The recipe object populated with data from the database.
     */
    public static function getRecipeById(int $id): recipe
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe WHERE recipe_id = ?');

        $stmt->execute([$id]);
        $fetch = $stmt->fetch();
        return new recipe($fetch['recipe_name'], $fetch['description'], $fetch['howto'], $fetch['ingredients'], $fetch['image']);
    }

    /**
     * Deletes a recipe by its ID.
     *
     * This method removes the recipe from the database based on the provided recipe ID.
     *
     * @param int $id The ID of the recipe to delete.
     */
    public static function deleteRecipeById(int $id): void
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('DELETE FROM recipe WHERE recipe_id = ?');
        $stmt->execute([$id]);
    }

    /**
     * Retrieves the author ID of a recipe by its ID.
     *
     * This method fetches the author ID for the given recipe ID.
     *
     * @param int $authorId The ID of the recipe to fetch the author for.
     *
     * @return int The author ID associated with the recipe.
     */
    public static function getAuthorById(int $authorId): int
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT author FROM recipe WHERE author = ?');

        $stmt->execute([$authorId]);
        $result = $stmt->fetch();
        return $result['author'];
    }

    public static function updateRecipeById(array $recipe, $recipeId): void
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('UPDATE recipe SET recipe_name = ?, description = ?, howto = ?, ingredients = ? WHERE recipe_id = ?');
        $stmt->execute([$recipe['recipe_name'], $recipe['description'], $recipe['howto'], $recipe['ingredients'], $recipeId]);
    }
}