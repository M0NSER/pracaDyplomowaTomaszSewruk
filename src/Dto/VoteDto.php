<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class VotePriorityDto
 * @package App\Dto
 */
class VoteDto
{
    /**
     * @Assert\NotNull
     * @Assert\GreaterThan(0)
     * @var int|null
     */
    private ?int $priority=null;

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int|null $priority
     */
    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }


}