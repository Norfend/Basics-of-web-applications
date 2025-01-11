<?php
namespace configuration;

use PDO;
use PDOException;

/**
 * Singleton class to manage database connection using PDO.
 */
class database_connection
{

    private static ?database_connection $instance = null;

    private ?PDO $connection = null;

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
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Returns the singleton instance of the database connection class.
     * If the instance does not exist, it creates and returns a new one.
     *
     * @return database_connection The singleton instance of the class.
     */
    public static function getInstance(): database_connection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }
}