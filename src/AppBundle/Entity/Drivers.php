<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drivers
 *
 * @ORM\Table(name="drivers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriversRepository")
 */
class Drivers
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
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="enterprisetitle", type="string", length=255)
     */
    private $enterprisetitle;

    /**
     * @var string
     *
     * @ORM\Column(name="jobdescription", type="string", length=255)
     */
    private $jobdescription;

    /**
     * TODO: OneToOne -> Image
     *
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;


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
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Drivers
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
     * Set enterprisetitle
     *
     * @param string $enterprisetitle
     *
     * @return Drivers
     */
    public function setEnterprisetitle($enterprisetitle)
    {
        $this->enterprisetitle = $enterprisetitle;

        return $this;
    }

    /**
     * Get enterprisetitle
     *
     * @return string
     */
    public function getEnterprisetitle()
    {
        return $this->enterprisetitle;
    }

    /**
     * Set jobdescription
     *
     * @param string $jobdescription
     *
     * @return Drivers
     */
    public function setJobdescription($jobdescription)
    {
        $this->jobdescription = $jobdescription;

        return $this;
    }

    /**
     * Get jobdescription
     *
     * @return string
     */
    public function getJobdescription()
    {
        return $this->jobdescription;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Drivers
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
}

