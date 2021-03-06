<?php

namespace AppBundle\Repository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
    public function findLastPosters($count)
    {

        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Image p  WHERE p.poster=true ORDER BY p.id DESC')
            ->setMaxResults($count)
            ->getResult();
    }
}
