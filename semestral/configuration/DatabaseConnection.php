<?php

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private ?PDO $connection = null;

    /**
     * Private constructor to prevent direct object creation.
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->$_ENV["host"]};dbname={$this->$_ENV["dbName"]};charset={$this->$_ENV["charset"]}";
            $this->connection = new PDO($dsn, $this->$_ENV["username"], $this->$_ENV["password"], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Set error mode to exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Fetch results as associative arrays
                PDO::ATTR_PERSISTENT         => true                   // Persistent connection
            ]);
        } catch (PDOException $e) {
            // Log error or handle gracefully in production
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the singleton instance of the DatabaseConnection class.
     *
     * @return DatabaseConnection
     */
    public static function getInstance(): DatabaseConnection
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