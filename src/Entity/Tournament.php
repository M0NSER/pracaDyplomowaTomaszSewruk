<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tournament
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="App\Repository\TournamentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=false, timeAware=true)
 */
class Tournament
{
    /**
     * Tournament constructor.
     */
    public function __construct()
    {
        $this->optionsInThisTournament = new ArrayCollection();
    }

    /**
     * @var int
     * @ORM\Column(name="id_tournament", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @var string|null
     * @ORM\Column(name="description", type="text", length=10000, nullable=true)
     */
    private ?string $description;

    /**
     * @var string|null
     * @ORM\Column(name="funny_icon", type="string", length=100, nullable=true)
     */
    private ?string $funnyIcon = null;

    /**
     * @var DateTime|null
     * @ORM\Column(name="vote_to_datetime", type="datetime", nullable=true)
     */
    private ?DateTime $voteToDatetime = null;

    /**
     * @var DateTime|null
     * @ORM\Column(name="select_to_datetime", type="datetime", nullable=true)
     */
    private ?DateTime $selectToDatetime = null;

    /**
     * @var int
     * @ORM\Column(name="votes_quantity", type="integer", nullable=false)
     */
    private int $votesQuantity;

    /**
     * @var bool
     * @ORM\Column(name="is_public", type="boolean", nullable=false)
     */
    private bool $isPublic = false;

    /**
     * @var DateTime|null
     * @ORM\Column(name="create_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private ?DateTime $createAt = null;

    /**
     * @var DateTime|null
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private ?DateTime $updateAt = null;

    /**
     * @var DateTime|null
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private ?DateTime $deletedAt;

    /**
     * @return Collection
     * @ORM\OneToMany(targetEntity=OptionInTournament::class, mappedBy="idTournament")
     */
    private Collection $optionsInThisTournament;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
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
    public function getVotesQuantity(): int
    {
        return $this->votesQuantity;
    }

    /**
     * @param int $votesQuantity
     *
     * @return $this
     */
    public function setVotesQuantity(int $votesQuantity): self
    {
        $this->votesQuantity = $votesQuantity;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    /**
     * @param bool $isPublic
     */
    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateAt(): ?DateTime
    {
        return $this->createAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setCreateAt(): void
    {
        $this->createAt = new DateTime();
    }

    /**
     * @return DateTime|null
     */
    public function getUpdateAt(): ?DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param DateTime|null $updateAt
     */
    public function setUpdateAt(?DateTime $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }


    /**
     * @return bool|null
     */
    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getOptionsInThisTournament()
    {
        return $this->optionsInThisTournament;
    }


}
