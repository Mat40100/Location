<?php

namespace App\Controller;

use App\Entity\Room;
use App\Service\CourseService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax")
 */
class SlotTakenController extends AbstractController
{
    /**
     * @Route("/course/date/{date}/{room}")
     */
    public function getAvailableSlot(\DateTime $date, Room $room,Request $request, CourseService $service)
    {
        if (!$request->isXmlHttpRequest()) {

            return new HttpException( '403', 'wrong request');
        }

        $available = $service->getAvailableSlot($date, $room);

        sleep(0.5);

        return $this->render('course/slot_ajax.html.twig', ['available' => $available]);
    }

    /**
     * @Route("/room/{room}/max")
     */
    public function getMaxCustomer(Room $room, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {

            return new HttpException( '403', 'wrong request');
        }

        sleep(0.5);

        return new JsonResponse(['data' => $room->getPlaces()]);
    }
}
