<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentUser
 *
 * @ORM\Table(name="tournament_user", indexes={@ORM\Index(name="fk_tournament_owners_tournaments1_idx", columns={"id_tournament"}), @ORM\Index(name="fk_tournament_owners_users1_idx", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="App\Repository\TournamentUserRepository")
 */
class TournamentUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tournament_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $idTournamentUser;

    /**
     * @var string
     *
     * @ORM\Column(name="tournament_user_type", type="string", nullable=false)
     */
    private string $tournamentUserType;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private User $idUser;

    /**
     * @return int
     */
    public function getIdTournamentUser(): int
    {
        return $this->idTournamentUser;
    }

    /**
     * @param int $idTournamentUser
     */
    public function setIdTournamentUser(int $idTournamentUser): void
    {
        $this->idTournamentUser = $idTournamentUser;
    }

    /**
     * @return string
     */
    public function getTournamentUserType(): string
    {
        return $this->tournamentUserType;
    }

    /**
     * @param string $tournamentUserType
     */
    public function setTournamentUserType(string $tournamentUserType): void
    {
        $this->tournamentUserType = $tournamentUserType;
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

    /**
     * @return User
     */
    public function getIdUser(): User
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser(User $idUser): void
    {
        $this->idUser = $idUser;
    }


}
