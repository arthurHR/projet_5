<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\User;


class UserRepository extends EntityRepository
{
    public function findByRoles($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('App:User', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%');

        return $qb->getQuery()->getResult();
    }
}