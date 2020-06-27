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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */

    private $title;
    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="Measure", mappedBy="report", cascade={"persist"})
     **/
    private $measures;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="publication")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     **/
    private $eleve;

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
     * @param Measure $measures
     * @return Publication
     */
    public function addMeasure(Measure $measures)
    {
        $this->measures->add($measures);
        $measures->setReport($this);
        return $this;
    }

    /**
     * $measures
     */
    public function removeMeasure(Measure $measures)
    {
        $this->measures->removeElement($measures);
        $measures->setReport(null);
    }

    /**
     * @return Collection
     */
    public function getMeasures()
    {
        return $this->measures;
    }

    /**
     * @param string $title
     * @return Publication
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $content
     * @return Publication
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getEleve()
    {
        return $this->eleve;
    }

    /**
     * @param User $eleve
     * @return Pulbicatoin
     */
    public function setEleve($eleve){
      $this->eleve = $eleve;
      return $this;
    }
}
