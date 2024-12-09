<?php
namespace configuration;

use PDO;
use PDOException;

class database_connection
{
    private static ?database_connection $instance = null;
    private ?PDO $connection = null;

    /**
     * Private constructor to prevent direct object creation.
     */
    private function __construct()
    {
        try {
            $env = parse_ini_file('.env');
            $dsn = "mysql:host={$env["host"]};dbname={$env["dbName"]}";
            $this->connection = new PDO($dsn, $env["username"], $env["password"], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT         => true
            ]);
        } catch (PDOException $e) {
            // Log error or handle gracefully in production
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the singleton instance of the DatabaseConnection class.
     *
     * @return database_connection
     */
    public static function getInstance(): database_connection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the PDO connection instance.
     *
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Prevent cloning of the singleton instance.
     */
    private function __clone()
    {
    }

    /**
     * Prevent serialization of the singleton instance.
     */
    public function __wakeup()
    {
    }
}