<?php

namespace AppBundle\Repository;

/**
 * PhotoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PhotoRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Recherche des des galleries photos
     */
    public function findGallerie($limit, $offset)
    {
        return $this->createQueryBuilder('p')
                    ->groupBy('p.article')
                    ->orderBy('p.id', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getQuery()->getResult();
            ;
    }

    /**
     * Liste des dernières photos
     */
    public function findPhoto($limit, $offset)
    {
        return $this->createQueryBuilder('p')
                    ->addSelect('a')
                    ->leftJoin('p.article', 'a')
                    ->orderBy('p.id', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->getQuery()->getResult()
        ;
    }

    /**
     * Liste des galerie photo GroupBy Article
     */
    public function findGalerie()
    {
        return $this->createQueryBuilder('p')
                    ->groupBy('p.article')
                    ->orderBy('p.id', 'DESC')
                    ->getQuery()->getResult()
        ;
    }

    /**
     * Liste des photos de la galerie
     */
    public function findListPhoto($slug)
    {
        return $this->createQueryBuilder('p')
                    ->join('p.article', 'a')
                    ->where('a.slug LIKE :slug')
                    ->setParameter('slug', '%'.$slug.'%')
                    ->getQuery()->getResult()
        ;
    }
}
