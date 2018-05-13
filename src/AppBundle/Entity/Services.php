<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Services
 *
 * @ORM\Table(name="services")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServicesRepository")
 */
class Services
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="services", cascade={"persist"})
     */
    private $place;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time", nullable=true)
     */

    private $time;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;



    /**
     * @var bool
     *
     * @ORM\Column(name="istour", type="boolean")
     */
    private $istour;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set place
     *
     * @param array $place
     *
     * @return Services
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return array
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     *
     * @return Services
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Services
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Services
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Services
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set istour
     *
     * @param boolean $istour
     *
     * @return Services
     */
    public function setIstour($istour)
    {
        $this->istour = $istour;

        return $this;
    }

    /**
     * Get istour
     *
     * @return bool
     */
    public function getIstour()
    {
        return $this->istour;
    }



    function __toString()
    {
        $tmp = "";
        if($this->istour)
            $tmp = "[Tour]".$this->place;

        return $tmp;
    }
}

