<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlotTakenRepository")
 */
class SlotTaken
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SlotAllowed", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $slot;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Course", inversedBy="slotTaken", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\Column(type="date")
     */
    private $slotDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlot(): ?SlotAllowed
    {
        return $this->slot;
    }

    public function setSlot(SlotAllowed $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getSlotDate(): ?\DateTimeInterface
    {
        return $this->slotDate;
    }

    public function setSlotDate(\DateTimeInterface $slotDate): self
    {
        $this->slotDate = $slotDate;

        return $this;
    }
}
