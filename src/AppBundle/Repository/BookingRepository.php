<?php

namespace AppBundle\Repository;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends \Doctrine\ORM\EntityRepository
{
    public function listBookings($page = 1, $count = 20)
    {

        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Booking p ORDER BY p.id DESC'
            )

            ->setMaxResults($count)
            ->setFirstResult(($page - 1) * $count)
            ->getResult();
    }

}
