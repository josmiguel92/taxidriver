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


}

