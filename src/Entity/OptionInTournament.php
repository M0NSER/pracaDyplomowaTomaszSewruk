<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * OptionInTournament
 *
 * @ORM\Table(name="option_in_tournament", indexes={@ORM\Index(name="fk_options_in_tournaments_tournament_users1_idx", columns={"id_tournament_user"}), @ORM\Index(name="fk_options_in_tournaments_tournaments1_idx", columns={"id_tournament"})})
 * @ORM\Entity(repositoryClass="App\Repository\OptionInTournamentRepository")
 *
 */
class OptionInTournament
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_options_in_tournaments", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private string $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private ?string $description;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number_of_slots", type="integer", nullable=true)
     */
    private ?int $numberOfSlots;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private ?DateTime $createAt = null;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private ?DateTime $updateAt;

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getNumberOfSlots(): ?int
    {
        return $this->numberOfSlots;
    }

    /**
     * @param int|null $numberOfSlots
     */
    public function setNumberOfSlots(?int $numberOfSlots): void
    {
        $this->numberOfSlots = $numberOfSlots;
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


}
