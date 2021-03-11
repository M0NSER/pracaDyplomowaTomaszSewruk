<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\OptionInTournament;
use App\Entity\User;

class VoteAdminDto
{
    private int $id;

    private bool $isSelectedByPromoter = false;

    private int $priority = 0;

    private ?DateTime $createAt = null;

    private ?DateTime $updateAt;

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
}