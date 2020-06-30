<?php
// src/AppBundle/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->classroom = new ArrayCollection();    }

    /**
     * @var string
     *
     * @ORM\Column(name="establishment", type="string", length=255, nullable=true)
     */
    private $establishment;

    /**
     * @ORM\ManyToMany(targetEntity=Classroom::class, inversedBy="users", cascade={"persist", "remove"})
     */
    private $classroom;


    /**
     * Set establishment
     *
     * @param string $establishment
     * @return User
     */
    public function setEstablishment($establishment) {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * Get establishment
     *
     * @return string
     */
    public function getEstablishment() {
        return $this->establishment;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return User
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return Collection|Classroom[]
     */
    public function getClassroom(): Collection
    {
        return $this->classroom;
    }

    public function addClassroom(Classroom $classroom): self
    {
        if (!$this->classroom->contains($classroom)) {
            $this->classroom[] = $classroom;
            $classroom->addUser($this);
        }

        return $this;
    }

    public function removeClassroom(Classroom $classroom): self
    {
        if ($this->classroom->contains($classroom)) {
            $this->classroom->removeElement($classroom);
            $classroom->removeUser($this);
        }

        return $this;
    }

  

}
