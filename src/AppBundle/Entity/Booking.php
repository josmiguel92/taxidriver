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
     * @ORM\Column(name="place", type="integer")
     */
    private $place;

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
     * @var boolean
     * @ORM\Column(name="accepted", type="boolean", nullable=true)
     */
    private $accepted;

    /**
     * @var boolean
     * @ORM\Column(name="confirmed", type="boolean", nullable=true)
     */
    private $confirmed;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;


    function __construct()
    {
        $this->token = uniqid("bk".date("Ymd"));
    }


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
     * Set Place
     *
     * @param string $place
     *
     * @return Booking
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get Place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
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
        $this->pickuptime = \DateTime::createFromFormat('l d M Y - H:i',$pickuptime);

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

    /**
     * @return boolean
     */
    public function isAccepted()
    {
        return $this->accepted;
    }

    /**
     * @param boolean $accepted
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
    }

    /**
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param boolean $confirmed
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


}

