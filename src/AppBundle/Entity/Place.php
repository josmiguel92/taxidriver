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
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

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
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;

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
     * @var int
     *
     * @ORM\Column(name="distance", type="integer", nullable=true)
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
     * @return bool
     */
    public function isIstour()
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

}

