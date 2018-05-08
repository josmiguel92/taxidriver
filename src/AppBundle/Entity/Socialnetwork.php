<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Socialnetwork
 *
 * @ORM\Table(name="socialnetwork")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocialnetworkRepository")
 */
class Socialnetwork
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="profilelink", type="string", length=255, unique=true)
     */
    private $profilelink;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;


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
     * Set name
     *
     * @param string $name
     *
     * @return Socialnetwork
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

    /**
     * Set profilelink
     *
     * @param string $profilelink
     *
     * @return Socialnetwork
     */
    public function setProfilelink($profilelink)
    {
        $this->profilelink = $profilelink;

        return $this;
    }

    /**
     * Get profilelink
     *
     * @return string
     */
    public function getProfilelink()
    {
        return $this->profilelink;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Socialnetwork
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}

