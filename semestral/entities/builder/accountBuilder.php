<?php
declare(strict_types=1);

namespace entities\builder;
require_once __DIR__ . '/../accountDTO.php';
use entities\account;
use entities\accountDTO;

class accountBuilder
{
    public static function toDTO(array $account) :accountDTO
    {
        return new accountDTO($account);
    }

    public static function toEntity(accountDTO $accountDTO) :account
    {
        return new account($accountDTO->getFirstName(), $accountDTO->getLastName(), $accountDTO->getUsername(),
            $accountDTO->getEmail(), $accountDTO->getPassword(), $accountDTO->getAvatar());
    }
}