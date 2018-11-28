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
    use GalleryFields;
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_en", type="string", length=255)
     */
    private $nameEn;

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

