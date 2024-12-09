<?php
declare(strict_types=1);

namespace function;
include "../entities/Account.php";
use configuration\DatabaseConnection;
use entities\Account;
use PDOException;

class Validator {

    private static ?Validator $instance = null;

    private static array $errors = array();

    private function __construct()
    {}

    public static function getInstance(): Validator
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getErrors(): array
    {
        return self::$errors;
    }

    public function validateAccountPost(string $firstName, string $lastName, string $username,
                                        string $email, string $password, string $confirm_password,
                                        array $avatar) : ?Account
    {
        if (! $this->validateName($firstName)) self::$errors[] = "First name must be at least 2 characters";
        if (! $this->validateName($lastName)) self::$errors[] = "Last name must be at least 2 characters";
        $this->validateUsername($username);
        if (! $this->validateEmail($email)) self::$errors[] = "Email is invalid";
        if (! $this->validatePassword($password)) self::$errors[] = "Password must be at least 8 characters long,
        contain at least one lowercase letter, one uppercase letter, and one number";
        if ($password !== $confirm_password) self::$errors[] = "Passwords do not match";
        if (count($avatar) > 6) $this->validateImage($avatar);
        if (count(self::$errors) < 1) {
            $accountPassword = password_hash($password, PASSWORD_BCRYPT);
            $filename = $username . '-' . pathinfo($avatar['name'], PATHINFO_FILENAME) . '.' . pathinfo($avatar['name'], PATHINFO_EXTENSION);
            $destination = '../upload/avatar' . '/' . $filename;
            try {
                move_uploaded_file($avatar['tmp_name'], $destination);/*Не работает на сервере ЗВА*/
                $accountAvatar = $destination;
            }
            catch (PDOException $e) {
                $accountAvatar = '../upload/avatar/avatar-placeholder.png';
            }
            return new Account($firstName, $lastName, $username, $email, $accountPassword, $accountAvatar);
        }
        else return null;
    }

    public function validateName(string $data): bool
    {
        $safeInput = $this->trim_input($data);
        if (! strlen($safeInput) < 1) return true;
        return false;
    }

    public function validateUsername(string $data): void
    {
        $safeInput = $this->trim_input($data);
        if (preg_match('/^[a-zA-Z0-9]{6,}$/', $safeInput)) {
            $connection = DatabaseConnection::getInstance()->getConnection();
            $stmt = $connection->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
            try {
                $stmt->execute([$data]);
            }
            catch (PDOException $e) {
                self::$errors[] = $e->getMessage();
            }
            if ($stmt->fetchColumn() > 0) self::$errors[] = 'Username is not available';
        }
        else self::$errors[] = 'Username is not valid';
    }

    public function validateEmail(string $data): bool
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) return true;
        else return false;
    }

    public function validatePassword(string $passwordOne): bool
    {
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/', $passwordOne)) return true;
        else return false;
    }

    public function validateImage(array $file) :bool
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            self::$errors[] = "File upload error";
            return false;
        }
        if ($file['size'] > 1024 * 1024) {
            self::$errors[] =  "File size exceeds the allowed limit of 1Kb";
            return false;
        }
        if (!is_uploaded_file($file['tmp_name'])) {
            self::$errors[] =  "The file was not uploaded via HTTP POST";
            return false;
        }
        if (!str_starts_with(mime_content_type($file['tmp_name']), 'image/')) {
            self::$errors[] =  "The uploaded file is not an image";
            return false;
        }
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            self::$errors[] =  "The file is not a valid image";
            return false;
        }
        [$width, $height] = $imageInfo;
        if ($width > 400 || $height > 400) {
            echo "Image dimensions exceed the allowed limit of 400x400 pixels";
            return false;
        }
        return true;
    }

    private function trim_input(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
}