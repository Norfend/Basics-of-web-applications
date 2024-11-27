<?php
declare(strict_types=1);

class Validator {

    private static ?Validator $instance = null;

    private function __construct()
    {}

    static function getInstance(): Validator
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function validateAccountPost() :
    {
        $firstName = $this->trim_input($_POST['first-name']);
        $lastName = $this->trim_input($_POST['last-name']);
        $username = $this->trim_input($_POST['username']);
        $email = $this->trim_input($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
        $avatar = $_FILES['avatar'];
    }

    function validateName(string $stringOne): bool
    {
        $safeInput = trim($stringOne);
        return !empty($safeInput);
    }

    private function trim_input(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
}