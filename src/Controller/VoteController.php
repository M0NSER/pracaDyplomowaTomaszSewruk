<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\OptionInTournament;
use App\Entity\Vote;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VoteController
 * @package App\Controller
 */
class VoteController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * VoteController constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("vote/{id}/delete", name="vote-delete")
     * @param Vote $vote
     *
     * @return RedirectResponse
     */
    public function delete(Vote $vote): RedirectResponse
    {
        //TODO: zabezpieczyć jeśli konkurs minął
        try {
            $this->entityManager->remove($vote);
            $this->entityManager->flush();
            $this->addFlash('success', MessageFactory::getMessage('MESSAGE_VOTE_SUCCESSFULLY_DELETED'));
        } catch (Exception $ex) {
            $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_CAN_NOT_DELETE_VOTE'));
        }

        return $this->redirectToRoute('tournament-show', [
            'id' => $vote->getIdOptionInTournament()->getIdTournament()->getId(),
        ]);
    }
}
