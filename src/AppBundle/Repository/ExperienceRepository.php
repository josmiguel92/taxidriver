<?php

namespace AppBundle\Repository;

/**
 * ExperienceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExperienceRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllSorted(){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Experience p ORDER BY p.weight DESC'
            )
            ->getResult();
    }

    public function findRandomByImportant($excludedId = null, $amount = 3)
    {
        return $this->createQueryBuilder('a')
            ->addSelect('RAND() as HIDDEN rand')
            ->where('a.important = true')
            ->andWhere('a.id != :id')
            ->orderBy('rand')
            ->setMaxResults($amount)
            ->setParameter('id', $excludedId)
            ->getQuery()
            ->getResult();
    }
}
