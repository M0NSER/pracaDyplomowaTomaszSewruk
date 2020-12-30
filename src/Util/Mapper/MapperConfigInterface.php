<?php


namespace App\Util\Mapper;


use AutoMapperPlus\Configuration\AutoMapperConfig;

interface MapperConfigInterface
{
    /**
     * @return AutoMapperConfig
     */
    function build(): AutoMapperConfig;
}
