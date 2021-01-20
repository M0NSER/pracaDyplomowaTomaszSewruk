<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserDto
 * @package App\Dto
 */
class AddUserToTournamentDto
{
    /**
     * @Assert\Type("array")
     * @Assert\Length(min="3")
     * @var array
     */
    private array $usersToAdd;

    /**
     * @return array
     */
    public function getUsersToAdd(): array
    {
        return $this->usersToAdd;
    }

    /**
     * @param array $usersToAdd
     *
     * @return $this
     */
    public function setUsersToAdd(array $usersToAdd): self
    {
        $this->usersToAdd = $usersToAdd;

        return $this;
    }
}