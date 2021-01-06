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
     * @Assert\Type("string")
     * @Assert\Length(min="3")
     * @var string
     */
    private string $userFindField;

    /**
     * @return string
     */
    public function getUserFindField(): string
    {
        return $this->userFindField;
    }

    /**
     * @param string $userFindField
     */
    public function setUserFindField(string $userFindField): void
    {
        $this->userFindField = $userFindField;
    }
}