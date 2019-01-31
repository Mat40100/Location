<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("/admin")
 *@IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/courses")
     */
    public function courses()
    {
        $this->getDoctrine()->getRepository(Course::class)->findAll();

        return $this->render('course/index.html.twig');
    }

    /**
     * @Route("/users", methods={"GET"})
     */
    public function users(UserRepository $userRepository): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
