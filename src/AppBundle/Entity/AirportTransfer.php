<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirportTransfer
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="airport_transfer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AirportTransferRepository")
 */
class AirportTransfer extends Service
{

    /**
     * @var Place
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Airport")
     * @ORM\JoinColumn(name="target_airport", referencedColumnName="id")
     */
    protected $targetAirport;



    /**
     * @return Place
     */
    public function getTargetAirport()
    {
        return $this->targetAirport;
    }

    /**
     * @param Airport $targetAirport
     */
    public function setTargetAirport(Airport $targetAirport)
    {
        $this->targetAirport = $targetAirport;
    }



    public function __toString()
    {
        return $this->getName();
    }

    public function getServiceType(){
        return 'AirportTransfer';
    }
}

