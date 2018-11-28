<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Place;
use AppBundle\Utils\Utils;

/**
 * Service
 *
 */
class Service extends ImageField
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

}

