<?php

namespace App\Controller;

use App\Entity\SlotAllowed;
use App\Form\SlotAllowedType;
use App\Repository\SlotAllowedRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slot")
 * @IsGranted("ROLE_ADMIN")
 */
class SlotAllowedController extends AbstractController
{
    /**
     * @Route("/", name="slot_allowed_index", methods={"GET"})
     */
    public function index(SlotAllowedRepository $slotAllowedRepository): Response
    {
        return $this->render('slot_allowed/index.html.twig', [
            'slot_alloweds' => $slotAllowedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="slot_allowed_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $slotAllowed = new SlotAllowed();
        $form = $this->createForm(SlotAllowedType::class, $slotAllowed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($slotAllowed);
            $entityManager->flush();

            return $this->redirectToRoute('slot_allowed_index');
        }

        return $this->render('slot_allowed/new.html.twig', [
            'slot_allowed' => $slotAllowed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slot_allowed_show", methods={"GET"})
     */
    public function show(SlotAllowed $slotAllowed): Response
    {
        return $this->render('slot_allowed/show.html.twig', [
            'slot_allowed' => $slotAllowed,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="slot_allowed_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SlotAllowed $slotAllowed): Response
    {
        $form = $this->createForm(SlotAllowedType::class, $slotAllowed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('slot_allowed_index', [
                'id' => $slotAllowed->getId(),
            ]);
        }

        return $this->render('slot_allowed/edit.html.twig', [
            'slot_allowed' => $slotAllowed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slot_allowed_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SlotAllowed $slotAllowed): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slotAllowed->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($slotAllowed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('slot_allowed_index');
    }
}
