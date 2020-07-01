<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MeasureRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Measure
 *
 * @ORM\Table(name="measure")
 * @ORM\Entity(repositoryClass="App\Repository\MeasureRepository")
 */
class Measure
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="temperature", type="float", scale=2, nullable=true)
     */
    private $temperature;

    /**
     * @var float
     *
     * @ORM\Column(name="wind_speed", type="float", scale=2, nullable=true)
     */
    private $windSpeed;

    /**
     * @var integer
     *
     * @ORM\Column(name="wind_direction", type="integer", nullable=true)
     */
    private $windDirection;

    /**
     * @var integer
     *
     * @ORM\Column(name="rain_level", type="integer", nullable=true)
     */
    private $rainLevel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="measurement_date", type="datetime", nullable=true)
     */
    private $measurementDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="rain_measure_duration", type="integer",nullable=true)
     */
    private $rainMeasureDuration;


    /**
     * @ORM\OneToOne(targetEntity=Publication::class, mappedBy="measure", cascade={"persist", "remove"})
     */
    private $publication;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $temperature
     * @return Measure
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * @return float
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param float $windSpeed
     * @return Measure
     */
    public function setWindSpeed($windSpeed)
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    /**
     * @return float
     */
    public function getWindSpeed()
    {
        return $this->windSpeed;
    }

    /**
     * @param integer $windDirection
     * @return Measure
     */
    public function setWindDirection($windDirection)
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    /**
     * @return integer
     */
    public function getWindDirection()
    {
        return $this->windDirection;
    }

    /**
     * @param integer $rainLevel
     * @return Measure
     */
    public function setRainLevel($rainLevel)
    {
        $this->rainLevel = $rainLevel;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRainLevel()
    {
        return $this->rainLevel;
    }

    /**
     * @param \DateTime $measurementDate
     * @return Measure
     */
    public function setMeasurementDate($measurementDate)
    {
        $this->measurementDate = $measurementDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getMeasurementDate()
    {
        return $this->measurementDate;
    }

    /**
     * @param Publication $report
     * @return Measure
     */
    public function setReport(Publication $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * @return Publication
     */
    public function getReport()
    {
        return $this->publication;
    }


    /**
     * @param integer $rainMeasureDuration
     * @return Measure
     */
    public function setRainMeasureDuration($rainMeasureDuration)
    {
        $this->rainMeasureDuration = $rainMeasureDuration;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRainMeasureDuration()
    {
        return $this->rainMeasureDuration;
    }


    public function getPublication(): ?Publication
    {
        return $this->publication;
    }

    public function setPublication(?Publication $publication): self
    {
        $this->publication = $publication;

        // set (or unset) the owning side of the relation if necessary
        $newMeasure = null === $publication ? null : $this;
        if ($publication->getMeasure() !== $newMeasure) {
            $publication->setMeasure($newMeasure);
        }

        return $this;
    }
}
