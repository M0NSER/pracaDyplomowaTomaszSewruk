<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\OptionInTournament;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use App\Util\FlashBag\MessageFactory;
use Doctrine\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ModderSelectService
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @var FlashBag
     */
    private FlashBag $flashBag;

    /**
     * @var VoteRepository
     */
    private VoteRepository $voteRepository;

    public function __construct(EntityManager $entityManager, FlashBag $flashBag, VoteRepository $voteRepository)
    {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->voteRepository = $voteRepository;
    }

    /**
     * @param array $votesInOptionInTournament
     */
    public function setAsSelectedByModder(array $votesInOptionInTournament)
    {
        if (empty($votesInOptionInTournament)) {
            throw new UnauthorizedHttpException("Something wrong with selected people array");
        }

        /** @var OptionInTournament $currentIdOptionInTournament */
        $currentIdOptionInTournament = $votesInOptionInTournament[0]->getIdOptionInTournament();
        $alreadySelectedQuantity = $this->voteRepository->getCountSelectedVotesInOptionInTournament($currentIdOptionInTournament)->getSingleScalarResult();
        if (sizeof($votesInOptionInTournament) > $currentIdOptionInTournament->getNumberOfSlots() - $alreadySelectedQuantity) {
            $this->flashBag->add('warning', MessageFactory::getMessage('MESSAGE_YOU_HAVE_SELECTED_TOO_MUCH_PEOPLE'));

            return;
        }


        try {
            /** @var Vote $vote */
            foreach ($votesInOptionInTournament as $vote) {
                $vote
                    ->setIsSelectedByPromoter(true);

                $this->entityManager->persist($vote);
            }

            $this->entityManager->flush();
            $this->flashBag->add('success', MessageFactory::getMessage('MESSAGE_SUCCESSFULLY_SELECTED_PEOPLE'));

            return;
        } catch (Exception $e) {
            $this->flashBag->add('danger', MessageFactory::getMessage('MESSAGE_CAN_NOT_SELECT_SOME_PEOPLE'));

            return;
        }
    }

    /**
     * @param array $votesInOptionInTournament
     */
    public function setAsNotSelectedByModder(array $votesInOptionInTournament)
    {
        try {
            /** @var Vote $vote */
            foreach ($votesInOptionInTournament as $vote) {
                $vote
                    ->setIsSelectedByPromoter(false);

                $this->entityManager->persist($vote);
            }

            $this->entityManager->flush();
            $this->flashBag->add('success', MessageFactory::getMessage('MESSAGE_SUCCESSFULLY_UNSELECT_PEOPLE'));
        } catch (Exception $e) {
            $this->flashBag->add('danger', MessageFactory::getMessage('MESSAGE_PEOPLE_CAN_NOT_BE_UNSELECTED'));
        }
    }
}