<?php
declare(strict_types=1);

namespace entities;
class accountDTO
{
    private string $firstName;

    private string $lastName;

    private string $username;

    private string $avatar;

    function __construct(string $firstName, string $lastName, string $username, string $avatar)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->avatar = $avatar;
    }

    public function __toString(): string
    {
        return $this->firstName . ' ' . $this->lastName . ' ' . $this->username . ' ' . $this->avatar;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }
}