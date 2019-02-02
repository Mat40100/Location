<?php

namespace App\Service;


use App\Entity\Course;
use App\Entity\Room;
use App\Entity\SlotTaken;
use App\Repository\SlotAllowedRepository;
use App\Repository\SlotTakenRepository;

class CourseService
{
    private $takenRepository;

    private $allowedRepository;

    public function __construct(SlotAllowedRepository $allowedRepository, SlotTakenRepository $takenRepository)
    {
        $this->takenRepository = $takenRepository;
        $this->allowedRepository = $allowedRepository;

    }

    /**
     * @param Course $course
     * @return bool
     */
    public function checkCustomerNumber(Course $course)
    {
        if (count($course->getCustomers()) < $course->getMaximumCustomerNumber()) {
            return true;
        }

        return false;
    }

    public function checkSlotAvailable(SlotTaken $slotTaken)
    {
        $slotTakenThisDay = $this->takenRepository->findBy(['slotDate' => $slotTaken->getSlotDate(), 'slot' => $slotTaken->getSlot(), 'room' => $slotTaken->getRoom()]);

        if (empty($slotTakenThisDay)) {
            return true;
        }

        return false;
    }

    public function getAvailableSlot(\DateTime $dateTime, Room $room)
    {
        $taken = $this->takenRepository->findBy(['slotDate' => $dateTime, 'room' => $room]);
        $allowed = $this->allowedRepository->findAll();

        foreach ($taken as $item => $value) {
            foreach ($allowed as $key => $object) {
                if ($value->getSlot()->getId() === $object->getId()) {
                    unset($allowed[$key]);
                }
            }
        }

        return $allowed;
    }
}