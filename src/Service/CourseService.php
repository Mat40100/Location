<?php

namespace App\Service;


use App\Entity\Course;
use App\Entity\Room;
use App\Entity\SlotTaken;
use App\Repository\SlotAllowedRepository;
use App\Repository\SlotTakenRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

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

        if ($slotTakenThisDay[0] === $slotTaken) {
            return true;
        }

        return false;
    }

    public function getAvailableSlot(\DateTime $dateTime, Room $room, ?Course $course)
    {
        $taken = $this->takenRepository->findBy(['slotDate' => $dateTime, 'room' => $room]);
        $allowed = $this->allowedRepository->findAll();

        foreach ($taken as $item => $value) {
            foreach ($allowed as $key => $object) {
                if ($value->getSlot()->getId() === $object->getId()) {
                    if ($course !== null) {
                        if ($object->getId() !== $course->getSlotTaken()->getSlot()->getId()) unset($allowed[$key]);
                    }else unset($allowed[$key]);
                }
            }
        }

        return $allowed;
    }

    public function checkForm(Form $form, Course $course)
    {
        if (!$this->checkSlotAvailable($course->getSlotTaken())) {
            $form->get('slotTaken')->get('slot')->addError(new FormError('Ce créneau n\'est plus disponibe, choisissez en un autre !'));
        }
        if ($course->getMaximumCustomerNumber() > $course->getSlotTaken()->getRoom()->getPlaces()) {
            $form->get('maximumCustomerNumber')->addError(new FormError(
                'Vous ne pouvez pas mettre plus de personnes que la salle ne peut en contenir'
            ));
        }

        return $form;
    }
}