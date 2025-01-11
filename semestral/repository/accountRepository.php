<?php

declare(strict_types=1);

namespace repository;
require_once $_SERVER['DOCUMENT_ROOT'] . '/entities/builder/accountBuilder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configuration/database_connection.php';
use entities\accountDTO;
use entities\builder\accountBuilder;
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

    public static function getAccountByUsername(string $username): ?accountDTO
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM user WHERE username = ?');

        $stmt->execute([$username]);
        $results = $stmt->fetchAll();

        if (count($results) === 1) {
            return accountBuilder::toDTO($results[0]);
        }
        return null;
    }

    public static function getUserIdByUsername(string $username): int
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT user_id FROM user WHERE username = ?');

        $stmt->execute([$username]);
        $results = $stmt->fetchAll();

        if (count($results) === 1) {
            return $results[0]['user_id'];
        }
        return -1;
    }

    public static function updateAccount(array $updatedAccount): void
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('UPDATE user SET first_name = ?, last_name = ?, email = ? WHERE username = ?');
        $stmt->execute([$updatedAccount['first_name'], $updatedAccount['last_name'], $updatedAccount['email'], $updatedAccount['username']]);
        if ($updatedAccount['password'] !== null) {
            $stmt = self::$databaseConnection->prepare('UPDATE user SET password = ? WHERE username = ?');
            $updatedPassword = password_hash($updatedAccount['password'], PASSWORD_BCRYPT);
            $stmt->execute([$updatedPassword, $updatedAccount['username']]);
        }
    }

    public static function deleteAccountByUsername(string $username) :void
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('DELETE FROM user WHERE username = ?');
        $stmt->execute([$username]);
    }
}
