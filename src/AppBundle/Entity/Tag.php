<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Utils;


/**
 * Keyword
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
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
     * @ORM\Column(name="tag", type="string", length=255)
     */
    private $tag;

    /**
     * @var string
     *
     * @ORM\Column(name="tag_en", type="string", length=255)
     */
    private $tagEn;


    private $posts;


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
     * Set keyword
     *
     * @param string $tag
     *
     * @return Keyword
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set keywordEn
     *
     * @param string $keywordEn
     *
     * @return Keyword
     */
    public function setTagEn($tagEn)
    {
        $this->tagEn = $tagEn;

        return $this;
    }

    /**
     * Get keywordEn
     *
     * @return string
     */
    public function getTagEn()
    {
        return $this->tagEn;
    }

    /**
     * Get keywordLocale
     *
     * @return string
     */
    public function getTagLocale()
    {
        if (Utils\Utils::getRequestLocaleLang() == 'es')
            return $this->tag;
        return $this->tagEn;
    }



    /**
     * Set posts
     *
     * @param string $posts
     *
     * @return Keyword
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
     * Get posts
     *
     * @return string
     */
    public function getPosts()
    {
        return $this->posts;
    }
}

