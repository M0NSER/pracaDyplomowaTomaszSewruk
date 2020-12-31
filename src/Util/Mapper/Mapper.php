<?php


namespace App\Util\Mapper;


use AutoMapperPlus\AutoMapper;

/**
 * Class Mapper
 * @package App\Util\Mapper
 */
class Mapper extends AutoMapper
{
    /**
     * @param MapperConfig $mapperConfig
     */
    public function __construct(MapperConfig $mapperConfig)
    {
        parent::__construct($mapperConfig->build());
    }
}
