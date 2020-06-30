<?php

namespace App\Entity;

use App\Repository\ClassRoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassRoomRepository::class)
 * @ORM\Table(name="classroom")
 */
class Classroom
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Year;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="classroom")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="classrooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $school;


    /**
     * @ORM\OneToMany(targetEntity=Measure::class, mappedBy="classroom")
     */
    private $measures;

    /**
     * @ORM\OneToMany(targetEntity=Publication::class, mappedBy="classroom")
     */
    private $publications;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->measures = new ArrayCollection();
        $this->publications = new ArrayCollection();
		$this->publicMessages = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getYear(): ?string
    {
        return $this->Year;
    }

    public function setYear(string $Year): self
    {
        $this->Year = $Year;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        $users = $this->getUsers();

        foreach ($users as $user){

            if($user->getRoles() == "ROLE_TEACHER" || $user->getRoles() == "ROLE_ADMIN" || $user->getRoles() == "ROLE_SUPER_ADMIN"){
                return $user->getId();
            }else{
                $roles = $user->getRoles();
                foreach ($roles as $role){
                    if($role == "ROLE_TEACHER" || $role == "ROLE_ADMIN" || $role == "ROLE_SUPER_ADMIN"){
                        return $user->getId();
                    }
                }
            }

        }
        return null;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addClassroom($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeClassroom($this);
        }

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }

    /**
     * @return Collection|Measure[]
     */
    public function getMeasures(): Collection
    {
        return $this->measures;
    }

    public function addMeasure(Measure $measure): self
    {
        if (!$this->measures->contains($measure)) {
            $this->measures[] = $measure;
            $measure->setClassroom($this);
        }
    }
	/*
     * @return Collection|PublicMessage[]
     */
    public function getPublicMessages(): Collection
    {
        return $this->publicMessages;
    }

    public function addPublicMessage(PublicMessage $publicMessage): self
    {
        if (!$this->publicMessages->contains($publicMessage)) {
            $this->publicMessages[] = $publicMessage;
            $publicMessage->setIdClasseEmeteur($this);

        }

        return $this;
    }


    public function removeMeasure(Measure $measure): self
    {
        if ($this->measures->contains($measure)) {
            $this->measures->removeElement($measure);
            // set the owning side to null (unless already changed)
            if ($measure->getClassroom() === $this) {
                $measure->setClassroom(null);
            }
        }
    }

    public function removePublicMessage(PublicMessage $publicMessage): self
    {
        if ($this->publicMessages->contains($publicMessage)) {
            $this->publicMessages->removeElement($publicMessage);
            // set the owning side to null (unless already changed)
            if ($publicMessage->getIdClasseEmeteur() === $this) {
                $publicMessage->setIdClasseEmeteur(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Publication[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications[] = $publication;
            $publication->setClassroom($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->contains($publication)) {
            $this->publications->removeElement($publication);
            // set the owning side to null (unless already changed)
            if ($publication->getClassroom() === $this) {
                $publication->setClassroom(null);
            }
        }

        return $this;
    }
}
