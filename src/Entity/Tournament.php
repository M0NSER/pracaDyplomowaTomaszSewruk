<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="App\Repository\TournamentRepository")
 */
class Tournament
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tournament", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $idTournament;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private string $description;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="vote_to_datetime", type="datetime", nullable=true)
     */
    private ?DateTime $voteToDatetime;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="select_to_datetime", type="datetime", nullable=true)
     */
    private ?DateTime $selectToDatetime;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=false)
     */
    private $isPublic = '0';

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createAt = 'CURRENT_TIMESTAMP';

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private ?DateTime $updateAt;

    /**
     * @return int
     */
    public function getIdTournament(): int
    {
        return $this->idTournament;
    }

    /**
     * @param int $idTournament
     */
    public function setIdTournament(int $idTournament): void
    {
        $this->idTournament = $idTournament;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     * @param DateTime|null $createAt
     */
    public function setCreateAt(?DateTime $createAt): void
    {
        $this->createAt = $createAt;
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

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }


}
