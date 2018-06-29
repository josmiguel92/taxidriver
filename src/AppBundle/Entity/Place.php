<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Utils;
use AppBundle\Entity\ImageField;

/**
 * Place
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 */
class Place extends ImageField
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=255)
     */
    private $nameEn;



    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }


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
     * @var float
     *
     * @ORM\Column(name="transferprice", type="float")
     */
    private $trasferprice;

    /**
     * @var bool
     *
     * @ORM\Column(name="istour", type="boolean")
     */
    private $istour;


    /**
     * @var int
     *
     * @ORM\Column(name="distance", type="float", nullable=true)
     */
    private $distance;

    //TODO: latlong and googlename no deben ser nullables en prod.env
    /**
     * @var int
     *
     * @ORM\Column(name="latlong", type="string", nullable=true)
     */
    private $latlong;

    /**
     * @var int
     *
     * @ORM\Column(name="googlename", type="string", nullable=true)
     */
    private $googlename;

    /**
     * @var string
     *
     * @ORM\Column(name="placedesc", type="text", nullable=true)
     */
    private $placedesc;

    /**
     * @var string
     *
     * @ORM\Column(name="placedesen", type="text", nullable=true)
     */
    private $placedescen;

    /**
     * @return string
     */
    public function getPlacedesc()
    {
        return $this->placedesc;
    }

    /**
     * @param string $placedesc
     */
    public function setPlacedesc($placedesc)
    {
        $this->placedesc = $placedesc;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getPlaceDescLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->placedesc;
        return $this->placedescen;
    }

    /**
     * @return string
     */
    public function getPlacedescen()
    {
        return $this->placedescen;
    }

    /**
     * @param string $placedescen
     */
    public function setPlacedescen($placedescen)
    {
        $this->placedescen = $placedescen;
    }





    /**
     * @return int
     */
    public function getGooglename()
    {
        return $this->googlename;
    }

    /**
     * @param int $googlename
     */
    public function setGooglename($googlename)
    {
        $this->googlename = $googlename;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getTrasferprice()
    {
        return $this->trasferprice;
    }

    /**
     * @param float $trasferprice
     */
    public function setTrasferprice($trasferprice)
    {
        $this->trasferprice = $trasferprice;
    }


    /**
     * @return bool
     */
    public function getistour()
    {
        return $this->istour;
    }

    /**
     * @param bool $istour
     */
    public function setIstour($istour)
    {
        $this->istour = $istour;
    }


    /**
     * @return int
     */
    public function getLatlong()
    {
        return $this->latlong;
    }

    /**
     * @param int $latlong
     */
    public function setLatlong($latlong)
    {
        $this->latlong = $latlong;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    function __toString()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Place
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getNameLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->name;
        return $this->nameEn;
    }

    /**
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * @param string $nameEn
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weigh
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}

