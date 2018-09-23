<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Utils\Utils;


trait GalleryFields
{
    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="galleryImage0_id", referencedColumnName="id", nullable=true)
     */
    private $galleryImage0;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="galleryImage1_id", referencedColumnName="id", nullable=true)
     */
    private $galleryImage1;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="galleryImage2_id", referencedColumnName="id", nullable=true)
     */
    private $galleryImage2;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="galleryImage3_id", referencedColumnName="id", nullable=true)
     */
    private $galleryImage3;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="galleryImage4_id", referencedColumnName="id", nullable=true)
     */
    private $galleryImage4;

    /**
     * @return mixed
     */
    public function getGalleryImage0()
    {
        return $this->galleryImage0;
    }

    /**
     * @param mixed $galleryImage0
     */
    public function setGalleryImage0($galleryImage0)
    {
        $this->galleryImage0 = $galleryImage0;
    }

    /**
     * @return mixed
     */
    public function getGalleryImage1()
    {
        return $this->galleryImage1;
    }

    /**
     * @param mixed $galleryImage1
     */
    public function setGalleryImage1($galleryImage1)
    {
        $this->galleryImage1 = $galleryImage1;
    }

    /**
     * @return mixed
     */
    public function getGalleryImage2()
    {
        return $this->galleryImage2;
    }

    /**
     * @param mixed $galleryImage2
     */
    public function setGalleryImage2($galleryImage2)
    {
        $this->galleryImage2 = $galleryImage2;
    }

    /**
     * @return mixed
     */
    public function getGalleryImage3()
    {
        return $this->galleryImage3;
    }

    /**
     * @param mixed $galleryImage3
     */
    public function setGalleryImage3($galleryImage3)
    {
        $this->galleryImage3 = $galleryImage3;
    }

    /**
     * @return mixed
     */
    public function getGalleryImage4()
    {
        return $this->galleryImage4;
    }

    /**
     * @param mixed $galleryImage4
     */
    public function setGalleryImage4($galleryImage4)
    {
        $this->galleryImage4 = $galleryImage4;
    }

    public function getGalleryImages()
    {
        $gallery = [];
        $images = [$this->galleryImage0,
            $this->galleryImage1,
            $this->galleryImage2,
            $this->galleryImage3,
            $this->galleryImage4];

        foreach ($images as $image)
        {
            if($image)
                $gallery[] = $image;
        }
        return $gallery;
    }
}
