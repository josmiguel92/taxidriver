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
class Image
{
    private $temp;
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
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;



    function __construct($active = false)
    {
        $this->active = $active;
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
     */
    public function setTitleEn($title_en)
    {
        $this->title_en = $title_en;
        return $this;
    }

    /**
     * @param string $details_en
     */
    public function setDetailsEn($details_en)
    {
        $this->details_en = $details_en;
        return $this;
    }

    /**
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param string $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
        ? null
        : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
        ? null
        : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads';
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // si hay un error al mover el archivo, move() automáticamente
        // envía una excepción. This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            @unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            // haz lo que quieras para generar un nombre único
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

     /**
     * @ORM\PostRemove()
     */
     public function removeUpload()
     {
        if ($file = $this->getAbsolutePath()) {
            @unlink($file);
        }
    }
    /**
     * Set path
     *
     * @param string $path
     *
     * @return Imagen
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function __toString(){
        return $this->title;
    }
}
