<?php

declare(strict_types=1);

namespace repository;
use PDO;
require_once $_SERVER['DOCUMENT_ROOT'] . '/configuration/database_connection.php';
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
}