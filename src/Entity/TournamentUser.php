<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TournamentUser
 * @ORM\Table(name="tournament_user", indexes={@ORM\Index(name="fk_tournament_owners_tournaments1_idx",
 *     columns={"id_tournament"}), @ORM\Index(name="fk_tournament_owners_users1_idx", columns={"id_user"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"id_user", "id_tournament"})}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TournamentUserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", hardDelete=false)
 * @UniqueEntity(fields={"idUser", "idTournament"}, message="This user already exists")
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
    public function getTournamentUserType(): string
    {
        return $this->tournamentUserType;
    }

    /**
     * @param string $tournamentUserType
     *
     * @return $this
     */
    public function setTournamentUserType(string $tournamentUserType): self
    {
        $this->tournamentUserType = $tournamentUserType;

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
     * @ORM\PrePersist()
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
     * @ORM\PreUpdate()
     * @return $this
     */
    public function setUpdateAt(): self
    {
        $this->updateAt = new DateTime();

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

    /**
     * @return User
     */
    public function getIdUser(): User
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     *
     * @return $this
     */
    public function setIdUser(User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
}
