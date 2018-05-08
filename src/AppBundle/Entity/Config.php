<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigRepository")
 */
class Config
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
     * @ORM\Column(name="logourl", type="string", length=255)
     */
    private $logourl;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttitle", type="string", length=255)
     */
    private $abouttitle;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttext", type="string", length=700)
     */
    private $abouttext;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttextfooter", type="string", length=700, nullable=true)
     */
    private $abouttextfooter;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutteamtext", type="string", length=700)
     */
    private $aboutteamtext;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtitle", type="string", length=255)
     */
    private $aboutinfographtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtext", type="string", length=700, nullable=true)
     */
    private $aboutinfographtext;

    /**
     * //TODO: OneToMany -> InfographItem
     *
     * @ORM\Column(name="aboutinfographitems", type="string", length=255)
     */
    private $aboutinfographitems;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestitle", type="string", length=255)
     */
    private $servicestitle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestext", type="string", length=700)
     */
    private $servicestext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxititle", type="string", length=255)
     */
    private $servicestaxititle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitext", type="string", length=700)
     */
    private $servicestaxitext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstitle", type="string", length=255)
     */
    private $servicestaxitourstitle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstext", type="string", length=700)
     */
    private $servicestaxitourstext;

    /**
     * @var string
     *
     * @ORM\Column(name="jsonmaproutes", type="text", nullable=true)
     */
    private $jsonmaproutes;

    /**
     * @var string
     *
     * @ORM\Column(name="servicesmakeroutetext", type="string", length=700)
     */
    private $servicesmakeroutetext;

    /**
     * TODO: OneToMany -> InfographItem
     *
     * @ORM\Column(name="servicesotherinfographitems", type="string", length=255)
     */
    private $servicesotherinfographitems;

    /**
     * @var string
     *
     * @ORM\Column(name="contacttelephone", type="string", length=100)
     */
    private $contacttelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="contactemail", type="string", length=255)
     */
    private $contactemail;


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
     * Set logourl
     *
     * @param string $logourl
     *
     * @return Config
     */
    public function setLogourl($logourl)
    {
        $this->logourl = $logourl;

        return $this;
    }

    /**
     * Get logourl
     *
     * @return string
     */
    public function getLogourl()
    {
        return $this->logourl;
    }

    /**
     * Set abouttitle
     *
     * @param string $abouttitle
     *
     * @return Config
     */
    public function setAbouttitle($abouttitle)
    {
        $this->abouttitle = $abouttitle;

        return $this;
    }

    /**
     * Get abouttitle
     *
     * @return string
     */
    public function getAbouttitle()
    {
        return $this->abouttitle;
    }

    /**
     * Set abouttext
     *
     * @param string $abouttext
     *
     * @return Config
     */
    public function setAbouttext($abouttext)
    {
        $this->abouttext = $abouttext;

        return $this;
    }

    /**
     * Get abouttext
     *
     * @return string
     */
    public function getAbouttext()
    {
        return $this->abouttext;
    }

    /**
     * Set abouttextfooter
     *
     * @param string $abouttextfooter
     *
     * @return Config
     */
    public function setAbouttextfooter($abouttextfooter)
    {
        $this->abouttextfooter = $abouttextfooter;

        return $this;
    }

    /**
     * Get abouttextfooter
     *
     * @return string
     */
    public function getAbouttextfooter()
    {
        return $this->abouttextfooter;
    }

    /**
     * Set aboutteamtext
     *
     * @param string $aboutteamtext
     *
     * @return Config
     */
    public function setAboutteamtext($aboutteamtext)
    {
        $this->aboutteamtext = $aboutteamtext;

        return $this;
    }

    /**
     * Get aboutteamtext
     *
     * @return string
     */
    public function getAboutteamtext()
    {
        return $this->aboutteamtext;
    }

    /**
     * Set aboutinfographtitle
     *
     * @param string $aboutinfographtitle
     *
     * @return Config
     */
    public function setAboutinfographtitle($aboutinfographtitle)
    {
        $this->aboutinfographtitle = $aboutinfographtitle;

        return $this;
    }

    /**
     * Get aboutinfographtitle
     *
     * @return string
     */
    public function getAboutinfographtitle()
    {
        return $this->aboutinfographtitle;
    }

    /**
     * Set aboutinfographtext
     *
     * @param string $aboutinfographtext
     *
     * @return Config
     */
    public function setAboutinfographtext($aboutinfographtext)
    {
        $this->aboutinfographtext = $aboutinfographtext;

        return $this;
    }

    /**
     * Get aboutinfographtext
     *
     * @return string
     */
    public function getAboutinfographtext()
    {
        return $this->aboutinfographtext;
    }

    /**
     * Set aboutinfographitems
     *
     * @param string $aboutinfographitems
     *
     * @return Config
     */
    public function setAboutinfographitems($aboutinfographitems)
    {
        $this->aboutinfographitems = $aboutinfographitems;

        return $this;
    }

    /**
     * Get aboutinfographitems
     *
     * @return string
     */
    public function getAboutinfographitems()
    {
        return $this->aboutinfographitems;
    }

    /**
     * Set servicestitle
     *
     * @param string $servicestitle
     *
     * @return Config
     */
    public function setServicestitle($servicestitle)
    {
        $this->servicestitle = $servicestitle;

        return $this;
    }

    /**
     * Get servicestitle
     *
     * @return string
     */
    public function getServicestitle()
    {
        return $this->servicestitle;
    }

    /**
     * Set servicestext
     *
     * @param string $servicestext
     *
     * @return Config
     */
    public function setServicestext($servicestext)
    {
        $this->servicestext = $servicestext;

        return $this;
    }

    /**
     * Get servicestext
     *
     * @return string
     */
    public function getServicestext()
    {
        return $this->servicestext;
    }

    /**
     * Set servicestaxititle
     *
     * @param string $servicestaxititle
     *
     * @return Config
     */
    public function setServicestaxititle($servicestaxititle)
    {
        $this->servicestaxititle = $servicestaxititle;

        return $this;
    }

    /**
     * Get servicestaxititle
     *
     * @return string
     */
    public function getServicestaxititle()
    {
        return $this->servicestaxititle;
    }

    /**
     * Set servicestaxitext
     *
     * @param string $servicestaxitext
     *
     * @return Config
     */
    public function setServicestaxitext($servicestaxitext)
    {
        $this->servicestaxitext = $servicestaxitext;

        return $this;
    }

    /**
     * Get servicestaxitext
     *
     * @return string
     */
    public function getServicestaxitext()
    {
        return $this->servicestaxitext;
    }

    /**
     * Set servicestaxitourstitle
     *
     * @param string $servicestaxitourstitle
     *
     * @return Config
     */
    public function setServicestaxitourstitle($servicestaxitourstitle)
    {
        $this->servicestaxitourstitle = $servicestaxitourstitle;

        return $this;
    }

    /**
     * Get servicestaxitourstitle
     *
     * @return string
     */
    public function getServicestaxitourstitle()
    {
        return $this->servicestaxitourstitle;
    }

    /**
     * Set servicestaxitourstext
     *
     * @param string $servicestaxitourstext
     *
     * @return Config
     */
    public function setServicestaxitourstext($servicestaxitourstext)
    {
        $this->servicestaxitourstext = $servicestaxitourstext;

        return $this;
    }

    /**
     * Get servicestaxitourstext
     *
     * @return string
     */
    public function getServicestaxitourstext()
    {
        return $this->servicestaxitourstext;
    }

    /**
     * Set jsonmaproutes
     *
     * @param string $jsonmaproutes
     *
     * @return Config
     */
    public function setJsonmaproutes($jsonmaproutes)
    {
        $this->jsonmaproutes = $jsonmaproutes;

        return $this;
    }

    /**
     * Get jsonmaproutes
     *
     * @return string
     */
    public function getJsonmaproutes()
    {
        return $this->jsonmaproutes;
    }

    /**
     * Set servicesmakeroutetext
     *
     * @param string $servicesmakeroutetext
     *
     * @return Config
     */
    public function setServicesmakeroutetext($servicesmakeroutetext)
    {
        $this->servicesmakeroutetext = $servicesmakeroutetext;

        return $this;
    }

    /**
     * Get servicesmakeroutetext
     *
     * @return string
     */
    public function getServicesmakeroutetext()
    {
        return $this->servicesmakeroutetext;
    }

    /**
     * Set servicesotherinfographitems
     *
     * @param string $servicesotherinfographitems
     *
     * @return Config
     */
    public function setServicesotherinfographitems($servicesotherinfographitems)
    {
        $this->servicesotherinfographitems = $servicesotherinfographitems;

        return $this;
    }

    /**
     * Get servicesotherinfographitems
     *
     * @return string
     */
    public function getServicesotherinfographitems()
    {
        return $this->servicesotherinfographitems;
    }

    /**
     * Set contacttelephone
     *
     * @param string $contacttelephone
     *
     * @return Config
     */
    public function setContacttelephone($contacttelephone)
    {
        $this->contacttelephone = $contacttelephone;

        return $this;
    }

    /**
     * Get contacttelephone
     *
     * @return string
     */
    public function getContacttelephone()
    {
        return $this->contacttelephone;
    }

    /**
     * Set contactemail
     *
     * @param string $contactemail
     *
     * @return Config
     */
    public function setContactemail($contactemail)
    {
        $this->contactemail = $contactemail;

        return $this;
    }

    /**
     * Get contactemail
     *
     * @return string
     */
    public function getContactemail()
    {
        return $this->contactemail;
    }
}

