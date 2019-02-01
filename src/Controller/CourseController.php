<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Service\AllowService;
use App\Service\CourseService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/course")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findNextCourses(new \DateTime()),
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"})
     * @IsGranted("ROLE_CLIENT")
     */
    public function new(Request $request, CourseService $service): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$service->checkSlotAvailable($course->getSlotTaken())) {
                $form->get('slotTaken')->get('slot')->addError(new FormError('Ce créneau n\'est plus disponibe, choisissez en un autre !'));

                return $this->render('course/new.html.twig', [
                    'course' => $course,
                    'form' => $form->createView(),
                ]);
            }

            $course->setCreator($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            $this->addFlash('success', 'Votre cours à été créé.');

            return $this->redirectToRoute('app_course_index');
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET","POST"})
     * @IsGranted("ROLE_CLIENT")
     */
    public function edit(Request $request, Course $course, AllowService $service): Response
    {
        if (!$service->allowAccess($this->getUser(), $course->getCreator())) {
            $this->addFlash('danger', 'Vous n\' avez pas accès à ces fonctions');

            return $this->redirectToRoute('app_homepage_index');
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre cours a bien été modifié.');

            return $this->redirectToRoute('app_course_index', [
                'id' => $course->getId(),
            ]);
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     * @IsGranted("ROLE_CLIENT")
     */
    public function delete(Request $request, Course $course, AllowService $service): Response
    {
        if (!$service->allowAccess($this->getUser(), $course->getCreator())) {
            $this->addFlash('danger', 'Vous n\' avez pas accès à ces fonctions');

            return $this->redirectToRoute('app_homepage_index');
        }

        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Votre cours est supprimé.');

        return $this->redirectToRoute('app_course_index');
    }

    /**
     * @Route("/{id}/join")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function join(Course $course, CourseService $courseService)
    {
        if ($courseService->checkCustomerNumber($course) === false ) {
            $this->addFlash('warning', 'Ce cours est plein :(');

            return $this->redirectToRoute('app_course_show', ['id' => $course->getId()]);
        }

        $course->addCustomer($this->getUser());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Vous êtes inscrit à ce cours');
        # TODO : send email, link to the suscribe process ect...

        return $this->redirectToRoute('app_course_show', ['id' => $course->getId()]);
    }

    /**
     * @Route("/{id}/leave")
     * @IsGranted("ROLE_CUSTOMER")
     */
    public function leave(Course $course)
    {
        $course->removeCustomer($this->getUser());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Vous vous êtes désinscrit de ce cours.');
        # TODO : send email, link to the suscribe process ect...

        return $this->redirectToRoute('app_course_show', ['id' => $course->getId()]);
    }
}
