<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\RoomRepository;
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
    public function courses(CourseRepository $repository)
    {
        return $this->render('course/index.html.twig', ['courses' => $repository->findAll()]);
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

    /**
     * @Route("/rooms", methods={"GET"})
     */
    public function roomOverview(RoomRepository $repository)
    {
        return $this->render('admin/room_index.html.twig', ['rooms' => $repository->findAll()]);
    }
}
