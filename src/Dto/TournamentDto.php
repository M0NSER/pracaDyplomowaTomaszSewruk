<?php

declare(strict_types=1);

namespace App\Dto;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TournamentDto
 * @package App\Dto
 */
class TournamentDto
{
    /**
     * @var string|null
     * @Assert\NotNull()
     * @Assert\Length(min="6", max="255")
     * @Assert\Type("string")
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @Assert\Length(max="2000")
     * @Assert\Type("string")
     */
    private ?string $description = null;

    /**
     * @var string|null
     * @Assert\Length(max="100")
     * @Assert\Type("string")
     */
    private ?string $funnyIcon = null;

    /**
     * @var DateTime|null
     * @Assert\Type("\DateTimeInterface")
     */
    private ?DateTime $voteToDatetime = null;

    /**
     * @var DateTime|null
     * @Assert\Type("\DateTimeInterface")
     */
    private ?DateTime $selectToDatetime = null;

    /**
     * @var int|null
     * @Assert\GreaterThan(0)
     * @Assert\NotNull
     */
    private ?int $votesQuantity = null;

    /**
     * @var bool|null
     * @Assert\Type("boolean")
     */
    private ?bool $isPublic = null;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getFunnyIcon(): ?string
    {
        return $this->funnyIcon;
    }

    /**
     * @param string|null $funnyIcon
     */
    public function setFunnyIcon(?string $funnyIcon): void
    {
        $this->funnyIcon = $funnyIcon;
    }

    /**
     * @return DateTime|null
     */
    public function getVoteToDatetime(): ?DateTime
    {
        return $this->voteToDatetime;
    }

    /**
     * @param DateTime|null $voteToDatetime
     */
    public function setVoteToDatetime(?DateTime $voteToDatetime): void
    {
        $this->voteToDatetime = $voteToDatetime;
    }

    /**
     * @return DateTime|null
     */
    public function getSelectToDatetime(): ?DateTime
    {
        return $this->selectToDatetime;
    }

    /**
     * @param DateTime|null $selectToDatetime
     */
    public function setSelectToDatetime(?DateTime $selectToDatetime): void
    {
        $this->selectToDatetime = $selectToDatetime;
    }

    /**
     * @return int|null
     */
    public function getVotesQuantity(): ?int
    {
        return $this->votesQuantity;
    }

    /**
     * @param int|null $votesQuantity
     *
     * @return $this
     */
    public function setVotesQuantity(?int $votesQuantity): self
    {
        $this->votesQuantity = $votesQuantity;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool|null $isPublic
     */
    public function setIsPublic(?bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

}