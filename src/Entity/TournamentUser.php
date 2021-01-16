<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TournamentUser
 * @ORM\Table(name="tournament_user", indexes={@ORM\Index(name="fk_tournament_owners_tournaments1_idx", columns={"id_tournament"}), @ORM\Index(name="fk_tournament_owners_users1_idx", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="App\Repository\TournamentUserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=false)
 */
class TournamentUser
{
    /**
     * @var int
     * @ORM\Column(name="id_tournament_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="tournament_user_type", type="string", nullable=false)
     */
    private string $tournamentUserType;

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
     * @var Tournament
     * @ORM\ManyToOne(targetEntity="Tournament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournament", referencedColumnName="id_tournament", nullable=false)
     * })
     */
    private Tournament $idTournament;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User",fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user", nullable=false)
     * })
     */
    private User $idUser;

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
     * @param DateTime|null $deletedAt
     */
    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
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
