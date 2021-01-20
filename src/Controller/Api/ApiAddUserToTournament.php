<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class ApiAddUserToTournament
 * @package App\Controller\Api
 */
class ApiAddUserToTournament
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/add-user-to-tournament", name="add-user-to-tournament")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = $request->query->get('q');
        $pageLimit = $request->query->getInt('page_limit', 5);
        $page = $request->query->getInt('page', 1);

        $result = $this->userRepository->filterByQuery($page, $pageLimit, $query);

        return new JsonResponse([
            'results' => $result,
            'more' => count($result) == $pageLimit,
        ]);
    }
}