<?php

declare(strict_types=1);

namespace App\Security\TournamentUserSecurity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class TournamentUserTypeFactory
 * @package App\Security\TournamentUserSecurity
 */
class TournamentUserTypeFactory extends AbstractController
{
    const RAW_T_ADMIN = 'Admin';
    const RAW_T_MODDER = 'T_MODDER';
    const RAW_T_VOTER = 'Student';
    const RAW_T_DELETED = 'Deleted';

    const TOURNAMENT_PRIVILEGE = [
        'T_ADMIN'   => 'T_ADMIN',
        'T_MODDER'  => 'T_MODDER',
        'T_VOTER'   => 'T_VOTER',
        'T_DELETED' => 'T_DELETED',
    ];

    const RAW_TOURNAMENT_PRIVILEGE = [
        'T_ADMIN'   => 'Admin',
        'T_MODDER'  => 'T_MODDER',
        'T_VOTER'   => 'Student',
        'T_DELETED' => 'Deleted',
    ];


}