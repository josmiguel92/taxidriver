<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 */
class Booking
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
     * @var bool
     *
     * @ORM\Column(name="airport", type="boolean", nullable=true)
     */
    private $airport;

    /**
     * @var integer
     * @ORM\Column(name="service", type="integer")
     */
    private $service;

    /**
     * @return array
     */
    public function getOwnroute()
    {
        return $this->ownroute;
    }

    /**
     * @param array $ownroute
     */
    public function setOwnroute($ownroute)
    {
        $this->ownroute = $ownroute;
    }

    /**
     * @return string
     */
    public function getTour()
    {
        return $this->tour;
    }

    /**
     * @param string $tour
     */
    public function setTour($tour)
    {
        $this->tour = $tour;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @var array
     * @ORM\Column(name="ownroute", type="simple_array", nullable=true)
     */
    private $ownroute;

    /**
     * @var string
     * @ORM\Column(name="tourservice", type="string", length=255)
     */
    private $tour;



    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;
    /**
     * @var string
     *
     * @ORM\Column(name="flynumber", type="string", length=255, nullable=true)
     */
    private $flynumber;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pickuptime", type="datetime")
     */
    private $pickuptime;

    /**
     * @var int
     *
     * @ORM\Column(name="burden", type="smallint")
     */
    private $burden;

    /**
     * @var int
     *
     * @ORM\Column(name="numpeople", type="smallint")
     */
    private $numpeople;


    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;


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
     * Set airport
     *
     * @param boolean $airport
     *
     * @return Booking
     */
    public function setAirport($airport)
    {
        $this->airport = $airport;

        return $this;
    }

    /**
     * Get airport
     *
     * @return bool
     */
    public function getAirport()
    {
        return $this->airport;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Booking
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Booking
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Booking
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set flynumber
     *
     * @param string $flynumber
     *
     * @return Booking
     */
    public function setFlynumber($flynumber)
    {
        $this->flynumber = $flynumber;

        return $this;
    }

    /**
     * Get flynumber
     *
     * @return string
     */
    public function getFlynumber()
    {
        return $this->flynumber;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Booking
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set pickuptime
     *
     * @param \DateTime $pickuptime
     *
     * @return Booking
     */
    public function setPickuptime($pickuptime)
    {
        $this->pickuptime = $pickuptime;

        return $this;
    }

    /**
     * Get pickuptime
     *
     * @return \DateTime
     */
    public function getPickuptime()
    {
        return $this->pickuptime;
    }

    /**
     * Set burden
     *
     * @param boolean $burden
     *
     * @return Booking
     */
    public function setBurden($burden)
    {
        $this->burden = $burden;

        return $this;
    }

    /**
     * Get burden
     *
     * @return bool
     */
    public function getBurden()
    {
        return $this->burden;
    }

    /**
     * Set numpeople
     *
     * @param integer $numpeople
     *
     * @return Booking
     */
    public function setNumpeople($numpeople)
    {
        $this->numpeople = $numpeople;

        return $this;
    }

    /**
     * Get numpeople
     *
     * @return int
     */
    public function getNumpeople()
    {
        return $this->numpeople;
    }
}

