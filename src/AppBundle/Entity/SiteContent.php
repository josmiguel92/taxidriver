<?php

namespace AppBundle\Entity;

use AppBundle\Utils\Utils;
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
     * @ORM\Column(name="abouttext", type="text")
     */
    private $abouttext;

    /**
     * @var string
     *
     * @ORM\Column(name="abouttexten", type="text")
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
     * @ORM\Column(name="aboutteamtext", type="text")
     */
    private $aboutteamtext;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutteamtexten", type="text")
     */
    private $aboutteamtexten;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtitle", type="string", length=500)
     */
    private $aboutinfographtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtitleen", type="string", length=500)
     */
    private $aboutinfographtitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtext", type="text", nullable=true)
     */
    private $aboutinfographtext;

    /**
     * @var string
     *
     * @ORM\Column(name="aboutinfographtexten", type="text", nullable=true)
     */
    private $aboutinfographtexten;


    /**
     * @var string
     *
     * @ORM\Column(name="servicestitle", type="string", length=1000)
     */
    private $servicestitle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestitleen", type="string", length=1000)
     */
    private $servicestitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestext", type="text")
     */
    private $servicestext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestexten", type="text")
     */
    private $servicestexten;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxititle", type="string", length=1000)
     */
    private $servicestaxititle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxititleen", type="string", length=1000)
     */
    private $servicestaxititleen;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitext", type="text")
     */
    private $servicestaxitext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitexten", type="text")
     */
    private $servicestaxitexten;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstitle", type="string", length=1000)
     */
    private $servicestaxitourstitle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstitleen", type="string", length=1000)
     */
    private $servicestaxitourstitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstext", type="text")
     */
    private $servicestaxitourstext;

    /**
     * @var string
     *
     * @ORM\Column(name="servicestaxitourstexten", type="text")
     */
    private $servicestaxitourstexten;

    /**
     * @var string
     *
     * @ORM\Column(name="servicesinfographtitle", type="string", length=1000, nullable=true)
     */
    private $servicesinfographtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="servicesinfographtitleen", type="string", length=1000, nullable=true)
     */
    private $servicesinfographtitleen;

    /**
     * @var string
     *
     * @ORM\Column(name="sitedescription", type="text", nullable=true)
     */
    private $sitedescription;

    /**
     * @var string
     *
     * @ORM\Column(name="sitedescriptionen", type="text", nullable=true)
     */
    private $sitedescriptionen;


    /**
     * @var string
     *
     * @ORM\Column(name="sitekeywords", type="text", nullable=true)
     */
    private $sitekeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="sitekeywordsen", type="text", nullable=true)
     */
    private $sitekeywordsen;

    /**
     * @return string
     */
    public function getServicesinfographtitle()
    {
        return $this->servicesinfographtitle;
    }

    /**
     * @param string $servicesinfographtitle
     */
    public function setServicesinfographtitle($servicesinfographtitle)
    {
        $this->servicesinfographtitle = $servicesinfographtitle;
    }

    /**
     * @return string
     */
    public function getServicesinfographtitleen()
    {
        return $this->servicesinfographtitleen;
    }

    /**
     * @param string $servicesinfographtitleen
     */
    public function setServicesinfographtitleen($servicesinfographtitleen)
    {
        $this->servicesinfographtitleen = $servicesinfographtitleen;
    }

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
     * @var string
     *
     * @ORM\Column(name="contactaddress", type="string", length=255)
     */
    private $contactaddress;

    /**
     * @var string
     *
     * @ORM\Column(name="contactaddress_en", type="string", length=255)
     */
    private $contactaddress_en;

    /**
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="ownrouteimage_id", referencedColumnName="id")
     */
    private $ownrouteimage;

    /**
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="aboutusimage_id", referencedColumnName="id")
     */
    private $aboutusimage;

    /**
     * @ORM\OneToOne(targetEntity="Image")
     * @ORM\JoinColumn(name="blogimage_id", referencedColumnName="id")
     */
    private $blogimage;
    /**
     * @return string
     */

    /**
     * @return mixed
     */
    public function getOwnrouteimage()
    {
        return $this->ownrouteimage;
    }

    /**
     * @param mixed $ownrouteimage
     */
    public function setOwnrouteimage($ownrouteimage)
    {
        $this->ownrouteimage = $ownrouteimage;
    }

    /**
     * @return mixed
     */
    public function getAboutusimage()
    {
        return $this->aboutusimage;
    }

    /**
     * @param mixed $aboutusimage
     */
    public function setAboutusimage($aboutusimage)
    {
        $this->aboutusimage = $aboutusimage;
    }


    public function getContactaddress()
    {
        return $this->contactaddress;
    }

    /**
     * @param string $contactaddress
     */
    public function setContactaddress($contactaddress)
    {
        $this->contactaddress = $contactaddress;
    }

    /**
     * @return string
     */
    public function getContactaddressEn()
    {
        return $this->contactaddress_en;
    }

    /**
     * @param string $contactaddress_en
     */
    public function setContactaddressEn($contactaddress_en)
    {
        $this->contactaddress_en = $contactaddress_en;
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
     * @return string
     */
    public function getContactaddressLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->contactaddress;
        else return $this->getContactaddressEn();
    }

    /**
     * @return string
     */
    public function getAbouttitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getAbouttextfooterLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getAboutinfographtextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->aboutinfographtext;
        else
            return $this->aboutinfographtexten;
    }



    /**
     * @return string
     */
    public function getServicestitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getServicestextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getServicestaxititleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getServicestaxitextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getServicestaxitourstitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getServicestaxitourstextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getServicesmakeroutetextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getAbouttextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getAboutteamtextLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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
    public function getAboutinfographtitleLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
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

    /**
     * @return mixed
     */
    public function getBlogimage()
    {
        return $this->blogimage;
    }

    /**
     * @param mixed $blogimage
     */
    public function setBlogimage($blogimage)
    {
        $this->blogimage = $blogimage;
    }

    public function getHeaderimage()
    {
        return $this->blogimage;
    }

    /**
     * @return string
     */
    public function getSitedescription()
    {
        return $this->sitedescription;
    }

    /**
     * @param string $sitedescription
     */
    public function setSitedescription($sitedescription)
    {
        $this->sitedescription = $sitedescription;
    }

    /**
     * @return string
     */
    public function getSitedescriptionen()
    {
        return $this->sitedescriptionen;
    }

    /**
     * @param string $sitedescriptionen
     */
    public function setSitedescriptionen($sitedescriptionen)
    {
        $this->sitedescriptionen = $sitedescriptionen;
    }

    /**
     * @return string
     */
    public function getSitekeywords()
    {
        return $this->sitekeywords;
    }

    /**
     * @param string $sitekeywords
     */
    public function setSitekeywords($sitekeywords)
    {
        $this->sitekeywords = $sitekeywords;
    }

    /**
     * @return string
     */
    public function getSitekeywordsen()
    {
        return $this->sitekeywordsen;
    }

    /**
     * @param string $sitekeywordsen
     */
    public function setSitekeywordsen($sitekeywordsen)
    {
        $this->sitekeywordsen = $sitekeywordsen;
    }

    public function getSitekeywordsLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->sitekeywords;
        else return $this->sitekeywordsen;
    }

    public function getcLocale()
    {
        if(Utils::getRequestLocaleLang()=="es")
            return $this->sitedescription;
        else return $this->sitedescriptionen;
    }

}

