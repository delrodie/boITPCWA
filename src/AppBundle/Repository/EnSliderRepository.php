<?php

namespace AppBundle\Repository;

/**
 * EnSliderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EnSliderRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste decroissante des ressources
     */
    public function findEnSliderDesc($limit, $offset)
    {
        return $this->createQueryBuilder('s')
                    ->orderBy('s.id', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getQuery()->getResult()
            ;
    }
}
