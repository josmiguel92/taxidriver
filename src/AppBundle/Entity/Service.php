<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Place;
use AppBundle\Utils\Utils;

/**
 * Service
 *
 */
abstract class Service extends ImageField
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_es", type="string", length=255)
     */
    protected $nameEs;

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Place")
     * @ORM\JoinColumn(name="target_place", referencedColumnName="id", nullable=true)
     */
    protected $targetPlace;

    /**
     * @var float
     *
     * @ORM\Column(name="base_price", type="float", nullable=true)
     */
    protected $basePrice;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="description_en", type="text", nullable=true)
     */
    protected $descriptionEn;

    /**
     * @var integer
     * @ORM\Column(name="weight", type="integer", nullable=true)
     */
    protected $weight;


    /**
     * @var boolean
     * @ORM\Column(name="is_external_book", type="boolean", nullable=true)
     */
    protected $is_external_book;


    /**
     * @var integer
     * @ORM\Column(name="trekksoft_id", type="integer", nullable=true)
     */
    protected $trekksoft_id;


    /**
     * @var integer
     * @ORM\Column(name="trekksoft_tour_id", type="integer", nullable=true)
     */
    protected $trekksoft_tour_id;


    /**
     * @var boolean
     * @ORM\Column(name="is_personal_price", type="boolean", nullable=true)
     */
    protected $is_personal_price;


    /**
     * @var float
     *
     * @ORM\Column(name="personal_price_increment", type="float", nullable=true)
     */
    protected $personal_price_increment;



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
     * @return Service
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
     * Set nameEs
     *
     * @param string $nameEs
     *
     * @return Service
     */
    public function setNameEs($nameEs)
    {
        $this->nameEs = $nameEs;

        return $this;
    }

    /**
     * Get nameEs
     *
     * @return string
     */
    public function getNameEs()
    {
        return $this->nameEs;
    }

    /**
     * Set targetPlace
     *
     * @param Place $targetPlace
     *
     * @return Service
     */
    public function setTargetPlace(Place $targetPlace)
    {
        $this->targetPlace = $targetPlace;

        return $this;
    }

    /**
     * Get targetPlace
     *
     * @return string
     */
    public function getTargetPlace()
    {
        return $this->targetPlace;
    }

    /**
     * Set basePrice
     *
     * @param float $basePrice
     *
     * @return Service
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * Get basePrice
     *
     * @return float
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Service
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
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    /**
     * @param string $descriptionEs
     */
    public function setDescriptionEn($descriptionEn)
    {
        $this->descriptionEn = $descriptionEn;
    }



    /**
     * Get name
     *
     * @return string
     */
    public function getNameLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->nameEs;
        return $this->name;
    }


    /**
     * Get description
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
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }


    /**
     * @return bool
     */
    public function isExternalBook()
    {
        return $this->is_external_book;
    }

    /**
     * @param bool $is_external_book
     */
    public function setIsExternalBook($is_external_book)
    {
        $this->is_external_book = $is_external_book;
    }

    /**
     * @return int
     */
    public function getTrekksoftId()
    {
        return $this->trekksoft_id;
    }

    /**
     * @param int $trekksoft_id
     */
    public function setTrekksoftId($trekksoft_id)
    {
        $this->trekksoft_id = $trekksoft_id;
    }

    /**
     * @return int
     */
    public function getTrekksoftTourId()
    {
        return $this->trekksoft_tour_id;
    }

    /**
     * @param int $trekksoft_tour_id
     */
    public function setTrekksoftTourId($trekksoft_tour_id)
    {
        $this->trekksoft_tour_id = $trekksoft_tour_id;
    }

    /**
     * @return boolean
     */
    public function isIsPersonalPrice()
    {
        return $this->is_personal_price;
    }

    /**
     * @param boolean $is_personal_price
     */
    public function setIsPersonalPrice($is_personal_price)
    {
        $this->is_personal_price = $is_personal_price;
    }

    /**
     * @return float
     */
    public function getPersonalPriceIncrement()
    {
        return $this->personal_price_increment;
    }

    /**
     * @param float $personal_price_increment
     */
    public function setPersonalPriceIncrement($personal_price_increment)
    {
        $this->personal_price_increment = $personal_price_increment;
    }





    abstract function getServiceType();

}

