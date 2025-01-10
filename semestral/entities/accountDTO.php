<?php

namespace entities;

class accountDTO
{
    private string $firstName;

    private string $lastName;

    private string $username;

    private string $email;

    private ?string $password;

    private string $avatar;

    public function __construct(array $account)
    {
        $this->firstName = $account['first_name'];
        $this->lastName = $account['last_name'];
        $this->username = $account['username'];
        $this->email = $account['email'];
        $this->password = null;
        $this->avatar = $account['avatar'];
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }
}