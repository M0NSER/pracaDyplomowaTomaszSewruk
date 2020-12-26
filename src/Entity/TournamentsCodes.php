<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentsCodes
 *
 * @ORM\Table(name="tournaments_codes", indexes={@ORM\Index(name="fk_tournaments_codes_tournaments1_idx", columns={"id_tournaments"})})
 * @ORM\Entity
 */
class TournamentsCodes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tournaments_codes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTournamentsCodes;

    /**
     * @var string
     *
     * @ORM\Column(name="generated_code", type="string", length=100, nullable=false)
     */
    private $generatedCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire_date", type="datetime", nullable=false)
     */
    private $expireDate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var Tournaments
     *
     * @ORM\ManyToOne(targetEntity="Tournaments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournaments", referencedColumnName="id_tournaments")
     * })
     */
    private $idTournaments;

    public function getIdTournamentsCodes(): ?int
    {
        return $this->idTournamentsCodes;
    }

    public function getGeneratedCode(): ?string
    {
        return $this->generatedCode;
    }

    public function setGeneratedCode(string $generatedCode): self
    {
        $this->generatedCode = $generatedCode;

        return $this;
    }

    public function getExpireDate(): ?DateTimeInterface
    {
        return $this->expireDate;
    }

    public function setExpireDate(DateTimeInterface $expireDate): self
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIdTournaments(): ?Tournaments
    {
        return $this->idTournaments;
    }

    public function setIdTournaments(?Tournaments $idTournaments): self
    {
        $this->idTournaments = $idTournaments;

        return $this;
    }


}
