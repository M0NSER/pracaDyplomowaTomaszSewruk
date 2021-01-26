<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use function GuzzleHttp\Promise\any;

/**
 * Class ModderSelectDto
 * @package App\Dto
 */
class ModderSelectDto
{
    /**
     * @Assert\NotNull
     * @Assert\NotBlank()
     * @var array|null
     */
    private ?array $votesInOptionInTournament=null;

    /**
     * @return array|null
     */
    public function getVotesInOptionInTournament(): ?array
    {
        return $this->votesInOptionInTournament;
    }

    /**
     * @param array|null $votesInOptionInTournament
     *
     * @return $this
     */
    public function setVotesInOptionInTournament(?array $votesInOptionInTournament): self
    {
        $this->votesInOptionInTournament = $votesInOptionInTournament;

        return $this;
    }


}