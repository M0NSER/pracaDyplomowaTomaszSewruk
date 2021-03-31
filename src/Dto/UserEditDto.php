<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserEditDto
 * @package App\Dto
 */
class UserEditDto
{
    /**
     * @Assert\Type("string")
     * @Assert\Length(max="43")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string|null
     */
    private ?string $firstName = null;

    /**
     * @Assert\Type("string")
     * @Assert\Length(max="60")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string|null
     */
    private ?string $lastName = null;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return $this
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return $this
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }
}