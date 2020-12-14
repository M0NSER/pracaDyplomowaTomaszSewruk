<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromoterChoices
 *
 * @ORM\Table(name="promoter_choices", indexes={@ORM\Index(name="fk_promoter_choices_tournament_users1_idx", columns={"id_promoter"}), @ORM\Index(name="fk_promoter_choices_tournament_users2_idx", columns={"id_student"})})
 * @ORM\Entity
 */
class PromoterChoices
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_promoter_choices", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromoterChoices;

    /**
     * @var \TournamentUsers
     *
     * @ORM\ManyToOne(targetEntity="TournamentUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_promoter", referencedColumnName="id_tournament_users")
     * })
     */
    private $idPromoter;

    /**
     * @var \TournamentUsers
     *
     * @ORM\ManyToOne(targetEntity="TournamentUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_student", referencedColumnName="id_tournament_users")
     * })
     */
    private $idStudent;

    public function getIdPromoterChoices(): ?int
    {
        return $this->idPromoterChoices;
    }

    public function getIdPromoter(): ?TournamentUsers
    {
        return $this->idPromoter;
    }

    public function setIdPromoter(?TournamentUsers $idPromoter): self
    {
        $this->idPromoter = $idPromoter;

        return $this;
    }

    public function getIdStudent(): ?TournamentUsers
    {
        return $this->idStudent;
    }

    public function setIdStudent(?TournamentUsers $idStudent): self
    {
        $this->idStudent = $idStudent;

        return $this;
    }


}
