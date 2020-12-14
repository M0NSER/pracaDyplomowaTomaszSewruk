<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OptionsInTournaments
 *
 * @ORM\Table(name="options_in_tournaments", indexes={@ORM\Index(name="fk_options_in_tournaments_tournaments1_idx", columns={"id_tournaments"}), @ORM\Index(name="fk_options_in_tournaments_tournament_users1_idx", columns={"id_tournament_users"})})
 * @ORM\Entity
 */
class OptionsInTournaments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_options_in_tournaments", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOptionsInTournaments;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number_of_slots", type="integer", nullable=true)
     */
    private $numberOfSlots;

    /**
     * @var \TournamentUsers
     *
     * @ORM\ManyToOne(targetEntity="TournamentUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournament_users", referencedColumnName="id_tournament_users")
     * })
     */
    private $idTournamentUsers;

    /**
     * @var \Tournaments
     *
     * @ORM\ManyToOne(targetEntity="Tournaments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournaments", referencedColumnName="id_tournaments")
     * })
     */
    private $idTournaments;

    public function getIdOptionsInTournaments(): ?int
    {
        return $this->idOptionsInTournaments;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumberOfSlots(): ?int
    {
        return $this->numberOfSlots;
    }

    public function setNumberOfSlots(?int $numberOfSlots): self
    {
        $this->numberOfSlots = $numberOfSlots;

        return $this;
    }

    public function getIdTournamentUsers(): ?TournamentUsers
    {
        return $this->idTournamentUsers;
    }

    public function setIdTournamentUsers(?TournamentUsers $idTournamentUsers): self
    {
        $this->idTournamentUsers = $idTournamentUsers;

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
