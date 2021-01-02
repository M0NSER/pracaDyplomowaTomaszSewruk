<?php


namespace App\Dto;


use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class OptionInTournamentDto
 * @package App\Dto
 */
class OptionInTournamentDto
{
    /**
     * @Assert\NotNull()
     * @Assert\Length(min=5)
     * @Assert\Type("string")
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @Assert\Type("string")
     * @var string|null
     */
    private ?string $description = null;

    /**
     * @Assert\Type("int")
     * @var int|null
     */
    private ?int $numberOfSlots = null;

    /**
     * @Assert\Url()
     * @var string|null
     */
    private ?string $photoUrl = null;

    /**
     * @Assert\Type("int")
     * @var int|null
     */
    private ?int $idUser = null;

    /**
     * @Assert\Type("int")
     * @var int|null
     */
    private ?int $idTournament = null;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
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
     * @return string|null
     */
    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    /**
     * @param string|null $photoUrl
     */
    public function setPhotoUrl(?string $photoUrl): void
    {
        $this->photoUrl = $photoUrl;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @param int|null $idUser
     */
    public function setIdUser(?int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdTournament(): int
    {
        return $this->idTournament;
    }

    /**
     * @param int|null $idTournament
     */
    public function setIdTournament(?int $idTournament): void
    {
        $this->idTournament = $idTournament;
    }
}