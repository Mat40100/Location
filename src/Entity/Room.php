<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SlotTaken", mappedBy="room")
     */
    private $slotTaken;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->slotTaken = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|SlotTaken[]
     */
    public function getSlotTaken(): Collection
    {
        return $this->slotTaken;
    }

    public function addSlotTaken(SlotTaken $slotTaken): self
    {
        if (!$this->slotTaken->contains($slotTaken)) {
            $this->slotTaken[] = $slotTaken;
            $slotTaken->setRoom($this);
        }

        return $this;
    }

    public function removeSlotTaken(SlotTaken $slotTaken): self
    {
        if ($this->slotTaken->contains($slotTaken)) {
            $this->slotTaken->removeElement($slotTaken);
            // set the owning side to null (unless already changed)
            if ($slotTaken->getRoom() === $this) {
                $slotTaken->setRoom(null);
            }
        }

        return $this;
    }
}
