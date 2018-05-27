<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Utils\Utils;
use AppBundle\Entity\ImageField;

/**
 * Blogentries
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="blogentries")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlogentrieRepository")
 */
class Blogentrie  extends ImageField
{
    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    /**
     * @return mixed
     */
    public function getSecondaryPicture()
    {
        return $this->secondaryPicture;
    }

    /**
     * @param mixed $secondaryPicture
     */
    public function setSecondaryPicture($secondaryPicture)
    {
        $this->secondaryPicture = $secondaryPicture;
    }
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
     * @ORM\Column(name="title", type="string", length=500)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="titleen", type="string", length=500)
     */
    private $titleEn;

    /**
     * @var string
     *
     * @ORM\Column(name="titleurl", type="string", length=250)
     */
    private $titleurl;

    /**
     * @var string
     *
     * @ORM\Column(name="titleurlen", type="string", length=250)
     */
    private $titleurlen;

    /**
     * @return string
     */
    public function getTitleurl()
    {
        return $this->titleurl;
    }

    /**
     * @param string $titleurl
     */
    public function setTitleurl($titleurl)
    {
        $this->titleurl = $titleurl;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $picture;


    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="secondImage_id", referencedColumnName="id")
     */
    private $secondaryPicture;

    /**
     * @var string
     *
     * @ORM\Column(name="teaser", type="text")
     */
    private $teaser;

    /**
     * @var string
     *
     * @ORM\Column(name="teaseren", type="text")
     */
    private $teaseren;

    /**
     * @var string
     *
     * @ORM\Column(name="posttext", type="text", nullable=true)
     */
    private $posttext;

    /**
     * @var string
     *
     * @ORM\Column(name="quote", type="text", nullable=true)
     */
    private $quote;

    /**
     * @var string
     *
     * @ORM\Column(name="quoteen", type="text", nullable=true)
     */
    private $quoteen;

    /**
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="posttexten", type="text", nullable=true)
     */
    private $posttexten;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publisheddate", type="datetime")
     */
    private $publisheddate;


    /**
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     */
    protected $tags;


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
     * @return string
     */
    public function getTitleen()
    {
        return $this->titleEn;
    }

    /**
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param string $quote
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    /**
     * @return string
     */
    public function getQuoteen()
    {
        return $this->quoteen;
    }

    /**
     * @param string $quoteen
     */
    public function setQuoteen($quoteen)
    {
        $this->quoteen = $quoteen;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @param string $titleEn
     */
    public function setTitleen($titleEn)
    {
        $this->titleEn = $titleEn;
    }

    /**
     * @return string
     */
    public function getTitleurlen()
    {
        return $this->titleurlen;
    }

    /**
     * @param string $titleurlen
     */
    public function setTitleurlen($titleurlen)
    {
        $this->titleurlen = $titleurlen;
    }

    /**
     * @return string
     */
    public function getTeaseren()
    {
        return $this->teaseren;
    }

    /**
     * @param string $teaseren
     */
    public function setTeaseren($teaseren)
    {
        $this->teaseren = $teaseren;
    }

    /**
     * @return string
     */
    public function getPosttexten()
    {
        return $this->posttexten;
    }

    /**
     * @param string $posttexten
     */
    public function setPosttexten($posttexten)
    {
        $this->posttexten = $posttexten;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Blogentries
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Blogentries
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function getImagePrimary()
    {
        return $this->getPicture();
    }

    public function getImageSecondary()
    {
        return $this->getSecondaryPicture();
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     *
     * @return Blogentries
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set posttext
     *
     * @param string $posttext
     *
     * @return Blogentries
     */
    public function setPosttext($posttext)
    {
        $this->posttext = $posttext;

        return $this;
    }

    /**
     * Get posttext
     *
     * @return string
     */
    public function getPosttext()
    {
        return $this->posttext;
    }

    /**
     * Set publisheddate
     *
     * @param \DateTime $publisheddate
     *
     * @return Blogentries
     */
    public function setPublisheddate($publisheddate)
    {
        $this->publisheddate = $publisheddate;

        return $this;
    }

    /**
     * Get publisheddate
     *
     * @return \DateTime
     */
    public function getPublisheddate()
    {
        return $this->publisheddate;
    }

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        return $this->publisheddate = new \DateTime();
    }

    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
    }
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    public function getTitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->title;
        return $this->titleEn;

    }

    public function getTitleUrlLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->titleurl;
        return $this->titleurlen;

    }

    public function getTeaserLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->teaser;
        return $this->teaseren;

    }

    public function getPostTextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->posttext;
        return $this->posttexten;

    }

    public function getQuoteLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->quote;
        return $this->quoteen;

    }
}

