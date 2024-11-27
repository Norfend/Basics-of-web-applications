<?php

namespace class;
class Account
{
    private $firstName;

    private $lastName;

    private $username;

    private $email;

    private $password;

    private $avatar;

    function __construct()
    {
        $this->firstName = "";
        $this->lastName = "";
    }
}