<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * Class VotePriorityDto
 * @package App\Dto
 */
class VotePriorityDto
{
    /**
     * @var int
     */
    private int $priority;

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
}