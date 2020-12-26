<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentCode
 *
 * @ORM\Table(name="tournament_code", indexes={@ORM\Index(name="fk_tournaments_codes_tournaments1_idx", columns={"id_tournament"})})
 * @ORM\Entity(repositoryClass="App\Repository\TournamentCodeRepository")
 */
class TournamentCode
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tournament_code", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="generated_code", type="string", length=255, nullable=false)
     */
    private string $generatedCode;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="expire_at", type="datetime", nullable=true)
     */
    private ?DateTime $expireAt;

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
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournament", referencedColumnName="id_tournament")
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setGeneratedCode(string $generatedCode): void
    {
        $this->generatedCode = $generatedCode;
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
     */
    public function setExpireAt(?DateTime $expireAt): void
    {
        $this->expireAt = $expireAt;
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

    /**
     * @return Tournament
     */
    public function getIdTournament(): Tournament
    {
        return $this->idTournament;
    }

    /**
     * @param Tournament $idTournament
     */
    public function setIdTournament(Tournament $idTournament): void
    {
        $this->idTournament = $idTournament;
    }


}
