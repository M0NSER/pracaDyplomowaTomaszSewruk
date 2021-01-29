<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vote
 * @ORM\Table(name="vote", indexes={@ORM\Index(name="fk_votes_users1_idx",
 *     columns={"id_user"}), @ORM\Index(name="fk_votes_options_in_tournaments1_idx", columns={"id_option_in_tournament"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"id_user", "id_option_in_tournament"})}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Vote
{
    public function __toString()
    {
        return $this->idUser->getFirstName() . ' ' . $this->idUser->getLastName() . '(' . $this->idUser->getEmail() . ')';
    }

    /**
     * @var int
     * @ORM\Column(name="id_vote", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var bool
     * @ORM\Column(name="is_selected_by_promoter", type="boolean", nullable=false)
     */
    private bool $isSelectedByPromoter = false;

    /**
     * @var int
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private int $priority = 0;

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
     * @var OptionInTournament
     * @ORM\ManyToOne(targetEntity="OptionInTournament", inversedBy="votes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_option_in_tournament", referencedColumnName="id_options_in_tournaments", nullable=false)
     * })
     */
    private OptionInTournament $idOptionInTournament;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
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
     * @return bool
     */
    public function isSelectedByPromoter(): bool
    {
        return $this->isSelectedByPromoter;
    }

    /**
     * @param bool $isSelectedByPromoter
     *
     * @return $this
     */
    public function setIsSelectedByPromoter(bool $isSelectedByPromoter): self
    {
        $this->isSelectedByPromoter = $isSelectedByPromoter;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @return $this
     */
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

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
     * @return OptionInTournament
     */
    public function getIdOptionInTournament(): OptionInTournament
    {
        return $this->idOptionInTournament;
    }

    /**
     * @param OptionInTournament $idOptionInTournament
     *
     * @return $this
     */
    public function setIdOptionInTournament(OptionInTournament $idOptionInTournament): self
    {
        $this->idOptionInTournament = $idOptionInTournament;

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
