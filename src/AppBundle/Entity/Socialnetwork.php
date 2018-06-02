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
     * @ORM\Column(name="profilelink", type="string", length=255, unique=true)
     */
    private $profilelink;



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
     * Get icon
     *
     * @return string
     */
    public function getName()
    {
            $tmp = str_replace('https://www.','',$this->profilelink);
            $tmp = str_replace('http://www.','',$tmp);
            $tmp = str_replace('www.','',$tmp);
            $tmp = str_replace('https://','',$tmp);
            $tmp = str_replace('http://','',$tmp);

            $end = strpos($tmp, '.');
            $tmp = substr($tmp,0, $end);

        return $tmp;
    }
}

