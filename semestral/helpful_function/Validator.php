<?php
declare(strict_types=1);

namespace helpful_function;
include "../my_classes/Account.php";
use my_classes\Account;

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
                                        $avatar) : ?Account
    {
        if (! $this->validateName($firstName)) self::$errors[] = "First name is invalid";
        if (! $this->validateName($lastName)) self::$errors[] = "Last name is invalid";
        if (! $this->validateUsername($username)) self::$errors[] = "Username is invalid";
        if (! $this->validateEmail($email)) self::$errors[] = "Email is invalid";
        if (! $this->validatePassword($password)) self::$errors[] = "Password is invalid";
        if ($password !== $confirm_password) self::$errors[] = "Passwords do not match";
        if (! $this->validateImage($avatar)) self::$errors[] = "Avatar is invalid";
        if (count(self::$errors) < 1) {
            $accountPassword = password_hash($password, PASSWORD_BCRYPT);
            $accountAvatar = "avatar";
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

    public function validateUsername(string $data): bool
    {
        $safeInput = $this->trim_input($data);
        if (preg_match('/^[a-zA-Z0-9]{6,}$/', $safeInput)) return true;
        else return false;
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

    public function validateImage($file) :bool
    {
/*        if (getimagesize($file)) return true;
        else return false;*/
        return true;
    }

    private function trim_input(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
}