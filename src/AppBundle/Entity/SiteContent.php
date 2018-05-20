<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="sitecontent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteContentRepository")
 */
class SiteContent
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
     * @ORM\Column(name="abouttitleen", type="string", length=255)
     */
    private $abouttitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttext", type="string", length=700)
     */
    private $abouttext;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttexten", type="string", length=700)
     */
    private $abouttexten;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttextfooter", type="string", length=700, nullable=true)
     */
    private $abouttextfooter;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttextfooteren", type="string", length=700, nullable=true)
     */
    private $abouttextfooteren;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutteamtext", type="string", length=700)
     */
    private $aboutteamtext;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutteamtexten", type="string", length=700)
     */
    private $aboutteamtexten;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtitle", type="string", length=255)
     */
    private $aboutinfographtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtitleen", type="string", length=255)
     */
    private $aboutinfographtitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtext", type="string", length=700, nullable=true)
     */
    private $aboutinfographtext;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtexten", type="string", length=700, nullable=true)
     */
    private $aboutinfographtexten;

    /**
     * ids eparados por comas
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
     * @ORM\Column(name="servicestitleen", type="string", length=255)
     */
    private $servicestitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestext", type="string", length=700)
     */
    private $servicestext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestexten", type="string", length=700)
     */
    private $servicestexten;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxititle", type="string", length=255)
     */
    private $servicestaxititle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxititleen", type="string", length=255)
     */
    private $servicestaxititleen;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitext", type="string", length=700)
     */
    private $servicestaxitext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitexten", type="string", length=700)
     */
    private $servicestaxitexten;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstitle", type="string", length=255)
     */
    private $servicestaxitourstitle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstitleen", type="string", length=255)
     */
    private $servicestaxitourstitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstext", type="string", length=700)
     */
    private $servicestaxitourstext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstexten", type="string", length=700)
     */
    private $servicestaxitourstexten;


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
     * @var string
     *
     * @ORM\Column(name="servicesmakeroutetexten", type="string", length=700)
     */
    private $servicesmakeroutetexten;

    /**
     * ids separados por comas
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
     * @return string
     */
    public function getAbouttitleLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->abouttitle;
        else
        return $this->abouttitleen;
    }
    /**
     * @return string
     */
    public function getAbouttitleen()
    {
        return $this->abouttitleen;
    }

    /**
     * @param string $abouttitleen
     */
    public function setAbouttitleen($abouttitleen)
    {
        $this->abouttitleen = $abouttitleen;
    }




    /**
     * @return string
     */
    public function getAbouttextfooterLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->abouttextfooter;
        else
            return $this->abouttextfooteren;
    }
    /**
     * @return string
     */
    public function getAbouttextfooteren()
    {
        return $this->abouttextfooteren;
    }

    /**
     * @param string $abouttextfooteren
     */
    public function setAbouttextfooteren($abouttextfooteren)
    {
        $this->abouttextfooteren = $abouttextfooteren;
    }



    /**
     * @return string
     */
    public function getAboutinfographtextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->aboutinfographtext;
        else
            return $this->aboutinfographtexten;
    }



    /**
     * @return string
     */
    public function getServicestitleLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicestitle;
        else
            return $this->servicestitleen;
    }

    /**
     * @return string
     */
    public function getServicestitleen()
    {
        return $this->servicestitleen;
    }

    /**
     * @param string $servicestitleen
     */
    public function setServicestitleen($servicestitleen)
    {
        $this->servicestitleen = $servicestitleen;
    }

    /**
     * @return string
     */
    public function getServicestextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicestext;
        else
            return $this->servicestexten;
    }


    /**
     * @return string
     */
    public function getServicestexten()
    {
        return $this->servicestexten;
    }

    /**
     * @param string $servicestexten
     */
    public function setServicestexten($servicestexten)
    {
        $this->servicestexten = $servicestexten;
    }

    /**
     * @return string
     */
    public function getServicestaxititleLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicestaxititle;
        else
            return $this->servicestaxititleen;
    }

    /**
     * @return string
     */
    public function getServicestaxititleen()
    {
        return $this->servicestaxititleen;
    }

    /**
     * @param string $servicestaxititleen
     */
    public function setServicestaxititleen($servicestaxititleen)
    {
        $this->servicestaxititleen = $servicestaxititleen;
    }


    /**
     * @return string
     */
    public function getServicestaxitextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicestaxitext;
        else
            return $this->servicestaxitexten;
    }
    /**
     * @return string
     */
    public function getServicestaxitexten()
    {
        return $this->servicestaxitexten;
    }

    /**
     * @param string $servicestaxitexten
     */
    public function setServicestaxitexten($servicestaxitexten)
    {
        $this->servicestaxitexten = $servicestaxitexten;
    }

    /**
     * @return string
     */
    public function getServicestaxitourstitleLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicestaxitourstitle;
        else
            return $this->servicestaxitourstitleen;
    }

    /**
     * @return string
     */
    public function getServicestaxitourstitleen()
    {
        return $this->servicestaxitourstitleen;
    }

    /**
     * @param string $servicestaxitourstitleen
     */
    public function setServicestaxitourstitleen($servicestaxitourstitleen)
    {
        $this->servicestaxitourstitleen = $servicestaxitourstitleen;
    }

    /**
     * @return string
     */
    public function getServicestaxitourstextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicestaxitourstext;
        else
            return $this->servicestaxitourstexten;
    }
    /**
     * @return string
     */
    public function getServicestaxitourstexten()
    {
        return $this->servicestaxitourstexten;
    }

    /**
     * @param string $servicestaxitourstexten
     */
    public function setServicestaxitourstexten($servicestaxitourstexten)
    {
        $this->servicestaxitourstexten = $servicestaxitourstexten;
    }

    /**
     * @return string
     */
    public function getServicesmakeroutetextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->servicesmakeroutetext;
        else
            return $this->servicesmakeroutetexten;
    }

    /**
     * @return string
     */
    public function getServicesmakeroutetexten()
    {
        return $this->servicesmakeroutetexten;
    }

    /**
     * @param string $servicesmakeroutetexten
     */
    public function setServicesmakeroutetexten($servicesmakeroutetexten)
    {
        $this->servicesmakeroutetexten = $servicesmakeroutetexten;
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
     * @return string
     */
    public function getAbouttextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->abouttext;
        else
            return $this->abouttexten;
    }
    /**
     * @return string
     */
    public function getAbouttexten()
    {
        return $this->abouttexten;
    }

    /**
     * @param string $abouttexten
     */
    public function setAbouttexten($abouttexten)
    {
        $this->abouttexten = $abouttexten;
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
     * @return string
     */
    public function getAboutteamtextLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->aboutteamtext;
        else
            return $this->aboutteamtexten;
    }

    /**
     * @return string
     */
    public function getAboutteamtexten()
    {
        return $this->aboutteamtexten;
    }

    /**
     * @param string $aboutteamtexten
     */
    public function setAboutteamtexten($aboutteamtexten)
    {
        $this->aboutteamtexten = $aboutteamtexten;
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
     * @return string
     */
    public function getAboutinfographtitleLocale($locale)
    {
        if(strtolower($locale)=="es")
            return $this->aboutinfographtitle;
        else
            return $this->aboutinfographtitleen;
    }

    /**
     * @return string
     */
    public function getAboutinfographtitleen()
    {
        return $this->aboutinfographtitleen;
    }

    /**
     * @param string $aboutinfographtitleen
     */
    public function setAboutinfographtitleen($aboutinfographtitleen)
    {
        $this->aboutinfographtitleen = $aboutinfographtitleen;
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
     * @return string
     */
    public function getAboutinfographtexten()
    {
        return $this->aboutinfographtexten;
    }

    /**
     * @param string $aboutinfographtexten
     */
    public function setAboutinfographtexten($aboutinfographtexten)
    {
        $this->aboutinfographtexten = $aboutinfographtexten;
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

    public function getSerialized(){
        return serialize($this);
    }

}

