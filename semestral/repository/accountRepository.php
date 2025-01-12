<?php

declare(strict_types=1);

namespace repository;

require_once __DIR__ . '/../entities/builder/accountBuilder.php';
require_once __DIR__ . '/../configuration/database_connection.php';
use entities\accountDTO;
use entities\builder\accountBuilder;
use PDO;
use configuration\database_connection;

/**
 * Account Repository class responsible for database interactions related to user accounts.
 *
 * This class handles operations like fetching account details by username, updating account information,
 * checking user privileges, and deleting accounts.
 *
 * @package repository
 */
class accountRepository
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
     * Retrieves an account by its username.
     *
     * This method fetches the user details from the database based on the provided username.
     * It returns an accountDTO object representing the user's data if found, or null otherwise.
     *
     * @param string $username The username to search for.
     *
     * @return accountDTO|null An accountDTO object if the account is found, null otherwise.
     */
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

    /**
     * Retrieves the user ID by the username.
     *
     * This method fetches the user ID from the database for the provided username.
     * It returns the user ID if found, or -1 if the username does not exist.
     *
     * @param string $username The username to search for.
     *
     * @return int The user ID if found, -1 otherwise.
     */
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

    /**
     * Updates an account's information in the database.
     *
     * This method updates the account details (first name, last name, and email) of the specified user.
     * If a new password is provided, it is also updated after hashing.
     *
     * @param array $updatedAccount An associative array containing the updated account information.
     */
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

    /**
     * Deletes an account by username.
     *
     * This method removes the user record from the database based on the provided username.
     *
     * @param string $id The username of the account to delete.
     */
    public static function deleteAccountById(int $id): void
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('DELETE FROM user WHERE user_id = ?');
        $stmt->execute([$id]);
    }

    /**
     * Checks if a user has superuser privileges.
     *
     * This method checks the `super_user` column for the provided username and returns true if the user
     * is a superuser, otherwise false.
     *
     * @param string $username The username to check for privileges.
     *
     * @return bool True if the user has superuser privileges, false otherwise.
     */
    public static function checkUserPrivileges(string $username): bool
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT super_user FROM user WHERE username = ?');
        $stmt->execute([$username]);
        $result = $stmt->fetch()['super_user'];
        if ($result === 0) return false;
        else return true;
    }

    public static function getAllUsers(): array
    {
        self::initConnection();
        $stmt = self::$databaseConnection->prepare('SELECT * FROM user WHERE super_user = 0');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}