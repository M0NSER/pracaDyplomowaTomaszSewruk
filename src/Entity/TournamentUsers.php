<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentUsers
 *
 * @ORM\Table(name="tournament_users", indexes={@ORM\Index(name="fk_tournament_owners_tournaments1_idx", columns={"id_tournaments"}), @ORM\Index(name="fk_tournament_owners_owner_types_idx", columns={"id_tounaments_users_types"}), @ORM\Index(name="fk_tournament_owners_users1_idx", columns={"id_users"})})
 * @ORM\Entity
 */
class TournamentUsers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tournament_users", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTournamentUsers;

    /**
     * @var \TounamentsUsersTypes
     * @var TounamentsUsersTypes
     *
     *
     * @ORM\ManyToOne(targetEntity="TounamentsUsersTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tounaments_users_types", referencedColumnName="id_owner_types")
     * })
     */
    private $idTounamentsUsersTypes;

    /**
     * @var \Tournaments
     *
     * @ORM\ManyToOne(targetEntity="Tournaments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournaments", referencedColumnName="id_tournaments")
     * })
     */
    private $idTournaments;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_users", referencedColumnName="id_users")
     * })
     */
    private $idUsers;

    public function getIdTournamentUsers(): ?int
    {
        return $this->idTournamentUsers;
    }

    public function getIdTounamentsUsersTypes(): ?TounamentsUsersTypes
    {
        return $this->idTounamentsUsersTypes;
    }

    public function setIdTounamentsUsersTypes(?TounamentsUsersTypes $idTounamentsUsersTypes): self
    {
        $this->idTounamentsUsersTypes = $idTounamentsUsersTypes;

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

    public function getIdUsers(): ?Users
    {
        return $this->idUsers;
    }

    public function setIdUsers(?Users $idUsers): self
    {
        $this->idUsers = $idUsers;

        return $this;
    }


}
