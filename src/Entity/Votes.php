<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Votes
 *
 * @ORM\Table(name="votes", indexes={@ORM\Index(name="fk_votes_options_in_tournaments1_idx", columns={"id_options_in_tournaments"}), @ORM\Index(name="fk_votes_tournaments1_idx", columns={"id_tournaments"}), @ORM\Index(name="fk_votes_tournament_users1_idx", columns={"id_tournament_users"})})
 * @ORM\Entity
 */
class Votes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_glosowania", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGlosowania;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority;

    /**
     * @var \OptionsInTournaments
     *
     * @ORM\ManyToOne(targetEntity="OptionsInTournaments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_options_in_tournaments", referencedColumnName="id_options_in_tournaments")
     * })
     */
    private $idOptionsInTournaments;

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

    public function getIdGlosowania(): ?int
    {
        return $this->idGlosowania;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getIdOptionsInTournaments(): ?OptionsInTournaments
    {
        return $this->idOptionsInTournaments;
    }

    public function setIdOptionsInTournaments(?OptionsInTournaments $idOptionsInTournaments): self
    {
        $this->idOptionsInTournaments = $idOptionsInTournaments;

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
