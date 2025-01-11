<?php
declare(strict_types=1);

namespace entities\builder;

require_once __DIR__ . '/../accountDTO.php';

use entities\account;
use entities\accountDTO;

/**
 * Class accountBuilder
 *
 * A builder class for transforming between `account` entities and `accountDTO` objects.
 *
 * This class provides methods to convert an array of account data to a Data Transfer Object (DTO) and to convert
 * an `accountDTO` object to an `account` entity.
 *
 * @package entities\builder
 */
class accountBuilder
{
    /**
     * Converts an array of account data to an `accountDTO` object.
     *
     * This method takes an associative array representing account data and returns an instance of the `accountDTO`
     * class initialized with the provided data.
     *
     * @param array $account The account data as an associative array. Expected keys: 'firstName', 'lastName',
     *                       'username', 'email', 'password', 'avatar'.
     * @return accountDTO The corresponding `accountDTO` object.
     */
    public static function toDTO(array $account) : accountDTO
    {
        return new accountDTO($account);
    }

    /**
     * Converts an `accountDTO` object to an `account` entity.
     *
     * This method takes an `accountDTO` object and uses its getters to instantiate an `account` entity, which represents
     * the domain model for an account.
     *
     * @param accountDTO $accountDTO The `accountDTO` object to convert.
     * @return account The corresponding `account` entity.
     */
    public static function toEntity(accountDTO $accountDTO) : account
    {
        return new account(
            $accountDTO->getFirstName(),
            $accountDTO->getLastName(),
            $accountDTO->getUsername(),
            $accountDTO->getEmail(),
            $accountDTO->getPassword(),
            $accountDTO->getAvatar()
        );
    }
}
