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
 */
class ImageField
{
    private $temp;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;



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

    public function getWebPath($size = "thumb")
    {
        if($size == "thumb")
            return $this->getUploadDir().'/'.$this->path.'-thumb.jpg';
        if($size == "wide")
            return $this->getUploadDir().'/'.$this->path.'-wide.jpg';
        else
            return $this->getUploadDir().'/'.$this->path;
    }

    public function getFullImageWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    public function getThumbnailWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path.'-thumb.jpg';
    }

    public function getWideImageWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path.'-wide.jpg';
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__ . '/../../../public_html/' .$this->getUploadDir();
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
        $this->createThumb();

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
            $this->removeThumbs();
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

    private function createThumb()
    {
        $image = @imagecreatefromjpeg($this->getAbsolutePath());
        $filename = $this->getAbsolutePath().'-thumb.jpg';

        $thumb_width = 270;
        $thumb_height = 270;

        $widefilename = $this->getAbsolutePath().'-wide.jpg';
        $widethumb_width = 1350;
        $widethumb_height = 760;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;
        $widethumb_aspect = $widethumb_width / $widethumb_height;

        if ( $original_aspect >= $thumb_aspect )
        {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        }
        else
        {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        if ( $original_aspect >= $widethumb_aspect )
        {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height_wide = $widethumb_width;
            $new_width_wide = $width / ($height / $widethumb_height);
        }
        else
        {
            // If the thumbnail is wider than the image
            $new_width_wide = $widethumb_width;
            $new_height_wide = $height / ($width / $widethumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
        $widethumb = imagecreatetruecolor( $widethumb_width, $widethumb_height );

// Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);

        imagecopyresampled($widethumb,
            $image,
            0 - ($new_width_wide - $widethumb_width) / 2, // Center the image horizontally
            0 - ($new_height_wide - $widethumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width_wide, $new_height_wide,
            $width, $height);

        @imagejpeg($thumb, $filename, 85);
        @imagejpeg($widethumb, $widefilename, 85);
    }

    public function removeThumbs()
    {
        if($file = $this->getAbsolutePath())
        {
            @unlink($file.'-thumb.jpg');
            @unlink($file.'-wide.jpg');
        }
    }

    public function updateThumbs(){
        $this->removeThumbs();
        $this->createThumb();
    }
}
