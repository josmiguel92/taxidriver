<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Utils\Utils;

/**
 * Image
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image extends ImageField
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
     * @ORM\Column(name="title", type="string")
     */
    private $title;



    /**
     * @var string
     *
     * @ORM\Column(name="title_en", type="string")
     */
    private $title_en;

    /**
     * @var string
     *
     * @ORM\Column(name="details_es", type="string",  nullable=true)
     */
    private $details_es;

    /**
     * @var string
     *
     * @ORM\Column(name="details_en", type="string",  nullable=true)
     */
    private $details_en;

    /**
     * @var bool
     *
     * @ORM\Column(name="poster", type="boolean")
     */
    private $poster;

    /**
     * @return bool
     */
    public function isPoster()
    {
        return $this->poster;
    }

    /**
     * @param bool $poster
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
    }



    /**
     * @return string
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }

    /**
     * @return string
     */
    public function getDetailsEn()
    {
        return $this->details_en;
    }

    /**
     * @param string $title_en
     * @return Image
     */
    public function setTitleEn($title_en)
    {
        $this->title_en = $title_en;
        return $this;
    }

    /**
     * @param string $details_en
     * @return Image
     */
    public function setDetailsEn($details_en)
    {
        $this->details_en = $details_en;
        return $this;
    }




    /**
     * Get Translated title
     *
     * @return string
     */
    public function getTitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->title;
        else return $this->title_en;

    }


    /**
     * Get Translated details
     *
     * @return string
     */
    public function getDetailsLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->details_es;
        else $this->details_en;

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
     * Set title
     *
     * @param string $title
     *
     * @return Imagen
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
     * Set details_es
     *
     * @param string $details_es
     *
     * @return Imagen
     */
    public function setDetailsEs($details_es)
    {
        $this->details_es = $details_es;

        return $this;
    }

    /**
     * Get details_es
     *
     * @return string
     */
    public function getDetailsEs()
    {
        return $this->details_es;
    }


    public function __toString(){
        return $this->title;
    }
}
