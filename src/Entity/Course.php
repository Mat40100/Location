<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="courses")
     */
    private $customers;

    /**
     * @ORM\Column(type="integer")
     */
    private $maximumCustomerNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CourseDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="courses")
     */
    private $room;

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

    public function getCourseDate(): ?\DateTimeInterface
    {
        return $this->CourseDate;
    }

    public function setCourseDate(\DateTimeInterface $CourseDate): self
    {
        $this->CourseDate = $CourseDate;

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
}
