<?php

namespace AppBundle\Repository;

/**
 * EnPresentationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EnPresentationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste e
     */
    public function findPresentation($slug, $limit, $offset)
    {
        return $this->createQueryBuilder('p')
                    ->join('p.type', 't')
                    ->where('t.slug LIKE :slug')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter('slug', '%'.$slug.'%')
                    ->getQuery()->getResult()
        ;
    }
}
