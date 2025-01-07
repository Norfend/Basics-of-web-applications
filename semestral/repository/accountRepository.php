<?php

declare(strict_types=1);

namespace repository;
use PDO;
use configuration\database_connection;

class accountRepository
{
    private static ?PDO $databaseConnection = null;

    private static function initConnection(): void
    {
        if (self::$databaseConnection === null) {
            self::$databaseConnection = database_connection::getInstance()->getConnection();
        }
    }

    public static function getAccountByUsername(string $username) : int {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT user_id FROM user WHERE username = ?');

        $stmt->execute([$username]);
        $results = $stmt->fetchAll();

        if (count($results) === 1) {
            return $results[0]['user_id'];
        }
        return -1;
    }
}
