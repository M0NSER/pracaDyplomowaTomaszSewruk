<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TournamentCode
 * @ORM\Table(name="tournament_code", indexes={@ORM\Index(name="fk_tournaments_codes_tournaments1_idx", columns={"id_tournament"})})
 * @ORM\Entity(repositoryClass="App\Repository\TournamentCodeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=false)
 */
class TournamentCode
{
    /**
     * @var int
     * @ORM\Column(name="id_tournament_code", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="generated_code", type="string", length=255, nullable=false)
     */
    private string $generatedCode;

    /**
     * @var DateTime|null
     * @ORM\Column(name="expire_at", type="datetime", nullable=true)
     */
    private ?DateTime $expireAt;

    /**
     * @var DateTime|null
     * @ORM\Column(name="create_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private ?DateTime $createAt = null;

    /**
     * @var DateTime|null
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private ?DateTime $updateAt;

    /**
     * @var DateTime|null
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private ?DateTime $deletedAt;

    /**
     * @var Tournament
     * @ORM\ManyToOne(targetEntity="Tournament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournament", referencedColumnName="id_tournament", nullable=false)
     * })
     */
    private Tournament $idTournament;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getGeneratedCode(): string
    {
        return $this->generatedCode;
    }

    /**
     * @param string $generatedCode
     *
     * @return $this
     */
    public function setGeneratedCode(string $generatedCode): self
    {
        $this->generatedCode = $generatedCode;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getExpireAt(): ?DateTime
    {
        return $this->expireAt;
    }

    /**
     * @param DateTime|null $expireAt
     *
     * @return $this
     */
    public function setExpireAt(?DateTime $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateAt(): ?DateTime
    {
        return $this->createAt;
    }

    /**
     * @ORM\PrePersist
     * @return $this
     */
    public function setCreateAt(): self
    {
        $this->createAt = new DateTime();

        return $this;
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
     *
     * @return $this
     */
    public function setUpdateAt(?DateTime $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime|null $deletedAt
     *
     * @return $this
     */
    public function setDeletedAt(?DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Tournament
     */
    public function getIdTournament(): Tournament
    {
        return $this->idTournament;
    }

    /**
     * @param Tournament $idTournament
     *
     * @return $this
     */
    public function setIdTournament(Tournament $idTournament): self
    {
        $this->idTournament = $idTournament;

        return $this;
    }
}
