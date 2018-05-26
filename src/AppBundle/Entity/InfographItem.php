<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle_en", type="string", length=255, nullable=true)
     */
    private $subtitle_en;

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
    public function getSubtitleEn()
    {
        return $this->subtitle_en;
    }

    /**
     * @param string $subtitle_en
     */
    public function setSubtitleEn($subtitle_en)
    {
        $this->subtitle_en = $subtitle_en;
    }
    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return InfographItem
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }


    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->subtitle;

        else return $this->subtitle_en;
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




}

