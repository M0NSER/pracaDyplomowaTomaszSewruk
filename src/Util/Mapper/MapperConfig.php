<?php

namespace App\Util\Mapper;


use App\Dto\TournamentDto;
use App\Entity\Tournament;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class MapperConfig
 * @package App\Util\Mapper
 */
class MapperConfig implements MapperConfigInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var AutoMapperConfig
     */
    protected AutoMapperConfig $config;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->config = new AutoMapperConfig();
    }

    /**
     * @inheritDoc
     */
    public function build(): AutoMapperConfig
    {
        return $this
            ->buildTournamentMapping()
            ->config;
    }

    /**
     * Map TournamentDto => Tournament
     * Map Tournament => TournamentDto
     * @return MapperConfig
     */
    protected function buildTournamentMapping(): MapperConfig
    {
        $this->config
            ->registerMapping(TournamentDto::class, Tournament::class)
            ->reverseMap();

        return $this;
    }

}
