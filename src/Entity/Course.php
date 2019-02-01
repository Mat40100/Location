<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="joinedCourses")
     */
    private $customers;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $maximumCustomerNumber;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     * @Assert\NotNull()
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="courses")
     * @Assert\NotNull()
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="createdCourses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SlotTaken", mappedBy="course", cascade={"persist", "remove"})
     */
    private $slotTaken;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(User $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
        }

        return $this;
    }

    public function removeCustomer(User $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
        }

        return $this;
    }

    public function getMaximumCustomerNumber(): ?int
    {
        return $this->maximumCustomerNumber;
    }

    public function setMaximumCustomerNumber(int $maximumCustomerNumber): self
    {
        $this->maximumCustomerNumber = $maximumCustomerNumber;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getLeftPlace()
    {
        return $this->getMaximumCustomerNumber() - count($this->getCustomers());
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSlotTaken(): ?SlotTaken
    {
        return $this->slotTaken;
    }

    public function setSlotTaken(SlotTaken $slotTaken): self
    {
        $this->slotTaken = $slotTaken;

        // set the owning side of the relation if necessary
        if ($this !== $slotTaken->getCourse()) {
            $slotTaken->setCourse($this);
        }

        return $this;
    }
}
