<?php
declare(strict_types=1);

namespace function;
require_once __DIR__ . "/../entities/account.php";
require_once __DIR__ . "/../entities/recipe.php";
use configuration\database_connection;
use entities\account;
use entities\recipe;
use PDOException;

class validator {

    private static ?validator $instance = null;

    private static array $errors = array();

    private function __construct()
    {}

    public static function getInstance(): validator
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
                                        array $avatar) : ?account
    {
        self::$errors = array();
        if (! $this->validateName($firstName)) self::$errors[] = "First name must be at least 2 characters";
        if (! $this->validateName($lastName)) self::$errors[] = "Last name must be at least 2 characters";
        $this->validateUsername($username);
        if (! $this->validateEmail($email)) self::$errors[] = "Email is invalid";
        if (! $this->validatePassword($password)) self::$errors[] = "Password must be at least 8 characters long, contain at least one lowercase letter, one uppercase letter, and one number";
        if ($password !== $confirm_password) self::$errors[] = "Passwords don't match";
        if (count($avatar) > 7) $this->validateImage($avatar);
        if (count(self::$errors) < 1) {
            $accountPassword = password_hash($password, PASSWORD_BCRYPT);
            if (count($avatar) > 7) {
                $filename = $username . '-' . pathinfo($avatar['name'], PATHINFO_FILENAME) . '.' . pathinfo($avatar['name'], PATHINFO_EXTENSION);
            }
            else {
                $filename = 'avatar-placeholder.png';
            }
            $destination = realpath(__DIR__ . '/../upload/avatar');
            try {
                move_uploaded_file($avatar['tmp_name'], $destination . '/' . $filename);/*Не работает на сервере ЗВА*/
                $accountAvatar = 'upload/avatar/' . $filename;
            }
            catch (PDOException $e) {}
            return new account($firstName, $lastName, $username, $email, $accountPassword, $accountAvatar);
        }
        else return null;
    }

    public function validateRecipePost(string $recipeName, string $description, string $howto,
                                       string $ingredients, array $image) : ?recipe
    {
        self::$errors = array();
        if (! preg_match('/^[a-zA-Z0-9\s]{3,255}$/', $recipeName)) self::$errors[] = "Recipe name must be at least 3 characters";
        if (! preg_match('/^[a-zA-Z0-9\s_!.,():;?-]{20,5000}$/', $description)) self::$errors[] = "Description must be at least 20 characters";
        if (! preg_match('/^[a-zA-Z0-9\s_!.,():;?-]{20,255}$/', $howto)) self::$errors[] = "How to must be at least 20 characters";
        if (! preg_match('/^[a-zA-Z0-9\s_!.,():;?-]{20,255}$/', $ingredients)) self::$errors[] = "Ingredients must be at least 20 characters";
        if (count($image) > 7) $this->validateImage($image);
        if (count(self::$errors) < 1) {
            if (count($image) > 7) {
                $filename = str_replace(' ', '-', $recipeName) . '-' . pathinfo($image['name'], PATHINFO_FILENAME) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
            }
            else {
                $filename = 'recipe-placeholder.png';
            }
            $destination = realpath(__DIR__ . '/../upload/recipe/');
            try {
                move_uploaded_file($image['tmp_name'], $destination . '/' . $filename);
                $recipeImage = 'upload/recipe/' . $filename;
            }
            catch (PDOException $e) {}
            return new recipe($recipeName, $description, $howto, $ingredients, $recipeImage);
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
        if (preg_match('/^[a-zA-Z0-9_]{6,255}$/', $safeInput)) {
            $connection = database_connection::getInstance()->getConnection();
            $stmt = $connection->prepare('SELECT COUNT(*) FROM user WHERE username = ?');
            try {
                $stmt->execute([$data]);
            }
            catch (PDOException $e) {
                self::$errors[] = $e->getMessage();
            }
            if ($stmt->fetchColumn() > 0) self::$errors[] = 'Username is not available';
        }
        else self::$errors[] = 'Username must be at least 6 characters long and contain only letters and numbers';
    }

    public function validateEmail(string $data): bool
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) return true;
        else return false;
    }

    public function validatePassword(string $passwordOne): bool
    {
        if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $passwordOne)) return true;
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