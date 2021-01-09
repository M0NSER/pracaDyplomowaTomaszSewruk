<?php

namespace App\Controller;

use App\Dto\OptionInTournamentDto;
use App\Entity\OptionInTournament;
use App\Entity\Tournament;
use App\Form\OptionInTournamentType;
use App\Util\FlashBag\MessageFactory;
use App\Util\Mapper\Mapper;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 * Class OptionInTournamentController
 * @package App\Controller
 */
class OptionInTournamentController extends AbstractController
{
    /**
     * @var Mapper
     */
    private Mapper $mapper;

    /**
     * OptionInTournamentController constructor.
     *
     * @param Mapper $mapper
     */
    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @Route("option-in-tournament/show/{id}", name="option-in-tournament-show", requirements={"id"="\d+"})
     * @param OptionInTournament $optionInTournament
     *
     * @return Response
     */
    public function show(OptionInTournament $optionInTournament): Response
    {
        return $this->render('option_in_tournament/show.html.twig', [
            'optionInTournament' => $optionInTournament,
        ]);
    }

    /**
     * @Route("tournament/{tournament}/new-option", name="option-in-tournament-new", requirements={"tournament"="\d+"})
     * @param Request    $request
     * @param Tournament $tournament
     *
     * @return RedirectResponse|Response
     * @throws UnregisteredMappingException
     */
    public function new(Request $request, Tournament $tournament)
    {
        $optionInTournamentDto = new OptionInTournamentDto();

        $form = $this->createForm(OptionInTournamentType::class, $optionInTournamentDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var OptionInTournament $optionInTournament */
            $optionInTournamentDto->setIdUser($this->getUser()->getId());
            $optionInTournamentDto->setIdTournament($tournament->getId());
            $optionInTournament = $this->mapper->map($optionInTournamentDto, OptionInTournament::class);

            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($optionInTournament);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_NEW_SUCCESS'));

                return $this->redirectToRoute('option-in-tournament-show', ['id' => $optionInTournament->getId()]);
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_NEW_FAILURE'));
            }

            return $this->redirectToRoute('tournament', ['id' => $tournament->getId()]);
        }

        return $this->render('option_in_tournament/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("option-in-tournament/edit/{id}", name="option-in-tournament-edit", requirements={"tournament"="\d+"})
     * @param Request            $request
     * @param OptionInTournament $optionInTournament
     *
     * @return RedirectResponse|Response
     * @throws UnregisteredMappingException
     */
    public function edit(Request $request, OptionInTournament $optionInTournament)
    {
        /** @var OptionInTournamentDto $optionInTournamentDto */
        $optionInTournamentDto = $this->mapper->map($optionInTournament, OptionInTournamentDto::class);

        $form = $this->createForm(OptionInTournamentType::class, $optionInTournamentDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($optionInTournament);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_EDIT_SUCCESS'));
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_EDIT_FAILURE'));
            }

            return $this->redirectToRoute('option-in-tournament-show', ['id' => $optionInTournament->getId()]);
        }

        return $this->render('option_in_tournament/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
