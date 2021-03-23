<?php

namespace App\Controller;

use App\Controller\AbstractClass\CustomAbstractController;
use App\Entity\Tournament;
use App\Repository\TournamentRepository;
use App\Service\TournamentPrivilegeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends CustomAbstractController
{
    const REPORT_SEPARATOR = ";";

    /**
     * @var TournamentRepository
     */
    private TournamentRepository $tournamentRepository;

    /**
     * @var TournamentPrivilegeService
     */
    private TournamentPrivilegeService $tournamentPrivilegeService;

    public function __construct(TournamentRepository $tournamentRepository, TournamentPrivilegeService $tournamentPrivilegeService)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->tournamentPrivilegeService = $tournamentPrivilegeService;
    }

    /**
     * @Route("/report/{tournament}", name="report")
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return Response
     */
    public function index(Request $request, Tournament $tournament)
    {
        $this->tournamentPrivilegeService->hasPrivilegeToTournament($tournament, [
            $this->getTournamentPrivilege()['T_ADMIN'],
            $this->getTournamentPrivilege()['T_MODDER'],
        ]);

        $results = $this->tournamentRepository->getResultToCsv($tournament)->getResult();

        $response = new StreamedResponse();

        $titles = [
            '#',
            'First name',
            'Last name',
            'Email',
            'Tournament title',
            'Promoter name',
            'Priority',
            'Max Vote Priority',
        ];

        $response->setCallback(function () use ($titles, $results, $request) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, $titles, self::REPORT_SEPARATOR);

            foreach ($results as $counter => $result) {
                array_unshift($result, (string)($counter + 1));
                fputcsv($handle, $result, self::REPORT_SEPARATOR);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="tournament_%s.csv"', $tournament->getId()));

        return $response;
    }
}
