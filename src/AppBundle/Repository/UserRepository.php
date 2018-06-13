<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * Liste des utilisateurs sans Delrodie
     *
     * @author Delrodie AMOIKON
     * Date: 09/05/2017
     */
    public function findUser(){
        $em = $this->getEntityManager();
        $qb = $em->createQuery('
          SELECT u
          FROM AppBundle:User u
          WHERE u.username <> :nom
      ')
            ->setParameter('nom', 'delrodie')
        ;
        try {
            $result = $qb->getResult();

            return $result;

        } catch (NoResultException $e) {
            return $e;
        }
    }
}