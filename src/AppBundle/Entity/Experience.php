<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ImageField;
use AppBundle\Utils\Utils;
use AppBundle\Entity\Service;

/**
 * Experience
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="experience")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExperienceRepository")
 */
class Experience extends Service
{
    use GalleryFields;


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

    public function __toString()
    {
        return $this->getName();
    }

    public function getServiceType(){
        return 'Experience';
    }
}

