<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Boat", inversedBy="schedule")
     */
    private $boat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lunch", inversedBy="schedule")
     */
    private $lunch;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TimeSlot", inversedBy="schedule")
     */
    private $timeSlot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBoat(): ?Boat
    {
        return $this->boat;
    }

    public function setBoat(?Boat $boat): self
    {
        $this->boat = $boat;

        return $this;
    }

    public function getLunch(): ?Lunch
    {
        return $this->lunch;
    }

    public function setLunch(?Lunch $lunch): self
    {
        $this->lunch = $lunch;

        return $this;
    }

    public function getTimeSlot(): ?TimeSlot
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(?TimeSlot $timeSlot): self
    {
        $this->timeSlot = $timeSlot;

        return $this;
    }

    public function __construct($username , $email , $phone ,Boat $boat ,Lunch $lunch ,TimeSlot $timeSlot)
    {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setBoat($boat);
        $this->setLunch($lunch);
        $this->setTimeSlot($timeSlot);
    }

}
