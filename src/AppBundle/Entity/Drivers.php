<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils\Utils;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Drivers
 * @ORM\HasLifecycleCallbacks
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
     * @var string
     *
     * @ORM\Column(name="jobdescriptionen", type="string", length=255)
     */
    private $jobdescriptionen;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;



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
     * @return string
     */
    public function getJobdescriptionen()
    {
        return $this->jobdescriptionen;
    }

    /**
     * @param string $jobdescriptionen
     */
    public function setJobdescriptionen($jobdescriptionen)
    {
        $this->jobdescriptionen = $jobdescriptionen;
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

    public function getJobdescriptionLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->jobdescription;
        return $this->jobdescriptionen;

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
}
