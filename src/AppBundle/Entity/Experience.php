<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ImageField;
use AppBundle\Utils\Utils;

/**
 * Experience
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="experience")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExperienceRepository")
 */
class Experience extends ImageField
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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="NameEn", type="string", length=255)
     */
    private $nameEn;

    /**
     * @var string
     *
     * @ORM\Column(name="Place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="PlaceEn", type="string", length=255)
     */
    private $placeEn;

    /**
     * @var string
     *
     * @ORM\Column(name="Price", type="text")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="PriceEn", type="text")
     */
    private $priceEn;

    /**
     * @var string
     *
     * @ORM\Column(name="PriceSumary", type="text", nullable=true)
     */
    private $priceSumary;

    /**
     * @var string
     *
     * @ORM\Column(name="PriceSumaryEn", type="text", nullable=true)
     */
    private $priceSumaryEn;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionEn", type="text", nullable=true)
     */
    private $descriptionEn;
  
     /**
     * @var bool
     *
     * @ORM\Column(name="external", type="boolean")
     */
    private $external;
  
    /**
     * @var string
     *
     * @ORM\Column(name="externalUrl", type="string", length=500, nullable=true)
     */
    private $externalUrl;

     /**
     * @var bool
     *
     * @ORM\Column(name="needtaxi", type="boolean")
     */
    private $needTaxi;


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
     * Set name
     *
     * @param string $name
     *
     * @return Experience
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Experience
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Experience
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set priceSumary
     *
     * @param string $priceSumary
     *
     * @return Experience
     */
    public function setPriceSumary($priceSumary)
    {
        $this->priceSumary = $priceSumary;

        return $this;
    }

    /**
     * Get priceSumary
     *
     * @return string
     */
    public function getPriceSumary()
    {
        return $this->priceSumary;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Experience
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return string
     */
    public function getPlaceEn()
    {
        return $this->placeEn;
    }

    /**
     * @param string $placeEn
     */
    public function setPlaceEn($placeEn)
    {
        $this->placeEn = $placeEn;
    }

    /**
     * @return string
     */
    public function getPriceEn()
    {
        return $this->priceEn;
    }

    /**
     * @param string $priceEn
     */
    public function setPriceEn($priceEn)
    {
        $this->priceEn = $priceEn;
    }

    /**
     * @return string
     */
    public function getPriceSumaryEn()
    {
        return $this->priceSumaryEn;
    }

    /**
     * @param string $priceSumaryEn
     */
    public function setPriceSumaryEn($priceSumaryEn)
    {
        $this->priceSumaryEn = $priceSumaryEn;
    }

    /**
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    /**
     * @param string $descriptionEn
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->descriptionEn = $descriptionEn;
    }


    /**
     * Get nameLocale
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
     * Get descriptionLocale
     *
     * @return string
     */
    public function getDescriptionLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->description;
        return $this->descriptionEn;
    }


    /**
     * Get placeLocale
     *
     * @return string
     */
    public function getPlaceLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->place;
        return $this->placeEn;
    }

    /**
     * Get priceLocale
     *
     * @return string
     */
    public function getPriceLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->price;
        return $this->priceEn;
    }

    /**
     * Get priceSummaryLocale
     *
     * @return string
     */
    public function getPriceSumaryLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->priceSumary;
        return $this->priceSumaryEn;
    }
  
    /**
     * Set External
     *
     * @param bool external
     *
     * @return Experience
     */
    public function setExternal($external)
    {
        $this->external = $external;

        return $this;
    }

    /**
     * Get External
     *
     * @return string
     */
    public function getExternal()
    {
        return $this->external;
    }
  
   /**
     * Set External
     *
     * @param bool external
     *
     * @return Experience
     */
    public function setExternalUrl($externalurl)
    {
        $this->externalUrl = $externalurl;

        return $this;
    }

    /**
     * Get External
     *
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }
  
  /**
     * Set NeedTaxi
     *
     * @param bool needtaxi
     *
     * @return Experience
     */
    public function setNeedTaxi($needtaxi)
    {
        $this->needTaxi = $needtaxi;

        return $this;
    }

    /**
     * Get NeedTaxi
     *
     * @return string
     */
    public function getNeedTaxi()
    {
        return $this->needTaxi;
    }

    public function __toString()
    {
        return $this->getName();
    }
}

