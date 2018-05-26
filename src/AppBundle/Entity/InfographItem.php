<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Utils;
/**
 * InfographItem
 *
 * @ORM\Table(name="infograph_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InfographItemRepository")
 */
class InfographItem
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
     * @ORM\Column(name="icon", type="string", length=255)
     */
    private $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @return string
     */
    public function getIsservices()
    {
        return $this->isservices;
    }

    /**
     * @param string $isservices
     */
    public function setIsservices($isservices)
    {
        $this->isservices = $isservices;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="isservices", type="boolean", nullable=true)
     */
    private $isservices;

    /**
     * @var string
     *
     * @ORM\Column(name="title_en", type="string", length=255, nullable=true)
     */
    private $title_en;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=500, nullable=true)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="text_en", type="string", length=500, nullable=true)
     */
    private $text_en;

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
    public function getTitleEn()
    {
        return $this->title_en;
    }

    /**
     * @param string $title_en
     */
    public function setTitleEn($title_en)
    {
        $this->title_en = $title_en;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getTextEn()
    {
        return $this->text_en;
    }

    /**
     * @param string $text_en
     */
    public function setTextEn($text_en)
    {
        $this->text_en = $text_en;
    }




    /**
     * Get text
     *
     * @return string
     */
    public function getTextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->text;

        else return $this->text_en;
    }

    /**
     * Get text
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
     * @return mixed
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param mixed $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function __toString()
    {
        return $this->title;
    }


}

