<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blogentries
 *
 * @ORM\Table(name="blogentries")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BlogentriesRepository")
 */
class Blogentries
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
     * @ORM\Column(name="title", type="string", length=500)
     */
    private $title;

    //TODO: OneToOne -> Image
    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="teaser", type="string", length=500)
     */
    private $teaser;

    /**
     * @var string
     *
     * @ORM\Column(name="posttext", type="text", nullable=true)
     */
    private $posttext;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publisheddate", type="datetime")
     */
    private $publisheddate;

    /**
     * @var array
     *
     * @ORM\Column(name="keywords", type="simple_array", nullable=true)
     */
    private $keywords;


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

    /**
     * Set keywords
     *
     * @param array $keywords
     *
     * @return Blogentries
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}

