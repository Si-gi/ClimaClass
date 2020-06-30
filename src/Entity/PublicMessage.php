<?php

namespace App\Entity;

use App\Repository\PublicMessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicMessageRepository::class)
 */
class PublicMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class)
     * @ORM\JoinColumn(name="idClassEmeteur", referencedColumnName="id")
     */
    private $idClasseEmeteur;

    /**
     * @ORM\ManyToOne(targetEntity=Classroom::class)
     * @ORM\JoinColumn(name="idClasseDestinataire", referencedColumnName="id")
     */
    private $idClasseDestinataire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->idClasseDestinataire = new ArrayCollection();
        $this->idClasseEmeteur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }




    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdClasseEmeteur()
    {
        return $this->idClasseEmeteur;
    }

    public function setIdClasseEmeteur(?Classroom $idClasseEmeteur): self
    {
        $this->idClasseEmeteur = $idClasseEmeteur;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdClasseDestinataire()
    {
        return $this->idClasseDestinataire;
    }

    public function setIdClasseDestinataire(?Classroom $idClasseDestinataire): self
    {
        $this->idClasseDestinataire = $idClasseDestinataire;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
