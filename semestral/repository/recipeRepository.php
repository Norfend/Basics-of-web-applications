<?php

declare(strict_types=1);

namespace repository;
use entities\recipe;
use PDO;
require_once $_SERVER['DOCUMENT_ROOT'] . '/configuration/database_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/entities/recipe.php';
use \configuration\database_connection;

class recipeRepository
{
    private static ?PDO $databaseConnection = null;

    private static function initConnection(): void
    {
        if (self::$databaseConnection === null) {
            self::$databaseConnection = database_connection::getInstance()->getConnection();
        }
    }

    public static function getRecipePage(int $pageSize, int $offset): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllRecipes(): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe');

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getRecipesByAuthor(int $author): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe WHERE author = ?');

        $stmt->execute([$author]);
        return $stmt->fetchAll();
    }

    public static function getRecipeById(int $id): recipe
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM recipe WHERE recipe_id = ?');

        $stmt->execute([$id]);
        $fetch = $stmt->fetch();
        return new recipe($fetch['recipe_name'], $fetch['description'], $fetch['howto'], $fetch['ingredients'], $fetch['image']);
    }
}