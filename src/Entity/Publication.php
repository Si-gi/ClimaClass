<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 */
class Publication
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=TypeDonnee::class)
     */
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|TypeDonnee[]
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(TypeDonnee $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
        }

        return $this;
    }

    public function removeData(TypeDonnee $data): self
    {
        if ($this->data->contains($data)) {
            $this->data->removeElement($data);
        }

        return $this;
    }
}
