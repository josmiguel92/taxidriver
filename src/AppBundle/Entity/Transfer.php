<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ImageField;
use AppBundle\Utils\Utils;

/**
 * Transfer
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="transfer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransferRepository")
 */
class Transfer extends Service
{

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
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

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
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    public function __toString()
    {
        return $this->getName();
    }
    public function getServiceType(){
        return 'Transfer';
    }
}

