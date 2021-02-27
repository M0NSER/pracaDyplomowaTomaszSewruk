<?php

declare(strict_types=1);

namespace App\Controller\AbstractClass;

use App\Service\TournamentPrivilegeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class CustomAbstractController extends AbstractController
{
    /**
     * @return array
     */
    public function getTournamentPrivilege(): array
    {
        return $this->getParameter('tournament_privilege');
    }
}