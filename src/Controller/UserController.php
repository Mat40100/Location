<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\AllowService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/me", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function me(): Response
    {
        $user = $this->getUser();

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, User $user, AllowService $service): Response
    {
        if (!$service->allowAccess($this->getUser(), $user)) {
            $this->addFlash('danger', 'Vous n\' avez pas accès à ces fonctions');

            return $this->redirectToRoute('app_homepage_index');
        }

        $form = $this->createForm(UserType::class, $user)->remove('role');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_user_index', [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }

    /**
     * @Route("/{id}/inactivate", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function inactivate(Request $request, User $user, AllowService $service): Response
    {
        if (!$service->allowAccess($this->getUser(), $user)) {
            $this->addFlash('danger', 'Vous n\' avez pas accès à ces fonctions');

            return $this->redirectToRoute('app_homepage_index');
        }

        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setIsActive(false);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }
}
