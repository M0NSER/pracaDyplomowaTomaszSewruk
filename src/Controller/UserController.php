<?php

namespace App\Controller;

use App\Dto\UserEditDto;
use App\Form\UserType;
use App\Util\FlashBag\MessageFactory;
use App\Util\Mapper\Mapper;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    /**
     * @var Mapper
     */
    private Mapper $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @Route("/user-profile/edit", name="user-profile-edit")
     * @param Request       $request
     * @param UserInterface $user
     *
     * @return Response
     * @throws UnregisteredMappingException
     */
    public function edit(Request $request, UserInterface $user): Response
    {
        /** @var UserEditDto $userEditDto */
        $userEditDto = $this->mapper->map($user, UserEditDto::class);

        $form = $this->createForm(UserType::class, $userEditDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userValid = $this->mapper->mapToObject($userEditDto, $user);
            try {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', MessageFactory::getMessage('MESSAGE_USER_UPDATED_SUCCESS'));

                return $this->redirectToRoute('main');
            } catch (Exception $ex) {
                $this->addFlash('danger', MessageFactory::getMessage('MESSAGE_USER_UPDATED_FAILURE'));
            }
        }

        return $this->render('user/edit.html.twig', [
            'user'            => $user,
            'form'            => $form->createView(),
        ]);
    }
}
