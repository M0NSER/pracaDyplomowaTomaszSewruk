<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote", indexes={@ORM\Index(name="fk_votes_tournament_users1_idx", columns={"id_tournament_user"}), @ORM\Index(name="fk_votes_options_in_tournaments1_idx", columns={"id_option_in_tournament"}), @ORM\Index(name="fk_votes_tournaments1_idx", columns={"id_tournament"})})
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_vote", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_selected_by_promoter", type="boolean", nullable=false)
     */
    private $isSelectedByPromoter = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority = '0';

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
     * @var OptionInTournament
     *
     * @ORM\ManyToOne(targetEntity="OptionInTournament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_option_in_tournament", referencedColumnName="id_options_in_tournaments")
     * })
     */
    private OptionInTournament $idOptionInTournament;

    /**
     * @var TournamentUser
     *
     * @ORM\ManyToOne(targetEntity="TournamentUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tournament_user", referencedColumnName="id_tournament_user")
     * })
     */
    private TournamentUser $idTournamentUser;

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
     * @return bool
     */
    public function isSelectedByPromoter(): bool
    {
        return $this->isSelectedByPromoter;
    }

    /**
     * @param bool $isSelectedByPromoter
     */
    public function setIsSelectedByPromoter(bool $isSelectedByPromoter): void
    {
        $this->isSelectedByPromoter = $isSelectedByPromoter;
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
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
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
     * @return OptionInTournament
     */
    public function getIdOptionInTournament(): OptionInTournament
    {
        return $this->idOptionInTournament;
    }

    /**
     * @param OptionInTournament $idOptionInTournament
     */
    public function setIdOptionInTournament(OptionInTournament $idOptionInTournament): void
    {
        $this->idOptionInTournament = $idOptionInTournament;
    }

    /**
     * @return TournamentUser
     */
    public function getIdTournamentUser(): TournamentUser
    {
        return $this->idTournamentUser;
    }

    /**
     * @param TournamentUser $idTournamentUser
     */
    public function setIdTournamentUser(TournamentUser $idTournamentUser): void
    {
        $this->idTournamentUser = $idTournamentUser;
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

    public function getIsSelectedByPromoter(): ?bool
    {
        return $this->isSelectedByPromoter;
    }


}
