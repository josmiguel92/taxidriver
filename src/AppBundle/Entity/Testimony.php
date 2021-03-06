<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Utils;
use AppBundle\Entity\ImageField;

/**
 * Testimony
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="testimony")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TestimonyRepository")
 */
class Testimony extends ImageField
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
     * @ORM\Column(name="text", type="string", length=600)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="texten", type="string", length=600)
     */
    private $texten;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;



    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;



    /**
     * @var string
     *
     * @ORM\Column(name="titleen", type="string", length=255, nullable=true)
     */
    private $titleen;



    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=500, nullable=true)
     */
    private $link;


    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;


    /**
     * @var Place
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Place")
     * @ORM\JoinColumn(name="targetPlace", referencedColumnName="id", nullable=true)
     */
    private $targetPlace;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Testimony
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Testimony
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

    function getTextLocale(){
        if(Utils::getRequestLocaleLang()=="es")
            return $this->text;
        return $this->texten;
    }

    /**
     * @return string
     */
    public function getTexten()
    {
        return $this->texten;
    }

    /**
     * @param string $texten
     */
    public function setTexten($texten)
    {
        $this->texten = $texten;
    }

    /**
     * @return Place
     */
    public function getTargetPlace()
    {
        return $this->targetPlace;
    }

    /**
     * @param Place $targetPlace
     */
    public function setTargetPlace($targetPlace)
    {
        $this->targetPlace = $targetPlace;
    }

    /**
     * @return Experience
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param Experience $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    /**
     * @return Transfer
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

    /**
     * @param Transfer $transfer
     */
    public function setTransfer($transfer)
    {
        $this->transfer = $transfer;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitleen()
    {
        return $this->titleen;
    }

    /**
     * @param string $titleen
     */
    public function setTitleen($titleen)
    {
        $this->titleen = $titleen;
    }


    function getTitleLocale(){
        if(Utils::getRequestLocaleLang()=="es")
            return $this->title;
        return $this->titleen;
    }


    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $points = $points > 5 ? 5 : $points;
        $points = $points < 1 ? 1 : $points;
        $this->points = $points;
    }



}

