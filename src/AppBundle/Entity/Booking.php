<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Utils\Utils;
use AppBundle\Entity\Place;
use AppBundle\Entity\Experience;
use AppBundle\Entity\Transfer;
use AppBundle\Entity\AirportTransfer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Booking
{
    /**tasas de cambio, la base es el euro*/
    CONST EUR_TO_USD = 1.20;
    CONST EUR_TO_CUC = 1.08;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Assert\NotBlank()
     * @ORM\Column(name="bookingTime", type="datetime")
     */
    private $bookingTime;

    /**
     * @ORM\Column(name="changeRate", type="array", nullable=true)
     */
    private $changeRate;

    /**
     * @var string
     *
     * @ORM\Column(name="airport", type="string", length=255, nullable=true)
     */
    private $airport;

    /**
     * @var Airport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Airport")
     * @ORM\JoinColumn(name="airportname", referencedColumnName="id", nullable=true)
     */
    private $airportName;

    /**
     * @var Place
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Place")
     * @ORM\JoinColumn(name="targetPlace", referencedColumnName="id", nullable=true)
     */
    private $targetPlace;

    /**
     * @var integer
     * @ORM\Column(name="place", type="integer", nullable=true)
     */
    private $place;

    /**
     * @var AirportTransfer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AirportTransfer")
     * @ORM\JoinColumn(name="airportTransfer", referencedColumnName="id", nullable=true)
     */
    private $airportTransfer;


    /**
     * @var Experience
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Experience")
     * @ORM\JoinColumn(name="experience", referencedColumnName="id", nullable=true)
     */
    private $experience;



    /**
     * @var Transfer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transfer")
     * @ORM\JoinColumn(name="transfer", referencedColumnName="id", nullable=true)
     */
    private $transfer;

    /**
     * @var array
     * @ORM\Column(name="ownroute", type="string", nullable=true)
     */
    private $ownroute;

    /**
     * @var string
     * @ORM\Column(name="tourservice", type="boolean", nullable=true)
     */
    private $tour;



    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="flynumber", type="string", length=255, nullable=true)
     */
    private $flynumber;

    /**
     * @var string
     * Lugar de recogida
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @Assert\NotBlank()
     * @ORM\Column(name="pickuptime", type="datetime")
     */
    private $pickuptime;
    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="payedDate", type="datetime", nullable=true)
     */
    private $payedDate;

    /**
     * @var boolean
     * @ORM\Column(name="returnpickup", type="boolean")
     */
    private $returnpickup;

    /**
     * @var boolean
     * @ORM\Column(name="experience_taxi", type="boolean")
     */
    private $experienceTaxi;

    /**
     * @var boolean
     * @ORM\Column(name="experience_time", type="integer", nullable=true)
     */
    private $experienceTime;

    /**
     * @var bool
     *
     * @ORM\Column(name="toAirport", type="boolean", nullable=true)
     */
    private $toAirport;

    /**
     * @var string
     * @ORM\Column(name="timelinetravel", type="text", nullable=true)
     */
    private $timelinetravel;

    /**
     * @var bool
     *
     * @ORM\Column(name="children", type="boolean", nullable=true)
     */
    private $children;

    /**
     * @var string
     * @ORM\Column(name="bookingLanguage", type="string", nullable=true)
     */
    private $bookingLanguage;

    /**
     * @var string
     * @ORM\Column(name="paymentDetails", type="text", nullable=true)
     */
    private $paymentDetails;


    /**
     * @var bool
     *
     * @ORM\Column(name="payed", type="boolean", nullable=false)
     */
    private $payed;

    /**
     * @var string
     * @ORM\Column(name="drivername", type="text", nullable=true)
     */
    private $drivername;

    /**
     * @var string
     * @ORM\Column(name="bookingSource", type="string", length=255, nullable=true)
     */
    private $bookingSource;

    /**
     * @Assert\Choice(choices = {"CUC", "USD", "EUR"}, message = "Select currency")
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $currency;

    /**
     * @var bool
     *
     * @ORM\Column(name="stared", type="boolean", nullable=true)
     */
    private $stared;

    public function getCurrency()
    {
        if($this->currency)
            return $this->currency;
        else
            return 'EUR';
    }

    public function setCurrency($currency = 'EUR')
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimelinetravel()
    {
        return $this->timelinetravel;
    }

    /**
     * @param string $timelinetravel
     * @return Booking
     */
    public function setTimelinetravel($timelinetravel)
    {
        $this->timelinetravel = $timelinetravel;
        return $this;
    }

    /**
     * @return bool
     */
    public function isChildren()
    {
        return $this->children;
    }

    /**
     * @param bool $children
     * @return Booking
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return string
     */
    public function getBookingLanguage()
    {
        return $this->bookingLanguage;
    }

    /**
     * @param string $bookingLanguage
     * @return Booking
     */
    public function setBookingLanguage($bookingLanguage)
    {
        $this->bookingLanguage = $bookingLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * @param string $paymentDetails
     * @return Booking
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
        return $this;
    }

    /**
     * @return string
     */
    public function getDrivername()
    {
        return $this->drivername;
    }

    /**
     * @param string $drivername
     * @return Booking
     */
    public function setDrivername($drivername)
    {
        $this->drivername = $drivername;
        return $this;
    }



    /**
     * @return \DateTime
     */
    public function getBookingTime()
    {
        return $this->bookingTime;
    }

    /**
     * @param \DateTime $bookingTime
     * @return Booking
     */
    public function setBookingTime($bookingTime)
    {
        $this->bookingTime = $bookingTime;
        return $this;
    }



    /**
     * @return bool
     */
    public function isToAirport()
    {
        return $this->toAirport;
    }

    /**
     * @param bool $toAirport
     */
    public function setToAirport($toAirport)
    {
        $this->toAirport = $toAirport;
    }

    /**
     * @return bool
     */
    public function isReturnpickup()
    {
        return $this->returnpickup;
    }

    /**
     * @param bool $returnpickup
     */
    public function setReturnpickup($returnpickup)
    {
        $this->returnpickup = $returnpickup;
    }

    /**
     * @var \DateTime
     * @Assert\DateTime()
     * @ORM\Column(name="returnpickuptime", type="datetime", nullable=true)
     */
    private $returnpickuptime;

    /**
     * @var \DateTime
     * @ORM\Column(name="returnpickupplacce", type="string", length=600, nullable=true)
     */
    private $returnpickupplacce;


    /**
     * @var int
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="numpeople", type="smallint")
     */
    private $numpeople;

    /**
     * @var int
     * @Assert\GreaterThan(0)
     * @ORM\Column(name="price", type="float", nullable=true, )
     */
    private $price;


    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
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
     * @var boolean
     * @ORM\Column(name="idpaypal", type="string", length=255, nullable=true)
     */
    private $idpaypal;


    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(name="drivermsg", type="string", length=1000, nullable=true)
     */
    private $drivermsg;

    /**
     * @var int
     * @ORM\Column(name="telephone", type="string", length=30, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     * @ORM\Column(name="serviceType", type="string", length=30)
     */
    private $serviceType;

    public function getServiceLocaleName(){
        if($service = $this->getCurrentService())
            return $service->getNameLocale();
    }

    public function getServiceImage($size){
        if($service = $this->getCurrentService())
            return $service->getWebPath($size);
    }

    public function getCurrentService(){
        $service = null;

        if($this->experience)
            $service = $this->experience;

        elseif($this->airportTransfer)
            $service = $this->airportTransfer;

        elseif($this->transfer)
            $service = $this->transfer;

        if($service)
        return $service;
    }

    public function getBookingLocale()
    {
        return substr($this->token, 0, 2);
    }

    function __construct($changeRate = null)
    {
        $this->token =  "TDC-".date("dm")."-".substr(uniqid("", true),8,4);
        $this->ownroute = new ArrayCollection();
        $this->setAccepted(false);
        $this->setConfirmed(false);
        $this->setBookingTime(new \DateTime('now'));
        $this->payed = false;

        if($changeRate)
            $this->changeRate = $changeRate;
        else
            $this->changeRate = $this->getInitRates();

    }

    /**
     * @return \DateTime
     */
    public function getPayedDate()
    {
        return $this->payedDate;
    }

    /**
     * @param \DateTime $payedDate
     */
    public function setPayedDate($payedDate)
    {
        $this->payedDate = $payedDate;
    }


    /**
     * @return bool
     */
    public function isPayed()
    {
        return $this->payed;
    }

    /**
     * @param bool $payed
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;
    }


    /**
     * @return Airport
     */
    public function getAirportName()
    {
        return $this->airportName;
    }

    /**
     * @param string $airportName
     */
    public function setAirportName($airportName)
    {
        $this->airportName = $airportName;
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
    public function getDrivermsg()
    {
        return $this->drivermsg;
    }

    /**
     * @param string $drivermsg
     */
    public function setDrivermsg($drivermsg)
    {
        $this->drivermsg = $drivermsg;
    }

    
    /**
     * @return string
     */
    public function getIdpaypal()
    {
        return $this->idpaypal;
    }

    /**
     * @param array $idpaypal
     */
    public function setIdpaypal($idpaypal)
    {
        $this->idpaypal = $idpaypal;
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
     * @return \AppBundle\Entity\Place
     */
    public function getTargetPlace()
    {
        return $this->targetPlace;
    }

    /**
     * @param \AppBundle\Entity\Place $targetPlace
     */
    public function setTargetPlace($targetPlace)
    {
        $this->targetPlace = $targetPlace;
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

        if(gettype($pickuptime)=='string')
            $_pickuptime = \DateTime::createFromFormat('l d M Y - H:i',$pickuptime);
        else
            $_pickuptime = $pickuptime;
        
        //check if the pickupdate is at least 2 days in the future
        $limit = new \DateTime('now + 12 hours');
        $interval = $limit->diff($_pickuptime);
        if( $interval->format('%a') >= 0 )
            $this->pickuptime = $_pickuptime;
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
     * @return \DateTime
     */
    public function getReturnpickuptime()
    {
        return $this->returnpickuptime;
    }

    /**
     * @param \DateTime $returnpickuptime
     */
    public function setReturnpickuptime($returnpickuptime)
    {
        if(gettype($returnpickuptime)=='string')
            $this->returnpickuptime = \DateTime::createFromFormat('l d M Y - H:i',$returnpickuptime);
        else
            $this->returnpickuptime = $returnpickuptime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReturnpickupplacce()
    {
        return $this->returnpickupplacce;
    }

    /**
     * @param \DateTime $returnpickupplacce
     */
    public function setReturnpickupplacce($returnpickupplacce)
    {
        $this->returnpickupplacce = $returnpickupplacce;
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
        if($this->accepted == null)
            $this->accepted = false;
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
     * @return string
     */
    public function getOrderNumber()
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

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price, $base_prices=false)
    {
        //if($base_prices)
            $this->price = $price;
       // else
         //   $this->price = $this->getBasePriceByCurrency($price);
    }


    public function ownrouteFormated(){
        $places = explode('|', $this->ownroute);
        array_pop($places);
        return $places;
    }

    public function isTour(){
        return $this->tour;
    }

    public function getPickuptimeFormated($format = 'd-M-Y'){
        if(gettype($this->pickuptime)=='object')
            return $this->pickuptime->format($format);
        return null;
    }

    public function getReturnPickuptimeFormated($format = 'd-M-Y'){
        if(gettype($this->returnpickuptime)=='object')
            return $this->returnpickuptime->format($format);
        return null;
    }

    public function isAnAirport(){
        if ($this->airport=='airport')
            return true;
        return false;
    }

    public function isACruise(){
        if ($this->airport=='cruise')
            return true;
        return false;
    }

    /**
     * @return string
     */
    public function getBookingSource()
    {
        return $this->bookingSource;
    }

    /**
     * @param string $bookingSource
     */
    public function setBookingSource($bookingSource = 'webtaxidrivers')
    {
        $this->bookingSource = $bookingSource;
    }



    public function isPickuptime(){
        $now = new \DateTime('now');
        $interval = $now->diff($this->pickuptime);
        $differenceHours = $interval->y*365*24+$interval->m*30*24+$interval->d*24+$interval->h;
        if($differenceHours >= 12 )
            return true;
        return false;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param Experience $experience
     */
    public function setExperience(Experience $experience)
    {
        $this->experience = $experience;
    }

    /**
     * @return int
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * @param Transfer $transfer
     */
    public function setTransfer(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    /**
     * @return int
     */
    public function getAirportTransfer()
    {
        return $this->airportTransfer;
    }

    /**
     * @param AirportTransfer $airportTransfer
     */
    public function setAirportTransfer(AirportTransfer $airportTransfer)
    {
        $this->airportTransfer = $airportTransfer;
    }


    /**
     * @return bool
     */
    public function isExperienceTaxi()
    {
        return $this->experienceTaxi;
    }

    /**
     * @param bool $experienceTaxi
     */
    public function setExperienceTaxi($experienceTaxi)
    {
        $this->experienceTaxi = $experienceTaxi;
    }

    /**
     * @return bool
     */
    public function getExperienceTime()
    {
        return $this->experienceTime;
    }

    /**
     * @param bool $experienceTime
     */
    public function setExperienceTime($experienceTime)
    {
        $this->experienceTime = $experienceTime;
    }


    public function isExperience()
    {
        if($this->experience != null)
           return true;
        return false;
    }

    /**
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param int $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * @param string $serviceType
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
    }


    public function calculateSimplePrice($increment = 8.8)
    {

        $basePrice = 0;
        if($service_increment = $this->getCurrentService()->getPersonalPriceIncrement())
            $increment = $service_increment;

        if($this->transfer)
        {
            $basePrice = $this->transfer->getBasePrice();
        }
        if($this->experience)
        {
            $basePrice = $this->experience->getBasePrice();
        }
        if($this->airportTransfer)
        {
            if($this->targetPlace)
            {

                $airportIdentifier = $this->airportName->machineName();
                $airportIdentifier = str_replace('_airportname_','_airportprice_',$airportIdentifier);

                $basePrice =$this->targetPlace->__get($airportIdentifier);
            }
            else
                $basePrice = $this->airportTransfer->getBasePrice();
        }
        if(!$basePrice)
            return false;
        $min_invariable_numberPeople = $this->getCurrentService()->isIsPersonalPrice() ? 1 : 3;

        $plusPrice = $this->numpeople <= $min_invariable_numberPeople ? 0 : ($this->numpeople-$min_invariable_numberPeople)*$increment;
        $price = $basePrice + $plusPrice;
        return $price;
    }

    public function getPriceByCurrency($price = null)
    {
        $rates = $this->getChangeRate();
        if(!$price)
            $price = $this->price;

        //dump(['price'=>$this->price, 'rates'=>$rates, 'currency'=>$this->currency]);
        if( $this->currency )
           return round($price * $rates[$this->currency], 2);
        return round($price, 2);
    }

    public function getBasePriceByCurrency($price)
    {
        $rates = $this->getChangeRate();
        
        if( $this->currency )
           return round($price / $rates[$this->currency], 2);
        return round($price, 2);
    }
    public function getEventColor()
    {
        //for use in dashboard calendar API
        if($this->transfer)
            return "#66dd66";
        if($this->experience)
            return "#dd6666";
        if($this->airportTransfer)
            return "#6666dd";
    }

    public function getInternalDescription()
    {
        $text = "";
        if($this->experience)
            $text .= $this->getExperience()->getName() . "(" . $this->getExperience()->getTargetPlace() . ")";

        elseif($this->transfer)
            $text .= $this->transfer->getTargetPlace();

        elseif ($this->airportTransfer) {
            $text .= $this->getAirportName();
        }

        return $text .= "(".$this->getPriceByCurrency()." ".$this->getCurrency().")";
      
    }

    /**
     * @return string
     */
    public function getChangeRate($currency = null)
    {
        $rates = $this->changeRate ? $this->changeRate : $this->getInitRates();

        if($currency)
            return $rates[$currency];
        return $rates;
    }

    /**
     * @param string $serviceType
     */
    public function setChangeRate($changeRate)
    {
        $this->changeRate = $changeRate;
    }

    public function getInitRates()
    {
        return ['USD' => self::EUR_TO_USD, 'CUC' => self::EUR_TO_CUC, 'EUR'=> 1];
    }

    public function UpdatePriceByCurrency()
    {

       $this->price = $this->getBasePriceByCurrency($this->price );
      // dump( [$this->price, $this->currency] );
    }

    /**
     * @return bool
     */
    public function isStared()
    {
        return $this->stared;
    }

    /**
     * @param bool $stared
     */
    public function setStared($stared)
    {
        $this->stared = $stared;
    }
}

